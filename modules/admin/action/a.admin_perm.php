<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
if ($my['uid'] != 1 || $memberuid == 1) getLink('','',_LANG('a2001','admin'),'');

$perm = '';
foreach($module_members as $mds)
{
	$perm .= '['.$mds.']';
}

getDbUpdate($table['s_mbrdata'],"adm_view='".$perm."'",'memberuid='.$memberuid);

getLink('reload','parent.',_LANG('a2002','admin'),'');
?>