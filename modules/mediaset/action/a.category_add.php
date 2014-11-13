<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) getLink('','',_LANG('a0001','mediaset'),'');

if (!getDbRows($table['s_uploadcat'],'mbruid='.$my['uid'].' and type='.$ablum_type))
{
	getDbInsert($table['s_uploadcat'],'gid,site,mbruid,type,hidden,users,name,r_num,d_regis,d_update',"'0','".$s."','".$my['uid']."','".$ablum_type."','0','','none','0','".$date['totime']."',''");
	getDbInsert($table['s_uploadcat'],'gid,site,mbruid,type,hidden,users,name,r_num,d_regis,d_update',"'1','".$s."','".$my['uid']."','".$ablum_type."','0','','trash','0','".$date['totime']."',''");
}

$MAXC = getDbCnt($table['s_uploadcat'],'max(gid)','mbruid='.$my['uid'].' and type='.$ablum_type);
$sarr = explode(',',trim($name));
$slen = count($sarr);

for ($i = 0 ; $i < $slen; $i++)
{
	$xname	= trim($sarr[$i]);
	if (!$xname) continue;
	if ($xname == 'none' || $xname == 'trash') continue;
	$gid = $MAXC+1+$i;
	getDbInsert($table['s_uploadcat'],'gid,site,mbruid,type,hidden,users,name,r_num,d_regis,d_update',"'$gid','".$s."','".$my['uid']."','".$ablum_type."','0','','".$xname."','0','".$date['totime']."',''");
}

getLink('reload','parent.','','');
?>