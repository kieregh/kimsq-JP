<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

include $g['path_core'].'function/dir.func.php';

$w_dir = $g['path_tmp'].'widget';
DirDelete($w_dir);
mkdir($w_dir,0707);
@chmod($w_dir,0707);

getLink('reload','parent.frames._ADMPNL_.',_LANG('a1001','site'),'');
?>