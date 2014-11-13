<?php
$R=array();
$recnum= $recnum ? $recnum : 15;
$sendsql = 'gid>-1';
if ($keyw)
{
	$sendsql .= " and (id like '%".$keyw."%' or name like '%".$keyw."%')";
}
$RCD = getDbArray($table['s_module'],$sendsql,'*','gid','asc',$recnum,$p);
$NUM = getDbRows($table['s_module'],$sendsql);
$TPG = getTotalPage($NUM,$recnum);
if (!$id)$id=$module;
$R = getDbData($table['s_module'],"id='".$id."'",'*');
?>

<div class="row">
	<div class="col-md-5 col-lg-4" id="tab-content-list">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading rb-icon">
					<div class="icon">
						<i class="fa kf kf-module fa-2x"></i>
					</div>
					<h4 class="dropdown panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapmetane"><?php echo _LANG('a0001','module')?></a>
						<span class="pull-right" style="position:relative;left:-15px;top:3px;">
							<button type="button" class="btn btn-default btn-xs<?php if(!$_SESSION['sh_site_page_search']):?> collapsed<?php endif?>" data-toggle="collapse" data-target="#panel-search" data-tooltip="tooltip" title="<?php echo _LANG('a0002','module')?>" onclick="sessionSetting('sh_module_search','1','','1');getSearchFocus();"><i class="glyphicon glyphicon-search"></i></button>
						</span>
					</h4>
				</div>
				<div id="panel-search" class="collapse<?php if($_SESSION['sh_module_search']):?> in<?php endif?>">
					<form role="form" action="<?php echo $g['s']?>/" method="get">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="<?php echo $m?>">
					<input type="hidden" name="module" value="<?php echo $module?>">
					<input type="hidden" name="front" value="<?php echo $front?>">
					<input type="hidden" name="id" value="<?php echo $id?>">
						<div class="panel-heading rb-search-box">
							<div class="input-group">
								<div class="input-group-addon"><small><?php echo _LANG('a0003','module')?></small></div>
								<div class="input-group-btn">
									<select class="form-control" name="recnum" onchange="this.form.submit();">
									<option value="15"<?php if($recnum==15):?> selected<?php endif?>>15</option>
									<option value="30"<?php if($recnum==30):?> selected<?php endif?>>30</option>
									<option value="60"<?php if($recnum==60):?> selected<?php endif?>>60</option>
									<option value="100"<?php if($recnum==100):?> selected<?php endif?>>100</option>
									</select>
								</div>
							</div>
						</div>
						<div class="rb-keyword-search">
							<input type="text" name="keyw" class="form-control" value="<?php echo $keyw?>" placeholder="<?php echo _LANG('a0004','module')?>">
						</div>
					</form>
				</div>

				<div class="panel-collapse collapse in" id="collapmetane">
					<table id="module-list" class="table">
						<thead>
							<tr>
								<td class="rb-name"><span><?php echo _LANG('a0005','module')?></span></td>
								<td class="rb-id"><span><?php echo _LANG('a0006','module')?></span></td>
								<td class="rb-time"><span><?php echo _LANG('a0007','module')?></span></td>
							</tr>
						</thead>
						<tbody>
							<?php while($_R = db_fetch_array($RCD)):?>
							<tr<?php if($id==$_R['id']):?> class="active1"<?php endif?> onclick="goHref('<?php echo $g['adm_href']?>&amp;recnum=<?php echo $recnum?>&amp;p=<?php echo $p?>&amp;id=<?php echo $_R['id']?>&amp;keyw=<?php echo urlencode($keyw)?>#page-info');">
								<td class="rb-name">
									<i class="kf <?php echo $_R['icon']?$_R['icon']:'kf-'.$_R['id']?>"></i> 
									<?php echo $_R['name']?>
									<?php if(!$_R['hidden']):?><small><small class="glyphicon glyphicon-eye-open"></small></small><?php endif?>
								</td>
								<td class="rb-id"><?php echo $_R['id']?></td>
								<td class="rb-time">
									<?php echo getDateFormat($_R['d_regis'],$lang['module']['date1'])?>
								</td>
							</tr>
							<?php endwhile?>
						</tbody>
					</table>
				
					<?php if($TPG>1):?>
					<div class="panel-footer rb-panel-footer">
						<ul class="pagination">
						<script>getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
						<?php //echo getPageLink(5,$p,$TPG,'')?>
						</ul>
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
						<a class="accordion-toggle collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">
							<?php echo _LANG('a1001','module')?>
						</a>
					</h4>
				</div>
				<div class="panel-collapse collapse" id="collapseTwo">
					<form role="form" action="<?php echo $g['s']?>/" method="post">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="<?php echo $module?>">
					<input type="hidden" name="a" value="moduleorder_update">
						<div class="panel-body" style="border-top:#ccc solid 1px;">
							<div class="dd" id="nestable-menu">
								<ol class="dd-list">
									<?php $RCD = getDbArray($table['s_module'],'','*','gid','asc',0,1)?>
									<?php while($_R=db_fetch_array($RCD)):?>
									<li class="dd-item" data-id="1">
										<div class="dd-handle">
											<input type="checkbox" name="modulemembers[]" value="<?php echo $_R['id']?>" checked class="hidden">
											<i class="fa fa-arrows fa-fw"></i>
											<i class="kf <?php echo $_R['icon']?$_R['icon']:'kf-'.$_R['id']?>"></i>
											<?php echo $_R['name']?> (<?php echo $_R['id']?>)
										</div>
									</li>
									<?php endwhile?>
								</ol>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php if(!$R['id']) $R=getDbData($table['s_module'],"id='site'",'*')?>
	<?php if($g['device']):?><a name="page-info"></a><?php endif?>
	<div class="col-md-7 col-lg-8" id="tab-content-view">
		<div class="page-header">
			<h4><?php echo _LANG('a1002','module')?></h4>
		</div>

		<div class="row">
			<div class="col-md-2 col-sm-2 text-center">
				<div class="rb-box">
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $_R['id']?>">
						<i class="rb-icon kf <?php echo $R['icon']?$R['icon']:'kf-'.$R['id']?>"></i><br>
						<i class="rb-name"><?php echo $R['id']?></i>
					</a>
				</div>
			</div>
			
			<div class="col-md-10 col-sm-10">
				<h4 class="media-heading">
					<strong><?php echo $R['name']?></strong>
				</h4>

				<div class="btn-group" style="margin:10px 0">
					<button type="button" class="btn btn-default"><?php echo _LANG('a1003','module')?></button>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
				<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&amp;module=<?php echo $R['id']?>"><?php echo _LANG('a1004','module')?></a></li>
				<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $R['id']?>" target="_blank"><?php echo _LANG('a1005','module')?></a></li>
				<li class="divider"></li>
				<?php @include $g['path_module'].$R['id'].'/var/var.moduleinfo.php'?>
				<li<?php if($d['moduleinfo']['market']):?>><a href="<?php echo $d['moduleinfo']['market']?>" target="_blank"<?php else:?> class="disabled"><a disabled<?php endif?>><i class="fa fa-shopping-cart fa-fw fa-lg"></i> <?php echo _LANG('a1025','module')?></a></li>
				<li<?php if($d['moduleinfo']['github']):?>><a href="<?php echo $d['moduleinfo']['github']?>" target="_blank"<?php else:?> class="disabled"><a disabled<?php endif?>><i class="fa fa-github fa-fw fa-lg"></i> <?php echo _LANG('a1026','module')?></a></li>
				<li<?php if($d['moduleinfo']['issue']):?>><a href="<?php echo $d['moduleinfo']['issue']?>" target="_blank"<?php else:?> class="disabled"><a disabled<?php endif?>><i class="fa fa-bug fa-fw fa-lg"></i> <?php echo _LANG('a1027','module')?></a></li>
				<li<?php if($d['moduleinfo']['website']):?>><a href="<?php echo $d['moduleinfo']['website']?>" target="_blank"<?php else:?> class="disabled"><a disabled<?php endif?>><i class="fa fa-home fa-fw fa-lg"></i> <?php echo _LANG('a1028','module')?></a></li>
				<li<?php if($d['moduleinfo']['help']):?>><a href="<?php echo $d['moduleinfo']['help']?>" target="_blank"<?php else:?> class="disabled"><a disabled<?php endif?>><i class="fa fa-question-circle fa-fw fa-lg"></i> <?php echo _LANG('a1029','module')?></a></li>
				<li class="divider"></li>
				<?php if(!$R['system']):?>
				<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=module_delete&amp;moduleid=<?php echo $R['id']?>" onclick="return hrefCheck(this,true,'<?php echo _LANG('a1006','module')?>');"><i class="fa fa-trash-o fa-fw fa-lg"></i> <?php echo _LANG('a1007','module')?></a></li>
				<?php else:?>
				<li class="disabled"><a><i class="fa fa-trash-o fa-fw fa-lg"></i> <?php echo _LANG('a1007','module')?></a></li>
				<?php endif?>
				</ul>

			</div>
			<p class="text-muted"><small><?php echo _LANG('a1008','module')?></small></p>
		</div>
	</div>
	<hr>

	<form class="form-horizontal rb-form" role="form" name="procForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>">
	<input type="hidden" name="m" value="<?php echo $module?>">
	<input type="hidden" name="moduleid" value="<?php echo $R['id']?>">
	<input type="hidden" name="a" value="moduleinfo_update">
	<input type="hidden" name="iconaction" value="">

		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1009','module')?></label>
			<div class="col-md-10">
				<p class="form-control-static"><?php echo $R['id']?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1010','module')?></label>
			<div class="col-md-9">
				<input class="form-control col-md-6" placeholder="" type="text" name="name" value="<?php echo $R['name']?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1011','module')?></label>
			<div class="col-md-9">
				<select name="modulelang" class="form-control">
				<option value=""<?php if(!$R['lang']):?> selected<?php endif?>><?php echo _LANG('a1012','module')?> (<?php echo getFolderName($g['path_module'].$module.'/language/'.$d['admin']['syslang'])?>)</option>
				<?php if(is_dir($g['path_module'].$R['id'].'/language')):?>
				<?php $dirs = opendir($g['path_module'].$R['id'].'/language')?>
				<?php while(false !== ($tpl = readdir($dirs))):?>
				<?php if($tpl=='.'||$tpl=='..'||$tpl==$d['admin']['syslang'])continue?>
				<option value="<?php echo $tpl?>"<?php if($R['lang']==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_module'].$R['id'].'/language/'.$tpl)?></option>
				<?php endwhile?>
				<?php closedir($dirs)?>
				<?php endif?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1013','module')?></label>
			<div class="col-md-9">
				 <div class="input-group">
					  <input type="text" name="icon" class="form-control" value="<?php echo $R['icon']?>">
					  <span class="input-group-btn">
						<button type="button" class="btn btn-default rb-modal-iconset" data-toggle="modal" data-target="#modal_window"><?php echo _LANG('a1014','module')?></button>
					  </span>
				</div>
				<p class="form-control-static">
					<ul class="list-unstyled">
						<li><?php echo _LANG('a1015','module')?></li>
						<li><?php echo _LANG('a1016','module')?></li>
						<li><?php echo _LANG('a1017','module')?></li>
					</ul>
				</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label"></label>
			<div class="col-md-9">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="hidden" value="1"<?php if($R['hidden']):?> checked="checked"<?php endif?>>
						<i></i><?php echo _LANG('a1018','module')?>
					</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">DB</label>
			<div class="col-md-9">
				<p class="form-control-static">
				<?php if($R['tblnum']):?>
				<?php echo sprintf(_LANG('a1019','module'),$R['tblnum'])?>
				<?php else:?>
				<?php echo _LANG('a1020','module')?>
				<?php endif?>					
				</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1021','module')?></label>
			<div class="col-md-9">
				<p class="form-control-static"><?php echo getDateFormat($R['d_regis'],$lang['module']['date1'])?></p>
			</div>
		</div>

		<hr>

		<div class="form-group">
			<div class="col-md-offset-2 col-md-9">
				<button class="btn btn-primary btn-block btn-lg" type="submit"><i class="fa fa-check fa-lg"></i> <?php echo _LANG('a1022','module')?></button>
			</div>
		</div>
	</form>

	</div>
</div>


<!-- nestable : https://github.com/dbushell/Nestable -->
<?php getImport('nestable','jquery.nestable',false,'js')?>
<script>
$('#nestable-menu').nestable();
$('.dd').on('change', function() {
	var f = document.forms[1];
	getIframeForAction(f);
	f.submit();
});
</script>

<!-- basic -->
<script>
$(document).ready(function()
{
	$('.rb-modal-iconset').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('site/pages/modal.icons')?>');
	});
});
function saveCheck(f)
{
	if (f.name.value == '')
	{
		alert('<?php echo _LANG('a1023','module')?>     ');
		f.name.focus();
		return false;
	}
	getIframeForAction(f);
	return confirm('<?php echo _LANG('a1024','module')?>         ');
}
function getSearchFocus()
{
	if(getId('panel-search').className.indexOf('in') == -1) setTimeout("document.forms[0].keyw.focus();",100);
}
function iconDrop(val)
{
	var f = document.procForm;
	f.icon.value = val;
	iconDropAply();
}
function iconDropAply()
{
	var f = document.procForm;
	f.iconaction.value = '1';
	getIframeForAction(f);
	f.submit();
	$('#modal_window').modal('hide');
}
</script>
