<?php
function getSwitchList($pos)
{
	$incs = array();
	foreach($GLOBALS['d']['switch'][$pos] as $_switch => $_sites)
	{
		if(is_file($GLOBALS['g']['path_switch'].$pos.'/'.$_switch.'/main.php')) $incs[] = array($_switch,$_sites);
	}
	$dirh = opendir($GLOBALS['g']['path_switch'].$pos);
	while(false !== ($folder = readdir($dirh))) 
	{ 
		$_fins = substr($folder,0,1);
		if(strpos('_.',$_fins) || isset($GLOBALS['d']['switch'][$pos][$folder])) continue;
		$incs[] = array($folder,'');
	} 
	closedir($dirh);
	return $incs;
}
$_switchset = array(
	'start'=>_LANG('a6001','admin'),
	'top'=>_LANG('a6002','admin'),
	'head'=>_LANG('a6003','admin'),
	'foot'=>_LANG('a6004','admin'),
	'end'=>_LANG('a6005','admin')
);
$TMPST = array();
$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p);
$SITEN = db_num_rows($SITES);
?>

<div class="row" id="switch">
	<div class="col-sm-4 col-lg-3 rb-aside">
		<div class="panel panel-default">
			<div class="panel-heading rb-icon">
				<div class="icon">
				<i class="fa fa-power-off fa-2x"></i>
				</div>
				<h4 class="panel-title"><?php echo _LANG('a6006','admin')?></h4>
			</div>
			<div class="panel-body rb-panel-form">
				<select class="form-control" onchange="goHref('<?php echo $g['s']?>/?m=<?php echo $m?>&module=<?php echo $module?>&front=<?php echo $front?>&switchdir=<?php echo $switchdir?>&r='+this.value);">
				<?php while($S = db_fetch_array($SITES)):$TMPST[]=array($S['name'],$S['id'])?>
				<option value="<?php echo $S['id']?>"<?php if($r==$S['id']):?> selected<?php endif?>><?php echo $S['name']?> (<?php echo $S['id']?>)</option>
				<?php endwhile?>
				</select>
			</div>

			<form action="<?php echo $g['s']?>/" method="post" class="rb-form" onsubmit="return orderCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="switch_order">
			<input type="hidden" name="auto" value="">
				
				<?php foreach($_switchset as $_key => $_val):?>
				<div class="panel-body">
					<h5><small><?php echo $_val?></small></h5>
					<div class="dd" id="nestable-<?php echo $_key?>">
						<ol class="dd-list">
						<?php if(isset($d['switch'][$_key])):?>
						<?php $_i=1;foreach(getSwitchList($_key) as $_switch):$_switch[2]=getFolderName($g['path_switch'].$_key.'/'.$_switch[0]);$_switch[3]=$_key?>
						<li class="dd-item dd3-item<?php if($_key.'/'.$_switch[0]==$switchdir):$sinfo=$_switch?> rb-active<?php endif?>" data-id="<?php echo $_i?>">
							<div class="dd-handle dd3-handle"></div>
							<div class="dd3-content"><a href="<?php echo $g['adm_href']?>&amp;switchdir=<?php echo $_key.'/'.$_switch[0]?>"><?php echo $_switch[2]?></a> <small>(<?php echo $_switch[0]?>)</small></div>
							<div class="dd-checkbox">
								<input type="checkbox" name="switchmembers_<?php echo $_key?>[]" value="<?php echo $_switch[0]?>" checked class="hidden"><i class="glyphicon glyphicon-eye-<?php echo strstr($_switch[1],'['.$r.']')?'open':'close rb-eye-close'?>"></i>
							</div>
						</li>
						<?php $_i++;endforeach?>
						<?php else:?>
						<li><small></small></li>
						<?php endif?>
						</ol>
					</div>
				</div>
				<?php endforeach?>
			
				<div class="panel-footer">
					<div class="btn-group btn-group-justified">
						<div class="btn-group">
							<button type="button" class="btn btn-default rb-modal-add-switch" data-toggle="modal" href="#modal_window">
								<?php echo _LANG('a6007','admin')?>
							</button>
						</div>
						<div class="btn-group">
							<button type="submit" class="btn btn-default">
								<?php echo _LANG('a6008','admin')?>
							</button>
						</div>
					</div>	
				</div>

			</form>
		</div>
	</div>
	<div class="col-sm-8 col-lg-9 rb-main">
		<?php if($switchdir):?>

		<div class="page-header">
			<h4><?php echo _LANG('a6009','admin')?></h4>
		</div>

		<div class="row">
			<div class="col-md-2 col-sm-2 text-center">
				<span class="fa-stack fa-3x">
					<i class="fa fa-square fa-stack-2x"></i>
					<i class="fa fa-power-off fa-stack-1x fa-inverse"></i>
				</span>
			</div>
			<div class="col-md-10 col-sm-10">
				<h4 class="media-heading">
					<strong><?php echo $sinfo[2]?></strong> 
					<small class="text-muted">(<?php echo $sinfo[0]?>) <span class="label label-default"><?php echo $sinfo[3]?></span></small> 
				</h4>
				<p class="text-muted"><small><?php echo _LANG('a6010','admin')?></small></p>
				<div class="btn-group">
				  <a class="btn btn-default" data-toggle="collapse" data-target="#_edit_area_" onclick="sessionSetting('sh_admin_switch1','1','','1');"><i class="fa fa-code fa-lg"></i> <?php echo _LANG('a6011','admin')?></a>	
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				    <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" role="menu">
					<?php if(is_file($g['path_switch'].$switchdir.'/readme.txt')):?>
					<li><a href="#." data-toggle="collapse" data-target="#_guide_area_" onclick="sessionSetting('sh_admin_switch2','1','','1');"><?php echo _LANG('a6012','admin')?></a></li>
					<?php endif?>
				    <li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=switch_delete&amp;switch=<?php echo $switchdir?>" onclick="return hrefCheck(this,true,'<?php echo _LANG('a6013','admin')?>');"><?php echo _LANG('a6014','admin')?></a></li>
				  </ul>
				</div>
			</div>
		</div>

		<form name="procForm" class="form-horizontal" role="form" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="switch_edit">
		<input type="hidden" name="switch" value="<?php echo $switchdir?>">
		<input type="hidden" name="name" value="<?php echo $sinfo[2]?>">

			<div class="page-header">
				<h4><?php echo _LANG('a6015','admin')?></h4>
			</div>

			<div class="form-group">
				<div class="col-lg-12">
					<?php foreach($TMPST as $_val):?>
					<label class="checkbox-inline rb-no-indent">
						<input type="checkbox" name="aply_sites[]" value="<?php echo $_val[1]?>"<?php if(strstr($sinfo[1],'['.$_val[1].']')):?> checked<?php endif?>> <i></i><strong><?php echo $_val[0]?></strong> <small class="text-muted">(<?php echo $_val[1]?>)</small>
					</label>
					<?php endforeach?>
				</div>
			</div>
			
			<hr>

			<div class="form-group">
				<div class="col-sm-12">
					<div class="btn-group">
						<button type="button" class="btn btn-default" onclick="checkboxChoice('aply_sites[]',true);"><?php echo _LANG('a6016','admin')?></button>
						<button type="button" class="btn btn-default" onclick="checkboxChoice('aply_sites[]',false);"><?php echo _LANG('a6017','admin')?></button>
					</div>
					<div class="btn-group">
						<button class="btn btn-primary" type="submit"><i class="fa fa-check fa-lg"></i> <?php echo _LANG('a6018','admin')?></button>
					</div>
				</div>
			</div>
			
			<div id="_edit_area_" class="collapse<?php if($_SESSION['sh_admin_switch1']):?> in<?php endif?>">
				<div class="rb-files">
					<div class="rb-codeview">
						<div class="rb-codeview-header">
							<ol class="breadcrumb pull-left">
								<li><?php echo _LANG('a6019','admin')?> :</li>
								<li>root</li>
								<li>switchs</li>
								<li><?php echo str_replace('/','</li><li>',$switchdir)?></li>
								<li class="active">main.php</li>
							</ol>
							<button type="button" class="btn btn-default btn-xs pull-right rb-full-screen" data-tooltip="tooltip" title="<?php echo _LANG('a6020','admin')?>" onclick="editFullSize('_edit_area_',this);"><i class="fa fa-arrows-alt fa-lg"></i></button>
						</div>
						<div class="rb-codeview-body">			
							<textarea name="switch_code" id="__code__" class="form-control" rows="35"><?php echo implode('',file($g['path_switch'].$switchdir.'/main.php'))?></textarea>
						</div>	
						<div class="rb-codeview-footer">
							<ul class="list-inline">
								<li><code><?php echo count(file($g['path_switch'].$switchdir.'/main.php'))?> lines</code></li>
								<li><code><?php echo getSizeFormat(filesize($g['path_switch'].$switchdir.'/main.php'),2)?></code></li>
								<li class="pull-right"><?php echo _LANG('a6021','admin')?></li>
							</ul>
						</div>
					</div>
				</div>

				<div class="rb-submit clearfix">
					<button type="submit" class="btn btn-primary"><?php echo _LANG('a6018','admin')?></button>
				</div>
			</div>

		</form>

		<?php if(is_file($g['path_switch'].$switchdir.'/readme.txt')):?>
		<br>
		<br>
		<div id="_guide_area_" class="collapse well<?php if($_SESSION['sh_admin_switch2']):?> in<?php endif?>">
			<small><?php echo getContents(nl2br(implode('',file($g['path_switch'].$switchdir.'/readme.txt'))),'HTML')?></small>
		</div>
		<?php endif?>


		<?php else:?>
		<div class="page-header">
			<h4><?php echo _LANG('a6022','admin')?></h4>
		</div>
		<ul class="rb-guide">
		<li><?php echo _LANG('a6023','admin')?></li>
		<li><?php echo _LANG('a6024','admin')?></li>
		</ul>

		<div class="page-header">
			<h4>요소별 실행위치</h4>
		</div>

		<dl class="dl-horizontal well">
		  <dt><?php echo _LANG('a6001','admin')?></dt>
		  <dd><small class="text-muted">(start)</small> <?php echo _LANG('a6025','admin')?></dd>
		  <dt><?php echo _LANG('a6002','admin')?></dt>
		  <dd><small class="text-muted">(top)</small> <?php echo _LANG('a6026','admin')?></dd>
		  <dt><?php echo _LANG('a6003','admin')?></dt>
		  <dd><small class="text-muted">(head)</small> <?php echo _LANG('a6027','admin')?></dd>
		  <dt><?php echo _LANG('a6004','admin')?></dt>
		  <dd><small class="text-muted">(foot)</small> <?php echo _LANG('a6028','admin')?></dd>
		  <dt><?php echo _LANG('a6005','admin')?></dt>
		  <dd><small class="text-muted">(end)</small> <?php echo _LANG('a6029','admin')?></dd>
		</dl>

		<p><a class="btn btn-link pull-right" data-toggle="modal" href="#admin-switch-structure"><?php echo _LANG('a6030','admin')?></a></p>
		<br>
		<?php endif?>

	</div>
