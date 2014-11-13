<?php
if ($_mtype == 'page')
{
	$_HP = getUidData($table['s_page'],$uid);
	$_filekind = $r.'-pages/'.$_HP['id'];
	$_filetype= _LANG('a4001','site');
	$_filesbj = $_HP['name'];
}
if ($_mtype == 'menu')
{
	$_HM = getUidData($table['s_menu'],$uid);
	$_filekind = $r.'-menus/'.$_HM['id'];
	$_filetype = _LANG('a4002','site');
	$_filesbj = $_HM['name'];

	include $g['path_core'].'function/menu.func.php';
	$ctarr = getMenuCodeToPath($table['s_menu'],$_HM['uid'],0);
	$ctnum = count($ctarr);
	$_HM['code'] = '';
	for ($i = 0; $i < $ctnum; $i++) $_HM['code'] .= $ctarr[$i]['id'].($i < $ctnum-1 ? '/' : '');
}

if($type == 'source'):
$_editArray = array(
	'source' => array('','HTML (Basic)','.php'),
	'mobile' => array('mobile','HTML (Mobile Only)','.mobile.php'),
	'css' => array('css','CSS','.css'),
	'js' => array('js','Javascript','.js'),
);
?>
<!-- 직접 꾸미기 -->
<div id="rb-page-source">

	<div class="page-header">
		<h4>
			<?php echo $_filetype?> - <?php echo $_filesbj?> 

			<div class="pull-right rb-top-btnbox">
				<?php if($wysiwyg=='Y'):?>
				<div class="btn-group">
					<a class="btn btn-default rb-modal-photoset" href="#." data-toggle="modal" data-target="#modal_window"><i class="fa fa-photo"></i> <?php echo _LANG('a0004','site')?></a>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu pull-right" role="menu">
						<li><a href="#." data-toggle="modal" data-target="#modal_window" class="rb-modal-videoset"><i class="glyphicon glyphicon-facetime-video"></i> <?php echo _LANG('a0005','site')?></a></li>
						<li><a href="#." data-toggle="modal" data-target="#modal_window" class="rb-modal-widgetedit"><i class="fa fa-puzzle-piece"></i> <?php echo _LANG('a0006','site')?></a></li>
					</ul>
				</div>
				<?php else:?>
				<a href="#." class="btn btn-default rb-modal-widgetcode" data-toggle="modal" data-target="#modal_window"><i class="fa fa-puzzle-piece fa-lg"></i> <?php echo _LANG('a0006','site')?></a>
				<?php endif?>

				<?php if ($_mtype == 'page'):$_viewpage=RW('mod='.$_HP['id'])?>
				<!-- 페이지 -->
				<div class="btn-group rb-btn-view">
					<a href="<?php echo $_viewpage?>" class="btn btn-default"><?php echo _LANG('a0053','site')?></a>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu pull-right" role="menu">
						<li><a href="<?php echo $_viewpage?>" target="_blank"><i class="glyphicon glyphicon-new-window"></i> <?php echo _LANG('a0054','site')?></a></li>
					</ul>
				</div>
				<div class="btn-group">
					<a id="rb-list-back" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=<?php echo $_mtype?>&amp;uid=<?php echo $uid?>&amp;cat=<?php echo urlencode($cat)?>&amp;p=<?php echo $p?>&amp;recnum=<?php echo $recnum?>&amp;keyw=<?php echo urlencode($keyw)?>" class="btn btn-default"><i class="fa fa-list"></i> <?php echo _LANG('a4003','site')?></a>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu pull-right" role="menu">
						<?php if($wysiwyg=='Y'):?>
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=_edit&amp;_mtype=<?php echo $_mtype?>&amp;type=source&amp;uid=<?php echo $uid?>&amp;cat=<?php echo urlencode($cat)?>&amp;p=<?php echo $p?>&amp;recnum=<?php echo $recnum?>&amp;keyw=<?php echo urlencode($keyw)?>"><i class="fa fa-code"></i> <?php echo _LANG('a4004','site')?></a></li>
						<?php else:?>
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=_edit&amp;_mtype=<?php echo $_mtype?>&amp;type=source&amp;uid=<?php echo $uid?>&amp;cat=<?php echo urlencode($cat)?>&amp;p=<?php echo $p?>&amp;recnum=<?php echo $recnum?>&amp;keyw=<?php echo urlencode($keyw)?>&amp;wysiwyg=Y"><i class="fa fa-edit"></i> <?php echo _LANG('a4005','site')?></a></li>
						<?php endif?>
						<li class="divider"></li>
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=<?php echo $_mtype?>"><i class="fa fa-plus"></i> <?php echo _LANG('a0051','site')?></a></li>
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletepage&amp;uid=<?php echo $uid?>&back=Y" onclick="return hrefCheck(this,true,'<?php echo _LANG('a0056','site')?>');"><i class="glyphicon glyphicon-trash"></i> <?php echo _LANG('a4006','site')?></a></li>
					</ul>
				</div>
				<?php else:$_viewpage=RW('c='.$_HM['code'])?>
				<!-- 메뉴 -->
				<div class="btn-group">
					<a href="<?php echo $_viewpage?>" class="btn btn-default"><?php echo _LANG('a0053','site')?></a>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu pull-right" role="menu">
						<li><a href="<?php echo $_viewpage?>" target="_blank"><i class="glyphicon glyphicon-new-window"></i> <?php echo _LANG('a0054','site')?></a></li>
					</ul>
				</div>
				<div class="btn-group">
					<a id="rb-list-back" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=<?php echo $_mtype?>&amp;cat=<?php echo $cat?>&amp;code=<?php echo $code?>" class="btn btn-default"><i class="glyphicon glyphicon-ok"></i> <?php echo _LANG('a4007','site')?></a>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu pull-right" role="menu">
						<?php if($wysiwyg=='Y'):?>
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=_edit&amp;_mtype=<?php echo $_mtype?>&amp;type=source&amp;uid=<?php echo $uid?>&amp;cat=<?php echo $cat?>&amp;code=<?php echo $code?>"><i class="fa fa-code"></i> <?php echo _LANG('a4004','site')?></a></li>
						<?php else:?>
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=_edit&amp;_mtype=<?php echo $_mtype?>&amp;type=source&amp;uid=<?php echo $uid?>&amp;cat=<?php echo $cat?>&amp;code=<?php echo $code?>&amp;wysiwyg=Y"><i class="fa fa-edit"></i> <?php echo _LANG('a4005','site')?></a></li>
						<?php endif?>
						<li class="divider"></li>
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=<?php echo $_mtype?>"><i class="fa fa-plus"></i> <?php echo _LANG('a0052','site')?></a></li>
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletemenu&amp;cat=<?php echo $cat?>&amp;back=Y" onclick="return hrefCheck(this,true,'<?php echo _LANG('a0056','site')?>');"><i class="glyphicon glyphicon-trash"></i> <?php echo _LANG('a4008','site')?></a></li>
					</ul>
				</div>
				<?php endif?>
			</div>
		</h4>
	</div>

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return sourcecheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>">
	<input type="hidden" name="m" value="<?php echo $module?>">
	<input type="hidden" name="a" value="sourcewrite">
	<input type="hidden" name="type" value="<?php echo $_mtype?>">
	<?php if($_mtype=='menu'):?>
	<input type="hidden" name="uid" value="<?php echo $_HM['uid']?>">
	<input type="hidden" name="id" value="<?php echo $_HM['id']?>">
	<?php else:?>
	<input type="hidden" name="id" value="<?php echo $_HP['id']?>">
	<?php endif?>
	<input type="hidden" name="wysiwyg" value="<?php echo $wysiwyg?>">
	<input type="hidden" name="editFilter" value="<?php echo $d['admin']['editor']?>">

	
	<?php 
	if($wysiwyg=='Y'):
	$__SRC__ = is_file($g['path_page'].$_filekind.'.php') ? htmlspecialchars(implode('',file($g['path_page'].$_filekind.'.php'))) : '';
	include $g['path_plugin'].$d['admin']['editor'].'/import.php';
	?>

	<div class="form-group">
		<button class="btn btn-primary btn-block btn-lg" id="rb-submit-button" type="submit"><i class="fa fa-check fa-lg"></i> <?php echo _LANG('a4009','site')?></button>
	</div>
	<?php else:?>
	<div id="tab-edit-area">
		<div class="form-group">
			<div class="panel-group" id="accordion">
				<?php $_i=1;foreach($_editArray as $_key => $_val):?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#site-code-<?php echo $_key?>" onclick="focusArea('code_<?php echo $_key?>');sessionSetting('sh_sys_page_edit','<?php echo $_key?>','','');">
								<?php echo $_val[1]?>
								<?php if(is_file($g['path_page'].$_filekind.$_val[2])):?><i class="fa fa-check-circle" title="<?php echo _LANG('a0050','site')?>" data-tooltip="tooltip"></i><?php endif?>
							</a>
						</h4>
					</div>
					<div id="site-code-<?php echo $_key?>" class="panel-collapse collapse<?php if(($_key==$_SESSION['sh_sys_page_edit']) || (!$_SESSION['sh_sys_page_edit']&&$_i==1)):?> in<?php endif?>">

						<div class="rb-codeview">
							<div class="rb-codeview-header">
								<ol class="breadcrumb pull-left">
									<li><?php echo _LANG('a4010','site')?> :</li>
									<li>root</li>
									<li>pages</li>
									<?php if($_mtype=='menu'):?>
									<li>menu</li>
									<?php endif?>
									<li class="active"><?php echo str_replace('menu/','',$_filekind).$_val[2]?></li>
								</ol>
								<button type="button" class="btn btn-default btn-xs pull-right" data-tooltip="tooltip" title="<?php echo _LANG('a0068','site')?>" onclick="_nowArea='<?php echo $_key?>';editFullSize('tab-edit-area',this);"><i class="fa fa-arrows-alt fa-lg"></i></button>
							</div>
							<div class="rb-codeview-body">			
								<textarea name="<?php echo $_key?>" id="code_<?php echo $_key?>" class="form-control" rows="35"><?php if(is_file($g['path_page'].$_filekind.$_val[2])) echo htmlspecialchars(implode('',file($g['path_page'].$_filekind.$_val[2])))?></textarea>
							</div>	
							<div class="rb-codeview-footer">
								<ul class="list-inline">
									<li><code><?php echo is_file($g['path_page'].$_filekind.$_val[2])?count(file($g['path_page'].$_filekind.$_val[2])):'0'?> lines</code></li>
									<li><code><?php echo is_file($g['path_page'].$_filekind.$_val[2])?getSizeFormat(@filesize($g['path_page'].$_filekind.$_val[2]),2):'0B'?></code></li>
									<li class="pull-right"><?php echo _LANG('a4011','site')?></li>
								</ul>
							</div>
						</div>

					</div>
				</div>
				<?php $_i++;endforeach?>
			</div>
		</div>
		<div class="form-group rb-submit">
			<button class="btn btn-primary btn-block btn-lg" id="rb-submit-button" type="submit"><i class="fa fa-check fa-lg"></i> <?php echo _LANG('a4009','site')?></button>
		</div>
	</div>
	<?php endif?>

	</form>
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
var editor_php1 = CodeMirror.fromTextArea(getId('code_source'), {
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
var editor_php2 = CodeMirror.fromTextArea(getId('code_mobile'), {
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
var editor_css = CodeMirror.fromTextArea(getId('code_css'), {
	mode: "text/css",
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
var editor_js = CodeMirror.fromTextArea(getId('code_js'), {
	mode: "text/javascript",
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
editor_php1.setSize('100%','550px');
editor_php2.setSize('100%','550px');
editor_css.setSize('100%','550px');
editor_js.setSize('100%','550px');

_isCodeEdit = true;
function _codefullscreen()
{
	if(_nowArea == 'source') editor_php1.setOption('fullScreen', !editor_php1.getOption('fullScreen'));
	if(_nowArea == 'mobile') editor_php2.setOption('fullScreen', !editor_php2.getOption('fullScreen'));
	if(_nowArea == 'css') editor_css.setOption('fullScreen', !editor_css.getOption('fullScreen'));
	if(_nowArea == 'js') editor_js.setOption('fullScreen', !editor_js.getOption('fullScreen'));
}
</script>
<!-- @codemirror -->
<?php endif?>



<script>
_nowArea = '';
function focusArea(xid)
{

}
function sourcecheck(f)
{
	var f = document.procForm;
	if(confirm('<?php echo _LANG('a0049','site')?>         '))
	{
		getIframeForAction(f);
		return true;
	}
	return false;
}
getId('rb-more-tab-<?php echo $_mtype=='page'?'3':'2'?>').className = 'active';
</script>
<?php endif?>



















<?php if($type == 'widget'):?>
<?php $d['page']['widget'] = array()?>
<?php if(is_file($g['path_page'].$_filekind.'.widget.php')) include $g['path_page'].$_filekind.'.widget.php'?>

<!-- 위젯 꾸미기 -->
<div id="rb-page-widget">

	<div class="page-header">
		<h4>
			<?php echo $_filetype?> <?php echo _LANG('a4012','site')?> - <?php echo $_filesbj?>


			<div class="pull-right rb-top-btnbox">

				<a href="#." class="btn btn-default rb-modal-widgetcall" data-toggle="modal" data-target="#modal_window"><i class="fa fa-puzzle-piece fa-lg"></i> <?php echo _LANG('a4013','site')?></a>

				<?php if ($_mtype == 'page'):$_viewpage=RW('mod='.$_HP['id'])?>
				<!-- 페이지 -->
				<div class="btn-group rb-btn-view">
					<a href="<?php echo $_viewpage?>" class="btn btn-default"><?php echo _LANG('a0053','site')?></a>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu pull-right" role="menu">
						<li><a href="<?php echo $_viewpage?>" target="_blank"><i class="glyphicon glyphicon-new-window"></i> <?php echo _LANG('a0054','site')?></a></li>
					</ul>
				</div>
				<div class="btn-group">
					<a id="rb-list-back" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=<?php echo $_mtype?>&amp;uid=<?php echo $uid?>&amp;cat=<?php echo urlencode($cat)?>&amp;p=<?php echo $p?>&amp;recnum=<?php echo $recnum?>&amp;keyw=<?php echo urlencode($keyw)?>" class="btn btn-default"><i class="fa fa-list"></i> <?php echo _LANG('a4003','site')?></a>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu pull-right" role="menu">
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=<?php echo $_mtype?>"><i class="fa fa-plus"></i> <?php echo _LANG('a0051','site')?></a></li>
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletepage&amp;uid=<?php echo $uid?>&back=Y" onclick="return hrefCheck(this,true,'<?php echo _LANG('a0056','site')?>');"><i class="glyphicon glyphicon-trash"></i> <?php echo _LANG('a4006','site')?></a></li>
					</ul>
				</div>
				<?php else:$_viewpage=RW('c='.$_HM['code'])?>
				<!-- 메뉴 -->
				<div class="btn-group">
					<a href="<?php echo $_viewpage?>" class="btn btn-default"><?php echo _LANG('a4014','site')?></a>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu pull-right" role="menu">
						<li><a href="<?php echo $_viewpage?>" target="_blank"><i class="glyphicon glyphicon-new-window"></i> <?php echo _LANG('a0054','site')?></a></li>
					</ul>
				</div>
				<div class="btn-group">
					<a id="rb-list-back" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=<?php echo $_mtype?>&amp;cat=<?php echo $cat?>&amp;code=<?php echo $code?>" class="btn btn-default"><i class="glyphicon glyphicon-ok"></i> <?php echo _LANG('a4007','site')?></a>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu pull-right" role="menu">
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=<?php echo $_mtype?>"><i class="fa fa-plus"></i> <?php echo _LANG('a0052','site')?></a></li>
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletemenu&amp;cat=<?php echo $cat?>&amp;back=Y" onclick="return hrefCheck(this,true,'<?php echo _LANG('a0056','site')?>');"><i class="glyphicon glyphicon-trash"></i> <?php echo _LANG('a4008','site')?></a></li>
					</ul>
				</div>
				<?php endif?>
			</div>
		</h4>
	</div>

	<form name="procForm" action="<?php echo $g['s']?>/" method="post">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>">
	<input type="hidden" name="a" value="widgetwrite">
	<input type="hidden" name="type" value="<?php echo $_mtype?>">
	<input type="hidden" name="escapevar" value="">
	<?php if($_mtype=='menu'):?>
	<input type="hidden" name="uid" value="<?php echo $_HM['uid']?>">
	<input type="hidden" name="id" value="<?php echo $_HM['id']?>">
	<?php else:?>
	<input type="hidden" name="id" value="<?php echo $_HP['id']?>">
	<?php endif?>
	<input type="hidden" name="iframe" value="Y">
	<input type="hidden" name="mainheight" value="Y">
	</form>
	<div id="workSpace" class="posrel"></div>

	<div class="form-group">
		<button class="btn btn-primary btn-block btn-lg" id="rb-submit-button" type="button" onclick="widgetcheck();"><i class="fa fa-check fa-lg"></i> <?php echo _LANG('a4015','site')?></button>
	</div>
</div>


<script>
var isIE = document.all;
var isNN = !document.all&&getId;
var isHot = false;
var maxTiles = 20;
var MovableItem;
var moveObject = new Array(maxTiles);
var blocktitle = new Array(maxTiles);
var blockarray = new Array(maxTiles);
var scrollAmt  = new Array();

function layoutWidth(obj)
{
	var f = document.procForm;
	if (obj.value != '')
	{
		f.mainwidth.value = obj.value;
		getId('workSpace').style.width = obj.value;
	}
}
function startMove(e)
{
    if (!MovableItem) return;
    canvas = isIE ? "BODY" : "HTML";
        activeItem=isIE ? event.srcElement : e.target;  
        offsetx=isIE ? event.clientX : e.clientX;
        offsety=isIE ? event.clientY : e.clientY;
        lastX=parseInt(MovableItem.style.left);
        lastY=parseInt(MovableItem.style.top);
        lastW=parseInt(MovableItem.style.width);
        lastH=parseInt(MovableItem.style.height);
    if (offsetx+scrollAmt[0]>=(MovableItem.parentNode.offsetLeft+parseInt(MovableItem.style.left)+(MovableItem.offsetWidth*0.95)) || offsety+scrollAmt[1]>=(MovableItem.parentNode.offsetTop+parseInt(MovableItem.style.top)+(MovableItem.offsetHeight*0.95)) ){edge=true;MovableItem.style.cursor='se-resize';} else{edge=false;MovableItem.style.cursor='move';}
    moveEnabled=true;
    document.onmousemove=moveIt;
}
function widgetMove(obj, X, Y)
{
   scrollAmt = puGetScrollXY();
   if (X+scrollAmt[0]>=(obj.parentNode.offsetLeft+parseInt(obj.style.left)+(obj.offsetWidth*0.95)) || Y+scrollAmt[1]>=(obj.parentNode.offsetTop+parseInt(obj.style.top)+(obj.offsetHeight*0.95)) ) {obj.style.cursor='se-resize';} else{obj.style.cursor='move';}
}
function moveIt(e)
{
	if (!moveEnabled||!MovableItem) return;

	getWHTL();

	var w = isIE ? event.clientX-offsetx +lastW : e.clientX-offsetx+lastW;
	var h = isIE ? event.clientY-offsety +lastH : e.clientY-offsety+lastH;
	var x = isIE ? lastX+event.clientX-offsetx : lastX+e.clientX-offsetx;
	var y = isIE ? lastY+event.clientY-offsety : lastY+e.clientY-offsety;


	if (edge)
	{
		MovableItem.style.width = w+'px'; 
		MovableItem.style.height = h+'px'; 
		return false;
	}
	else
	{
		MovableItem.style.top = y+'px';
		MovableItem.style.left = x+'px';
		return false;
	}
}

function puGetScrollXY()
{
    var scrollXamt = 0, scrollYamt = 0;
    if( typeof( window.pageYOffset ) == 'number' )
	{
        scrollYamt = window.pageYOffset;
        scrollXamt = window.pageXOffset;
    } 
	else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) 
	{
        scrollYamt = document.body.scrollTop;
        scrollXamt = document.body.scrollLeft;
    } 
	else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) 
	{
        scrollYamt = document.documentElement.scrollTop;
        scrollXamt = document.documentElement.scrollLeft;
    }
    return [ scrollXamt, scrollYamt ];
}
function createTile(w,h,t,l)
{
	var i;
    for (i=0; i<maxTiles; i++)
	{
        if (moveObject[i].style.display == 'none')
		{
            moveObject[i].style.display = 'block';
            moveObject[i].style.width = w;
            moveObject[i].style.height = h;
            moveObject[i].style.top = t;
            moveObject[i].style.left = l;
			
			MovableItem = moveObject[i];
			getWHTL();
			return;
        }
    }
}
function poplayer(topObject)
{
	if (!topObject) return;
    for (var i=0; i<moveObject.length; i++)
	{
        moveObject[i].style.border = '#C5D7EF solid 1px';
        if (moveObject[i].style.zIndex > topObject.style.zIndex-1 && moveObject[i]!=topObject)
        {
			moveObject[i].style.zIndex = moveObject[i].style.zIndex-1;
		}
    }
    
	topObject.style.zIndex = moveObject.length-1;
    topObject.style.border = '#1A62BA solid 1px';
}
function getWHTL()
{
	var i;
	var w = parseInt(MovableItem.offsetWidth);
	var h = parseInt(MovableItem.offsetHeight);
	var t = parseInt(MovableItem.style.top);
	var l = parseInt(MovableItem.style.left);

	getId('whtl'+MovableItem.id.replace('popup','')).innerHTML = '<div>W : <input type="text" id="whtl'+MovableItem.id.replace('popup','')+'_w" value="'+(w)+'" size="1" title="<?php echo _LANG('a4016','site')?>" onkeypress="widgetAply(\''+MovableItem.id.replace('popup','')+'\',event)"> / '+ 'H : <input type="text" id="whtl'+MovableItem.id.replace('popup','')+'_h" value="'+(h)+'" size="1" title="<?php echo _LANG('a4017','site')?>" onkeypress="widgetAply(\''+MovableItem.id.replace('popup','')+'\',event)"> / '+ 'T : <input type="text" id="whtl'+MovableItem.id.replace('popup','')+'_t" value="'+(t)+'" size="1" title="<?php echo _LANG('a4018','site')?>" onkeypress="widgetAply(\''+MovableItem.id.replace('popup','')+'\',event)"> / '+ 'L : <input type="text" id="whtl'+MovableItem.id.replace('popup','')+'_l" value="'+(l)+'" size="1" title="<?php echo _LANG('a4019','site')?>" onkeypress="widgetAply(\''+MovableItem.id.replace('popup','')+'\',event)"> ' + '<!--input type="button" value="<?php echo _LANG('a4020','site')?>" class="btngray" style="height:20px;position:relative;top:1px;" onclick="widgetAply(\''+MovableItem.id.replace('popup','')+'\',event)"></div>';
}
function widgetAply(layer,e)
{
	var keycode = event.keyCode ? event.keyCode : e.which;
	
	if (keycode == 13)
	{
		var w = getId('whtl'+layer+'_w').value;
		var h = getId('whtl'+layer+'_h').value;
		var t = getId('whtl'+layer+'_t').value;
		var l = getId('whtl'+layer+'_l').value;
		
		moveObject[layer].style.position = 'absolute';
		moveObject[layer].style.width = parseInt(w) + 'px';
		moveObject[layer].style.height = parseInt(h) + 'px';
		moveObject[layer].style.top = t + 'px';
		moveObject[layer].style.left = l + 'px';
	}
}
function makeWorkspace()
{
	var i;
    var workspace='';
	var widgetvar;

    for (i=0; i<maxTiles; i++)
	{
		widgetvar=blockarray[i].split(',');
        workspace=workspace+'<div id=popup'+i+' style="'+
        ' z-Index:'+i+';display:none;position:absolute;left:0px;top:0px;filter:alpha(opacity=70);opacity:0.7;background:#ffffff url(\'<?php echo $g['s']?>/modules/site/lang.korean/pages/images/btn_resize.gif\') bottom right no-repeat;border:#C5D7EF solid 1px;"'+
        ' onSelectStart="return false;"'+
        ' onmousedown="MovableItem=this;poplayer(this);"'+
        ' onMouseover="isHot=true;"'+
        ' onMousemove="widgetMove(this,event.clientX,event.clientY);" '+
        ' onMouseout="isHot=false;">'+

		' <div style="height:30px;border-bottom:#C5D7EF;background:#D4E6FC;color:#224499;font-weight:bold;padding:5px 10px 0 10px;">'+
		' <div><img src="<?php echo $g['s']?>/modules/site/lang.korean/pages/images/btn_move.gif" style="position:relative;top:-2px;" title="<?php echo _LANG('a4021','site')?>" data-tooltip="tooltip"> <span id="wtitle'+i+'" style="position:relative;top:-1px;">'+blocktitle[i]+'</span></div>'+
		' <div style="text-align:right;position:relative;top:-20px;">'+
		' <img src="<?php echo $g['s']?>/modules/site/lang.korean/pages/images/btn_conf.gif" alt="" title="<?php echo _LANG('a4022','site')?>" onmousedown="getWidget('+i+');" style="cursor:pointer;" data-tooltip="tooltip" class="rb-modal-widgetcall-modify"  data-toggle="modal" data-target="#modal_window">'+
		' <img src="<?php echo $g['s']?>/modules/site/lang.korean/pages/images/btn_del.gif" alt="" title="<?php echo _LANG('a4023','site')?>" onclick="delWidget('+i+');" style="cursor:pointer;"data-tooltip="tooltip">'+
		' </div>'+
		' <div style="clear:both;"></div>'+
		' </div>'+
		' <div id="whtl'+i+'" style="font-size:12px;font-family:arial;color:#555;padding:7px 0 0 10px;width:100%;height:100%;background:url(\'<?php echo $g['s']?>/modules/site/lang.korean/pages/images/widget/thumb_small.gif\') center center no-repeat;"></div>'+
		'</div>';
    }
    getId('workSpace').innerHTML = workspace;
}
function delWidget(i)
{
    if (!moveObject[i]) return;
	if (confirm('<?php echo _LANG('a0056','site')?> '))
	{
		moveObject[i].style.display = "none";
		blocktitle[i] = '';
		blockarray[i] = '';
	}
}
var tHeight = 0;
function makeMap(f)
{
	var i;
	var validMap = false;
	var mapSource = '\n\n';

    for (i=0; i<maxTiles; i++)
	{
        if (moveObject[i].style.display=='block')
		{
            mapSource=mapSource+

			'$d[\'page\'][\'widget\']['+i+'][\'name\'] = "'+blocktitle[i]+'";\n'+
			'$d[\'page\'][\'widget\']['+i+'][\'size\'] = "'+moveObject[i].offsetWidth+'px|'+moveObject[i].offsetHeight+'px|'+parseInt(moveObject[i].style.top)+'px|'+parseInt(moveObject[i].style.left)+'px";\n'+
			'$d[\'page\'][\'widget\']['+i+'][\'prop\'] = "'+blockarray[i]+'";\n\n';

			validMap = true;
			if (tHeight < parseInt(moveObject[i].style.top) + moveObject[i].offsetHeight)
			{
				tHeight = parseInt(moveObject[i].style.top) + moveObject[i].offsetHeight;
			}
        }
    }
	f.escapevar.value = mapSource;
}
function widgetcheck()
{
	var f = document.procForm;
	if(confirm('<?php echo _LANG('a0049','site')?>         '))
	{
		makeMap(f);
		f.mainheight.value = tHeight + 50;
		getIframeForAction(f);
		f.submit();
	}
}
var _Wdropfield = -1;
var _Woption = '';
function getWidget(i)
{
	var n = i < 0 ? 0 : i;
	var g = i < 0 ? '' : blockarray[i];

	_Wdropfield = n;
	_Woption = g.replace(/&/g,'[!]');
}
function setWidgetBox()
{
	var i;
    document.onmousedown = startMove;
    document.onmouseup = Function("moveEnabled=false;MovableItem=''");

	<?php $i = 0?>
	<?php foreach($d['page']['widget'] as $_key => $_val):?>
	blocktitle[<?php echo $i?>] = "<?php echo $d['page']['widget'][$_key]['name']?>";
	blockarray[<?php echo $i?>] = "<?php echo $d['page']['widget'][$_key]['prop']?>";
	<?php $i++; endforeach?>

	for(i=0;i<maxTiles;i++)
	{
		if (!blocktitle[i]) blocktitle[i] = '';
		if (!blockarray[i]) blockarray[i] = '';
	}

	makeWorkspace();

	for(i=0;i<maxTiles;i++) moveObject[i] = getId('popup'+i);

	<?php $i = 0?>
	<?php foreach($d['page']['widget'] as $_key => $_val):?>
	<?php $_size = explode('|',$d['page']['widget'][$_key]['size'])?>
	
	createTile("<?php echo $_size[0]?>","<?php echo $_size[1]?>","<?php echo $_size[2]?>","<?php echo $_size[3]?>");

	<?php $i++; endforeach?>

}
setWidgetBox();
getId('rb-more-tab-<?php echo $_mtype=='page'?'3':'2'?>').className = 'active';
</script>
<?php endif?>



<script>
$('.rb-modal-widgetcode').on('click',function() {
	modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.widget&amp;isWcode=Y')?>');
});
$('.rb-modal-widgetedit').on('click',function() {
	modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.widget&amp;isWcode=Y&amp;isEdit=Y')?>');
});
$('.rb-modal-photoset').on('click',function() {
	modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=editor')?>');
});
$('.rb-modal-videoset').on('click',function() {
	modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.video.media&amp;dropfield=editor')?>');
});
$('.rb-modal-widgetcall').on('click',function() {
	modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.widget')?>&amp;dropfield=-1');
});
$('.rb-modal-widgetcall-modify').on('click',function() {
	modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.widget')?>&amp;dropfield='+_Wdropfield+'&amp;option='+_Woption);
});

<?php if($d['admin']['dblclick']):?>
document.ondblclick = function(event)
{
	getContext('<li><a href="<?php echo $_viewpage?>"><?php echo _LANG('a4024','site')?></a></li><li><a href="#." onclick="getId(\'rb-list-back\').click();"><?php echo _LANG('a4025','site')?></a></li><li class="divider"></li><li><a href="#." onclick="getId(\'rb-submit-button\').click();"><?php echo _LANG('a4026','site')?></a></li>',event);	
}
<?php endif?>
</script>
