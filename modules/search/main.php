<?php
if(!defined('__KIMS__')) exit;

include $g['dir_module'].'var/var.search.php';
include $g['dir_module'].'var/var.order.php';

$swhere	= $swhere ? $swhere : 'all';
$_ResultArray = array();
$_HM['layout'] = $d['search']['layout'];

include getLangFile($g['dir_module'].'language/',($_HS['lang']?$_HS['lang']:$d['admin']['syslang']),'/lang.theme-'.$d['search']['theme'].'.php');

$g['dir_module_skin'] = $g['dir_module'].'/themes/'.$d['search']['theme'].'/';
$g['url_module_skin'] = $g['url_module'].'/themes/'.$d['search']['theme'];
$g['img_module_skin'] = $g['url_module_skin'].'/images';

$g['dir_module_mode'] = $g['dir_module_skin'].'main';
$g['url_module_mode'] = $g['url_module_skin'].'/main';

$g['url_reset']	= $g['s'].'/?r='.$r.'&amp;m='.$m;
$g['url_where']	= $g['url_reset'].($sort?'&amp;sort='.$sort:'').($orderby?'&amp;sort='.$orderby:'').($keyword?'&amp;keyword='.urlencode($keyword):'').'&amp;swhere=';

$g['push_location'] = '<li class="active">'.$_HMD['name'].'</li>';					

$g['main'] = $g['dir_module_mode'].'.php';
?>