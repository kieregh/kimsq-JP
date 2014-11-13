<?php
$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p);
$SITEN = db_num_rows($SITES);
include $g['path_core'].'function/menu.func.php';
$ISCAT = getDbRows($table['s_menu'],'site='.$_HS['uid']);

if($cat)
{
	$CINFO = getUidData($table['s_menu'],$cat);
	$_SEO = getDbData($table['s_seo'],'rel=1 and parent='.$CINFO['uid'],'*');
	$ctarr = getMenuCodeToPath($table['s_menu'],$cat,0);
	$ctnum = count($ctarr);
	$CINFO['code'] = '';
	for ($i = 0; $i < $ctnum; $i++)
	{
		$CXA[] = $ctarr[$i]['uid'];
		$CINFO['code'] .= $ctarr[$i]['id'].($i < $ctnum-1 ? '/' : '');
		$_code .= $ctarr[$i]['uid'].($i < $ctnum-1 ? '/' : '');
	}
	$code = $code ? $code : $_code;
}

$catcode = '';
$is_fcategory =  $CINFO['uid'] && $vtype != 'sub';
$is_regismode = !$CINFO['uid'] || $vtype == 'sub';
if ($is_regismode)
{
	$CINFO['menutype'] = '3';
	$CINFO['name']	   = '';
	$CINFO['joint']	   = '';
	$CINFO['redirect'] = '';
	$CINFO['hidden']   = '';
	$CINFO['target']   = '';
	$CINFO['imghead']  = '';
	$CINFO['imgfoot']  = '';
}
$menuType = array('',_LANG('a0001','site'),_LANG('a0002','site'),_LANG('a0003','site'));
?>


