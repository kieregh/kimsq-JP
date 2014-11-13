<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$R = getUidData($table['s_site'],$account);
if ($R['uid'])
{
	getDbDelete($table['s_site'],'uid='.$R['uid']);
	getDbDelete($table['s_seo'],'rel=0 and parent='.$R['uid']);

	$_MENUS = getDbSelect($table['s_menu'],'site='.$R['uid'].' order by gid asc','*');
	while($_M = db_fetch_array($_MENUS))
	{
		@unlink($g['path_var'].'menu/'.$_M['imghead']);
		@unlink($g['path_var'].'menu/'.$_M['imgfoot']);	
		
		getDbDelete($table['s_seo'],'rel=1 and parent='.$_M['uid']);
	}

	$_PAGES = getDbSelect($table['s_page'],'site='.$R['uid'].' order by uid asc','*');
	while($_P = db_fetch_array($_PAGES))
	{
		getDbDelete($table['s_seo'],'rel=2 and parent='.$_P['uid']);
	}

	getDbDelete($table['s_menu'],'site='.$R['uid']);
	getDbDelete($table['s_page'],'site='.$R['uid']);

	db_query("OPTIMIZE TABLE ".$table['s_site'],$DB_CONNECT); 
	db_query("OPTIMIZE TABLE ".$table['s_menu'],$DB_CONNECT); 
	db_query("OPTIMIZE TABLE ".$table['s_page'],$DB_CONNECT); 
	db_query("OPTIMIZE TABLE ".$table['s_seo'],$DB_CONNECT); 

	unlink($g['path_var'].'sitephp/'.$account.'.php');

	include $g['path_core'].'function/dir.func.php';
	DirDelete($g['path_page'].$R['id'].'-menus');
	DirDelete($g['path_page'].$R['id'].'-pages');
}

if (!getDbRows($table['s_site'],''))
{
	getLink($g['s'].'/','parent.parent.','','');
}
else {
	getLink($g['s'].'/?m=admin&pickmodule='.$m.'&panel=Y','parent.parent.','','');
}
?>