<?php
$addExtensionSet = array
(
	'module' => array(_LANG('a3001','market'),$g['path_module'],'rb_module_'._LANG('a3008','market').'.zip'),
	'layout' => array(_LANG('a3002','market'),$g['path_layout'],'rb_layout_'._LANG('a3009','market').'.zip'),
	'widget' => array(_LANG('a3003','market'),$g['path_widget'],'rb_widget_'._LANG('a3010','market').'.zip'),
	'switch' => array(_LANG('a3004','market'),$g['path_switch'],'rb_switch_'._LANG('a3011','market').'.zip'),
	'plugin' => array(_LANG('a3005','market'),$g['path_plugin'],'rb_plugin_'._LANG('a3012','market').'.zip'),
	'dashboard' => array(_LANG('a3006','market'),$g['path_module'].'dashboard/widgets','rb_dashboard_'._LANG('a3013','market').'.zip'),
	'etc' => array(_LANG('a3007','market'),'/root/','rb_etc_'._LANG('a3014','market').'.zip'),
);
?>


<form name="_upload_form_" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data">
<input type="hidden" name="r" value="<?php echo $r?>">
<input type="hidden" name="m" value="<?php echo $module?>">
<input type="hidden" name="a" value="add_<?php echo $addType?>">
<input type="hidden" name="reload" value="<?php echo $reload?>">
	<div class="modal-body">

		<div class="attach well form-horizontal">
			<div class="row">
				<div class="col-sm-2">
					<input type="file" name="upfile" id="packageupfile" class="hidden" onchange="progressbar();">
					<button type="button" class="btn btn-default" id="fileselectbtn" onclick="$('#packageupfile').click();"><?php echo _LANG('a3015','market')?></button>
				</div>
				<div class="col-sm-10" style="padding-top:7px">
					<div id="uplocation">
						<code><?php echo _LANG('a3016','market')?> : <?php echo str_replace('./','/root/',$addExtensionSet[$addType][1])?></code>
					</div>
					<div class="progress progress-striped active hidden" id="progress-bar">
						<div class="progress-bar" role="progressbar" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>
		<ul>
			<li><?php echo sprintf(_LANG('a3017','market'),$addExtensionSet[$addType][0])?></li>
			<li><?php echo sprintf(_LANG('a3018','market'),$addExtensionSet[$addType][2])?></li>
			<li><?php echo _LANG('a3019','market')?></li>
			<li><?php echo sprintf(_LANG('a3020','market'),$addExtensionSet[$addType][0])?></li>
		</ul>
	</div>
</form>




<!----------------------------------------------------------------------------
@부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->

<div id="_modal_header" class="hidden">
	<button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
	<h4 class="modal-title" id="myModalLabel"><i class="fa fa-upload fa-lg"></i> <?php echo sprintf(_LANG('a3021','market'),$addExtensionSet[$addType][0])?></h4>
</div>
<div id="_modal_footer" class="hidden">
	<button class="btn btn-default pull-left" data-dismiss="modal" type="button"><?php echo _LANG('a3022','market')?></button>
	<button class="btn btn-primary" type="button" onclick="frames._modal_iframe_modal_window.getFiles();" id="afterChooseFileNext" disabled><?php echo _LANG('a3023','market')?></button>
</div>


<script>
var _per = 0;
function progressbar()
{
	if(_per == 0)
	{
		$('#progress-bar').removeClass('hidden');
		$('#uplocation').addClass('hidden');
	}

	if (_per < 100)
	{
		_per = _per + 10;
		getId('progress-bar').children[0].style.width = (_per>100?100:_per)+ '%';
		setTimeout("progressbar();",100);
	}
	else {
		parent.getId('afterChooseFileNext').disabled = false;
		_per = 0;
	}
}
function getFiles()
{
	var f = document._upload_form_;
	if (f.upfile.value == '')
	{
		alert('<?php echo _LANG('a3024','market')?>   ');
		return false;
	}
	getIframeForAction(f);
	f.submit();
	parent.getId('afterChooseFileNext').innerHTML = '<i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> Uploading ...';
	parent.getId('afterChooseFileNext').disabled = true;
}
function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.width = '100%';
	parent.getId('modal_window_dialog_modal_window').style.paddingRight = '20px';
	parent.getId('modal_window_dialog_modal_window').style.maxWidth = '800px';
	parent.getId('_modal_iframe_modal_window').style.height = '400px'
	parent.getId('_modal_body_modal_window').style.height = '400px';

	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_body_modal_window').style.padding = '0';
	parent.getId('_modal_body_modal_window').style.margin = '0';

	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
}
document.body.onresize = document.body.onload = function()
{
	setTimeout("modalSetting();",100);
	setTimeout("modalSetting();",200);
}
</script>


<style>
#rb-body {
	background: #fff;
}
</style>
