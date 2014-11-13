<?php
if(!defined('__KIMS__')) exit;

if(!is_file($g['wdgcod']))
{
	$fp = fopen($g['wdgcod'],'w');
	fwrite($fp,$g['widget_cssjs']);
	fclose($fp);
	@chmod($g['wdgcod'],0707);
	echo $g['widget_cssjs'];
}
?>