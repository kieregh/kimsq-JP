<?php
$R = array();
$SITES   = getDbArray($table['s_site'],'','*','gid','asc',0,$p);
$SITEN   = db_num_rows($SITES);
$recnum  = $recnum ? $recnum : 15;
$sendsql = 'site='.$_HS['uid'];
$sendsql.= $cat ? " and category='".$cat."'" : '';
if ($keyw)
{
	$sendsql .= " and (id like '%".$keyw."%' or name like '%".$keyw."%' or category like '%".$keyw."%')";
}
$PAGES = getDbArray($table['s_page'],$sendsql,'*','d_update','desc',$recnum,$p);
$NUM = getDbRows($table['s_page'],$sendsql);
$TPG = getTotalPage($NUM,$recnum);

if ($uid)
{
	$R = getUidData($table['s_page'],$uid);
	$_SEO = getDbData($table['s_seo'],'rel=2 and parent='.$R['uid'],'*');
}
$pageType = array('',_LANG('a0001','site'),_LANG('a0002','site'),_LANG('a0003','site'));
?>


<div class="row">
	<div class="col-md-5 col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading rb-icon">
				<div class="icon">
					<i class="fa fa-file-text-o fa-2x"></i>
				</div>
				<h4 class="dropdown panel-title">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $cat?$cat:_LANG('a3001','site')?> <i class="caret"></i></a>
					<ul class="dropdown-menu">
						<li role="presentation" class="dropdown-header"><?php echo _LANG('a3002','site')?></li>
						<li<?php if(!$cat):?> class="active"<?php endif?>><a href="<?php echo $g['adm_href']?>"><?php echo _LANG('a3001','site')?></a></li>
						<?php $_cats=array()?>
						<?php $CATS=db_query("select *,count(*) as cnt from ".$table['s_page']." group by category",$DB_CONNECT)?>
						<?php while($C=db_fetch_array($CATS)):$_cats[]=$C['category']?>
						<li<?php if($C['category']==$cat):?> class="active"<?php endif?>><a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo urlencode($C['category'])?>"><?php echo $C['category']?> <small>(<?php echo $C['cnt']?>)</small></a></li>
						<?php endwhile?>
					</ul>
					<span class="pull-right">
						<button type="button" class="btn btn-default btn-xs<?php if(!$_SESSION['sh_site_page_search']):?> collapsed<?php endif?>" data-toggle="collapse" data-target="#panel-search" data-tooltip="tooltip" title="<?php echo _LANG('a3003','site')?>" onclick="sessionSetting('sh_site_page_search','1','','1');getSearchFocus();"><i class="glyphicon glyphicon-search"></i></button>
					</span>
				</h4>
			</div>
	
			<?php if($SITEN>1):?>
			<div class="panel-body rb-panel-form" style="border-bottom:#dfdfdf solid 1px;">
				<select class="form-control" onchange="goHref('<?php echo $g['s']?>/?m=<?php echo $m?>&module=<?php echo $module?>&front=<?php echo $front?>&r='+this.value);">
				<?php while($S = db_fetch_array($SITES)):?>
				<option value="<?php echo $S['id']?>"<?php if($r==$S['id']):?> selected<?php endif?>><?php echo $S['name']?> (<?php echo $S['id']?>)</option>
				<?php endwhile?>
				</select>
			</div>
			<?php endif?>

			<div id="panel-search" class="collapse<?php if($_SESSION['sh_site_page_search']):?> in<?php endif?>">
				<form role="form" action="<?php echo $g['s']?>/" method="get">
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="m" value="<?php echo $m?>">
				<input type="hidden" name="module" value="<?php echo $module?>">
				<input type="hidden" name="front" value="<?php echo $front?>">
				<input type="hidden" name="cat" value="<?php echo $cat?>">
					<div class="panel-heading rb-search-box">
						<div class="input-group">
							<div class="input-group-addon"><small><?php echo _LANG('a3004','site')?></small></div>
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
						<input type="text" name="keyw" class="form-control" value="<?php echo $keyw?>" placeholder="<?php echo _LANG('a3005','site')?>">
					</div>
				</form>
			</div>

			<table id="page-list" class="table">
			<thead>
				<tr>
					<td class="rb-pagename"><span><?php echo _LANG('a3006','site')?></span></td>
					<td class="rb-time"><span><?php echo _LANG('a3007','site')?></span></td>
				</tr>
			</thead>
			<tbody>
				<?php $pageTypeIcon=array('','fa-link','fa-puzzle-piece','fa-pencil')?>
				<?php while($PR = db_fetch_array($PAGES)):?>
				<tr<?php if($uid==$PR['uid']):?> class="active1"<?php endif?>>
					<td onclick="goHref('<?php echo $g['adm_href']?>&amp;uid=<?php echo $PR['uid']?>&amp;recnum=<?php echo $recnum?>&amp;p=<?php echo $p?>&amp;cat=<?php echo urlencode($cat)?>&amp;keyw=<?php echo urlencode($keyw)?>#site-page-info');">
						<a href="#.">
							<span class="badge" data-tooltip="tooltip" title="<?php echo $pageType[$PR['pagetype']]?>">
								<i class="fa <?php echo $pageTypeIcon[$PR['pagetype']]?> fa-lg"></i>
							</span>
							<?php echo $PR['name']?>
						</a>
						<small><i><?php echo $PR['id']?></i></small>
					</td>
					<td class="rb-time">
						<?php echo getDateFormat($PR['d_update'],$lang['site']['a3008'])?>
					</td>
				</tr>
				<?php endwhile?>
			</tbody>
			</table>

			<div class="panel-footer rb-panel-footer">
				<ul class="pagination">
				<script>getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
				<?php //echo getPageLink(5,$p,$TPG,'')?>
				</ul>
			</div>
			<div class="panel-footer">
				<a class="btn btn-default btn-block" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=dumpmenu&amp;type=package_page" target="_action_frame_<?php echo $m?>"><i class="fa fa-download fa-lg"></i> <?php echo _LANG('a0073','site')?></a>
			</div>
		</div>
	</div>

	<div id="tab-content-view" class="col-md-7 col-lg-8">
		<?php if($g['device']):?><a name="site-page-info"></a><?php endif?>
		<form name="procForm" class="form-horizontal rb-form" role="form" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="regispage">
		<input type="hidden" name="uid" value="<?php echo $R['uid']?>">
		<input type="hidden" name="orign_id" value="<?php echo $R['id']?>">
		<input type="hidden" name="perm_g" value="<?php echo $R['perm_g']?>">
		<input type="hidden" name="seouid" value="<?php echo $_SEO['uid']?>">
		<input type="hidden" name="layout" value="">
		<input type="hidden" name="cat" value="<?php echo $cat?>">
		<input type="hidden" name="recnum" value="<?php echo $recnum?>">
		<input type="hidden" name="keyw" value="<?php echo $keyw?>">
		<input type="hidden" name="p" value="<?php echo $p?>">
		<input type="hidden" name="pagetype" value="<?php echo $R['uid']?$R['pagetype']:3?>">

		
			<div class="page-header">
				<h4>
					<?php if($R['uid']):?>
					<?php echo _LANG('a3009','site')?>
					<div class="pull-right rb-top-btnbox hidden-xs">
						<a href="<?php echo $g['adm_href']?>" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo _LANG('a0051','site')?></a>
						<div class="btn-group rb-btn-view">
							<a href="<?php echo RW('mod='.$R['id'])?>" class="btn btn-default"><?php echo _LANG('a0053','site')?></a>
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li><a href="<?php echo RW('mod='.$R['id'])?>" target="_blank"><i class="glyphicon glyphicon-new-window"></i> <?php echo _LANG('a0054','site')?></a></li>
							</ul>
						</div>
					</div>
					<?php else:?>
					<?php echo _LANG('a3010','site')?>
					<?php endif?>
				</h4>
			</div>

			<div class="form-group rb-outside">
				<label class="col-md-2 col-lg-2 control-label"><?php echo _LANG('a3011','site')?></label>
				<div class="col-md-10 col-lg-9">
					<div class="input-group input-group-lg">
						<?php if($R['uid']):?>
						<span class="input-group-btn">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-tooltip="tooltip" title="<?php echo _LANG('a0055','site')?>">
								<span id="rb-document-type"><?php echo $pageType[$R['pagetype']]?></span> <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#" onclick="docType(3,'<?php echo $pageType[3]?>');"><i class="fa fa-code"></i> <?php echo $pageType[3]?></a></li>
								<li><a href="#" onclick="docType(2,'<?php echo $pageType[2]?>');"><i class="fa fa-puzzle-piece fa-lg"></i> <?php echo $pageType[2]?></a></li>
								<li><a href="#" onclick="docType(1,'<?php echo $pageType[1]?>');"><i class="kf kf-module"></i> <?php echo $pageType[1]?></a></li>
							</ul>
						</span>
						<?php endif?>
						<input class="form-control" placeholder="" type="text" name="name" value="<?php echo $R['name']?>"<?php if(!$R['uid'] && !$g['device']):?> autofocus<?php endif?>>
						<span class="input-group-btn">
							<button class="btn btn-default rb-help-btn" type="button" data-toggle="collapse" data-target="#guide_startpage" data-tooltip="tooltip" title="<?php echo _LANG('a3012','site')?>"><i class="kf-admin" style="width:10px;"></i></button>
						</span>
						<?php if($R['uid']):?>
						<span class="input-group-btn">
							<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletepage&amp;uid=<?php echo $R['uid']?>" onclick="return hrefCheck(this,true,'<?php echo _LANG('a0056','site')?>');" class="btn btn-default" data-tooltip="tooltip" title="<?php echo _LANG('a0065','site')?>">
							<i class="fa fa-trash-o fa-lg"></i>
							</a>
						</span>
						<?php endif?>
					</div>
				</div>
			</div>

			<div id="guide_startpage" class="collapse">
				<div class="col-md-offset-2 col-lg-offset-2">
					<div class="help-block">
						<label class="checkbox-inline">
							<input type="checkbox" name="ismain" value="1"<?php if($R['ismain']):?> checked<?php endif?>><i></i><span class="glyphicon glyphicon-home"></span> <?php echo _LANG('a3013','site')?> 
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" name="mobile" value="1"<?php if($R['mobile']):?> checked<?php endif?>><i></i><span class="glyphicon glyphicon-phone"></span> <?php echo _LANG('a3014','site')?> 
						</label>
						<p>
							<?php echo _LANG('a3015','site')?><br>
							<?php echo _LANG('a3016','site')?><br>
							<?php echo _LANG('a3017','site')?><br><br>
						</p>
					</div>
				</div>

				<div class="form-group rb-outside">
					<label class="col-md-2 control-label"><?php echo _LANG('a3018','site')?></label>
					<div class="col-md-10 col-lg-9">
						<div class="input-group">
							<input class="form-control" type="text" name="id" value="<?php echo $R['id']?$R['id']:'p'.$date['tohour']?>" maxlength="20" placeholder="">
							<span class="input-group-btn">
								<button class="btn btn-default rb-help-btn" type="button" data-toggle="collapse" data-target="#guide_pagecode" data-tooltip="tooltip" title="<?php echo _LANG('a0014','site')?>"><i class="fa fa-question fa-lg"></i></button>
							</span>
						</div>
						<div id="guide_pagecode" class="collapse help-block">
							<?php echo _LANG('a3019','site')?><br>
							<?php echo _LANG('a3020','site')?><br>
							<?php echo _LANG('a3021','site')?><br>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group tab-content<?php if(!$R['uid']):?> hidden<?php endif?>">
				<div class="form-group<?php if($R['pagetype']!=3):?> hidden<?php endif?>" id="editBox3">
					<div class="col-md-offset-2 col-md-10 col-lg-9">
						<fieldset<?php if($R['pagetype']!=3):?> disabled<?php endif?>>
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
							<ul class="list-unstyled">
								<li><?php echo _LANG('a0063','site')?></li>
								<li><?php echo _LANG('a0064','site')?></li>
								<?php if($R['pagetype']!=3):?><li><?php echo _LANG('a3022','site')?></li><?php endif?>
							</ul>
						</span>
					</div>
				</div>
				<div class="form-group<?php if($R['pagetype']!=2):?> hidden<?php endif?>" id="editBox2">
					<div class="col-md-offset-2 col-md-10 col-lg-9">
						<?php if($R['pagetype']==2):?>
						<fieldset>
							<a href="#." class="btn btn-default btn-block rb-modal-widget"><i class="fa fa-puzzle-piece fa-lg"></i> <?php echo _LANG('a0059','site')?></a>
						</fieldset>
						<?php else:?>
						<fieldset disabled>
							<a href="#." class="btn btn-default btn-block"><i class="fa fa-puzzle-piece fa-lg"></i>
								<?php echo _LANG('a0059','site')?>
								<small class="text-muted">( <?php echo _LANG('a3022','site')?> )</small>							
							</a>
						</fieldset>
						<?php endif?>
					</div>
				</div>
				<div class="form-group<?php if($R['pagetype']!=1):?> hidden<?php endif?>" id="editBox1">
					<div class="col-md-offset-2 col-md-10 col-lg-9">
						<?php if($R['pagetype']==1):?>
						<fieldset>
							<div class="input-group">
								<input type="text" name="joint" id="jointf" value="<?php echo $R['joint']?>" class="form-control">
								<span class="input-group-btn">
									<button class="btn btn-default rb-modal-module" type="button" title="<?php echo _LANG('a0060','site')?>" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window"><i class="fa fa-link fa-lg"></i></button>
									<button class="btn btn-default" type="button" title="<?php echo _LANG('a0061','site')?>" data-tooltip="tooltip" onclick="getId('jointf').value!=''?window.open(getId('jointf').value):alert('<?php echo _LANG('a0062','site')?>');">Go!</button>
								</span>
							</div>
						</fieldset>
						<?php else:?>
						<fieldset disabled>
							<div class="input-group">
								<input type="text" name="joint" id="jointf" value="<?php echo $R['joint']?>" placeholder="<?php echo _LANG('a3022','site')?>" class="form-control">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" title="<?php echo _LANG('a0060','site')?>"><i class="fa fa-link fa-lg"></i></button>
									<button class="btn btn-default" type="button" title="<?php echo _LANG('a0061','site')?>">Go!</button>
								</span>
							</div>
						</fieldset>
						<?php endif?>
						<span class="help-block text-muted">
							<ul class="list-unstyled">
								<li><?php echo _LANG('a3023','site')?></li>
								<li><?php echo _LANG('a3024','site')?></li>
								<li><?php echo _LANG('a3025','site')?></li>
							</ul>
						</span>
					</div>
				</div>
			</div>

			<div class="panel-group" id="page-settings">
				<div class="panel panel-<?php echo $_SESSION['sh_site_page_1']==1?'primary':'default'?>" id="page-settings-meta">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#page-settings" href="#page-settings-meta-body" onclick="sessionSetting('sh_site_page_1',getId('page-settings-meta').className.indexOf('default')==-1?'':'1','','');boxDeco('page-settings-meta','page-settings-advance');">
								<i class="fa fa-caret-right fa-fw"></i><?php echo _LANG('a0007','site')?>
							</a>
						</h4>
					</div>
					<div id="page-settings-meta-body" class="panel-collapse collapse<?php if($_SESSION['sh_site_page_1']==1):?> in<?php endif?>">
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
			  
				<div class="panel panel-<?php echo $_SESSION['sh_site_page_1']==2?'primary':'default'?>" id="page-settings-advance">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#page-settings" href="#page-settings-advance-body" onclick="sessionSetting('sh_site_page_1',getId('page-settings-advance').className.indexOf('default')==-1?'':'2','','');boxDeco('page-settings-advance','page-settings-meta');">
								<i class="fa fa-caret-right fa-fw"></i><?php echo _LANG('a0008','site')?>
							</a>
						</h4>
					</div>
					<div id="page-settings-advance-body" class="panel-collapse collapse<?php if($_SESSION['sh_site_page_1']==2):?> in<?php endif?>">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-md-2 control-label"><?php echo _LANG('a0027','site')?></label>
								<div class="col-md-10 col-lg-9">

									<div class="xrow">
										<div class="col-sm-6" id="rb-layout-select">
											<select class="form-control" name="layout_1" required onchange="getSubLayout(this,'rb-layout-select2','layout_1_sub','');">
												<?php $_layoutHexp=explode('/',$_HS['layout'])?>
												<option value="0"><?php echo _LANG('a0028','site')?>(<?php echo getFolderName($g['path_layout'].$_layoutHexp[0])?>)</option>
												<?php $_layoutExp1=explode('/',$R['layout'])?>
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
								<label class="col-md-2 col-lg-2 control-label"><?php echo _LANG('a3026','site')?></label>
								<div class="col-md-10 col-lg-9">
									<div class="input-group">
										<input class="form-control" type="text" name="category" value="<?php echo $R['category']?$R['category']:$_cats[0]?>">
										<div class="input-group-btn">
											<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu pull-right">
												<?php foreach($_cats as $_val):?>
												<li><a href="#." onclick="document.procForm.category.value=this.innerHTML;"><?php echo $_val?></a></li>
												<?php endforeach?>
												<?php if(count($_cats)):?>
												<li class="divider"></li>
												<?php endif?>
												<li><a href="#." onclick="document.procForm.category.value='';document.procForm.category.focus();"><?php echo _LANG('a3027','site')?></a></li>
											</ul>
										</div>
									</div>
									<ul class="rb-guide" style="border-top:0;">
									<li><?php echo _LANG('a3028','site')?></li>
									<li><?php echo _LANG('a3029','site')?></li>
									<li><?php echo _LANG('a3030','site')?></li>
									</ul>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label"><?php echo _LANG('a3031','site')?></label>
								<div class="col-md-10 col-lg-9">
									<select class="col-md-12 form-control" name="linkedmenu">
									<option value=""><?php echo _LANG('a3032','site')?></option>
									<?php include $g['path_core'].'function/menu1.func.php'?>
									<?php $cat=$R['linkedmenu']?>
									<?php getMenuShowSelect($s,$table['s_menu'],0,0,0,0,0,'')?>
									</select>
									<span class="help-block">
										<button type="button" class="btn btn-link" data-toggle="collapse" data-target="#guide_sosok"><i class="fa fa-question-circle fa-fw"></i><?php echo _LANG('a0014','site')?></button>
									</span>
									<ul id="guide_sosok" class="collapse rb-guide">
									<li><?php echo _LANG('a3033','site')?></li>
									<li><?php echo _LANG('a3034','site')?></li>
									</ul>
								</div>
							</div>				
							<div class="form-group">
								<label class="col-md-2 col-lg-2 control-label"><?php echo _LANG('a0030','site')?></label>
								<div class="col-md-10 col-lg-9">
									<select class="col-md-12 form-control" name="perm_l">
									<option value=""><?php echo _LANG('a0031','site')?></option>
									<?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
									<?php while($_L=db_fetch_array($_LEVEL)):?>
									<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$R['perm_l']):?> selected<?php endif?>><?php echo sprintf(_LANG('a0035','site'),$_L['name'].'('.number_format($_L['num']).')')?></option>
									<?php if($_L['gid'])break; endwhile?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label"><?php echo _LANG('a0032','site')?></label>
								<div class="col-md-10 col-lg-9">
									<select class="col-md-12 form-control" name="_perm_g" multiple size="5">
									<option value=""<?php if(!$R['perm_g']):?> selected="selected"<?php endif?>><?php echo _LANG('a0033','site')?></option>
									<?php $_SOSOK=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
									<?php while($_S=db_fetch_array($_SOSOK)):?>
									<option value="<?php echo $_S['uid']?>"<?php if(strstr($R['perm_g'],'['.$_S['uid'].']')):?> selected<?php endif?>><?php echo $_S['name']?>(<?php echo number_format($_S['num'])?>)</option>
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
									<?php $cachefile = $g['path_page'].$r.'-pages/'.$R['id'].'.txt'?>
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
										<input class="form-control" type="text" name="mediaset" id="mediaset" value="<?php echo $R['mediaset']?$R['mediaset']:''?>">
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
							<?php if($R['uid']):?>
							<?php $_url_1 = $g['s'].'/index.php?r='.$r.'&mod='.$R['id']?>
							<?php $_url_2 = $g['s'].'/'.$r.'/p/'.$R['id']?>
							<div class="form-group">
								<label class="col-md-2 col-lg-2 control-label"><?php echo _LANG('a0044','site')?></label>
								<div class="col-md-10 col-lg-9">
									<div class="input-group" style="margin-bottom: 5px">
										<span class="input-group-addon"><?php echo _LANG('a0045','site')?></span>
										<input type="text" id="_url_m_1_" class="form-control" value="<?php echo $_url_1?>">
										<span class="input-group-btn">
											<a href="#." class="btn btn-default rb-clipboard hidden-xs" data-tooltip="tooltip" title="<?php echo _LANG('a0047','site')?>" data-clipboard-target="_url_m_1_"><i class="fa fa-clipboard"></i></a>
											<a href="<?php echo $_url_1?>" target="_blank" class="btn btn-default" data-tooltip="tooltip" title="<?php echo _LANG('a0048','site')?>">Go!</a>
										</span>
									</div>  
									<div class="input-group">
										<span class="input-group-addon"><?php echo _LANG('a0046','site')?></span>
										<input type="text" id="_url_m_2_" class="form-control" value="<?php echo $_url_2?>">
										<span class="input-group-btn">
											<a href="#." class="btn btn-default rb-clipboard hidden-xs" data-tooltip="tooltip" title="<?php echo _LANG('a0047','site')?>" data-clipboard-target="_url_m_2_"><i class="fa fa-clipboard"></i></a>
											<a href="<?php echo $_url_2?>" target="_blank" class="btn btn-default" data-tooltip="tooltip" title="<?php echo _LANG('a0048','site')?>">Go!</a>
										</span>
									</div>
								</div>
							</div>
							<?php endif?>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12 col-lg-12">
					<button class="btn btn-primary btn-block btn-lg" id="rb-submit-button" type="submit"><i class="fa fa-check fa-lg"></i> <?php echo _LANG(($R['uid']?'a3035':'a3036'),'site')?></button>
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
		goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=_edit&_mtype=page&uid=<?php echo $R['uid']?>&type=source&cat=<?php echo urlencode($cat)?>&p=<?php echo $p?>&recnum=<?php echo $recnum?>&keyw=<?php echo urlencode($keyw)?>');
	});
	$('.rb-modal-wysiwyg').on('click',function() {
		goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=_edit&_mtype=page&uid=<?php echo $R['uid']?>&type=source&wysiwyg=Y&cat=<?php echo urlencode($cat)?>&p=<?php echo $p?>&recnum=<?php echo $recnum?>&keyw=<?php echo urlencode($keyw)?>');
	});
	$('.rb-modal-widget').on('click',function() {
		goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=_edit&_mtype=page&uid=<?php echo $R['uid']?>&type=widget&cat=<?php echo urlencode($cat)?>&p=<?php echo $p?>&recnum=<?php echo $recnum?>&keyw=<?php echo urlencode($keyw)?>');
	});
	$('.rb-modal-module').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.joint&amp;dropfield=jointf&amp;cmodule=[site]')?>');
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
			message: 'The username is not valid',
			validators: {
				notEmpty: {
					message: '<?php echo _LANG('a3037','site')?>'
				}
			}
		},
		id: {
			validators: {
				notEmpty: {
					message: '<?php echo _LANG('a3038','site')?>'
				},
				regexp: {
					regexp: /^[a-zA-Z0-9\_\-]+$/,
					message: '<?php echo _LANG('a3039','site')?>'
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


	<?php if($R['pagetype']=='1'):?>
	if (f.pagetype.value == '1')
	{
		if (f.joint.value == '')
		{
			alert('<?php echo _LANG('a0067','site')?>    ');
			f.joint.focus();
			return false;
		}
	}
	<?php endif?>

	if(f.layout_1.value != '0') f.layout.value = f.layout_1.value + '/' + f.layout_1_sub.value;
	else f.layout.value = '';

	getIframeForAction(f);	
	//return confirm('<?php echo _LANG('a0049','site')?>        ');
}
function boxDeco(layer1,layer2)
{
	if(getId(layer1).className.indexOf('default') == -1) $("#"+layer1).addClass("panel-default").removeClass("panel-primary");
	else $("#"+layer1).addClass("panel-primary").removeClass("panel-default");
	$("#"+layer2).addClass("panel-default").removeClass("panel-primary");
}
function getSearchFocus()
{
	if(getId('panel-search').className.indexOf('in') == -1) setTimeout("document.forms[0].keyw.focus();",100);
}
function docType(n,str)
{
	getId('rb-document-type').innerHTML = str;
	$('#editBox1').addClass('hidden');
	$('#editBox2').addClass('hidden');
	$('#editBox3').addClass('hidden');
	$('#editBox'+n).removeClass('hidden');
	document.procForm.pagetype.value = n;
}
<?php if($d['admin']['dblclick']):?>
document.ondblclick = function(event)
{
	getContext('<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?><?php if($R['id']):?>&mod=<?php echo $R['id']?><?php endif?>"><?php echo _LANG('a3040','site')?></a></li><li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&module=<?php echo $module?>&front=page"><?php echo _LANG('a3041','site')?></a></li><li class="divider"></li><li><a href="#." onclick="getId(\'rb-submit-button\').click();"><?php echo _LANG('a3042','site')?></a></li>',event);	
}
<?php endif?>
</script>
