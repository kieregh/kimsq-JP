<?php
function getSearchFileList($folder)
{
	$incs = array();
	$dirh = opendir($folder);
	while(false !== ($files = readdir($dirh))) 
	{ 
		if(substr($files,-4)!='.php') continue;
		$incs[] = str_replace('.php','',$files);
	} 
	closedir($dirh);
	return $incs;
}

include $g['path_module'].$module.'/var/var.search.php';
include $g['path_module'].$module.'/var/var.order.php';
$MODULE_LIST = getDbArray($table['s_module'],'','*','gid','asc',0,$p);
$_names = array();
$PAGESET = array();
$TMPST = array();
$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p);
$SITEN = db_num_rows($SITES);
?>

<div class="row" id="search-body">
	<div class="col-sm-4 col-lg-3 rb-aside">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading rb-icon">
					<div class="icon">
					<i class="fa fa-search fa-2x"></i>
					</div>
					<h4 class="panel-title">
						<a class="accordion-toggle collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseOne">
							<?php echo _LANG('a1001','search')?>
						</a>
					</h4>
				</div>
				
				<div class="panel-collapse collapse" id="collapseOne">
					<?php $_i=0;while($MD = db_fetch_array($MODULE_LIST)):?>
					<?php $forsearching_folder=$g['path_module'].$MD['id'].'/for-searching'?>
					<?php if(!is_dir($forsearching_folder)) continue?>
					<div class="panel-body">
						<h5><small><i class="<?php echo $MD['icon']?>"></i> <?php echo $MD['name']?> (<?php echo $MD['id']?>)</small></h5>
						<div class="dd">
							<ol class="dd-list">
								<?php foreach(getSearchFileList($forsearching_folder) as $_file):?>
								<?php $_namefile = $g['path_module'].$module.'/var/names/'.$MD['id'].'-'.$_file.'.txt'?>
								<?php $_names = is_file($_namefile) ? explode('|',implode('',file($_namefile))):array()?>
								<?php $PAGESET[$MD['id'].'_'.$_file] = array('filename'=>$_file,'filerename'=>$_names[0]?$_names[0]:$_file,'moduleid'=>$MD['id'],'modulename'=>$MD['name'],'site'=>$_names[1],'filepath'=>$forsearching_folder.'/'.$_file)?>
								<li class="dd-item dd3-item<?php if($MD['id'].'/'.$_file==$searchfile):?> rb-active<?php endif?>">
									<div class="dd-handle dd3-handle dd3-handle-none"></div>
									<div class="dd3-content">
										<i class="fa fa-file" style="position:absolute;left:10px;top:10px;color:#000;"></i>
										<a href="<?php echo $g['adm_href']?>&amp;searchfile=<?php echo $MD['id'].'/'.$_file?>"><?php echo $_file?>.php</a>
									</div>
								</li>
								<?php endforeach?>
							</ol>
						</div>
					</div>
					<?php $_i++;endwhile?>
					<?php if(!$_i):?>
					<div class="panel-body rb-none">
						<?php echo _LANG('a1002','search')?>
					</div>
					<?php endif?>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading rb-icon">
					<div class="icon">
						<i class="fa fa-retweet fa-2x"></i>
					</div>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">
							<?php echo _LANG('a1003','search')?>
						</a>
					</h4>
				</div>
				<div class="panel-body rb-panel-form">
					<select class="form-control" onchange="goHref('<?php echo $g['s']?>/?m=<?php echo $m?>&module=<?php echo $module?>&searchfile=<?php echo $searchfile?>&r='+this.value);">
					<?php while($S = db_fetch_array($SITES)):$TMPST[]=array($S['name'],$S['id'])?>
					<option value="<?php echo $S['id']?>"<?php if($r==$S['id']):?> selected<?php endif?>><?php echo $S['name']?> (<?php echo $S['id']?>)</option>
					<?php endwhile?>
					</select>
				</div>
				<div class="panel-collapse collapse in" id="collapseTwo">
					<form role="form" action="<?php echo $g['s']?>/" method="post">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="<?php echo $module?>">
					<input type="hidden" name="a" value="order">
					<input type="hidden" name="auto" value="">
					<input type="hidden" name="autoCheck" value="<?php echo $autoCheck?>">
						<div class="panel-body">
							<div class="dd" id="nestable-menu">
								<ol class="dd-list">
									<?php $_i=0;if(count($d['search_order'])):foreach($d['search_order'] as $_key => $_val):?>
									<?php if(!is_array($PAGESET[$_key]))continue?>
									<li class="dd-item dd3-item<?php if($PAGESET[$_key]['moduleid'].'/'.$PAGESET[$_key]['filename']==$searchfile):?> rb-active<?php endif?>" data-id="<?php echo $_i?>">
										<div class="dd-handle dd3-handle"></div>
										<div class="dd3-content"><a href="<?php echo $g['adm_href']?>&amp;searchfile=<?php echo $PAGESET[$_key]['moduleid'].'/'.$PAGESET[$_key]['filename']?>" title="<?php echo $PAGESET[$_key]['filename']?>.php" data-tooltip="tooltip"><?php echo $PAGESET[$_key]['filerename']?></a> <small title="<?php echo $PAGESET[$_key]['modulename']?>" data-tooltip="tooltip">(<?php echo $PAGESET[$_key]['moduleid']?>)</small></div>
										<div class="dd-checkbox">
											<input type="checkbox" name="searchmembers[]" value="<?php echo $PAGESET[$_key]['moduleid']?>_<?php echo $PAGESET[$_key]['filename']?>|<?php echo $PAGESET[$_key]['filerename']?>|<?php echo $PAGESET[$_key]['site']?>|<?php echo $PAGESET[$_key]['filepath']?>" checked class="hidden"><i class="glyphicon glyphicon-eye-<?php echo strstr($PAGESET[$_key]['site'],'['.$r.']')?'open':'close rb-eye-close'?>"></i>
										</div>
									</li>
									<?php $_i++;endforeach;$_nowOrderNum=$_i;endif?>
									<?php foreach($PAGESET as $_key => $_val):?>
									<?php if(is_array($d['search_order'][$_key]))continue?>
									<li class="dd-item dd3-item<?php if($_val['moduleid'].'/'.$_val['filename']==$searchfile):?> rb-active<?php endif?>" data-id="<?php echo $_i?>">
										<div class="dd-handle dd3-handle"></div>
										<div class="dd3-content"><a href="<?php echo $g['adm_href']?>&amp;searchfile=<?php echo $_val['moduleid'].'/'.$_val['filename']?>" title="<?php echo $_val['filename']?>.php" data-tooltip="tooltip"><?php echo $_val['filerename']?></a> <small title="<?php echo $_val['modulename']?>" data-tooltip="tooltip">(<?php echo $_val['moduleid']?>)</small></div>
										<div class="dd-checkbox">
											<input type="checkbox" name="searchmembers[]" value="<?php echo $_val['moduleid']?>_<?php echo $_val['filename']?>|<?php echo $_val['filerename']?>|<?php echo $_val['site']?>|<?php echo $_val['filepath']?>" checked class="hidden"><i class="glyphicon glyphicon-eye-<?php echo strstr($_val['site'],'['.$r.']')?'open':'close rb-eye-close'?>"></i>
										</div>
									</li>
									<?php $_i++;endforeach;$_nowOrderNum=$_i?>
								</ol>
							</div>
						</div>
						<?php if(!$_i):?>
						<div class="panel-body rb-none">
							<?php echo _LANG('a1004','search')?>
						</div>
						<?php endif?>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-8 col-lg-9 rb-main">
		<?php
		if($searchfile):
		$_searchfl = str_replace('/','-',$searchfile);
		$_namefile = $g['path_module'].$module.'/var/names/'.$_searchfl.'.txt';
		if (is_file($_namefile)) $_names = explode('|',implode('',file($_namefile)));
		else $_names = array();
		?>

		<div class="page-header">
			<h4>
				<?php echo _LANG('a1005','search')?>
				<div class="pull-right rb-top-btnbox hidden-xs">
					<a href="<?php echo $g['adm_href']?>" class="btn btn-default"><i class="glyphicon glyphicon-cog"></i> <?php echo _LANG('a1006','search')?></a>
					<div class="btn-group rb-btn-view">
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>" class="btn btn-default"><?php echo _LANG('a1007','search')?></a>
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>" target="_blank"><i class="glyphicon glyphicon-new-window"></i> <?php echo _LANG('a1008','search')?></a></li>
						</ul>
					</div>
				</div>
			</h4>
		</div>

		<form name="procForm" class="form-horizontal" role="form" action="<?php echo $g['s']?>/" method="post" onsubmit="return procCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="search_edit">
		<input type="hidden" name="namefile" value="<?php echo $_searchfl?>">
		<input type="hidden" name="searchfile" value="<?php echo $searchfile?>">

			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo _LANG('a1009','search')?></label>
				<div class="col-sm-9">
					<input type="text" name="name" value="<?php echo $_names[0]?$_names[0]:$_searchfl?>" class="form-control">
					<p class="form-control-static text-muted">
						<small><?php echo _LANG('a1010','search')?></small>
					</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo _LANG('a1011','search')?></label>
				<div class="col-sm-9">
					<?php foreach($TMPST as $_val):?>
					<label class="checkbox-inline rb-no-indent">
						<input type="checkbox" name="aply_sites[]" value="<?php echo $_val[1]?>"<?php if(strstr($_names[1],'['.$_val[1].']')):?> checked<?php endif?>> <i></i><strong><?php echo $_val[0]?></strong> <small class="text-muted">(<?php echo $_val[1]?>)</small>
					</label>
					<?php endforeach?>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-9">
					<div class="btn-group">
						<button type="button" class="btn btn-default" onclick="checkboxChoice('aply_sites[]',true);"><?php echo _LANG('a1012','search')?></button>
						<button type="button" class="btn btn-default" onclick="checkboxChoice('aply_sites[]',false);"><?php echo _LANG('a1013','search')?></button>
					</div>
					<div class="btn-group">
						<button class="btn btn-primary" type="submit" id="rb-submit-button"><i class="fa fa-check fa-lg"></i> <?php echo _LANG('a1014','search')?></button>
					</div>
				</div>
			</div>
		</form>


		<?php else:?>
		<div class="page-header">
			<h4>
				<?php echo _LANG('a1006','search')?>
				<div class="pull-right rb-top-btnbox hidden-xs">
					<div class="btn-group rb-btn-view">
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>" class="btn btn-default"><?php echo _LANG('a1007','search')?></a>
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>" target="_blank"><i class="glyphicon glyphicon-new-window"></i> <?php echo _LANG('a1008','search')?></a></li>
						</ul>
					</div>
				</div>			
			</h4>
		</div>

		<form name="saveForm" class="form-horizontal" role="form" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="config">
			<input type="hidden" name="layout" value="">

			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo _LANG('a1015','search')?></label>
				<div class="col-sm-9">
					<select class="form-control" name="theme">
						<?php $dirs = opendir($g['path_module'].$module.'/themes')?>
						<?php while(false !== ($theme = readdir($dirs))):?>
						<?php if(strpos('_..',$theme))continue?>
						<option value="<?php echo $theme?>"<?php if($d['search']['theme']==$theme):?> selected<?php endif?>><?php echo $theme?></option>
						<?php endwhile?>
						<?php closedir($dirs)?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo _LANG('a1016','search')?></label>
				<div class="col-sm-9">
					<select name="term" class="form-control">
						<option value="360"<?php if($d['search']['term']==360):?> selected="selected"<?php endif?>><?php echo _LANG('a1017','search')?></option>
						<option value="36"<?php if($d['search']['term']==36):?> selected="selected"<?php endif?>><?php echo _LANG('a1018','search')?></option>
						<option value="24"<?php if($d['search']['term']==24):?> selected="selected"<?php endif?>><?php echo _LANG('a1019','search')?></option>
						<option value="12"<?php if($d['search']['term']==12):?> selected="selected"<?php endif?>><?php echo _LANG('a1020','search')?></option>
						<option value="6"<?php if($d['search']['term']==6):?> selected="selected"<?php endif?>><?php echo _LANG('a1021','search')?></option>
						<option value="3"<?php if($d['search']['term']==3):?> selected="selected"<?php endif?>><?php echo _LANG('a1022','search')?></option>
						<option value="1"<?php if($d['search']['term']==1):?> selected="selected"<?php endif?>><?php echo _LANG('a1023','search')?></option>
					</select>
					<p class="form-control-static text-muted">
						<small><?php echo _LANG('a1024','search')?></small>
					</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo _LANG('a1025','search')?></label>
				<div class="col-sm-9">
					<div class="input-group" style="width:250px">
						<span class="input-group-addon"><?php echo _LANG('a1026','search')?></span>
						<input type="text" name="num1" size="5" value="<?php echo $d['search']['num1']?>" class="form-control">
						<span class="input-group-addon"><?php echo _LANG('a1027','search')?></span>
					</div>
					<div class="input-group" style="width:250px;margin-top:10px">
						<span class="input-group-addon"><?php echo _LANG('a1028','search')?></span>
						<input type="text" name="num2" size="5" value="<?php echo $d['search']['num2']?>" class="form-control">
						<span class="input-group-addon"><?php echo _LANG('a1027','search')?></span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo _LANG('a1029','search')?></label>
				<div class="col-sm-9">
					<textarea name="searchlist" class="form-control" rows="6"><?php echo trim(implode('',file($g['path_module'].$module.'/var/search.list.txt')))?></textarea>
					<p class="form-control-static text-muted">
						<small><?php echo _LANG('a1030','search')?></small>
					</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label"><?php echo _LANG('a1031','search')?></label>
				<div class="col-md-10 col-lg-9">

					<div class="row">
						<div class="col-sm-6" id="rb-layout-select">
							<select class="form-control" name="layout_1" required onchange="getSubLayout(this,'rb-layout-select2','layout_1_sub','');">
								<?php $_layoutHexp=explode('/',$_HS['layout'])?>
								<option value="0"><?php echo _LANG('a1032','search')?>(<?php echo getFolderName($g['path_layout'].$_layoutHexp[0])?>)</option>
								<?php $_layoutExp1=explode('/',$d['search']['layout'])?>
								<?php $dirs = opendir($g['path_layout'])?>
								<?php while(false !== ($tpl = readdir($dirs))):?>
								<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
								<option value="<?php echo $tpl?>"<?php if($_layoutExp1[0]==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo $tpl?>)</option>
								<?php endwhile?>
								<?php closedir($dirs)?>
							</select>
						</div>
						<div class="col-sm-6" id="rb-layout-select2">
							<select class="form-control" name="layout_1_sub"<?php if(!$d['search']['layout']):?> disabled<?php endif?>>
								<?php if(!$R['m_layout']):?><option><?php echo _LANG('a1033','search')?></option><?php endif?>
								<?php $dirs1 = opendir($g['path_layout'].$_layoutExp1[0])?>
								<?php while(false !== ($tpl1 = readdir($dirs1))):?>
								<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
								<option value="<?php echo $tpl1?>"<?php if($_layoutExp1[1]==$tpl1):?> selected<?php endif?>><?php echo str_replace('.php','',$tpl1)?></option>
								<?php endwhile?>
								<?php closedir($dirs1)?>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-9">
					<hr>
					<button type="submit" class="btn btn-primary btn-lg<?php if($g['device']):?> btn-block<?php endif?>" id="rb-submit-button"><?php echo _LANG('a1034','search')?></button>
				</div>
			</div>

		</form>



		<?php endif?>

	</div>