<div id="catebody" class="row">
	<div id="category" class="col-sm-5 col-md-4 col-lg-4">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading rb-icon">
					<div class="icon">
						<i class="fa fa-sitemap fa-2x"></i>
					</div>
					<h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapmetane"><?php echo _LANG('a2001','site')?></a></h4>
				</div>
				<div class="panel-collapse collapse in" id="collapmetane">
					<?php if($SITEN>1):?>
					<div class="panel-body rb-panel-form">
						<select class="form-control" onchange="goHref('<?php echo $g['s']?>/?m=<?php echo $m?>&module=<?php echo $module?>&front=<?php echo $front?>&r='+this.value);">
						<?php while($S = db_fetch_array($SITES)):?>
						<option value="<?php echo $S['id']?>"<?php if($r==$S['id']):?> selected<?php endif?>><?php echo $S['name']?> (<?php echo $S['id']?>)</option>
						<?php endwhile?>
						</select>
					</div>
					<?php endif?>
					
					<div class="panel-body">
						<div style="min-height:300px;">
							<link href="<?php echo $g['s']?>/_core/css/tree.css" rel="stylesheet">
							<?php $_treeOptions=array('site'=>$s,'table'=>$table['s_menu'],'dispNum'=>true,'dispHidden'=>false,'dispCheckbox'=>false,'allOpen'=>false,'bookmark'=>'site-menu-info')?>
							<?php $_treeOptions['link'] = $g['adm_href'].'&amp;cat='?>
							<?php echo getTreeMenu($_treeOptions,$code,0,0,'')?>
						</div>
					</div>
					
					<div class="panel-footer">
						<div class="btn-group dropup btn-block">
							<button type="button" class="btn btn-default dropdown-toggle btn-block" data-toggle="dropdown">
								<i class="fa fa-download fa-lg"></i> <?php echo _LANG('a2002','site')?>
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
							<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=dumpmenu&amp;type=xml" target="_blank"><?php echo _LANG('a2003','site')?></a></li>
							<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=dumpmenu&amp;type=xls" target="_action_frame_<?php echo $m?>"><?php echo _LANG('a2004','site')?></a></li>
							<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=dumpmenu&amp;type=txt" target="_action_frame_<?php echo $m?>"><?php echo _LANG('a2005','site')?></a></li>
							<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=dumpmenu&amp;type=package_menu" target="_action_frame_<?php echo $m?>"><?php echo _LANG('a0073','site')?></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			
			<?php if($g['device']):?><a name="site-menu-info"></a><?php endif?>
			<div class="panel panel-default">
				<div class="panel-heading rb-icon">
					<div class="icon">
						<i class="fa fa-retweet fa-2x"></i>
					</div>
					<h4 class="panel-title">
						<a class="accordion-toggle collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo"><?php echo _LANG('a2006','site')?></a>
					</h4>
				</div>
				
				<div class="panel-collapse collapse" id="collapseTwo">
					<?php if($CINFO['is_child']||(!$cat&&$ISCAT)):?>
					<form role="form" action="<?php echo $g['s']?>/" method="post">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="<?php echo $module?>">
					<input type="hidden" name="a" value="modifymenugid">
						<div class="panel-body" style="border-top:1px solid #DEDEDE;">
							<div class="dd" id="nestable-menu">
								<ol class="dd-list">
								<?php $_MENUS=getDbSelect($table['s_menu'],'site='.$s.' and parent='.intval($CINFO['uid']).' and depth='.($CINFO['depth']+1).' order by gid asc','*')?>
								<?php $_i=1;while($_M=db_fetch_array($_MENUS)):?>								
								<li class="dd-item" data-id="<?php echo $_i?>">
								<input type="checkbox" name="menumembers[]" value="<?php echo $_M['uid']?>" checked class="hidden">
								<div class="dd-handle"><i class="fa fa-arrows fa-fw"></i> <?php echo $_M['name']?></div>
								</li>
								<?php $_i++;endwhile?>
								</ol>
							</div>
						</div>
					</form>

					<!-- nestable : https://github.com/dbushell/Nestable -->
					<?php getImport('nestable','jquery.nestable',false,'js') ?>
					<script>
					$('#nestable-menu').nestable();
					$('.dd').on('change', function() {
						var f = document.forms[0];
						getIframeForAction(f);
						f.submit();
					});
					</script>

					<?php else:?>
					<div class="panel-body rb-blank">
						<?php if($cat):?>
						<?php echo sprintf(_LANG('a2008','site'),$CINFO['name'])?>
						<?php else:?>
						<?php echo _LANG('a2007','site')?>
						<?php endif?>
					</div>
					<?php endif?>
				</div>
			</div>
		</div>
	</div>


	<div id="catinfo" class="col-sm-7 col-md-8 col-lg-8">
		<form class="form-horizontal rb-form" name="procForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="regismenu">
		<input type="hidden" name="cat" value="<?php echo $CINFO['uid']?>">
		<input type="hidden" name="code" value="<?php echo $code?>">
		<input type="hidden" name="vtype" value="<?php echo $vtype?>">
		<input type="hidden" name="depth" value="<?php echo intval($CINFO['depth'])?>">
		<input type="hidden" name="parent" value="<?php echo intval($CINFO['uid'])?>">
		<input type="hidden" name="perm_g" value="<?php echo $CINFO['perm_g']?>">
		<input type="hidden" name="seouid" value="<?php echo $_SEO['uid']?>">
		<input type="hidden" name="layout" value="">
		<input type="hidden" name="menutype" value="<?php echo $CINFO['uid']?$CINFO['menutype']:3?>">

		<div class="page-header">
			<h4>
				<?php if($is_regismode):?>
				<?php if($vtype == 'sub'):?><?php echo _LANG('a2009','site')?><?php else:?><?php echo _LANG('a2010','site')?><?php endif?>
				<?php else:?>
				<?php echo _LANG('a2011','site')?>
				
				<div class="pull-right rb-top-btnbox hidden-xs">
					<a href="<?php echo $g['adm_href']?>" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo _LANG('a2012','site')?><?php echo _LANG('a0052','site')?></a>
					<div class="btn-group rb-btn-view">
						<a href="<?php echo RW('c='.$CINFO['code'])?>" class="btn btn-default"><?php echo _LANG('a0053','site')?></a>
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li><a href="<?php echo RW('c='.$CINFO['code'])?>" target="_blank"><i class="glyphicon glyphicon-new-window"></i> <?php echo _LANG('a0054','site')?></a></li>
						</ul>
					</div>
				</div>
				<?php endif?>
			</h4>
		</div>

		<?php if($vtype == 'sub'):?>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a2012','site')?></label>
			<div class="col-md-9">
				<ol class="breadcrumb">
				<?php for ($i = 0; $i < $ctnum; $i++):$subcode=$subcode.($i?'/'.$ctarr[$i]['uid']:$ctarr[$i]['uid']) ?>
				<li><a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $ctarr[$i]['uid']?>&amp;code=<?php echo $subcode?>"><?php echo $ctarr[$i]['name']?></a></li>
				<?php $catcode .= $ctarr[$i]['id'].'/';endfor?>
				</ol>
			</div>
		</div>
		<?php else:?>
		<?php if($cat):?>
		<div class="form-group">		
			<label class="col-md-2 control-label"><?php echo _LANG('a2012','site')?></label>
			<div class="col-md-9">
				<ol class="breadcrumb">
				<?php for ($i = 0; $i < $ctnum-1; $i++):$subcode=$subcode.($i?'/'.$ctarr[$i]['uid']:$ctarr[$i]['uid'])?>
				<li><a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $ctarr[$i]['uid']?>&amp;code=<?php echo $subcode?>"><?php echo $ctarr[$i]['name']?></a></li>
				<?php $delparent=$ctarr[$i]['uid'];$catcode .= $ctarr[$i]['id'].'/';endfor?>
				<?php if(!$delparent):?><?php echo _LANG('a2013','site')?><?php endif?>
				</ol>
			</div>
		</div>
		<?php endif?>
		<?php endif?>

		<div class="form-group rb-outside">
			<label class="col-md-2 control-label"><?php echo _LANG('a2014','site')?></label>
			<div class="col-md-10 col-lg-9">
				<?php if($is_fcategory):?>
				<div class="input-group input-group-lg">
				
					<?php if($CINFO['uid']):?>
					<span class="input-group-btn">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-tooltip="tooltip" title="<?php echo _LANG('a0055','site')?>">
							<span id="rb-document-type"><?php echo $menuType[$CINFO['menutype']]?></span> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#" onclick="docType(3,'<?php echo $menuType[3]?>');"><i class="fa fa-code"></i> <?php echo $menuType[3]?></a></li>
							<li><a href="#" onclick="docType(2,'<?php echo $menuType[2]?>');"><i class="fa fa-puzzle-piece fa-lg"></i> <?php echo $menuType[2]?></a></li>
							<li><a href="#" onclick="docType(1,'<?php echo $menuType[1]?>');"><i class="kf kf-module"></i> <?php echo $menuType[1]?></a></li>
						</ul>
					</span>
					<?php endif?>
				
					<input class="form-control col-md-6" placeholder="" type="text" name="name" value="<?php echo $CINFO['name']?>"<?php if(!$cat && !$g['device']):?> autofocus<?php endif?>>
					<span class="input-group-btn">
						<a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $cat?>&amp;code=<?php echo $code?>&amp;vtype=sub" class="btn btn-default" data-tooltip="tooltip" title="<?php echo _LANG('a2015','site')?>">
							<i class="fa fa-share fa-rotate-90 fa-lg"></i>
						</a>
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletemenu&amp;cat=<?php echo $cat?>&amp;parent=<?php echo $delparent?>&amp;code=<?php echo substr($catcode,0,strlen($catcode)-1)?>" onclick="return hrefCheck(this,true,'<?php echo _LANG('a0056','site')?>');" class="btn btn-default" data-tooltip="tooltip" title="<?php echo _LANG('a2016','site')?>">
							<i class="fa fa-trash-o fa-lg"></i>
						</a>
					</span>
				</div>
				<?php else:?>
				<div class="input-group input-group-lg">
					<input class="form-control" placeholder="" type="text" name="name" value="<?php echo $CINFO['name']?>"<?php if(!$g['device']):?> autofocus<?php endif?>>
					<span class="input-group-btn">
						<button class="btn btn-default rb-help-btn" type="button" data-toggle="collapse" data-target="#guide_new" data-tooltip="tooltip" title="<?php echo _LANG('a0014','site')?>"><i class="fa fa-question fa-lg text-muted"></i></button>
					</span>
				</div>
				<div id="guide_new" class="collapse help-block">
					<p>
						<?php echo _LANG('a2017','site')?><br>
						<?php echo _LANG('a2018','site')?>
					</p>
					<p>
						<?php echo _LANG('a2019','site')?><br>
						<?php echo _LANG('a2020','site')?>
					</p>
				</div>
				<?php endif?>
			</div>
		</div>

		<div class="form-group tab-content<?php if(!$CINFO['uid']||$vtype=='sub'):?> hidden<?php endif?>">
			<div class="form-group<?php if($CINFO['menutype']!=3):?> hidden<?php endif?>" id="editBox3">
				<div class="col-md-offset-2 col-md-10 col-lg-9">
					<fieldset<?php if($CINFO['menutype']!=3):?> disabled<?php endif?>>
						<div class="btn-group btn-group-justified" data-toggle="buttons">
							<a class="btn btn-default rb-modal-code">
								<i class="fa fa-code fa-lg"></i> <?php echo _LANG('a0057','site')?>
							</a>
							<a class="btn btn-default rb-modal-wysiwyg">
								<i class="fa fa-edit fa-lg"></i> <?php echo _LANG('a0058','site')?>
							</a>
						</div>
					</fieldset>
					<span class="help-block text-muted">
						<ul class="rb-guide" style="margin-bottom:0;padding-bottom:0;">
							<li><?php echo _LANG('a0063','site')?></li>
							<li><?php echo _LANG('a0064','site')?></li>
							<?php if($CINFO['menutype']!=3):?><li><?php echo _LANG('a2021','site')?></li><?php endif?>
						</ul>
					</span>
				</div>
			</div>
			<div class="form-group<?php if($CINFO['menutype']!=2):?> hidden<?php endif?>" id="editBox2">
				<div class="col-md-offset-2 col-md-10 col-lg-9">
					<?php if($CINFO['menutype']==2):?>
					<fieldset>
						<a href="#." class="btn btn-default btn-block rb-modal-widget"><i class="fa fa-puzzle-piece fa-lg"></i> <?php echo _LANG('a0059','site')?></a>
					</fieldset>
					<?php else:?>
					<fieldset disabled>
						<a href="#." class="btn btn-default btn-block"><i class="fa fa-puzzle-piece fa-lg"></i> 
							<?php echo _LANG('a0059','site')?>
							<small class="text-muted">( <?php echo _LANG('a2022','site')?> )</small>
						</a>
					</fieldset>
					<?php endif?>
				</div>
			</div>
			<div class="form-group<?php if($CINFO['menutype']!=1):?> hidden<?php endif?>" id="editBox1">
				<div class="col-md-offset-2 col-md-10 col-lg-9">
					<?php if($CINFO['menutype']==1):?>
					<fieldset>
						<div class="input-group">
							<input type="text" name="joint" id="jointf" value="<?php echo $CINFO['joint']?>" class="form-control">
							<span class="input-group-btn">
								<button class="btn btn-default rb-modal-module" type="button" title="<?php echo _LANG('a0060','site')?>" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window"><i class="fa fa-link fa-lg"></i></button>
								<button class="btn btn-default" type="button" title="<?php echo _LANG('a0061','site')?>" data-tooltip="tooltip" onclick="getId('jointf').value!=''?window.open(getId('jointf').value):alert('<?php echo _LANG('a0062','site')?>');">Go!</button>
							</span>
						</div>
					</fieldset>
					<?php else:?>
					<fieldset disabled>
						<div class="input-group">
							<input type="text" name="joint" id="jointf" value="<?php echo $CINFO['joint']?>" placeholder="<?php echo _LANG('a2022','site')?>" class="form-control">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button" title="<?php echo _LANG('a0060','site')?>"><i class="fa fa-link fa-lg"></i></button>
								<button class="btn btn-default" type="button" title="<?php echo _LANG('a0061','site')?>">Go!</button>
							</span>
						</div>
					</fieldset>
					<?php endif?>
					<div class="help-block">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="redirect" id="xredirect" value="1"<?php if($CINFO['redirect']):?> checked<?php endif?>>
								<i></i><?php echo _LANG('a2023','site')?>
							</label>
						</div>
						<ul class="rb-guide" style="margin-bottom:0;padding-bottom:0;">
							<li><?php echo _LANG('a2024','site')?></li>
							<li><?php echo _LANG('a2025','site')?></li>
							<li><?php echo _LANG('a2026','site')?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<?php if($CINFO['uid']&&!$vtype):?>
		<div class="form-group rb-outside">
			<label class="col-md-2 control-label"><?php echo _LANG('a2027','site')?></label>
			<div class="col-md-10 col-lg-9">
				<input class="form-control" placeholder="<?php echo _LANG('a2028','site')?>" type="text" name="id" value="<?php echo $CINFO['id']?>" maxlength="20">
		
				<span class="help-block">
					<button type="button" class="btn btn-link" data-toggle="collapse" data-target="#guide_menucode">
						<i class="fa fa-question-circle fa-fw"></i>
						<?php echo _LANG('a2029','site')?>
					</button>
				</span>
		
				<div id="guide_menucode" class="collapse rb-guide">
					<ul>
					<li><?php echo _LANG('a2030','site')?></li>
					<li><?php echo _LANG('a2031','site')?><code><?php echo RW('c=<span class="b">CODE</span>')?></code></li>
					<li><?php echo _LANG('a2032','site')?></li>
					</ul>
				</div>
			</div>
		</div>
		<?php endif?>

		<?php if($is_fcategory && $CINFO['is_child']):?>
		<div class="form-group">
			<div class="col-md-offset-2 col-lg-9">
				<hr>
				<div class="">
					<label>
						<input type="checkbox" name="subcopy" id="cubcopy" value="1" checked> <?php echo _LANG('a2033','site')?>
					</label> 
				</div>
			</div>
		</div>
		<?php endif?>

		<div class="panel-group" id="menu-settings">
			<!-- 메타설정-->
			<div class="panel panel-<?php echo $_SESSION['sh_site_menu_1']==1?'primary':'default'?>" id="menu-settings-meta">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#menu-settings" href="#menu-settings-meta-body" onclick="sessionSetting('sh_site_menu_1',getId('menu-settings-meta').className.indexOf('default')==-1?'':'1','','');boxDeco('menu-settings-meta','menu-settings-advance');">
							<i class="fa fa-caret-right fa-fw"></i><?php echo _LANG('a0007','site')?>
						</a>
					</h4>
				</div>
				<div id="menu-settings-meta-body" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_1']==1):?> in<?php endif?>">
					<div class="panel-body">
						<div class="form-group rb-outside">
							<label class="col-md-2 control-label"><?php echo _LANG('a0009','site')?></label>
							<div class="col-md-10 col-lg-9">
								<div class="input-group">
									<input type="text" class="form-control rb-title" name="title" value="<?php echo $_SEO['title']?>" maxlength="60" placeholder="<?php echo _LANG('a0013','site')?>">
									<span class="input-group-btn">
										<button class="btn btn-default rb-help-btn" type="button" data-toggle="collapse" data-target="#guide_title" data-tooltip="tooltip" title="<?php echo _LANG('a0014','site')?>"><i class="fa fa-question fa-lg text-muted"></i></button>
									</span>
								</div>
								<div class="help-block collapse" id="guide_title">
									<small>
										<?php echo _LANG('a0015','site')?>
									</small>
								</div>
							</div>
						</div>
						<div class="form-group rb-outside">
							<label class="col-md-2 control-label"><?php echo _LANG('a0010','site')?></label>
							<div class="col-md-10 col-lg-9">
								<textarea name="description" class="form-control rb-description" rows="5" placeholder="<?php echo _LANG('a0019','site')?>" maxlength="160"><?php echo $_SEO['description']?></textarea>
								<div class="help-text"><small class="text-muted"><a href="#guide_description" data-toggle="collapse" ><i class="fa fa-question-circle fa-fw"></i><?php echo _LANG('a0014','site')?></a></small></div>
								<div class="collapse" id="guide_description">
									<small class="help-block">
										<?php echo _LANG('a0016','site')?><br>
										<?php echo _LANG('a0017','site')?><br>
										<?php echo _LANG('a0018','site')?><br>
									</small>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label"><?php echo _LANG('a0011','site')?></label>
							<div class="col-md-10 col-lg-9">
								<input name="keywords" class="form-control" placeholder="<?php echo _LANG('a0020','site')?>" value="<?php echo $_SEO['keywords']?>">
								<div class="help-text"><small class="text-muted"><a href="#guide_keywords" data-toggle="collapse" ><i class="fa fa-question-circle fa-fw"></i><?php echo _LANG('a0014','site')?></a></small></div>
								<div class="help-block collapse" id="guide_keywords">
									<small>
										<?php echo _LANG('a0021','site')?><br>
										<?php echo _LANG('a0022','site')?><br>
										<?php echo _LANG('a0023','site')?><br>
									</small>
								</div>			
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label"><?php echo _LANG('a0012','site')?></label>
							<div class="col-md-10 col-lg-9">
								<input name="classification" class="form-control" placeholder="" value="<?php echo $_SEO['uid']?$_SEO['classification']:'ALL'?>">
								<div class="help-text"><small class="text-muted"><a href="#guide_classification" data-toggle="collapse" ><i class="fa fa-question-circle fa-fw"></i><?php echo _LANG('a0014','site')?></a></small></div>
								<div class="help-block collapse" id="guide_classification">
									<small class="help-block">
										<?php echo _LANG('a0024','site')?><br>
										<?php echo _LANG('a0025','site')?><br>
									</small>
								</div>			
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label"><?php echo _LANG('a0069','site')?></label>
							<div class="col-md-10 col-lg-9">
								<div class="input-group">
									<input class="form-control rb-modal-photo-drop" onmousedown="_mediasetField='meta_image_src&dfiles='+this.value;" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window" type="text" name="image_src" id="meta_image_src" value="<?php echo $_SEO['image_src']?$_SEO['image_src']:''?>">
									<div class="input-group-btn">
										<button class="btn btn-default rb-modal-photo1" type="button" title="<?php echo _LANG('a0004','site')?>" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window">
											<i class="fa fa-photo fa-lg"></i>
										</button>
									</div>
								</div>

								<div class="help-text"><small class="text-muted"><a href="#guide_image_src" data-toggle="collapse" ><i class="fa fa-question-circle fa-fw"></i><?php echo _LANG('a0014','site')?></a></small></div>
								<div class="help-block collapse" id="guide_image_src">
									<small class="help-block">
										<?php echo _LANG('a0070','site')?><br>
										<?php echo _LANG('a0071','site')?><br>
									</small>
								</div>			
							</div>						
						</div>
					</div>
					<div class="panel-footer">
	  					<small class="text-muted">
	  						<i class="fa fa-info-circle fa-lg fa-fw"></i> <?php echo _LANG('a0026','site')?>
	  					</small>
					</div>
				</div>
			</div>

			<div class="panel panel-<?php echo $_SESSION['sh_site_menu_1']==2?'primary':'default'?>" id="menu-settings-advance"><!--고급설정-->
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#menu-settings" href="#menu-settings-advance-body" onclick="sessionSetting('sh_site_menu_1',getId('menu-settings-advance').className.indexOf('default')==-1?'':'2','','');boxDeco('menu-settings-advance','menu-settings-meta');">
							<i class="fa fa-caret-right fa-fw"></i><?php echo _LANG('a0008','site')?>
						</a>
					</h4>
				</div>
				<div id="menu-settings-advance-body" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_1']==2):?> in<?php endif?>">
					<div class="panel-body">

						<div class="form-group">
							<label class="col-md-2 control-label"><?php echo _LANG('a0027','site')?></label>
							<div class="col-md-10 col-lg-9">

								<div class="xrow">
									<div class="col-sm-6" id="rb-layout-select">
										<select class="form-control" name="layout_1" required onchange="getSubLayout(this,'rb-layout-select2','layout_1_sub','');">
											<?php $_layoutHexp=explode('/',$_HS['layout'])?>
											<option value="0"><?php echo _LANG('a0028','site')?>(<?php echo getFolderName($g['path_layout'].$_layoutHexp[0])?>)</option>
											<?php $_layoutExp1=explode('/',$CINFO['layout'])?>
											<?php $dirs = opendir($g['path_layout'])?>
											<?php while(false !== ($tpl = readdir($dirs))):?>
											<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
											<option value="<?php echo $tpl?>"<?php if($_layoutExp1[0]==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo $tpl?>)</option>
											<?php endwhile?>
											<?php closedir($dirs)?>
										</select>
									</div>
									<div class="col-sm-6" id="rb-layout-select2">
										<select class="form-control" name="layout_1_sub"<?php if(!$CINFO['layout']):?> disabled<?php endif?>>
											<?php if(!$R['m_layout']):?><option><?php echo _LANG('a0029','site')?></option><?php endif?>
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
							<label class="col-md-2 control-label"><?php echo _LANG('a2034','site')?></label>
							<div class="col-md-10 col-lg-9">
								<div class="btn-group btn-group-justified" data-toggle="buttons">
									<label class="btn btn-default<?php if($CINFO['mobile']):?> active<?php endif?>">
										<input type="checkbox" name="mobile" value="1"<?php if($CINFO['mobile']):?> checked<?php endif?>>
										<span class="glyphicon glyphicon-phone"></span>
										<?php echo _LANG('a2035','site')?> 
									</label>
									<label class="btn btn-default<?php if($CINFO['target']):?> active<?php endif?>">
										<input type="checkbox" name="target" value="_blank"<?php if($CINFO['target']):?> checked<?php endif?>>
										<span class="glyphicon glyphicon-new-window"></span>
										<?php echo _LANG('a2036','site')?> 
									</label>
									<label class="btn btn-default<?php if($CINFO['hidden']):?> active<?php endif?>">
										<input type="checkbox" name="hidden" value="1"<?php if($CINFO['hidden']):?> checked<?php endif?>>
										<span class="glyphicon glyphicon-eye-close"></span>
										<?php echo _LANG('a2037','site')?> 
									</label>
									<label class="btn btn-default<?php if($CINFO['reject']):?> active<?php endif?>">
										<input type="checkbox" name="reject" value="1"<?php if($CINFO['reject']):?> checked<?php endif?>>
										<span class="glyphicon glyphicon-lock"></span>
										<?php echo _LANG('a2038','site')?> 
									</label>
								</div>
								<span class="help-block">
									<button type="button" class="btn btn-link" data-toggle="collapse" data-target="#guide_mpro"><i class="fa fa-question-circle fa-fw"></i><?php echo _LANG('a0014','site')?></button>
								</span>
								<div id="guide_mpro" class="collapse rb-guide">
									<dl class="dl-horizontal">
									<dt><?php echo _LANG('a2035','site')?></dt>
									<dd><?php echo _LANG('a2039','site')?></dd>
									<dt><?php echo _LANG('a2036','site')?></dt>
									<dd><?php echo _LANG('a2040','site')?></dd>
									<dt><?php echo _LANG('a2037','site')?></dt>
									<dd><?php echo _LANG('a2041','site')?></dd>
									<dt><?php echo _LANG('a2038','site')?></dt>
									<dd><?php echo _LANG('a2042','site')?></dd>
									</dl>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label"><?php echo _LANG('a0030','site')?></label>
							<div class="col-md-10 col-lg-9">
								<select class="col-md-12 form-control" name="perm_l">
								<option value=""><?php echo _LANG('a0031','site')?></option>
								<?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
								<?php while($_L=db_fetch_array($_LEVEL)):?>
								<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$CINFO['perm_l']):?> selected<?php endif?>><?php echo sprintf(_LANG('a0035','site'),$_L['name'].'('.number_format($_L['num']).')')?></option>
								<?php if($_L['gid'])break; endwhile?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label"><?php echo _LANG('a0032','site')?></label>
							<div class="col-md-10 col-lg-9">
								<select class="col-md-12 form-control" name="_perm_g" multiple size="5">
								<option value=""<?php if(!$CINFO['perm_g']):?> selected="selected"<?php endif?>><?php echo _LANG('a0033','site')?></option>
								<?php $_SOSOK=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
								<?php while($_S=db_fetch_array($_SOSOK)):?>
								<option value="<?php echo $_S['uid']?>"<?php if(strstr($CINFO['perm_g'],'['.$_S['uid'].']')):?> selected<?php endif?>><?php echo $_S['name']?>(<?php echo number_format($_S['num'])?>)</option>
								<?php endwhile?>
								</select>
								<span class="help-block">
									<button type="button" class="btn btn-link" data-toggle="collapse" data-target="#guide_permg"><i class="fa fa-question-circle fa-fw"></i><?php echo _LANG('a0014','site')?></button>
								</span>
								<ul id="guide_permg" class="collapse rb-guide">
								<li><?php echo _LANG('a0034','site')?></li>
								</ul>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label"><?php echo _LANG('a0036','site')?></label>
							<div class="col-md-10 col-lg-9">
								<?php $cachefile = $g['path_page'].$r.'-menus/'.$CINFO['id'].'.txt'?>
								<?php $cachetime = file_exists($cachefile) ? implode('',file($cachefile)) : 0?>
								<select name="cachetime" class="col-md-12 form-control">
								<option value=""><?php echo _LANG('a0037','site')?></option>
								<?php for($i = 1; $i < 61; $i++):?>
								<option value="<?php echo $i?>"<?php if($cachetime==$i):?> selected="selected"<?php endif?>><?php echo sprintf(_LANG('a0038','site'),$i)?></option>
								<?php endfor?>
								</select>
								<span class="help-block">
									<button type="button" class="btn btn-link" data-toggle="collapse" data-target="#guide_cache"><i class="fa fa-question-circle fa-fw"></i><?php echo _LANG('a0014','site')?></button>
								</span>
								<ul id="guide_cache" class="collapse rb-guide">
								<li><?php echo _LANG('a0040','site')?></li>
								<li class="text-danger"><?php echo _LANG('a0041','site')?></li>
								</ul>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 col-lg-2 control-label"><?php echo _LANG('a0039','site')?></label>
							<div class="col-md-10 col-lg-9">
								<div class="input-group">
									<input class="form-control" type="text" name="mediaset" id="mediaset" value="<?php echo $CINFO['mediaset']?$CINFO['mediaset']:''?>">
									<div class="input-group-btn">
										<button class="btn btn-default rb-modal-photo" type="button" title="<?php echo _LANG('a0004','site')?>" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window">
											<i class="fa fa-photo fa-lg"></i>
										</button>
										<button class="btn btn-default rb-modal-video" type="button" title="<?php echo _LANG('a0005','site')?>" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window">
											<i class="glyphicon glyphicon-facetime-video fa-lg"></i>
										</button>
									</div>
								</div>
								<span class="help-block">
									<button type="button" class="btn btn-link" data-toggle="collapse" data-target="#guide_mediaset"><i class="fa fa-question-circle fa-fw"></i><?php echo _LANG('a0014','site')?></button>
								</span>
								<ul id="guide_mediaset" class="collapse rb-guide">
								<li><?php echo _LANG('a0042','site')?></li>
								<li><?php echo _LANG('a0043','site')?></li>
								</ul>
							</div>
						</div>
						<?php if($CINFO['uid']):?>
						<?php $_url_1 = $g['s'].'/?r='.$r.'&c='.($vtype?substr($catcode,0,strlen($catcode)-1):$catcode.$CINFO['id'])?>
						<?php $_url_2 = $g['s'].'/'.$r.'/c/'.($vtype?substr($catcode,0,strlen($catcode)-1):$catcode.$CINFO['id'])?>
						<div class="form-group">
							<label class="col-md-2 control-label"><?php echo _LANG('a0044','site')?></label>
							<div class="col-md-10 col-lg-9">

								<div class="input-group" style="margin-bottom: 5px">
									<span class="input-group-addon"><?php echo _LANG('a0045','site')?></span>
									<input id="_url_m_1_" type="text" class="form-control" value="<?php echo $_url_1?>" readonly>
									<span class="input-group-btn">
										<a href="#." class="btn btn-default rb-clipboard hidden-xs" data-tooltip="tooltip" title="<?php echo _LANG('a0047','site')?>" data-clipboard-target="_url_m_1_"><i class="fa fa-clipboard"></i></a>
										<a href="<?php echo $_url_1?>" target="_blank" class="btn btn-default" data-tooltip="tooltip" title="<?php echo _LANG('a0048','site')?>">Go!</a>
									</span>
								</div>  

								<div class="input-group">
									<span class="input-group-addon"><?php echo _LANG('a0046','site')?></span>
									<input id="_url_m_2_" type="text" class="form-control" value="<?php echo $_url_2?>" readonly>
									<span class="input-group-btn">
										<a href="#." class="btn btn-default rb-clipboard hidden-xs" data-tooltip="tooltip" title="<?php echo _LANG('a0047','site')?>" data-clipboard-target="_url_m_2_"><i class="fa fa-clipboard"></i></a>
										<a href="<?php echo $_url_2?>" target="_blank" class="btn btn-default" data-tooltip="tooltip" title="<?php echo _LANG('a0048','site')?>">Go!</a>
									</span>
								</div>  
							</div>
						</div>
						<?php endif?>	

						<div class="form-group">
							<label class="col-md-2 control-label"><?php echo _LANG('a2043','site')?></label>
							<div class="col-md-10 col-lg-9">
								<div class="panel-group" style="margin-bottom:0;">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" href="#menu_header" onclick="sessionSetting('sh_site_menu_3','1','','1');">
													<?php echo _LANG('a2044','site')?> 
													<?php if($CINFO['uid']&&($CINFO['imghead']||is_file($g['path_page'].$r.'-menus/'.$CINFO['id'].'.header.php'))):?><i class="fa fa-check-circle" title="<?php echo _LANG('a0050','site')?>" data-tooltip="tooltip"></i><?php endif?>
												</a>
											</h4>
										</div>
										<div id="menu_header" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_3']):?> in<?php endif?>">
											<div class="panel-body">
												<div class="form-group">
													<label class="col-md-3 control-label" for="menuheader-InputFile"><?php echo _LANG('a2045','site')?></label>
													<div class="col-md-9 col-lg-9">
														<input type="file" name="imghead" id="menuheader-InputFile">
														<?php if($CINFO['imghead']):?>
														<p class="form-control-static">
															<a class="btn bnt-link" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=menu_file_delete&amp;cat=<?php echo $CINFO['uid']?>&amp;dtype=head" onclick="return hrefCheck(this,true,'<?php echo _LANG('a0056','site')?>');"><?php echo _LANG('a0065','site')?></a>
															<a class="btn btn-link" href="<?php echo $g['s']?>/_var/menu/<?php echo $CINFO['imghead']?>" target="_blank"><?php echo _LANG('a0072','site')?></a>
														</p>
														<?php else:?>
														<small class="help-block"><?php echo _LANG('a2046','site')?></small>
														<?php endif?>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label"><?php echo _LANG('a2047','site')?></label>
													<div class="col-md-9 col-lg-9">
														<p>
															<textarea name="codhead" id="codheadArea" class="form-control" rows="5"><?php if(is_file($g['path_page'].$r.'-menus/'.$CINFO['id'].'.header.php')) echo htmlspecialchars(implode('',file($g['path_page'].$r.'-menus/'.$CINFO['id'].'.header.php')))?></textarea>
														</p>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" href="#menu_footer" onclick="sessionSetting('sh_site_menu_4','1','','1');">
													<?php echo _LANG('a2048','site')?>
													<?php if($CINFO['uid']&&($CINFO['imgfoot']||is_file($g['path_page'].$r.'-menus/'.$CINFO['id'].'.footer.php'))):?><i class="fa fa-check-circle" title="<?php echo _LANG('a0050','site')?>" data-tooltip="tooltip"></i><?php endif?>
												</a>
											</h4>
										</div>
										<div id="menu_footer" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_4']):?> in<?php endif?>">
											<div class="panel-body">
												<div class="form-group">
													<label class="col-md-3 control-label" for="menuheader-InputFile"><?php echo _LANG('a2049','site')?></label>
													<div class="col-md-9 col-lg-9">
														<input type="file" name="imgfoot" id="menufooter-InputFile">
														<?php if($CINFO['imgfoot']):?>
														<p class="form-control-static">
															<a class="btn btn-link" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=menu_file_delete&amp;cat=<?php echo $CINFO['uid']?>&amp;dtype=foot" onclick="return hrefCheck(this,true,'<?php echo _LANG('a0056','site')?>');"><?php echo _LANG('a0065','site')?></a>
															<a class="btn btn-link" href="<?php echo $g['s']?>/_var/menu/<?php echo $CINFO['imgfoot']?>" target="_blank"><?php echo _LANG('a0072','site')?></a>
														</p>														
														<?php else:?>
														<small class="help-block"><?php echo _LANG('a2046','site')?></small>
														<?php endif?>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label"><?php echo _LANG('a2050','site')?></label>
													<div class="col-md-9 col-lg-9">
														<p>
															<textarea name="codfoot" id="codfootArea" class="form-control" rows="5"><?php if(is_file($g['path_page'].$r.'-menus/'.$CINFO['id'].'.footer.php')) echo htmlspecialchars(implode('',file($g['path_page'].$r.'-menus/'.$CINFO['id'].'.footer.php')))?></textarea>
														</p>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" href="#menu_addinfo" onclick="sessionSetting('sh_site_menu_5','1','','1');">
													<?php echo _LANG('a2051','site')?>
													<?php if($CINFO['addinfo']):?><i class="fa fa-check-circle" title="<?php echo _LANG('a0050','site')?>" data-tooltip="tooltip"></i><?php endif?>
												</a>
											</h4>
										</div>
										<div id="menu_addinfo" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_5']):?> in<?php endif?>">
											<div class="panel-body">
												<div class="form-group">
													<label class="col-md-3 control-label"><?php echo _LANG('a2051','site')?></label>
													<div class="col-md-9 col-lg-9">
														<textarea name="addinfo" class="form-control" rows="3"><?php echo htmlspecialchars($CINFO['addinfo'])?></textarea>
														<span class="help-block"><?php echo _LANG('a2052','site')?></span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" href="#menu_addattr" onclick="sessionSetting('sh_site_menu_6','1','','1');">
													<?php echo _LANG('a2053','site')?>
													<?php if($_SEO['subject']):?><i class="fa fa-check-circle" title="<?php echo _LANG('a0050','site')?>" data-tooltip="tooltip"></i><?php endif?>
												</a>
											</h4>
									</div>
									<div id="menu_addattr" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_6']):?> in<?php endif?>">
										<div class="panel-body">
											<div class="form-group">
												<label class="col-md-3 control-label"><?php echo _LANG('a2054','site')?></label>
												<div class="col-md-9 col-lg-9">
													<input type="text" name="addattr" class="form-control" placeholder="<?php echo _LANG('a2055','site')?>" value="<?php echo htmlspecialchars($CINFO['addattr'])?>">
													<span class="help-block"><?php echo _LANG('a2056','site')?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>					
						
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-12 col-lg-12">
			<button class="btn btn-primary btn-block btn-lg" id="rb-submit-button" type="submit"><i class="fa fa-check fa-lg"></i> <?php echo _LANG(($CINFO['uid']?'a2057':'a2058'),'site')?></button>
		</div>
	</div>

	</form>			
	</div>
