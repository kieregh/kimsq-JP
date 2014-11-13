<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) getLink('','',_LANG('block','notification'),'');

$NT_DATA = explode('|',$my['noticeconf']);

if ($member_uid)
{
	$NT_STRING = $NT_DATA[0].'|'.$NT_DATA[1].'|'.$NT_DATA[2].'|'.$NT_DATA[3].'|'.str_replace('['.$member_uid.']','',$NT_DATA[4]).'|'.$NT_DATA[5].'|';	
	getDbUpdate($table['s_mbrdata'],"noticeconf='".$NT_STRING."'",'memberuid='.$my['uid']);
	getLink('reload','parent.',_LANG('a4001','notification'),'');
}
else if ($module_id)
{
	$NT_STRING = $NT_DATA[0].'|'.$NT_DATA[1].'|'.$NT_DATA[2].'|'.str_replace('['.$module_id.']','',$NT_DATA[3]).'|'.$NT_DATA[4].'|'.$NT_DATA[5].'|';	
	getDbUpdate($table['s_mbrdata'],"noticeconf='".$NT_STRING."'",'memberuid='.$my['uid']);
	getLink('reload','parent.',_LANG('a4001','notification'),'');
}
else {
	$NT_STRING = $nt_rcv.'|'.$nt_rcvtype.'|'.$nt_rcvdel.'|'.$NT_DATA[3].'|'.$NT_DATA[4].'|'.$nt_email.'|';
	getDbUpdate($table['s_mbrdata'],"noticeconf='".$NT_STRING."'",'memberuid='.$my['uid']);
	getLink('','','','');
}
?>