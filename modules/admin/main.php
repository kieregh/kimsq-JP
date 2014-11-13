<?php
if(!defined('__KIMS__')) exit;

if (!$my['admin']) $mod = 'login';
if (!$mod) $mod = 'front';

$module = $module ? $module : 'admin';
$front  = $front  ? $front  : 'main';
$MD = getDbData($table['s_module'],"id='".$module."'",'*');

if (!$MD['id']) getLink($g['s'].'/?r='.$r.'&m=admin&module=admin','',_LANG('ex001','admin'),'');
if ($MD['id']!='admin'&&strpos('_'.$my['adm_view'],'['.$MD['id'].']')) getLink($g['s'].'/?r='.$r.'&m=admin&module=admin','',_LANG('ex002','admin'),'');

$d['module']['skin']	= $d['admin']['themepc'];
$g['dir_module_skin']	= $g['dir_module'].'theme/'.$d['module']['skin'].'/';
$g['url_module_skin']	= $g['url_module'].'/theme/'.$d['module']['skin'];

$g['dir_module_admin']	= $g['path_module'].$module.'/admin/'.$front;
$g['url_module_admin']	= $g['s'].'/modules/'.$module.'/admin/'.$front;
$g['img_module_admin']	= $g['s'].'/modules/'.$module.'/admin/images';
$g['adm_module_varmenu']= $g['path_module'].$module.'/admin/var/var.menu.php';

$g['adm_module']		= $g['path_module'].$module.'/admin.php';
$g['img_module_skin']	= $g['url_module_skin'].'/images';
$g['dir_module_mode']	= $g['dir_module_skin'].$mod;
$g['url_module_mode']	= $g['url_module_skin'].'/'.$mod;
$g['adm_href']			= $g['s'].'/?r='.$r.'&amp;m='.$m.'&amp;module='.$module.'&amp;front='.$front;
$g['adminlanguage']		= $MD['lang']?$MD['lang']:$d['admin']['syslang'];

include getLangFile($g['path_module'].$module.'/language/',$g['adminlanguage'],'/lang.admin.php');
include getLangFile($g['path_module'].$module.'/language/',$g['adminlanguage'],'/lang.admin-menu.php');

if (is_file($g['adm_module_varmenu']))
{
	$d['amenu'] = array();
	include $g['adm_module_varmenu'];
}

$g['main'] = $my['admin'] && $iframe == 'Y' ? $g['adm_module'] : $g['dir_module_mode'].'.php';
?>