</div>



<!-- zero-clipboard -->
<?php getImport('zero-clipboard','ZeroClipboard.min',false,'js') ?>
<script>
var client = new ZeroClipboard($(".rb-clipboard"));
client.on( "ready", function( readyEvent ) {
	client.on( "aftercopy", function( event ) {
		$('.tooltip .tooltip-inner').text('<?php echo _LANG('a0066','site')?>');
	});
});
</script>

<!-- bootstrap-maxlength -->
<?php getImport('bootstrap-maxlength','bootstrap-maxlength.min',false,'js')?>
<script>
$('input.rb-title').maxlength({
	alwaysShow: true,
	threshold: 10,
	warningClass: "label label-success",
	limitReachedClass: "label label-danger",
});

$('textarea.rb-description').maxlength({
	alwaysShow: true,
	threshold: 10,
	warningClass: "label label-success",
	limitReachedClass: "label label-danger",
});
</script>

<!-- modal -->
<script>
var _mediasetField='';
$(document).ready(function() {
	$('.rb-modal-code').on('click',function() {
		goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=_edit&_mtype=menu&uid=<?php echo $CINFO['uid']?>&type=source&cat=<?php echo $cat?>&code=<?php echo $code?>');
	});
	$('.rb-modal-wysiwyg').on('click',function() {
		goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=_edit&_mtype=menu&uid=<?php echo $CINFO['uid']?>&type=source&wysiwyg=Y&cat=<?php echo $cat?>&code=<?php echo $code?>');
	});
	$('.rb-modal-widget').on('click',function() {
		goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=_edit&_mtype=menu&uid=<?php echo $CINFO['uid']?>&type=widget&cat=<?php echo $cat?>&code=<?php echo $code?>');
	});
	$('.rb-modal-module').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.joint&amp;dropfield=jointf')?>');
	});
	$('.rb-modal-photo').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=mediaset')?>');
	});
	$('.rb-modal-photo1').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=meta_image_src')?>');
	});
	$('.rb-modal-video').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.video.media&amp;dropfield=mediaset')?>');
	});
	$('.rb-modal-photo-drop').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=')?>'+_mediasetField);
	});
});
</script>