</div>


<?php if($d['admin']['codeeidt']):?>
<!-- codemirror -->
<style>
.CodeMirror {
	font-size: 13px;
	font-weight: normal;
	font-family: Menlo,Monaco,Consolas,"Courier New",monospace !important;
}
</style>
<?php getImport('codemirror','codemirror',false,'css')?>
<?php getImport('codemirror','codemirror',false,'js')?>
<?php getImport('codemirror','theme/'.$d['admin']['codeeidt'],false,'css')?>
<?php getImport('codemirror','addon/display/fullscreen',false,'css')?>
<?php getImport('codemirror','addon/display/fullscreen',false,'js')?>
<?php getImport('codemirror','mode/htmlmixed/htmlmixed',false,'js')?>
<?php getImport('codemirror','mode/xml/xml',false,'js')?>
<?php getImport('codemirror','mode/javascript/javascript',false,'js')?>
<?php getImport('codemirror','mode/clike/clike',false,'js')?>
<?php getImport('codemirror','mode/php/php',false,'js')?>
<?php getImport('codemirror','mode/css/css',false,'js')?>
<script>
var editor = CodeMirror.fromTextArea(getId('__code__'), {
	mode: "application/x-httpd-php",
    indentUnit: 4,
    lineNumbers: true,
    matchBrackets: true,
    indentWithTabs: true,
	theme: '<?php echo $d['admin']['codeeidt']?>',
	extraKeys: {
		"F11": function(cm) {
		  cm.setOption("fullScreen", !cm.getOption("fullScreen"));
		},
		"Esc": function(cm) {
		  if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
		}
	}
});
editor.setSize('100%','550px');
_isCodeEdit = true;
function _codefullscreen()
{
	editor.setOption('fullScreen', !editor.getOption('fullScreen'));
}
</script>
<!-- @codemirror -->
<?php endif?>


