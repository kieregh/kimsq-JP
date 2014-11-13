<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$id = trim($id);
$category = trim($category);
$name = trim($name);
$joint = trim(str_replace('&amp;','&',$joint));
$hit = 0;
$d_regis = $date['totime'];
$title = trim($title);
$keywords = trim($keywords);
$description = trim($description);
$classification = trim($classification);
$mediaset = trim($mediaset);
$image_src = trim($image_src);

if (strstr($joint,'&c=')||strstr($joint,'?c='))
{
	getLink('','',_LANG('a6001','site'),'');
}

if (($orign_id && $orign_id != $id) || !$orign_id)
{
	$R = getDbData($table['s_page'],"site=".$s." and id='".$id."'",'*');
	if ($R['uid']) getLink('','',_LANG('a6002','site'),'');
}

if ($uid)
{

	if ($orign_id != $id)
	{
		$mfile1 = $g['path_page'].$r.'-pages/'.$orign_id.'.php';
		$mfile2 = $g['path_page'].$r.'-pages/'.$id.'.php';
		@rename($mfile1,$mfile2);
		@chmod($mfile2,0707);
		$mfile1 = $g['path_page'].$r.'-pages/'.$orign_id.'.widget.php';
		$mfile2 = $g['path_page'].$r.'-pages/'.$id.'.widget.php';
		@rename($mfile1,$mfile2);
		@chmod($mfile2,0707);
		@unlink($g['path_page'].$r.'-pages/'.$orign_id.'.txt');
	}
	if ($cachetime)
	{
		$fp = fopen($g['path_page'].$r.'-pages/'.$id.'.txt','w');
		fwrite($fp, $cachetime);
		fclose($fp);
		@chmod($g['path_page'].$r.'-pages/'.$id.'.txt',0707);
	}
	else {
		if (file_exists($g['path_page'].$r.'-pages/'.$id.'.txt'))
		{
			unlink($g['path_page'].$r.'-pages/'.$id.'.txt');
		}
	}

	$QVAL = "pagetype='$pagetype',ismain='$ismain',mobile='$mobile',id='$id',category='$category',name='$name',perm_g='$perm_g',perm_l='$perm_l',layout='$layout',joint='$joint',linkedmenu='$linkedmenu',d_update='$d_regis',mediaset='$mediaset'";
	getDbUpdate($table['s_page'],$QVAL,'uid='.$uid);

	$_SEO = getDbData($table['s_seo'],'uid='.(int)$seouid,'uid');
	if($_SEO['uid']) getDbUpdate($table['s_seo'],"title='$title',keywords='$keywords',description='$description',classification='$classification',image_src='$image_src'",'uid='.$_SEO['uid']);
	else getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'2','$uid','$title','$keywords','$description','$classification','$image_src'");

	if ($backgo)
	{
		if ($iframe=='Y') getLink(RW('mod='.$id),'parent.parent.','','');
		else getLink(RW('mod='.$id),'parent.','','');
	}
	else {
		getLink('reload','parent.','','');
	}
}
else {

	$sarr = explode(',' , trim($name));
	$slen = count($sarr);

	for ($i = 0 ; $i < $slen; $i++)
	{
		if (!$sarr[$i]) continue;

		$xname	= trim($sarr[$i]);
		$xnarr	= explode('=',$xname);
		$xnid	= $xnarr[1] ? $xnarr[1] : $id.$i;

		if(getDbRows($table['s_page'],"site=".$s." and id='".$xnid."'")) continue;

		$mfile = $g['path_page'].$r.'-pages/'.$xnid.'.php';
		$fp = fopen($mfile,'w');
		fwrite($fp,'');
		fclose($fp);
		@chmod($mfile,0707);
		$mfile = $g['path_page'].$r.'-pages/'.$xnid.'.widget.php';
		$fp = fopen($mfile,'w');
		fwrite($fp,'');
		fclose($fp);
		@chmod($mfile,0707);
		
		if ($cachetime)
		{
			$fp = fopen($g['path_page'].$r.'-pages/'.$xnid.'.txt','w');
			fwrite($fp, $cachetime);
			fclose($fp);
			@chmod($g['path_page'].$r.'-pages/'.$xnid.'.txt',0707);
		}

		$QKEY = "site,pagetype,ismain,mobile,id,category,name,perm_g,perm_l,layout,joint,hit,linkedmenu,d_regis,d_update,mediaset";
		$QVAL = "'$s','$pagetype','$ismain','$mobile','$xnid','$category','$xnarr[0]','$perm_g','$perm_l','$layout','$joint','$hit','$linkedmenu','$d_regis','$d_regis','$mediaset'";
		getDbInsert($table['s_page'],$QKEY,$QVAL);
		$lastpage = getDbCnt($table['s_page'],'max(uid)','');
		getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'2','$lastpage','$title','$keywords','$description','$classification','$image_src'");

	}

	db_query("OPTIMIZE TABLE ".$table['s_page'],$DB_CONNECT);

	getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=page&uid='.$lastpage.'&cat='.urlencode($cat).'&renum='.$recnum.'&p='.$p.'&keyw='.urlencode($keyw),'parent.','','');
}
?>