<!-- bootstrap Validator -->
<?php getImport('bootstrap-validator','dist/css/bootstrapValidator.min',false,'css')?>
<?php getImport('bootstrap-validator','dist/js/bootstrapValidator.min',false,'js')?>

<script>
$('.form-horizontal').bootstrapValidator({
	message: 'This value is not valid',
	<?php if(!$g['device']):?>
	feedbackIcons: {
		valid: 'glyphicon glyphicon-ok',
		invalid: 'glyphicon glyphicon-remove',
		validating: 'glyphicon glyphicon-refresh'
	},
	<?php endif?>
	fields: {
		name: {
			message: 'The menu is not valid',
			validators: {
				notEmpty: {
					message: '<?php echo _LANG('a2059','site')?>'
				}
			}
		},
		id: {
			validators: {
				notEmpty: {
					message: '<?php echo _LANG('a2060','site')?>'
				},
				regexp: {
					regexp: /^[a-zA-Z0-9\_\-]+$/,
					message: '<?php echo _LANG('a2061','site')?>'
				}
			}
		},
	}
});
</script>

<!-- basic -->
<script>
function saveCheck(f)
{
<?php if(!$SITEN):?>
	alert('<?php echo _LANG('a2062','site')?>      ');
	return false;
<?php endif?>
    var l1 = f._perm_g;
    var n1 = l1.length;
    var i;
	var s1 = '';

	for	(i = 0; i < n1; i++)
	{
		if (l1[i].selected == true && l1[i].value != '')
		{
			s1 += '['+l1[i].value+']';
		}
	}

	f.perm_g.value = s1;

	if (f.id)
	{
		if (f.id.value == '')
		{
			alert('<?php echo _LANG('a2060','site')?>      ');
			f.id.focus();
			return false;
		}
		if (!chkFnameValue(f.id.value))
		{
			alert('<?php echo _LANG('a2061','site')?>      ');
			f.id.focus();
			return false;
		}
	}
	<?php if($CINFO['menutype']=='1'):?>
	if (f.menutype.value == '1')
	{
		if (f.joint.value == '')
		{
			alert('<?php echo _LANG('a0067','site')?>      ');
			f.joint.focus();
			return false;
		}
	}
	<?php endif?>

	if(f.layout_1.value != '0') f.layout.value = f.layout_1.value + '/' + f.layout_1_sub.value;
	else f.layout.value = '';

	getIframeForAction(f);	
}
function boxDeco(layer1,layer2)
{
	if(getId(layer1).className.indexOf('default') == -1) $("#"+layer1).addClass("panel-default").removeClass("panel-primary");
	else $("#"+layer1).addClass("panel-primary").removeClass("panel-default");
	$("#"+layer2).addClass("panel-default").removeClass("panel-primary");
}
function docType(n,str)
{
	getId('rb-document-type').innerHTML = str;
	$('#editBox1').addClass('hidden');
	$('#editBox2').addClass('hidden');
	$('#editBox3').addClass('hidden');
	$('#editBox'+n).removeClass('hidden');
	document.procForm.menutype.value = n;
}
<?php if($d['admin']['dblclick']):?>
document.ondblclick = function(event)
{
	getContext('<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?><?php if($CINFO['code']):?>&c=<?php echo $CINFO['code']?><?php endif?>"><?php echo _LANG('a2063','site')?></a></li><li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&module=<?php echo $module?>&front=menu"><?php echo _LANG('a2064','site')?></a></li><li class="divider"></li><li><a href="#." onclick="getId(\'rb-submit-button\').click();"><?php echo _LANG('a2065','site')?></a></li>',event);	
}
<?php endif?>
</script>
