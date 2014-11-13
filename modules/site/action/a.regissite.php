<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$id = trim($id);
$name = trim($name);
$title = trim($title);
$headercode = trim($headercode);
$footercode = trim($footercode);
$meta_title = trim($meta_title);
$meta_keywords = trim($meta_keywords);
$meta_description = trim($meta_description);
$meta_classification = trim($meta_classification);
$meta_image_src = trim($meta_image_src);

if ($site_uid)
{
	$ISID = getDbData($Table['s_site'],"uid<>".$site_uid." and id='".$id."'",'*');
	if ($ISID['uid']) getLink('','',_LANG('a7001','site'),'');

	if ($iconaction)
	{
		getDbUpdate($table['s_site'],"icon='$icon'",'uid='.$site_uid);
		exit;
	}

	$QVAL = "id='$id',name='$name',title='$title',titlefix='$titlefix',icon='$icon',layout='$layout',startpage='$startpage',m_layout='$m_layout',m_startpage='$m_startpage',lang='$sitelang',open='$open',dtd='$dtd',nametype='$nametype',timecal='$timecal',rewrite='$rewrite',buffer='$buffer',usescode='$usescode',headercode='$headercode',footercode='$footercode'";
	getDbUpdate($table['s_site'],$QVAL,'uid='.$site_uid);

	$_SEO = getDbData($table['s_seo'],'uid='.(int)$seouid,'uid');
	if($_SEO['uid']) getDbUpdate($table['s_seo'],"title='$meta_title',keywords='$meta_keywords',description='$meta_description',classification='$meta_classification',image_src='$meta_image_src'",'uid='.$_SEO['uid']);
	else getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'0','$site_uid','$meta_title','$meta_keywords','$meta_description','$meta_classification','$meta_image_src'");

	$vfile = $g['path_var'].'sitephp/'.$site_uid.'.php';
	$fp = fopen($vfile,'w');
	fwrite($fp, trim(stripslashes($sitephpcode)));
	fclose($fp);
	@chmod($vfile,0707);

	if ($r != $id)
	{
		rename($g['path_page'].$r.'-menus',$g['path_page'].$id.'-menus');
		rename($g['path_page'].$r.'-pages',$g['path_page'].$id.'-pages');
	}

	if ($r != $id || $name != $_HS['name'])
	{
		getLink($g['s'].'/?r='.$id.'&pickmodule='.$m.'&panel=Y','parent.parent.','','');
	}
	else {
		if ($iframe=='Y') getLink('reload','parent.parent.','','');
		else getLink('reload','parent.','','');
	}
}
else {
	
	if (!$id)
	{
		$id = 's'.date('His');
	}
	if (!$title)
	{
		$title = $name;
	}

	$ISID = getDbData($Table['s_site'],"id='".$id."'",'*');
	if ($ISID['uid']) getLink('','',_LANG('a7001','site'),'');

	$MAXC = getDbCnt($table['s_site'],'max(gid)','');
	$gid = $MAXC + 1;
	
	$QKEY = "gid,id,name,title,titlefix,icon,layout,startpage,m_layout,m_startpage,lang,open,dtd,nametype,timecal,rewrite,buffer,usescode,headercode,footercode";
	$QVAL = "'$gid','$id','$name','$title','$titlefix','$icon','$layout','$startpage','$m_layout','$m_startpage','$sitelang','$open','$dtd','$nametype','$timecal','$rewrite','$buffer','$usescode','$headercode','$footercode'";
	getDbInsert($table['s_site'],$QKEY,$QVAL);
	$LASTUID = getDbCnt($table['s_site'],'max(uid)','');
	db_query("OPTIMIZE TABLE ".$table['s_site'],$DB_CONNECT); 
	getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'0','$LASTUID','$meta_title','$meta_keywords','$meta_description','$meta_classification','$meta_image_src'");


	$vfile = $g['path_var'].'sitephp/'.$LASTUID.'.php';
	$fp = fopen($vfile,'w');
	fwrite($fp, trim(stripslashes($sitephpcode)));
	fclose($fp);
	@chmod($vfile,0707);

	mkdir($g['path_page'].$id.'-menus',0707);
	mkdir($g['path_page'].$id.'-pages',0707);
	mkdir($g['path_page'].$id.'-menus/images',0707);
	mkdir($g['path_page'].$id.'-pages/images',0707);
	@chmod($g['path_page'].$id.'-menus',0707);
	@chmod($g['path_page'].$id.'-pages',0707);
	@chmod($g['path_page'].$id.'-menus/images',0707);
	@chmod($g['path_page'].$id.'-pages/images',0707);

	if ($nosite=='Y')
	{
		getLink($g['s'].'/?r='.$id.'&m=admin&pickmodule='.$m.'&panel=Y','parent.','','');
	}
	else {
		getLink($g['s'].'/?r='.$id.'&m=admin&pickmodule='.$m.'&panel=Y','parent.parent.','','');
	}
}
?>