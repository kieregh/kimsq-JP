<?php
if(!defined('__KIMS__')) exit;

$history = $__target ? '-1' : '';
$id	= trim($_POST['id']);
$pw	= trim($_POST['pw']);

if (!$id || !$pw) getLink('','',_LANG('a4001','site'),$history);

if (strpos($id,'@') && strpos($id,'.'))
{
	$M1 = getDbData($table['s_mbrdata'],"email='".$id."'",'*');
	$M	= getUidData($table['s_mbrid'],$M1['memberuid']);
}
else {
	$M = getDbData($table['s_mbrid'],"id='".$id."'",'*');
	$M1 = getDbData($table['s_mbrdata'],'memberuid='.$M['uid'],'*');
}

if (!$M['uid'] || $M1['auth'] == 4) getLink('','',_LANG('a4002','site'),$history);
if ($M1['auth'] == 2) getLink('','',_LANG('a4003','site'),$history);
if ($M1['auth'] == 3) getLink('','',_LANG('a4004','site'),$history);
if ($M['pw'] != getCrypt($pw,$M1['d_regis']) && $M1['tmpcode'] != getCrypt($pw,$M1['d_regis'])) getLink('','',_LANG('a4005','site'),$history);

if ($usertype == 'admin')
if (!$M1['admin']) getLink('','',_LANG('a4006','site'),$history);

getDbUpdate($table['s_mbrdata'],"num_login=num_login+1,now_log=1,last_log='".$date['totime']."'",'memberuid='.$M['uid']);
getDbUpdate($table['s_referer'],'mbruid='.$M['uid'],"d_regis like '".$date['today']."%' and site=".$s." and mbruid=0 and ip='".$_SERVER['REMOTE_ADDR']."'");

if ($idpwsave == 'checked') setcookie('svshop', $id.'|'.$pw, time()+60*60*24*30, '/');
else setcookie('svshop', '', 0, '/');

$_SESSION['mbr_uid'] = $M['uid'];
$_SESSION['mbr_pw']  = $M['pw'];
$referer = $referer ? urldecode($referer) : $_SERVER['HTTP_REFERER'];
$referer = str_replace('&panel=Y','',$referer);
$referer = str_replace('&a=logout','',$referer);

$fmktile = mktime();
$ffolder = $g['path_tmp'].'session/';
$opendir = opendir($ffolder);
while(false !== ($file = readdir($opendir)))
{	
	if(!is_file($ffolder.$file)) continue;
	if($fmktile -  filemtime($ffolder.$file) > 1800 ) unlink($ffolder.$file);
}
closedir($opendir);

if ($usertype == 'admin') getLink($g['s'].'/?r='.$r.'&panel=Y&pickmodule=dashboard','parent.parent.','','');
if ($M1['admin']) getLink($g['s'].'/?r='.$r.'&panel=Y&_admpnl_='.urlencode($referer),'parent.parent.','','');
getLink($referer?$referer:$g['s'].'/?r='.$r,'parent.parent.','','');
?>