<?php
if (!$_dashboardInclude && $g['device'])
{
	getLink($g['s'].'/?r='.$r.'&m='.$m.'&module='.$module.'&front=mobile.shortcut','','','');
}

include $g['path_core'].'function/rss.func.php';
include $g['path_module'].'market/var/var.php';
$_serverinfo = explode('/',$d['market']['url']);
$_updatelist = getUrlData('http://'.$_serverinfo[2].'/__update/update.v2.txt',10);
$_updatelist = explode("\n",$_updatelist);
$_updatelength = count($_updatelist)-1;
$_lastupdate = explode(',',trim($_updatelist[$_updatelength-1]));
$_isnewversion = is_file($g['path_var'].'update/'.$_lastupdate[1].'.txt') ? true : false;

$d['admwidget'] = array();
$_mywidget = $g['path_module'].$module.'/var/'.$my['uid'].'.php';
if(is_file($_mywidget)) include $_mywidget;
?>

<?php getImport('morris','morris',false,'css') ?>
<?php getImport('raphael','raphael-min',false,'js') ?>
<?php getImport('morris','morris.min',false,'js') ?>

<div id="rb-dashboard">
	<?php if(!$_isnewversion):?>
	<div id="rb-update-alert" class="alert alert-danger fade in">
		<?php if($_lastupdate[2]):?>
		<a href="<?php echo $_lastupdate[2]?>" class="alert-link" target="_blank" title="<?php echo _LANG('a1001','dashboard')?>" data-tooltip="tooltip">Rb <?php echo $_lastupdate[0]?></a>
		<?php else:?>
		<a href="#." class="alert-link" title="<?php echo _LANG('a1002','dashboard')?>" data-tooltip="tooltip">Rb <?php echo $_lastupdate[0]?></a>
		<?php endif?>
		<?php echo _LANG('a1003','dashboard')?> 
		<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=admin&amp;front=update" class="alert-link"><?php echo _LANG('a1004','dashboard')?></a>
	</div>
	<?php endif?>

	<div id="rb-widgets-body" class="row">

		<?php $_i=0;foreach($d['admwidget'] as $_key => $_val):?>
		<?php if(!is_file($g['path_module'].$module.'/widgets/'.$_key.'/main.php'))continue?>
		<?php if($_val=='true'):?>
		<?php include getLangFile($g['path_module'].$module.'/widgets/'.$_key.'/lang.',$d['admin']['syslang'],'.php')?>
		<?php include $g['path_module'].$module.'/widgets/'.$_key.'/var.php'?>
		<div class="col-md-<?php echo $d['admdash']['col']?> col-lg-<?php echo $d['admdash']['col']?>">
			<link href="<?php echo $g['s']?>/modules/<?php echo $module?>/widgets/<?php echo $_key?>/main.css" rel="stylesheet"> 
			<div class="panel panel-default<?php if($_SESSION['sh-dash-'.$_key]):?> rb-bottom-none<?php endif?>">
				<div class="panel-heading">
					<a class="rb-collapse btn btn-link" data-toggle="collapse" data-target="#wedget-<?php echo $_key?>">
						<i onclick="checkArrow(this);" title="<?php echo _LANG('a1009','dashboard')?>" data-tooltip="tooltip">×</i>
						<i onclick="checkArrow(this);" title="<?php echo _LANG('a1010','dashboard')?>" data-tooltip="tooltip"><?php echo $_SESSION['sh-dash-'.$_key]?'▼':'▲'?></i>
					</a>
					<h3 class="panel-title"><?php echo $d['admdash']['title']?></h3>
				</div>
				<div class="collapse<?php if(!$_SESSION['sh-dash-'.$_key]):?> in<?php endif?>" id="wedget-<?php echo $_key?>">

					<?php include $g['path_module'].$module.'/widgets/'.$_key.'/main.php'?>
					<?php if($d['admdash']['more']):?>
					<div class="panel-footer rb-more"><a href="<?php echo $d['admdash']['more']?>">more</a></div>
					<?php endif?>
				</div>
			</div>
		</div>
		<?php $_i++;endif?>
		<?php endforeach?>

		<div id="rb-guide-wrapper" class="rb-guide-wrapper<?php if($_i):?> hidden<?php endif?>">
			<div class="rb-guide-wrapper-inner">
				<div class="container">
					<h1>
						<i class="kf kf-widget fa-5x text-muted"></i>
						<br>
						<br>
						<?php echo _LANG('a1005','dashboard')?>
					</h1>
					<p class="text-muted">
						<?php echo _LANG('a1006','dashboard')?>
						<br class="hidden-xs">
						<?php echo _LANG('a1007','dashboard')?>
						<br class="hidden-xs">
					</p>
					<p>
						<br>
						<br>
						<a id="rb-dashboard-edit-btn" class="btn btn-primary rb-modal-dashboard" href="#." data-toggle="modal" data-target="#modal_window">
							<i class="glyphicon glyphicon-ok"></i>
							<?php echo _LANG('a1008','dashboard')?>
						</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>


<form name="actionForm" action="<?php echo $g['s']?>/" method="post">
<input type="hidden" name="r" value="<?php echo $r?>">
<input type="hidden" name="m" value="<?php echo $module?>">
<input type="hidden" name="a" value="dashboard_order">
<input type="hidden" name="widget" value="">
</form>

<script>
document.ondblclick = function()
{
	//$('#rb-dashboard-edit-btn').click();
}
$(document).ready(function()
{
	$('.rb-modal-dashboard').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m='.$m.'&amp;module='.$module.'&amp;front=modal.dashboard')?>');
	});
	<?php if(!$g['device']):?>
	$('#rb-admin-page-content').removeClass('tab-content');
	$('#rb-admin-ul-tabs').removeClass('nav nav-tabs rb-nav-tabs');
	<?php endif?>
});
function checkArrow(obj)
{
	var sid = obj.parentNode.parentNode.parentNode.children[1].id.replace('wedget-','');
	if (obj.innerHTML == '×')
	{
		obj.parentNode.parentNode.parentNode.parentNode.className += ' hidden';

		var f = document.actionForm;
		var wd = getId('rb-widgets-body');
		var wn = wd.children.length;
		var i;
		var j = 0;
		for (i = 0; i < wn-1; i++)
		{
			if (wd.children[i].className.indexOf('hidden') != -1) j++;
		}		
		if (wn-1 == j)
		{
			$('#rb-guide-wrapper').removeClass('hidden');
		}
		else {
			$('#rb-guide-wrapper').addClass('hidden');
		}
		f.widget.value = sid;
		getIframeForAction(f);
		f.submit();
	}
	else {
		if (obj.innerHTML == '▼')
		{
			obj.innerHTML = '▲';
			obj.parentNode.parentNode.parentNode.className = obj.parentNode.parentNode.parentNode.className.replace(' rb-bottom-none','');
		}
		else
		{
			obj.innerHTML = '▼';
			obj.parentNode.parentNode.parentNode.className += ' rb-bottom-none';
		}
		sessionSetting('sh-dash-'+sid,'1','','1');
	}
}
</script>
