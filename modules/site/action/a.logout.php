<?php
if(!defined('__KIMS__')) exit;

if ($my['uid'])
{
	getDbUpdate($table['s_mbrdata'],'now_log=0','memberuid='.$my['uid']);
	$_SESSION['mbr_uid'] = '';
	$_SESSION['mbr_logout'] = '1';
}

$referer = $referer ? urldecode($referer) : $_SERVER['HTTP_REFERER'];
$referer = explode('&_admpnl_',$referer);
$referer = $referer[0];

getLink($referer,'top.','','');
?>