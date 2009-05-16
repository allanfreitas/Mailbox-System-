<?php

class Messagemodel extends Model {

	function Messagemodel()
	{
		parent::Model();
		$this->load->database(); 
	}

	
	function getUsers($user){
		
		$sql = "SELECT username FROM user WHERE username != ?";
		
		$query = $this->db->query($sql,array($user));
	

			if ($query->num_rows() > 0){

				foreach ($query->result() as $row){

					$result[$row->username] =  $row->username;

				}

				return $result;

			}

			else{

				return false;

			}
	}
	function getInbox($user){
		
		$sql = "SELECT messageID,sender,sentDate,messageSubject,messageRead FROM message WHERE receiver = ? AND inboxDelete = ? ORDER BY sentDate DESC";
		
		$query = $this->db->query($sql,array($user,0));

		if ($query->num_rows() > 0){
			
			return $query->result();
			
			
		}
		
		else{
			
			return false;
			
		}

	}
	
	function getOutbox($user){
		
		$sql = "SELECT messageID,receiver,sentDate,messageSubject,messageRead FROM message WHERE sender = ? AND outboxDelete = ? ORDER BY sentDate DESC";
		
		$query = $this->db->query($sql,array($user,0));
		$i=0;
		
		if ($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	function getUnreadMessages($user){
		
			$sql = "SELECT messageRead FROM message WHERE receiver = ? AND messageRead = ?";

			
			$query = $this->db->query($sql,array($user,0));
			
			return $query->num_rows();
	}
	
	function insertMessage($user){
		
			$this->messageSubject   = $_POST['message_subject'];
		    $this->messageContent = $_POST['message_body'];
			$this->receiver = $_POST['message_recipient'];
			$this->sender = $user;
		    $this->sentDate = date('Y-m-d H:i:s');

		    $this->db->insert('message', $this);
		
		
	}
	
	function getMessage($id,$user){
		
		$sql = "SELECT messageID,sentDate,sender,receiver,messageSubject,messageContent,inboxDelete,outboxDelete FROM message WHERE messageID = ? AND ((sender= ? AND outboxDelete= ?)OR (receiver= ? AND inboxDelete= ?))";
		
		$query = $this->db->query($sql,array($id,$user,0,$user,0));
		
		
			if ($query->num_rows() > 0){
				
				return $query->row();

			}else{
				return false;
			}
	}
	
	function setRead($id,$user){
		
		$data = array('messageRead' => 1);

		$this->db->where('messageID', $id);
		$this->db->where('receiver',$user);
		$this->db->update('message', $data);
		
	}
	
	function checkDelete($id,$user){ //used to check if message is marked as deleted
		
			$sql = "SELECT sender,receiver,inboxDelete,outboxDelete FROM message WHERE messageID = ? AND (sender= ? OR receiver = ?)";

			$query = $this->db->query($sql,array($id,$user,$user));


				if ($query->num_rows() > 0){

					return $query->row();

				}
				else{
					
					return false;
					
				}

		
	}
	
	function setDelete($id,$mailbox){ //used to set message as being deleted in an inbox or an outbox
		
		if($mailbox=="inbox"){
			
			$data = array('inboxDelete' => 1);
				
		}
		elseif($mailbox=="outbox"){
			
			$data = array('outboxDelete' => 1);
			
		}
		
		$this->db->where('messageID', $id);
		$this->db->update('message', $data);

		
	}

	function actuallyDelete($id){ // actually deletes a message
		
		$this->db->where('messageID', $id);
		$this->db->delete('message');

	}
}
?>
