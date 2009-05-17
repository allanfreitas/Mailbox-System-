<?php

echo '<div class="messagemenu">';

echo '<p>';
	if($mailboxtype=="compose"){
		echo '<a href="'.site_url('message/compose').'"><img src="'.$baseurl.'images/composeselected.png" alt="Compose" width="90" height="26" border="0" /></a>';
	} else {
		echo '<a href="'.site_url('message/compose').'"><img src="'.$baseurl.'images/compose.png" alt="Compose" width="90" height="26" border="0" /></a>';
	}
	if($mailboxtype=="inbox"){
		echo '<a href="'.site_url('message/inbox').'"><img src="'.$baseurl.'images/inboxselected.png" alt="Inbox" width="86" height="26" border="0" /></a>';
	} else {
		echo '<a href="'.site_url('message/inbox').'"><img src="'.$baseurl.'images/inbox.png" alt="Inbox" width="86" height="26" border="0" /></a>';
	}
	if($mailboxtype=="outbox"){
		echo '<a href="'.site_url('message/outbox').'"><img src="'.$baseurl.'images/outboxselected.png" alt="Outbox" width="90" height="26" border="0" /></a>';
	} else {
		echo '<a href="'.site_url('message/outbox').'"><img src="'.$baseurl.'images/outbox.png" alt="Outbox" width="90" height="26" border="0" /></a>';
	}
echo '</p>';



echo '</div><div class="mailboxcontrols"><p><div class="mailboxcontrolsleft">';
		
		
		
		if($title1=="Read"){
			
			echo form_submit("submit","Reply");
			
			$hrefdelete = site_url("message/delete/".$message->messageID);
			
			//echo form_button("deletemessage","Delete message","ONCLICK=\"window.location.href='$hrefdelete'\"");
			
			

			echo form_button("deletemessage","Delete message","ONCLICK=\"deleteConfirm('$hrefdelete')\"");
		}
		if($mailboxtype!="compose"){
			
		}
		
		echo '</div><div class="mailboxcontrolsright">';
			
			if($title1=="Read"){
				if($mailboxtype=="inbox"){
				 	$hrefmailboxtype = site_url("message/inbox");
				} else if($mailboxtype=="outbox"){
					 $hrefmailboxtype = site_url("message/outbox");
				}
					echo form_button("closemessage","Close message","ONCLICK=\"window.location.href='$hrefmailboxtype'\"");
				}
			
		echo '</div></p></div>';