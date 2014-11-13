<?php
if(!defined('__KIMS__')) exit;
?>

<div id="rb-widget-include-area" style="position:relative;height:<?php echo $d['page']['mainheight']?>px;">
	<?php $_widgetGroup=''?>
	<?php $i = 0?>
	<?php foreach($d['page']['widget'] as $_key => $_val):?>
	<?php $_name = $d['page']['widget'][$_key]['name']?>
	<?php $_size = explode('|',$d['page']['widget'][$_key]['size'])?>
	<?php $_prop = explode(',',$d['page']['widget'][$_key]['prop'])?>
	<?php
	$wdgvar=array();
	$wdgvar['widgetlang'] = $_HS['lang']?$_HS['lang']:$d['admin']['syslang'];
	foreach($_prop as $_cval)
	{
		$_xval=explode('^',$_cval);
		$wdgvar[$_xval[0]]=$_xval[1];
	}
	$wdgvar['widget_path'] = $_prop[0];
	$wdgvar['widget_id'] = str_replace('/','-',$wdgvar['widget_path']);
	if(!is_file($g['wdgcod']) && !strstr($_widgetGroup,'['.$wdgvar['widget_path'].']'))
	{
		$wdgvar['widget_rpath'] = $g['path_widget'].$wdgvar['widget_path'];
		$wdgvar['widget_upath'] = $g['s'].'/widgets/'.$wdgvar['widget_path'];
		if(is_file($wdgvar['widget_rpath'].'/main.css')) $g['widget_cssjs'] .= '<link href="'.$wdgvar['widget_upath'].'/main.css'.$g['wcache'].'" rel="stylesheet">'."\n";
		if(is_file($wdgvar['widget_rpath'].'/main.js')) $g['widget_cssjs'] .= '<script src="'.$wdgvar['widget_upath'].'/main.js'.$g['wcache'].'"></script>'."\n";
	}
	?>

	<div style="position:absolute;width:<?php echo $_size[0]?>;height:<?php echo $_size[1]?>;top:<?php echo $_size[2]?>;left:<?php echo $_size[3]?>;">
	<?php include getLangFile($g['path_widget'].$wdgvar['widget_path'].'/lang.',$wdgvar['widgetlang'],'.php')?>
	<?php include $g['path_widget'].$wdgvar['widget_path'].'/main.php'?>
	</div>

	<?php $_widgetGroup .= '['.$wdgvar['widget_path'].']'?>
	<?php $i++; endforeach?>
</div>
