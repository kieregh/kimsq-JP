<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$tmpname	= $_FILES['upfile']['tmp_name'];
$realname	= $_FILES['upfile']['name'];
$fileExt	= strtolower(getExt($realname));
$extPath	= $g['path_tmp'].'app';
$extPath1	= $extPath.'/';
$saveFile	= $extPath1.$date['totime'].'.zip';
$tgFolder	= './';

if (is_uploaded_file($tmpname))
{
	if ($fileExt != 'zip' || substr($realname,0,7) != 'rb_etc_')
	{
		getLink('reload','parent.',_LANG('a8001','market'),'');
	}

	move_uploaded_file($tmpname,$saveFile);

	require $g['path_core'].'opensrc/unzip/ArchiveExtractor.class.php';
	require $g['path_core'].'function/dir.func.php';
	
	$extractor = new ArchiveExtractor();
	$extractor -> extractArchive($saveFile,$extPath1);
	unlink($saveFile);
	DirCopy($extPath1,$tgFolder);
	DirDelete($extPath);
	mkdir($extPath,0707);
	@chmod($extPath,0707);
}
else {
	getLink('','',_LANG('a8002','market'),'');
}

if ($reload == 'Y') getLink('reload',"parent.parent.",_LANG('a8003','market'),'');
else getLink('',"parent.parent.$('#modal_window').modal('hide');",_LANG('a8003','market'),'');
?>