<!-- nestable : https://github.com/dbushell/Nestable -->
<?php getImport('nestable','jquery.nestable',false,'js')?>
<script>
$('#nestable-start').nestable({group:1});
$('#nestable-top').nestable({group:2});
$('#nestable-head').nestable({group:3});
$('#nestable-foot').nestable({group:4});
$('#nestable-end').nestable({group:5});
$('.dd').on('change', function() {
	var f = document.forms[0];
	getIframeForAction(f);
	f.auto.value = '1';
	f.submit();
});
$(document).ready(function()
{
	$('.rb-full-screen').on('click',function() {

	});
	$('.rb-modal-add-switch').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=market&amp;front=modal.add&amp;addType=switch&amp;reload=Y')?>');
	});
});
</script>

<script>
function orderCheck(f)
{
	getIframeForAction(f);
	return true;
}
function saveCheck(f)
{
	if (f.name.value == '')
	{
		alert('<?php echo _LANG('a6031','admin')?>   ');
		f.name.focus();
		return false;
	}

	getIframeForAction(f);
	return confirm('<?php echo _LANG('a6032','admin')?>    ');
}
</script>




<div class="modal fade" id="admin-switch-structure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title"><?php echo _LANG('a6033','admin')?></h4>
			</div>
			<div class="modal-body">
				<fieldset id="guide_structure">
