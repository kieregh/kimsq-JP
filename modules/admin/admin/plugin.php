<?php
function getOpenSrcList()
{
	global $g;
	$incs = array();
	$dirh = opendir($g['path_plugin']);
	while(false !== ($folder = readdir($dirh))) 
	{ 
		if($folder == '.' || $folder == '..') continue;
		$incs[] = $folder;
	} 
	closedir($dirh);
	return $incs;
}
function _DirSizeNum($file)
{
	$sfile = $file.'/size.txt';
	if (is_file($sfile))
	{
		$info = explode(',',implode('',file($sfile)));
		$plugin = array();
		$plugin['size'] = $info[0];
		$plugin['num'] = $info[1];
		return $plugin;
	}
	else {
		$plugin = DirSizeNum($file);
		$fp = fopen($sfile,'w');
		fwrite($fp,$plugin['size'].','.$plugin['num']);
		fclose($fp);
		@chmod($sfile,0707);
		return $plugin;
	}
}
$_openSrcs = getOpenSrcList();
$_openSrcn = count($_openSrcs);
include $g['path_core'].'function/dir.func.php';
?>

<div id="plugins">
	<div class="page-header">
		<h4><?php echo sprintf(_LANG('a7001','admin'),$_openSrcn)?></h4>
	</div>

	<form name="pluginForm" action="<?php echo $g['s']?>/" method="post" class="rb-form" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="plugin_config">
		<input type="hidden" name="isdelete" value="">

		<div class="rb-files table-responsive">
			<table class="table table-condensed">
				<thead>
					<tr>
						<th class="rb-check"></th>
						<th class="rb-name"><?php echo _LANG('a7002','admin')?></th>
						<th class="rb-size"><?php echo _LANG('a7003','admin')?></th>
						<th class="rb-update"><?php echo _LANG('a7004','admin')?></th>
						<th class="rb-version"><?php echo _LANG('a7005','admin')?></th>
					</tr>
				</thead>
				<tbody>
				
					<?php $_sumPluginsSize=0?>
					<?php foreach($_openSrcs as $_key_):?>
					<?php $plCtime = filectime($g['path_plugin'].$_key_)?>
					<?php $plugins = _DirSizeNum($g['path_plugin'].$_key_)?>
					<?php $_sumPluginsSize+=$plugins['size']?>
					<tr>
						<td class="rb-check"><div class="checkbox"><label><input type="checkbox" name="pluginmembers[]" value="<?php echo $_key_?>"><i></i></label></div></td>
						<td class="rb-name"><i class="fa fa-folder fa-lg"></i> &nbsp;<a><?php echo $_key_?></a></td>
						<td class="rb-size"><?php echo getSizeFormat($plugins['size'],1)?> (<?php echo $plugins['num']?>)</td>
						<td class="rb-update">
							<time class="timeago" data-toggle="tooltip" datetime="<?php echo date('c',$plCtime)?>" data-tooltip="tooltip" title="<?php echo date($lang['admin']['a7006'],$plCtime)?>"></time>	
						</td>
						<td class="rb-version">
							<select name="ov[<?php echo $_key_?>]" class="form-control input-sm">
								<?php $incs = array()?>
								<?php $dirh = opendir($g['path_plugin'].$_key_)?>
								<?php while(false !== ($version = readdir($dirh))):?>
								<?php if($version=='.'||$version=='..')continue?>
								<?php if(!strstr($version,'.') || !is_dir($g['path_plugin'].$_key_.'/'.$version)) continue?>
								<option value="<?php echo $version?>"<?php if($version==$d['ov'][$_key_]):?> selected="selected"<?php endif?>><?php echo $version?></option>
								<?php endwhile?>
								<?php closedir($dirh)?>
							</select>
						</td>
					</tr>
					<?php endforeach?>

				</tbody>
			</table>
		</div>

		<div class="bottom-action clearfix">
			<div class="btn-toolbar" role="toolbar">
				<div class="btn-group hidden-xs">
					<button type="button" class="btn btn-danger" onclick="deletePlugin('<?php echo $_key_?>','1');"><i class="fa fa-trash-o fa-lg"></i> <?php echo _LANG('a7007','admin')?></button>
				</div>
				<div class="btn-group hidden-xs">
					<button type="button" class="btn btn-danger" onclick="deletePlugin('<?php echo $_key_?>','2');"><i class="fa fa-trash-o fa-lg"></i> <?php echo _LANG('a7008','admin')?></button>
				</div>
				<div class="btn-group hidden-xs">
					<button type="button" class="btn btn-default rb-modal-add-plugin" data-toggle="modal" data-target="#modal_window"><i class="fa fa-upload fa-lg"></i> <?php echo _LANG('a7009','admin')?></button>
				</div>
				<button type="submit" class="btn btn-primary pull-right rb-resave"><i class="fa fa-check fa-fw"></i> <?php echo _LANG('a7010','admin')?></button>
			</div>
		</div>

	</form>

	<div class="well">
		<?php echo _LANG('a7011','admin')?><br>
		<?php echo _LANG('a7012','admin')?><br>
		<span class="hidden-xs"><?php echo _LANG('a7013','admin')?> <code> &lt;?php  getImport('bootstrap-validator','dist/css/bootstrapValidator.min',false,'css') ?&gt;</code></span>
	</div>
</div>


<!-- timeago -->
<?php getImport('jquery-timeago','jquery.timeago',false,'js')?>
<?php getImport('jquery-timeago','locales/jquery.timeago.'.$lang['admin']['time1'],false,'js')?>
<script>
jQuery(document).ready(function() {
	$(".rb-update time").timeago();
});
$(document).ready(function()
{
	$('.rb-modal-add-plugin').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=market&amp;front=modal.add&amp;addType=plugin&amp;reload=Y')?>');
	});
});
</script>   

<script>
function deletePlugin(plugin,type)
{
	var f  = document.pluginForm;
    var l = document.getElementsByName('pluginmembers[]');
    var n = l.length;
    var i;
	var j=0;

	for (i=0; i < n; i++)
	{
		if (l[i].checked == true)
		{
			j++;
		}
	}
	if (j == 0)
	{
		alert('<?php echo _LANG('a7014','admin')?>   ');
		return false;
	}
	if (confirm('<?php echo _LANG('a7015','admin')?>   '))
	{
		getIframeForAction(f);
		f.isdelete.value = type;
		f.submit();
	}
	return false;
}
function saveCheck(f)
{
	if(confirm('<?php echo _LANG('a0001','admin')?>   '))
	{
		getIframeForAction(f);
		return true;
	}
	return false;
}
function saveCheck1()
{
	var f = document.pluginForm;
	getIframeForAction(f);
	f.submit();
}
getId('_sum_size_').innerHTML = '<?php echo getSizeFormat($_sumPluginsSize,2)?>';
<?php if($resave=='Y'):?>
setTimeout("saveCheck1();",100);
<?php endif?>
</script>

