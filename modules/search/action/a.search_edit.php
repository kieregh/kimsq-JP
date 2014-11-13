<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if (!$namefile || strstr($namefile,'/')) exit;
$_newsites = '';
foreach($aply_sites as $sites) $_newsites.= '['.$sites.']';
$_nameinfo = str_replace('|','/',trim($name)).'|'.$_newsites;

$_namefile = $g['dir_module'].'var/names/'.$namefile.'.txt';
$fp = fopen($_namefile,'w');
fwrite($fp,$_nameinfo);
fclose($fp);
@chmod($_namefile,0707);

getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&searchfile='.$searchfile.'&autoCheck=Y','parent.',_LANG('a2001','search'),'');
?>
