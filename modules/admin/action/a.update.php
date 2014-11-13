<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$_ufile = $g['path_var'].'update/'.$ufile.'.txt';

if ($type == 'delete')
{
	unlink($_ufile);
	getLink('reload','parent.',_LANG('ac001','admin'),'');
}
else if ($type == 'manual')
{
	$fp = fopen($_ufile,'w');
	fwrite($fp,$date['today'].',1');
	fclose($fp);
	@chmod($_ufile,0707);
	getLink('reload','parent.',_LANG('ac002','admin'),'');
}
else {
	require $g['path_core'].'opensrc/unzip/ArchiveExtractor.class.php';
	require $g['path_core'].'function/dir.func.php';
	include $g['path_core'].'function/rss.func.php';
	include $g['path_module'].'market/var/var.php';
	$_serverinfo = explode('/',$d['market']['url']);
	$_updatedate = getUrlData('http://'.$_serverinfo[2].'/__update/update.v2.txt',10);
	$_updatelist = explode("\n",$_updatedate);
	$_updateleng = count($_updatelist)-1;
	$_includeup = false;
	for($i=$_updateleng;$i>=0;$i--)
	{
		$_upx = explode(',',trim($_updatelist[$i]));
		if ($_upx[1]==$ufile)
		{
			$_updateversion = $_upx[0];
			$_includeup = true;
			break;
		}
	}
	if(!$_includeup) getLink('','',_LANG('ac003','admin'),'');
	$_updatefile = getUrlData('http://'.$_serverinfo[2].'/__update/files/v2/'.$ufile.'.zip',10);
	$folder		= './';
	$extPath  = $g['path_tmp'].'app';
	$extPath1 = $extPath.'/';
	$saveFile = $extPath1.'rb_update_app.zip';

	$fp = fopen($saveFile,'w');
	fwrite($fp,$_updatefile);
	fclose($fp);
	@chmod($saveFile,0707);

	$extractor = new ArchiveExtractor();
	$extractor -> extractArchive($saveFile,$extPath1);
	unlink($saveFile);

	$_updateFile = $extPath1.'/_update.php';
	if (is_file($_updateFile))
	{
		include $_updateFile;
		unlink($_updateFile);
	}

	DirCopy($extPath1,$folder);
	DirDelete($extPath);
	mkdir($extPath,0707);
	@chmod($extPath,0707);

	$fp = fopen($_ufile,'w');
	fwrite($fp,$date['today'].',0');
	fclose($fp);
	@chmod($_ufile,0707);

	if ($_updateversion != $d['admin']['version'])
	{
		$d['admin']['version'] = $_updateversion;
		$_tmpdfile = $g['dir_module'].'var/var.system.php';
		$fp = fopen($_tmpdfile,'w');
		fwrite($fp, "<?php\n");
		foreach ($d['admin'] as $key => $val)
		{
			fwrite($fp, "\$d['admin']['".$key."'] = \"".$val."\";\n");
		}
		fwrite($fp, "?>");
		fclose($fp);
		@chmod($_tmpdfile,0707);
	}

	getLink('reload','parent.',_LANG('ac004','admin'),'');
}
?>