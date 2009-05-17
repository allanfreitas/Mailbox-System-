
<h1><?php echo $title1.' '.$mailboxtype; ?> message</h1>

<?php
if($message){
	echo form_open('message/compose');
	if($message->sender==$user){
		echo form_hidden('message_recipient', $message->receiver);
	}
	else{
		echo form_hidden('message_recipient', $message->sender);
	}
	echo form_hidden('message_subject', 'RE: '.$message->messageSubject);
	echo form_hidden('message_body', "\n\n\n\n-----------------------------------------------\n \n On ".date("F j, Y", strtotime($message->sentDate))." at ".date("g:i a, ", strtotime($message->sentDate)).ucfirst($message->sender)." said: \n\n".$message->messageContent);
	include("messagemenu.php");
	echo form_close();
?>

<table id="messagelist" cellpadding="0" cellspacing="0">
	<tr class="messagelistheader">
		<th></th>
		<th>Subject</th>
		<th><?php if($mailboxtype=="inbox"){echo "From";}else if($mailboxtype=="outbox"){echo "To";} ?></th>
		<th>Date/Time</th>
	</tr>
	<tr class="messagelistheader">
		<td class="messagestatus"><img
			src="<?php echo $baseurl.'images/messageread.png'; ?>" width="21"
			height="20" border="0" alt="" /></td>
		<td class="messagesubject"><?php echo $message->messageSubject;?></td>
		<td class="messagewith"><?php if($mailboxtype=="inbox"){echo ucfirst($message->sender);}else if($mailboxtype=="outbox"){echo ucfirst($message->receiver);} ?></td>
		<td class="messagedate"><?php echo date("F j, Y, g:i a", strtotime($message->sentDate))?></td>
	</tr>
</table>

<table id="messageread" cellpadding="0" cellspacing="0">
	<tr class="read">
		<td>
		<p><?php echo nl2br($message->messageContent);?></p>
		</td>
	</tr>
</table>

<?php

}

?>
<br />
