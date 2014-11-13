<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$FTP_CONNECT = ftp_connect($ftp_host,$ftp_port); 
$FTP_CRESULT = ftp_login($FTP_CONNECT,$ftp_user,$ftp_pass);

if ($FTP_CONNECT && $FTP_CRESULT):

$FTP_PASV = true;
if($ftp_pasv)
{
	$FTP_PASV = ftp_pasv($FTP_CONNECT, true);
}
$FTP_CHDIR = ftp_chdir($FTP_CONNECT,$ftp_folder);
if (!$FTP_PASV) $_msg = _LANG('a3001','mediaset');
if (!$FTP_CHDIR || substr($ftp_folder,-1)!='/' || substr($ftp_urlpath,-1)!='/') $_msg = _LANG('a3002','mediaset');
if ($FTP_PASV && $FTP_CHDIR):
?>
<script>
alert('<?php echo _LANG('a3003','mediaset')?>');
parent.getId('ftpbtn').innerHTML = '<i class="fa fa-info-circle fa-lg fa-fw"></i><?php echo _LANG('a3004','mediaset')?>';
parent.submitFlag = false;
parent.document.procForm.a.value = 'config';
parent.document.procForm.ftp_connect.value = '1';
</script>
<?php else:?>
<script>
alert('<?php echo _LANG('a3006','mediaset')?> <?php echo $_msg?>');
parent.getId('ftpbtn').innerHTML = '<i class="fa fa-question fa-lg fa-fw"></i><?php echo _LANG('a3005','mediaset')?>';
parent.submitFlag = false;
parent.document.procForm.a.value = 'config';
parent.document.procForm.ftp_connect.value = '';
</script>
<?php endif?>
<?php else:?>
<script>
alert('<?php echo _LANG('a3007','mediaset')?>');
parent.getId('ftpbtn').innerHTML = '<i class="fa fa-question fa-lg fa-fw"></i><?php echo _LANG('a3005','mediaset')?>';
parent.submitFlag = false;
parent.document.procForm.a.value = 'config';
parent.document.procForm.ftp_connect.value = '';
</script>
<?php
endif;

exit;
?>