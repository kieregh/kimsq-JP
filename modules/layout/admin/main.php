<div class="row" id="layout-code">
	<div class="col-sm-4 col-md-4 col-lg-3">
		<div class="panel panel-default">
			<div class="panel-heading rb-icon">
				<div class="icon">
					<i class="fa kf kf-layout fa-2x"></i>
				</div>
				<h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapmetane"><?php echo _LANG('a1001','layout')?></a></h4>
			</div>
			<div class="panel-collapse collapse in" id="collapmetane">
				<div class="panel-body">
					<div style="min-height:250px">
						<link href="<?php echo $g['s']?>/_core/css/tree.css" rel="stylesheet">
						<div class="rb-tree">
							<ul id="tree-layout">
							<?php $numSub=array()?>
							<?php $layout = $layout ? $layout : dirname($_HS['layout'])?>
							<?php $sublayout = $sublayout ? $sublayout : 'default.php'?>
							<?php $_sublayout = str_replace('.php','',$sublayout)?>
							<?php $dirs = opendir($g['path_layout'])?>
							<?php $_i=1;while(false !== ($tpl = readdir($dirs))):?>
							<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
							<?php $dirs1 = opendir($g['path_layout'].$tpl)?>
							<li>
								<div class="rb-tree">
									<a data-toggle="collapse" href="#tree-layout-<?php echo $_i?>" class="rb-branch<?php if($tpl!=$layout):?> collapsed<?php endif?>"><span><?php echo getFolderName($g['path_layout'].$tpl)?></span> <small>(<?php echo $tpl?>)</small></a>
									<ul id="tree-layout-<?php echo $_i?>" class="collapse<?php if($tpl==$layout):?> in<?php endif?>">
										<?php $numSub[$tpl]=0;while(false !== ($tpl1 = readdir($dirs1))):?>
										<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
										<li>
											<a href="#." class="rb-leaf"></a>
											<a href="<?php echo $g['adm_href']?>&amp;layout=<?php echo $tpl?>&amp;sublayout=<?php echo $tpl1?>"><span<?php if($tpl==$layout&&$tpl1==$sublayout):?> class="rb-active"<?php endif?>><?php echo str_replace('.php','',$tpl1)?></span></a>
										</li>
										<?php $numSub[$tpl]++;endwhile?>
									</ul>
								</div>
							</li>
							<?php $_i++;endwhile?>
							</ul>
						</div>
					</div>
				</div>

				<div class="panel-footer">
					<a class="btn btn-default btn-block rb-modal-add-layout" data-toggle="modal" href="#modal_window"><?php echo _LANG('a1002','layout')?></a>
				</div>
			</div>
		</div>
	</div>

	<a name="__code__"></a>
	<div class="col-sm-8 col-md-8 col-lg-9">
		<div class="page-header">
			<h4>
				<?php echo getFolderName($g['path_layout'].$layout)?> <small>( <?php echo $layout?> )</small> <span class="label label-primary"><?php echo $_sublayout?></span>

				<div class="pull-right rb-top-btnbox hidden-xs">
					<div class="btn-group rb-btn-view">
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=layout_delete&amp;numSub=<?php echo $numSub[$layout]?>&amp;layout=<?php echo $layout?>&amp;sublayout=<?php echo $sublayout?>" class="btn btn-default" onclick="return hrefCheck(this,true,'<?php echo _LANG('a1003','layout')?>');"><?php echo _LANG('a1004','layout')?></a>
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=layout_delete&amp;numSub=1&amp;layout=<?php echo $layout?>&amp;sublayout=<?php echo $sublayout?>" onclick="return hrefCheck(this,true,'<?php echo _LANG('a1003','layout')?>');"><?php echo _LANG('a1004','layout')?> (<?php echo getFolderName($g['path_layout'].$layout)?>)</a></li>
						</ul>
					</div>

					<div class="btn-group rb-btn-view">
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=layout_delete&amp;numCopy=1&amp;layout=<?php echo $layout?>&amp;sublayout=<?php echo $sublayout?>" class="btn btn-default" onclick="return hrefCheck(this,true,'<?php echo _LANG('a1010','layout')?>');"><?php echo _LANG('a1009','layout')?></a>
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=layout_delete&amp;numCopy=2&amp;layout=<?php echo $layout?>" onclick="return hrefCheck(this,true,'<?php echo _LANG('a1010','layout')?>');"><?php echo _LANG('a1009','layout')?> (<?php echo getFolderName($g['path_layout'].$layout)?>)</a></li>
						</ul>
					</div>

				</div>
			</h4>
		</div>
		<ul class="nav nav-tabs rb-nav-tabs" role="tablist">
			<li<?php if($_SESSION['sh_layout_tab']=='tab_php'||!$_SESSION['sh_layout_tab']):$_etcfile=$sublayout?> class="active"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&module=<?php echo $module?>&layout=<?php echo $layout?>&sublayout=<?php echo $sublayout?>&etcfile=<?php echo $sublayout?>#__code__" onclick="sessionSetting('sh_layout_tab','tab_php','','');">Layout</a></li>
			<li<?php if($_SESSION['sh_layout_tab']=='tab_css'):$_etcfile=$_sublayout.'.css'?> class="active"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&module=<?php echo $module?>&layout=<?php echo $layout?>&sublayout=<?php echo $sublayout?>&etcfile=<?php echo $_sublayout?>.css#__code__" onclick="sessionSetting('sh_layout_tab','tab_css','','');">CSS</a></li>
			<li<?php if($_SESSION['sh_layout_tab']=='tab_js'):$_etcfile=$_sublayout.'.js'?> class="active"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&module=<?php echo $module?>&layout=<?php echo $layout?>&sublayout=<?php echo $sublayout?>&etcfile=<?php echo $_sublayout?>.js#__code__" onclick="sessionSetting('sh_layout_tab','tab_js','','');">Javascript</a></li>
			<li style="border:#ccc solid 1px;padding:5px;">
				<select class="form-control" onchange="location.href='<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&module=<?php echo $module?>&layout=<?php echo $layout?>&sublayout=<?php echo $sublayout?>&etcfile='+this.value+'#__code__';">
				<option value="">ETC</option>
				<?php $dirs = opendir($g['path_layout'].$layout.'/')?>
				<?php while(false !== ($tpl = readdir($dirs))):?>
				<?php if(substr($tpl,0,1) != '_' || $tpl == '_images' || is_file($g['path_layout'].$layout.'/'.$tpl))continue?>
				<?php $dirs1 = opendir($g['path_layout'].$layout.'/'.$tpl)?>
				<optgroup label="<?php echo $tpl?>" style="background:#333;color:#fff;">
				<?php while(false !== ($tpl1 = readdir($dirs1))):?>
				<?php if(!strstr($tpl1,'.php')&&!strstr($tpl1,'.css')&&!strstr($tpl1,'.js'))continue?>
				<option value="<?php echo $tpl?>/<?php echo $tpl1?>"<?php if($etcfile==$tpl.'/'.$tpl1):?> selected<?php endif?> style="background:#fff;color:#000;"><?php echo $tpl1?></option>
				<?php endwhile?>
				<?php closedir($dirs1)?>
				</optgroup>
				<?php endwhile?>
				<?php closedir($dirs)?>
				</select>
			</li>
		</ul>
		<?php $etcfile = $etcfile ? $etcfile : $_etcfile?>
		<?php $codfile = $g['path_layout'].$layout.'/'.$etcfile?>
		<?php $codeext = getExt($codfile)?>
		<?php $codeset = array('php' => 'application/x-httpd-php','css' => 'text/css','js' => 'text/javascript')?>
		<div id="tab-edit-area" class="tab-content">
			<div class="tab-pane fade active in" id="tab_etc">
				<form action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="a" value="layout_update">
				<input type="hidden" name="m" value="<?php echo $module?>">
				<input type="hidden" name="layout" value="<?php echo $layout?>">
				<input type="hidden" name="sublayout" value="<?php echo $sublayout?>">
				<input type="hidden" name="editfile" value="<?php echo $etcfile?>">
					<div class="rb-files">
						<div class="rb-codeview">
							<div class="rb-codeview-header">
								<ol class="breadcrumb pull-left">
									<li><?php echo _LANG('a1005','layout')?> :</li>
									<li>root</li>
									<li>layouts</li>
									<li><?php echo $layout?></li>
									<li><?php echo str_replace('/','</li><li class="active">',$etcfile)?></li>
								</ol>
								<button type="button" class="btn btn-default btn-xs pull-right" data-tooltip="tooltip" title="<?php echo _LANG('a1006','layout')?>" onclick="editFullSize('tab-edit-area',this);"><i class="fa fa-arrows-alt fa-lg"></i></button>
							</div>
							<div class="rb-codeview-body">			
								<textarea name="code" id="__code__" class="form-control" rows="35"><?php if(is_file($codfile)) echo htmlspecialchars(implode('',file($codfile)))?></textarea>
							</div>	
							<div class="input-group hidden-xs">
								<span class="input-group-addon"><small>Layout Name</small></span>
								<input type="text" name="name" value="<?php echo getFolderName($g['path_layout'].$layout)?>" class="form-control">

								<span class="input-group-addon"><small>Layout Folder</small></span>
								<input type="text" name="newLayout" value="<?php echo $layout?>" class="form-control">

								<span class="input-group-addon"><small>Sub-Layout</small></span>
								<input type="text" name="newSLayout" value="<?php echo $_sublayout?>" class="form-control">
							</div>
							<div class="rb-codeview-footer">
								<ul class="list-inline">
									<li><code><?php echo is_file($codfile) ? count(file($g['path_layout'].$layout.'/'.$etcfile)).' lines':'0 line'?></code></li>
									<li><code><?php echo is_file($codfile) ? getSizeFormat(@filesize($g['path_layout'].$layout.'/'.$etcfile),2) : '0 Byte'?></code></li>
									<li class="pull-right"><?php echo _LANG('a1007','layout')?></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="rb-submit">
						<button type="submit" class="btn btn-primary<?php if($g['device']):?> btn-block<?php endif?>"><?php echo _LANG('a1008','layout')?></button>
					</div>
				</form>
			</div>
		</div>
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
	mode: "<?php echo $codeset[$codeext]?$codeset[$codeext]:'application/x-httpd-php'?>",
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


<script>
$(document).ready(function()
{
	$('.rb-modal-add-layout').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=market&amp;front=modal.add&amp;addType=layout&amp;reload=Y')?>');
	});
});
function saveCheck(f)
{
	getIframeForAction(f);
	return true;
}
</script>
