<?php

$body_data = array('name' => 'message_body', 'value' => set_value('message_body'), 'rows' => '5','cols'  => '70');
$mailboxtype = "compose";

?>

<h1>Compose New Message</h1>
<?php 
include("messagemenu.php");
echo validation_errors(); 
?>

<?php echo form_open('message/send');?>
<table width="650" border="0">
	<tr>
		<td align="right" nowrap="nowrap"><b><?php echo form_label('To', 'message_recipient');?></b></td>
		<td><?php echo form_dropdown('message_recipient', $userList, set_value('message_recipient'));?></td>
	</tr>
	<tr>
		<td align="right" nowrap="nowrap"><b><?php echo form_label('Subject', 'message_subject');?></b></td>
		<td width="100%"><?php echo form_input('message_subject',set_value('message_subject'),'size="70"' );?></td>

	</tr>
	<tr>
		<td align="right" nowrap="nowrap"><b><?php echo form_label('Message', 'message_body');?></b></td>
		<td width="100%"><?php echo form_textarea($body_data);?>
			
		</td>
		
	</tr>
	<tr>
		<td colspan="2" align="center"><?php echo form_submit("submit","Submit"); ?></td>
	</tr>
</table>
<?php echo form_close();?>