</div>


<!-- nestable : https://github.com/dbushell/Nestable -->
<?php getImport('nestable','jquery.nestable',false,'js')?>
<script>
$('#nestable-menu').nestable();
$('.dd').on('change', function() {
	orderUpdate();
});
</script>

<script>
function orderUpdate()
{
	var f = document.forms[0];
	f.auto.value = '1';
	getIframeForAction(f);
	f.submit();
}
function procCheck(f)
{
	if (f.name.value == '')
	{
		alert('<?php echo _LANG('a1035','search')?>   ');
		f.name.focus();
		return false;
	}

	getIframeForAction(f);
	return confirm('<?php echo _LANG('a1036','search')?>   ');
}
function saveCheck(f)
{
	if(f.layout_1.value != '0') f.layout.value = f.layout_1.value + '/' + f.layout_1_sub.value;
	else f.layout.value = '';
	getIframeForAction(f);
	return confirm('<?php echo _LANG('a1036','search')?>   ');
}
<?php if($_nowOrderNum != count($d['search_order']) || $autoCheck=='Y'):?>
setTimeout("orderUpdate();",100);
<?php endif?>

<?php if($d['admin']['dblclick']):?>
document.ondblclick = function(event)
{
	getContext('<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $module?>"><?php echo _LANG('a1037','search')?></a></li><li class="divider"></li><li><a href="#." onclick="getId(\'rb-submit-button\').click();"><?php echo _LANG('a1038','search')?></a></li>',event);	
}
<?php endif?>
</script>

