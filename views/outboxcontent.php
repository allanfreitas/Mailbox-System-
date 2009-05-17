
<h1><?php echo $title1; ?> for <?php echo ucfirst($user);?> </h1>

<?php
$mailboxtype = "outbox";
include("messagemenu.php");
if($messageList){
?>

	<table id="messagelist" cellpadding="0" cellspacing="0">
		<tr class="messagelistheader">
			<th> </th>
			<th>Subject</th>
			<th>To</th>
			<th>Date/Time</th>
		</tr>
		
<?php	foreach($messageList as $message){?>
		<tr <?php if($message->messageRead==0){?> class="unread"<?php } else{?> class="read"<?php }?>>
			<td class="messagestatus"><img src="<?php if($message->messageRead==0){echo $baseurl.'images/messageunread.png';} else{echo $baseurl.'images/messageread.png';} ?>" width="21" height="20" border="0" alt="" /></td>
			<td class="messagesubject"><?php echo anchor("message/read/$message->messageID", $message->messageSubject);?></td>
			<td class="messagewith"><?php echo ucfirst($message->receiver);?></td>
			<td class="messagedate"><?php echo date("F j, Y, g:i a", strtotime($message->sentDate))?></td>
		</tr>
<?php	}?>
	</table>


<?php

		
}
else{
	
	echo '<h2>Outbox is empty</h2></br>';

}
?>

<br />
