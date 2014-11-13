<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'] || $category < 1) getLink('','',_LANG('a0001','mediaset'),'');

$_CT = getUidData($table['s_uploadcat'],$category);
if (!$_CT['uid']) getLink('','',_LANG('a0001','mediaset'),''); 
if ($my['uid'] != $_CT['mbruid']) getLink('','',_LANG('a1001','mediaset'),''); 

getDbDelete($table['s_uploadcat'],'uid='.$_CT['uid']);
getDbUpdate($table['s_uploadcat'],'r_num=r_num+'.$_CT['r_num'],"mbruid=".$my['uid']." and type=".$ablum_type." and name='trash'");
getDbUpdate($table['s_upload'],'category=-1','category='.$_CT['uid']);

getLink('reload','parent.','','');
?>