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
		<div class="panel panel-default">
			<div class="panel-heading rb-icon">
				<div class="icon">
					<i class="fa kf kf-module fa-2x"></i>
				</div>
				<h4 class="dropdown panel-title">
					<a><?php echo _LANG('a0001','module')?></a>
					<span class="pull-right">
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
	</div>

	<?php if(!$R['id']) $R=getDbData($table['s_module'],"id='site'",'*')?>
	<?php if($g['device']):?><a name="page-info"></a><?php endif?>
	<div class="col-md-7 col-lg-8" id="tab-content-view">
		<div class="page-header">
			<h4><?php echo _LANG('a2001','module')?></h4>
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
				<button type="button" class="btn btn-default" style="margin:10px 0"><span class="label label-default">1.1.0</span> 최신 업데이트가 없습니다.</button>
				<p class="text-muted"><small>선택된 모듈에 대한 업데이트 정보입니다.</small></p>
			</div>
		</div>

		<hr>

		<?php 
		include $g['path_core'].'function/rss.func.php';
		include $g['path_module'].'market/var/var.php';
		$_serverinfo = explode('/',$d['market']['url']);
		$_updatelist = getUrlData('http://'.$_serverinfo[2].'/__update/market/modules/'.$id.'/update.txt',10);
		$_updatelist = explode("\n",$_updatelist);
		$_updatelength = count($_updatelist)-1;
		$recnum	=  10;
		$TPG = getTotalPage($_updatelength,$recnum);
		?>
	
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>버전</th>
						<th>패치/업데이트</th>
						<th>적용일자</th>
						<th>처리여부</th>
						<th>관리</th>
					</tr>
				</thead>
				<tbody>

					<?php $_ishistory=false?>
					<?php for($i = $_updatelength-(($p-1)*$recnum)-1; $i > $_updatelength-($p*$recnum)-1; $i--):?>
					<?php $_update=trim($_updatelist[$i]);if(!$_update)continue?>
					<?php $var1=explode(',',$_update)?>
					<?php $var2=explode(',',$_updatelist[$i-1])?>
					<?php $_updatefile=$g['path_module'].$id.'/update/'.$var1[1].'.txt'?>
					<?php if(is_file($_updatefile)):?>
					<?php $_supdate=explode(',',implode('',file($_updatefile)))?>

					<tr>
						<td><?php echo $var1[0]?></td>
						<td><a href="http://<?php echo $_serverinfo[2]?>/market/<?php echo $var1[2]?>" target="_blank"><?php echo $var1[0]?>_<?php echo $var1[1]?></a></td>
						<td><?php echo getDateFormat($_supdate[0],$lang['module']['date1'])?></td>
						<td><span class="label label-default">완료됨 <?php if($_supdate[1]):?>(수동)<?php else:?>(원격)<?php endif?></span></td>
						<td>
							<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=update_extension&amp;extension_path=./modules/<?php echo $id?>/&amp;type=delete&amp;ufile=<?php echo $var1[1]?>" title="업데이트기록 제거" class="btn btn-default btn-sm" onclick="return hrefCheck(this,true,'정말로 업데이트 기록을 제거하시겠습니까?');">기록제거</a>
						</td>
					</tr>

					<?php else:?>

					<tr>
						<td><?php echo $var1[0]?></td>
						<td><a href="http://<?php echo $_serverinfo[2]?>/market/<?php echo $var1[2]?>" target="_blank"><?php echo $var1[0]?>_<?php echo $var1[1]?></a></td>
						<td></td>
						<td>미적용</td>
						<td>
							<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=update_extension&amp;extension_path=./modules/<?php echo $id?>/&amp;type=auto&amp;ufile=<?php echo $var1[1]?>" onclick="return hrefCheck(this,true,'정말로 업데이트 하시겠습니까?');">원격 업데이트</a>
							<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=update_extension&amp;extension_path=./modules/<?php echo $id?>/&amp;type=manual&amp;ufile=<?php echo $var1[1]?>" title="수동 업데이트 처리" onclick="return hrefCheck(this,true,'정말로 수동으로 업데이트 처리하시겠습니까?\n수동 업데이트 처리시 원격업데이트는 건너뜁니다.');">수동 업데이트</a>
						</td>
					</tr>

					<?php endif?>
					<?php endfor?>
					<?php if(!$_updatelength):?>
					<tr>
					<td colspan="5">업데이트 대기리스트가 없습니다.</td>
					</tr>
					<?php endif?>
				</tbody>
			</table>
		</div>

		<div class="text-center">
			<ul class="pagination">
				<script type="text/javascript">getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
				<?php //echo getPageLink(5,$p,$TPG,'')?>
			</ul>
		</div>
	</div>
</div>


