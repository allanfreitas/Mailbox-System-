<?php

class Message extends Controller {
	
	

	function Message(){
	
		parent::Controller();
		

			

			

	}


	function index(){
	
		redirect('message','inbox');
	
	}
	
	
	function inbox(){
		
		if($this->usermodel->isLoggedIn()){ //if the user is logged in
				
			$data['loggedin']=true;
			$this->load->library('table'); //load the html table class
			$data['messageList'] = $this->messagemodel->getInbox($this->usermodel->getCurrentUser()); //get a list of messages from the inbox
			$data['title1'] = "Inbox"; //title of page
				
			$this->load->view('inbox',$data); //change view to inbox view
				
		}
		
		else{ //if the user isn't logged in
			
			$data['loggedin']=false;
			$data['error']="You must be logged in to do that!";
			$this->load->view('frontpage',$data);
			
		}
		
	}


	function outbox(){
	
		if($this->usermodel->isLoggedIn()){ //if the user is logged in

			$data['loggedin']=true;
			$this->load->library('table'); //load the html table class
			$data['messageList'] = $this->messagemodel->getOutbox($this->usermodel->getCurrentUser()); //get a list of messages from the outbox
			$data['title1'] = "Outbox"; //title of page
			$this->load->view('outbox',$data); //display the outbox view
			
		}
			
		else{ //if the user isn't logged in

			$data['loggedin']=false;
			$data['error']="You must be logged in to do that!";
			$this->load->view('frontpage',$data);

		}
		
	}
	
	
	function compose(){
		
		if($this->usermodel->isLoggedIn()){ //if the user is logged in

			$data['loggedin']=true;
			$data['userList'] = $this->messagemodel->getUsers($this->usermodel->getCurrentUser()); //get the list of users
			$data['title1'] = "Compose"; //title of page
			$this->load->view('compose',$data); //display the compose view
					
		}
		
		else{ //if the user isn't logged in

			$data['loggedin']=false;
			$data['error']="You must be logged in to do that!";
			$this->load->view('frontpage',$data);

		}
		
	}
	
	
	function send(){
		
		if($this->usermodel->isLoggedIn()){ //if the user is logged in

			$data['loggedin']=true;
			$data['title1'] = "Send"; //title of page

			$this->load->helper(array('form', 'url')); //load the URL helper

			$this->load->library('form_validation'); //load the form validation class

			// set the rules for each of the form inputs
			$this->form_validation->set_rules('message_recipient', 'Recipient','trim|required|xss_clean');
			$this->form_validation->set_rules('message_subject', 'Subject','trim|required|xss_clean');
			$this->form_validation->set_rules('message_body', 'Body','trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE){ //run the validation check, if it's false
			
				$data['userList'] = $this->messagemodel->getUsers($this->usermodel->getCurrentUser()); //reload the select box of users
				$this->load->view('compose',$data); //reload the compose view

			}

			else{ //if it passes the validation
					
				$this->messagemodel->insertMessage($this->usermodel->getCurrentUser()); //insert message into the db, the message table
				
				$this->session->set_flashdata('success', 'Your message has been sent'); //create success message(displayed in the inbox view)
				redirect('message/inbox', 'refresh'); //redirect user to their inbox

			}
		}
			
		else{ //if the user isn't logged in

			$data['loggedin']=false;
			$data['error']="You must be logged in to do that!";
			$this->load->view('frontpage',$data);

		}
		
	}
	
	
	function read($id){
		
		if($this->usermodel->isLoggedIn()){ //if user is logged in
						
			$data['loggedin']=true; 
						
			$data['message'] = $this->messagemodel->getMessage($id,$this->usermodel->getCurrentUser()); //get the message from the db
			$data['title1'] = "Read"; //title of page
			if($data['message']!=false){
				if($data['message']->sender == $this->usermodel->getCurrentUser()) {
					$data['mailboxtype'] = "outbox";
				} 
				else {
					$data['mailboxtype'] = "inbox";
				}
	
				$this->messagemodel->setRead($id,$this->usermodel->getCurrentUser()); //set the message as being read
				$this->load->view('read',$data); //change view to display the message
			
			}
			elseif($data['message']==false){
				
				$this->session->set_flashdata('success', 'message does not exist'); //create success message(displayed in the inbox view)
				redirect('message/inbox', 'refresh');
				
			}
			
			
										
		}
				
		else{ //if the user isn't logged in
					
			$data['loggedin']=false; 
			$data['error']="You must be logged in to do that!"; 
			$this->load->view('frontpage',$data);
						
		}		
		
	}
	
	function delete($id){
		
			if($this->usermodel->isLoggedIn()){ //if user is logged in

				$data['loggedin']=true;
		
				$deleteCheck=$this->messagemodel->checkDelete($id,$this->usermodel->getCurrentUser()); 
				
				if($deleteCheck->sender == $this->usermodel->getCurrentUser()){ //if the user is the sender of the message
					
					if($deleteCheck->inboxDelete==1){ //if the message has been marked as being deleted by the receiver
					
						$query=$this->messagemodel->actuallyDelete($id); //call function which will actually delete message from the database
						
					}
					
					elseif($deleteCheck->inboxDelete==0){ //elseif the message hasn't been marked as being deleted by the receiver
						
						$query=$this->messagemodel->setDelete($id,"outbox"); //call the function which just sets it as being deleted in the outbox
						
					}
					
				}
				elseif(($deleteCheck->receiver == $this->usermodel->getCurrentUser())){ //elseif the user is the receiver of the message
					
					
					if($deleteCheck->outboxDelete==1){ //if the message has been marked as being deleted by the sender
					
						$query=$this->messagemodel->actuallyDelete($id); //call function which will actually delete message from the database
						
					}
					
					elseif($deleteCheck->outboxDelete==0){ //elseif the message hasn't been marked as being deleted by the sender
						
						$query=$this->messagemodel->setDelete($id,"inbox"); //call the function which just sets it as being deleted in the inbox
						
					}
					
					
				}
				

				$this->session->set_flashdata('success', 'Your message has been deleted&#33;'); //create success message(displayed in the inbox view)
				redirect('message/inbox', 'refresh');
					
				
				
			}
			
			else{ //if the user isn't logged in

					$data['loggedin']=false; 
					$data['error']="You must be logged in to do that!"; 
					$this->load->view('frontpage',$data);

			}
		
	}

	
}
?>