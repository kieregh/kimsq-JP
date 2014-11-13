<?php
if(!defined('__KIMS__')) exit;

$i = 0;
foreach($photomembers as $file_uid)
{
	$val = explode('|',$file_uid);
	getDbUpdate($table['s_upload'],'pid='.$i,'uid='.$val[0]);
	$i++;
}

getLink('reload','parent.','','');
?>