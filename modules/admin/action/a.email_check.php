<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if ($type == 'ftpbtn')
{
	$FTP_CONNECT = ftp_connect($ftp_host,$ftp_port); 
	$FTP_CRESULT = ftp_login($FTP_CONNECT,$ftp_user,$ftp_pass);

	if ($FTP_CONNECT && $FTP_CRESULT):

	$FTP_PASV = true;
	if($ftp_pasv)
	{
		$FTP_PASV = ftp_pasv($FTP_CONNECT, true);
	}
	$FTP_CHDIR = ftp_chdir($FTP_CONNECT,$ftp_rb);
	if (!$FTP_PASV) $_msg = _LANG('a6001','admin');
	if (!$FTP_CHDIR || substr($ftp_rb,-1)!='/') $_msg = _LANG('a6002','admin');
	if ($FTP_PASV && $FTP_CHDIR):
	?>
	<script>
	alert('<?php echo _LANG('a6003','admin')?>');
	parent.getId('<?php echo $type?>').innerHTML = '<i class="fa fa-info-circle fa-lg fa-fw"></i><?php echo _LANG('a1001','admin')?>';
	parent.submitFlag = false;
	parent.document.procForm.a.value = 'config';
	parent.document.procForm.autosave.value = '1';
	parent.document.procForm.ftp.value = '1';
	parent.document.procForm.target = '_autosave_';
	parent.document.procForm.submit();
	</script>
	<?php else:?>
	<script>
	alert('<?php echo _LANG('a6004','admin')?> <?php echo $_msg?>');
	parent.getId('<?php echo $type?>').innerHTML = '<i class="fa fa-question fa-lg fa-fw"></i><?php echo _LANG('a1002','admin')?>';
	parent.submitFlag = false;
	parent.document.procForm.a.value = 'config';
	parent.document.procForm.autosave.value = '1';
	parent.document.procForm.ftp.value = '';
	parent.document.procForm.target = '_autosave_';
	parent.document.procForm.submit();
	</script>
	<?php endif?>
	<?php else:?>
	<script>
	alert('<?php echo _LANG('a6005','admin')?>');
	parent.getId('<?php echo $type?>').innerHTML = '<i class="fa fa-question fa-lg fa-fw"></i><?php echo _LANG('a1002','admin')?>';
	parent.submitFlag = false;
	parent.document.procForm.a.value = 'config';
	parent.document.procForm.autosave.value = '1';
	parent.document.procForm.ftp.value = '';
	parent.document.procForm.target = '_autosave_';
	parent.document.procForm.submit();
	</script>
	<?php
	endif;
}
else if ($type == 'ftpbtn_uninstall')
{
	$FTP_CONNECT = ftp_connect($d['admin']['ftp_host'],$d['admin']['ftp_port']); 
	$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['admin']['ftp_user'],$pass);

	if ($FTP_CONNECT && $FTP_CRESULT):
	?>
	<script>
	alert('<?php echo _LANG('a6003','admin')?>');
	parent.getId('<?php echo $type?>').innerHTML = '<i class="fa fa-info-circle fa-lg fa-fw"></i><?php echo _LANG('a1001','admin')?>';
	</script>
	<?php else:?>
	<script>
	alert('<?php echo _LANG('a6005','admin')?>');
	parent.getId('<?php echo $type?>').innerHTML = '<i class="fa fa-question fa-lg fa-fw"></i><?php echo _LANG('a1002','admin')?>';
	</script>
	<?php
	endif;
}
else 
{
	include $g['path_core'].'function/email.func.php';

	$content = '<h4>'._LANG('a6008','admin').'</h4><br>';
	$content.= _LANG('a6009','admin').'<br><br>';

	if ($type == 'sendmailbtn')
	{
		$result = getSendMail($chk_email,$my['email'].'|'.$my['name'],'['.$_HS['name'].']'._LANG('a6008','admin').'(Using Sendmail)',$content,'HTML');
	}
	if ($type == 'smtpbtn') 
	{
		$d['admin']['smtp_use'] = true;
		$d['admin']['smtp'] = true;
		$d['admin']['smtp_host'] = trim($smtp_host);
		$d['admin']['smtp_port'] = trim($smtp_port);
		$d['admin']['smtp_ssl'] = trim($smtp_ssl);
		$d['admin']['smtp_auth'] = trim($smtp_auth);
		$d['admin']['smtp_user'] = trim($smtp_user);
		$d['admin']['smtp_pass'] = trim($smtp_pass);

		$result = getSendMail($chk_email,$my['email'].'|'.$my['name'],'['.$_HS['name'].']'._LANG('a6008','admin').'(Using SMTP)',$content,'HTML');
	}
	if ($result):
	?>
	<script>
	alert('<?php echo _LANG('a6010','admin')?>');
	parent.getId('<?php echo $type?>').innerHTML = '<i class="fa fa-info-circle fa-lg fa-fw"></i><?php echo _LANG('a1001','admin')?>';
	parent.submitFlag = false;
	parent.document.procForm.a.value = 'config';
	parent.document.procForm.autosave.value = '1';
	parent.document.procForm.<?php echo $type=='sendmailbtn'?'email':'smtp'?>.value = '1';
	parent.document.procForm.target = '_autosave_';
	parent.document.procForm.submit();
	</script>
	<?php else:?>
	<script>
	alert('<?php echo _LANG('a6011','admin')?>');
	parent.getId('<?php echo $type?>').innerHTML = '<i class="fa fa-question fa-lg fa-fw"></i><?php echo _LANG('a1002','admin')?>';
	parent.submitFlag = false;
	parent.document.procForm.a.value = 'config';
	parent.document.procForm.autosave.value = '1';
	parent.document.procForm.<?php echo $type=='sendmailbtn'?'email':'smtp'?>.value = '';
	parent.document.procForm.target = '_autosave_';
	parent.document.procForm.submit();
	</script>
	<?php
	endif;
}
exit;
?>