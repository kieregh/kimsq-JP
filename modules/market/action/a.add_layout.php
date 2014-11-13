<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$tmpname	= $_FILES['upfile']['tmp_name'];
$realname	= $_FILES['upfile']['name'];
$nameinfo	= explode('_',str_replace('.zip','',$realname));
$plFolder	= $nameinfo[2];
$fileExt	= strtolower(getExt($realname));
$extPath	= $g['path_tmp'].'app';
$extPath1	= $extPath.'/';
$saveFile	= $extPath1.$date['totime'].'.zip';
$plfldPath	= $g['path_layout'].$plFolder;
$tgFolder	= $plfldPath.'/';

if (is_uploaded_file($tmpname))
{
	if ($fileExt != 'zip' || substr($realname,0,10) != 'rb_layout_')
	{
		getLink('reload','parent.',_LANG('a3001','market'),'');
	}

	move_uploaded_file($tmpname,$saveFile);

	require $g['path_core'].'opensrc/unzip/ArchiveExtractor.class.php';
	require $g['path_core'].'function/dir.func.php';
	
	$extractor = new ArchiveExtractor();
	$extractor -> extractArchive($saveFile,$extPath1);
	unlink($saveFile);
	mkdir($plfldPath,0707);
	@chmod($plfldPath,0707);
	DirCopy($extPath1,$tgFolder);
	DirDelete($extPath);
	mkdir($extPath,0707);
	@chmod($extPath,0707);
}
else {
	getLink('','',_LANG('a3002','market'),'');
}

if ($reload == 'Y') getLink('reload',"parent.parent.",_LANG('a3003','market'),'');
else getLink('',"parent.parent.$('#modal_window').modal('hide');",_LANG('a3003','market'),'');
?>