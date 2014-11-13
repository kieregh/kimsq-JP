<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$tmpname	= $_FILES['upfile']['tmp_name'];
$realname	= $_FILES['upfile']['name'];
$nameinfo	= explode('_',str_replace('.zip','',$realname));
$plFolder	= $nameinfo[2];
$plVersion	= $nameinfo[3];
$fileExt	= strtolower(getExt($realname));
$extPath	= $g['path_tmp'].'app';
$extPath1	= $extPath.'/';
$saveFile	= $extPath1.$date['totime'].'.zip';
$plfldPath	= $g['path_switch'].$plFolder;
$plverPath	= $plfldPath.'/'.$plVersion;
$tgFolder	= $plverPath.'/';

if (is_uploaded_file($tmpname))
{
	if ($fileExt != 'zip' || substr($realname,0,10) != 'rb_switch_')
	{
		getLink('reload','parent.',_LANG('a5001','market'),'');
	}

	move_uploaded_file($tmpname,$saveFile);

	require $g['path_core'].'opensrc/unzip/ArchiveExtractor.class.php';
	require $g['path_core'].'function/dir.func.php';
	
	$extractor = new ArchiveExtractor();
	$extractor -> extractArchive($saveFile,$extPath1);
	unlink($saveFile);
	mkdir($plfldPath,0707);
	mkdir($plverPath,0707);
	@chmod($plfldPath,0707);
	@chmod($plverPath,0707);
	DirCopy($extPath1,$tgFolder);
	DirDelete($extPath);
	mkdir($extPath,0707);
	@chmod($extPath,0707);


	$_switchset = array('start','top','head','foot','end');
	$_ufile = $g['path_var'].'switch.var.php';
	$fp = fopen($_ufile,'w');
	fwrite($fp, "<?php\n");

	foreach ($_switchset as $_key)
	{
		foreach ($d['switch'][$_key] as $name => $sites)
		{
			fwrite($fp, "\$d['switch']['".$_key."']['".$name."'] = \"".$sites."\";\n");
		}
	}
	fwrite($fp, "\$d['switch']['".$plFolder."']['".$plVersion."'] = \"\";\n");
	fwrite($fp, "?>");
	fclose($fp);
	@chmod($_ufile,0707);
}
else {
	getLink('','',_LANG('a5002','market'),'');
}

if ($reload == 'Y') getLink('reload',"parent.parent.",sprintf(_q('a5003','market'),$plFolder.'/'.$plVersion),'');
else getLink('',"parent.parent.$('#modal_window').modal('hide');",sprintf(_q('a5003','market'),$plFolder.'/'.$plVersion),'');
?>