<pre>			
		<i>- <?php echo _LANG('a6034','admin')?> -</i>
		<i>- <?php echo _LANG('a6035','admin')?> -</i>
		<i>- <?php echo _LANG('a6036','admin')?> -</i>

		<span>[<?php echo _LANG('a6001','admin')?>]</span>

		<i>- <?php echo _LANG('a6037','admin')?> -</i>
		<i>- <?php echo _LANG('a6038','admin')?> -</i> 

		<span>[<?php echo _LANG('a6002','admin')?>]</span>
		<fieldset>
		<legend>[<?php echo _LANG('a6039','admin')?>]</legend>
		&lt;html&gt;
		&lt;head&gt;

			<i>- <?php echo _LANG('a6040','admin')?> -</i>
			<span>[<?php echo _LANG('a6003','admin')?>]</span>

		&lt;/head&gt;
		&lt;body&gt;
			
			<i>- <?php echo _LANG('a6041','admin')?> -</i>
			<span>[<?php echo _LANG('a6004','admin')?>]</span>

		&lt;/body&gt;
		&lt;/html&gt;
		</fieldset>
		<span>[<?php echo _LANG('a6005','admin')?>]</span>

</pre>
				</fieldset>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _LANG('a6042','admin')?></button>
			</div>
		</div>
	</div>
</div>
