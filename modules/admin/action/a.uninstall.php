<?php
if(!defined('__KIMS__')) exit;
checkAdmin(0);

// 제거탭 출력 설정 하지 않은 경우 차단
if (!$d['admin']['uninstall'])
{
	getLink('','',_LANG('a0001','admin'),'');	
}

// FTP 삭제
if ($d['admin']['ftp_use']&&$d['admin']['ftp'])
{
	getLink('','',_LANG('ab001','admin'),'');	
}
// NOBODY 삭제
else {
	foreach ($table as $key => $val) db_query('drop table '.$val,$DB_CONNECT);
	include $g['path_core'].'function/dir.func.php';
	DirDelete('./');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<script>
top.location.href = 'http://<?php echo $_SERVER['HTTP_HOST']?>/';
</script>
</head>
<body></body>
</html>
