<?php
include $g['path_module'].$module.'/function.php';
$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,1);

$sort	= $sort ? $sort : 'gid';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 201 ? $recnum : 20;

$sqlque	= 'uid';
if ($siteuid) $sqlque .= ' and site='.$siteuid;
if ($d_start) $sqlque .= ' and d_regis > '.str_replace('/','',$d_start).'000000';
if ($d_finish) $sqlque .= ' and d_regis < '.str_replace('/','',$d_finish).'240000';
if ($filekind)
{
	if ($filekind == 1)
	{
		if ($filetype == 2) $sqlque .= ' and type<0';
		else $sqlque .= ' and (type=-1 or type=2)';
	}
	else if ($filekind == 2)
	{
		if ($filetype == 2) $sqlque .= ' and type=0'; 
		else $sqlque .= ' and (type=0 or type=5)';
	}
	else
	{
		if ($filetype) $sqlque .= ' and fileonly=0';
		else $sqlque .= ' and fileonly=1';
	}
}
else {
	if ($filetype)
	{
		if ($filetype == 1) $sqlque .= ' and type>0';
		else $sqlque .= ' and type<1';
	}
}
if ($fserver)
{
	if ($fserver == 1) $sqlque .= ' and fserver=0';
	else $sqlque .= ' and fserver=1';
}
if ($where && $keyw)
{
	if (strstr('[mbruid]',$where)) $sqlque .= " and ".$where."='".$keyw."'";
	else $sqlque .= getSearchSql($where,$keyw,$ikeyword,'or');	
}
$RCD = getDbArray($table['s_upload'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_upload'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);
?>

<div id="uplist">

	<form name="procForm" action="<?php echo $g['s']?>/" method="get" class="form-horizontal">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $m?>">
		<input type="hidden" name="module" value="<?php echo $module?>">
		<input type="hidden" name="front" value="<?php echo $front?>">

		<div class="rb-heading well well-sm">
			<div class="form-group">
				<label class="col-sm-1 control-label"><?php echo _LANG('a2001','mediaset')?></label>
				<div class="col-sm-10">
					<div class="row">
						<div class="col-sm-3">
							<select name="siteuid" class="form-control input-sm" onchange="this.form.submit();">
							<option value=""><?php echo _LANG('a2002','mediaset')?></option>
							<?php $SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p)?>
							<?php while($S = db_fetch_array($SITES)):?>
							<option value="<?php echo $S['uid']?>"<?php if($S['uid']==$siteuid):?> selected<?php endif?>><?php echo $S['name']?> (<?php echo $S['id']?>)</option>
							<?php endwhile?>
							</select>
						</div>
						<div class="col-sm-3">
							<select name="filekind" class="form-control input-sm" onchange="this.form.submit();">
							<option value=""><?php echo _LANG('a2003','mediaset')?></option>
							<option value="1"<?php if($filekind==1):?> selected<?php endif?>><?php echo _LANG('a2004','mediaset')?></option>
							<option value="2"<?php if($filekind==2):?> selected<?php endif?>><?php echo _LANG('a2005','mediaset')?></option>
							<option value="3"<?php if($filekind==3):?> selected<?php endif?>><?php echo _LANG('a2006','mediaset')?></option>
							</select>
						</div>
						<div class="col-sm-3">
							<select name="filetype" class="form-control input-sm" onchange="this.form.submit();">
							<option value=""><?php echo _LANG('a2007','mediaset')?><?php echo _LANG('a2008','mediaset')?></option>
							<option value="1"<?php if($filetype==1):?> selected<?php endif?>><?php echo _LANG('a2008','mediaset')?></option>
							<option value="2"<?php if($filetype==2):?> selected<?php endif?>><?php echo _LANG('a2009','mediaset')?></option>
							</select>
						</div>
						<div class="col-sm-3">
							<select name="fserver" class="form-control input-sm" onchange="this.form.submit();">
							<option value=""><?php echo _LANG('a2010','mediaset')?></option>
							<option value="1"<?php if($fserver==1):?> selected<?php endif?>><?php echo _LANG('a2011','mediaset')?></option>
							<option value="2"<?php if($fserver==2):?> selected<?php endif?>><?php echo _LANG('a2012','mediaset')?></option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div id="search-more" class="collapse<?php if($_SESSION['sh_mediaset']):?> in<?php endif?>">

				<div class="form-group">
					<label class="col-sm-1 control-label"><?php echo _LANG('a2013','mediaset')?></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-4">
								<div class="input-daterange input-group input-group-sm" id="datepicker">
									<input type="text" class="form-control" name="d_start" placeholder="<?php echo _LANG('a2014','mediaset')?>" value="<?php echo $d_start?>">
									<span class="input-group-addon">~</span>
									<input type="text" class="form-control" name="d_finish" placeholder="<?php echo _LANG('a2015','mediaset')?>" value="<?php echo $d_finish?>">
									<span class="input-group-btn">
										<button class="btn btn-default" type="submit"><?php echo _LANG('a2016','mediaset')?></button>
									</span>
								</div>
							</div>
							<div class="col-sm-3 hidden-xs">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" onclick="dropDate('<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-1,substr($date['today'],0,4)))?>','<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-1,substr($date['today'],0,4)))?>');"><?php echo _LANG('a2017','mediaset')?></button>
									<button class="btn btn-default" type="button" onclick="dropDate('<?php echo getDateFormat($date['today'],'Y/m/d')?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');"><?php echo _LANG('a2018','mediaset')?></button>
									<button class="btn btn-default" type="button" onclick="dropDate('<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-7,substr($date['today'],0,4)))?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');"><?php echo _LANG('a2019','mediaset')?></button>
									<button class="btn btn-default" type="button" onclick="dropDate('<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2)-1,substr($date['today'],6,2),substr($date['today'],0,4)))?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');"><?php echo _LANG('a2020','mediaset')?></button>
									<button class="btn btn-default" type="button" onclick="dropDate('<?php echo getDateFormat(substr($date['today'],0,6).'01','Y/m/d')?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');"><?php echo _LANG('a2021','mediaset')?></button>
									<button class="btn btn-default" type="button" onclick="dropDate('<?php echo date('Y/m/',mktime(0,0,0,substr($date['today'],4,2)-1,substr($date['today'],6,2),substr($date['today'],0,4)))?>01','<?php echo date('Y/m/',mktime(0,0,0,substr($date['today'],4,2)-1,substr($date['today'],6,2),substr($date['today'],0,4)))?>31');"><?php echo _LANG('a2022','mediaset')?></button>
									<button class="btn btn-default" type="button" onclick="dropDate('','');"><?php echo _LANG('a2023','mediaset')?></button>
								</span>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group hidden-xs">
					<label class="col-sm-1 control-label"><?php echo _LANG('a2024','mediaset')?></label>
					<div class="col-sm-10">
						<div class="btn-toolbar">
							<div class="btn-group btn-group-sm" data-toggle="buttons">
								<label class="btn btn-default<?php if($sort=='gid'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="gid" name="sort"<?php if($sort=='gid'):?> checked<?php endif?>> <?php echo _LANG('a2025','mediaset')?>
								</label>
								<label class="btn btn-default<?php if($sort=='down'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="down" name="sort"<?php if($sort=='down'):?> checked<?php endif?>> <?php echo _LANG('a2026','mediaset')?>
								</label>
								<label class="btn btn-default<?php if($sort=='size'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="size" name="sort"<?php if($sort=='size'):?> checked<?php endif?>> <?php echo _LANG('a2027','mediaset')?>
								</label>
								<label class="btn btn-default<?php if($sort=='width'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="width" name="sort"<?php if($sort=='width'):?> checked<?php endif?>> <?php echo _LANG('a2028','mediaset')?>
								</label>
								<label class="btn btn-default<?php if($sort=='height'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="height" name="sort"<?php if($sort=='height'):?> checked<?php endif?>> <?php echo _LANG('a2029','mediaset')?>
								</label>
							</div>
							<div class="btn-group btn-group-sm" data-toggle="buttons">
								<label class="btn btn-default<?php if($orderby=='desc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="desc" name="orderby"<?php if($orderby=='desc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-desc"></i> <?php echo _LANG('a2030','mediaset')?>
								</label>
								<label class="btn btn-default<?php if($orderby=='asc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="asc" name="orderby"<?php if($orderby=='asc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-asc"></i> <?php echo _LANG('a2031','mediaset')?>
								</label>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-1 control-label"><?php echo _LANG('a2032','mediaset')?></label>
					<div class="col-sm-10">
						<div class="input-group input-group-sm">
							<span class="input-group-btn hidden-xs" style="width:165px">
								<select name="where" class="form-control btn btn-default">
									<option value="name"<?php if($where=='name'):?> selected="selected"<?php endif?>><?php echo _LANG('a2033','mediaset')?></option>
									<option value="caption"<?php if($where=='caption'):?> selected="selected"<?php endif?>><?php echo _LANG('a2034','mediaset')?></option>
									<option value="ext"<?php if($where=='ext'):?> selected="selected"<?php endif?>><?php echo _LANG('a2035','mediaset')?></option>
									<option value="mbruid"<?php if($where=='mbruid'):?> selected="selected"<?php endif?>><?php echo _LANG('a2036','mediaset')?></option>
								</select>
							</span>
							<input type="text" name="keyw" value="<?php echo stripslashes($keyw)?>" class="form-control">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><?php echo _LANG('a2032','mediaset')?></button>
							</span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-1 control-label"><?php echo _LANG('a2037','mediaset')?></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-2">
								<select name="recnum" onchange="this.form.submit();" class="form-control input-sm">
									<option value="20"<?php if($recnum==20):?> selected="selected"<?php endif?>><?php echo sprintf(_LANG('a2038','mediaset'),20)?></option>
									<option value="35"<?php if($recnum==35):?> selected="selected"<?php endif?>><?php echo sprintf(_LANG('a2038','mediaset'),35)?></option>
									<option value="50"<?php if($recnum==50):?> selected="selected"<?php endif?>><?php echo sprintf(_LANG('a2038','mediaset'),50)?></option>
									<option value="75"<?php if($recnum==75):?> selected="selected"<?php endif?>><?php echo sprintf(_LANG('a2038','mediaset'),75)?></option>
									<option value="90"<?php if($recnum==90):?> selected="selected"<?php endif?>><?php echo sprintf(_LANG('a2038','mediaset'),90)?></option>
								</select>
							</div>
							<div class="col-sm-2">

							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-10">
					<button type="button" class="btn btn-link rb-advance<?php if(!$_SESSION['sh_mediaset']):?> collapsed<?php endif?>" data-toggle="collapse" data-target="#search-more" onclick="sessionSetting('sh_mediaset','1','','1');"><?php echo _LANG('a2039','mediaset')?> <small></small></button>
					<a href="<?php echo $g['adm_href']?>" class="btn btn-link"><?php echo _LANG('a2040','mediaset')?></a>
				</div>
			</div>

		</div>
	</form>


	<div class="page-header">
		<h4>
			<small><?php echo number_format($NUM)?> <?php echo _LANG('a2041','mediaset')?> ( <?php echo $p?>/<?php echo $TPG.($TPG>1?'pages':'page')?> )</small>
		</h4>
	</div>

	<form name="listForm" action="<?php echo $g['s']?>/" method="post">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="">


		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th><label data-tooltip="tooltip" title="선택"><input type="checkbox" class="checkAll-file-user"></label></th>
						<th><?php echo _LANG('a2042','mediaset')?></th>
						<th class="rb-left"><?php echo _LANG('a2043','mediaset')?></th>
						<th><?php echo _LANG('a2044','mediaset')?></th>
						<th><?php echo _LANG('a2045','mediaset')?></th>
						<th><?php echo _LANG('a2046','mediaset')?></th>
						<th><?php echo _LANG('a2047','mediaset')?></th>
						<th><?php echo _LANG('a2048','mediaset')?></th>
						<th><?php echo _LANG('a2049','mediaset')?></th>
					</tr>
				</thead>
				<tbody>

				<?php $_i=0;while($R=db_fetch_array($RCD)):?>
				<?php $file_ext=$R['ext']?>

				<tr>
					<td><input type="checkbox" name="upfile_members[]" value="<?php echo $R['uid']?>" class="rb-file-user" onclick="checkboxCheck();"></td>
					<td>
						<?php echo $NUM-((($p-1)*$recnum)+$_rec++)?>
					</td>
					<td class="rb-left">
						<i class="fa fa-file-image-o fa-fw" data-tooltip="tooltip" title="<?php echo $file_ext?>"></i>
						<a href="<?php echo getMediaLink($R,1)?>" target="_blank" data-trigger="hover" data-popover="popover" data-content="<?php echo $R['caption']?strip_tags($R['caption']):_LANG('a2050','mediaset')?>" title="<?php echo $R['name']?>"><?php echo $R['name']?></a>
					</td>
					<?php if($R['mbruid']):?>
					<?php $M=getDbData($table['s_mbrdata'],'memberuid='.$R['mbruid'],'memberuid,name,nic')?>
					<td><a href="#." id='_rb-popover-<?php echo $_i?>' data-placement="auto" data-popover="popover" data-content="<div id='rb-popover-<?php echo $_i?>'><script>getPopover('member','<?php echo $M['memberuid']?>','rb-popover-<?php echo $_i?>')</script></div>"><?php echo $M[$_HS['nametype']]?></a></td>
					<?php else:?>
					<td><?php echo _LANG('a2051','mediaset')?></td>
					<?php endif?>
					<td><?php echo getDomain($R['url'])?></td>
					<td><?php echo $R['folder']?></td>
					<td><?php echo $R['size']?getSizeFormat($R['size'],1):''?></td>
					<td>
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=download&amp;uid=<?php echo $R['uid']?>" target="_action_frame_<?php echo $m?>" title="<?php echo _LANG('a2052','mediaset')?>" data-tooltip="tooltip">
						<?php echo $R['size']?$R['down']:''?>
						</a>
					</td>
					<td class="rb-update">
						<time class="timeago" data-toggle="tooltip" datetime="<?php echo getDateFormat($R['d_regis'],'c')?>" data-tooltip="tooltip" title="<?php echo getDateFormat($R['d_regis'],$lang['mediaset']['a2053'])?>"></time>	
					</td>
				</tr> 
				<?php $_i++;endwhile?> 
				</tbody>
			</table>
		</div>

		<?php if(!$NUM):?>
		<div class="rb-none"><?php echo _LANG('a2054','mediaset')?></div>
		<?php endif?>

		<div class="rb-footer clearfix">
			<div class="pull-right">
				<ul class="pagination">
				<script>getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
				<?php //echo getPageLink(5,$p,$TPG,'')?>
				</ul>
			</div>	

			<div>
				<button type="button" onclick="chkFlag('upfile_members[]');checkboxCheck();" class="btn btn-default btn-sm"><?php echo _LANG('a2055','mediaset')?></button>
				<button type="button" onclick="actCheck('multi_delete');" class="btn btn-default btn-sm" id="rb-action-btn" disabled><?php echo _LANG('a2056','mediaset')?></button>
			</div>
		</div>
	</form>

</div>

<!-- bootstrap-datepicker,  http://eternicode.github.io/bootstrap-datepicker/  -->
<?php getImport('bootstrap-datepicker','css/datepicker3',false,'css')?>
<?php getImport('bootstrap-datepicker','js/bootstrap-datepicker',false,'js')?>
<?php getImport('bootstrap-datepicker','js/locales/bootstrap-datepicker.kr',false,'js')?>
<style type="text/css">
.datepicker {z-index: 1151 !important;}
</style>
<script>
$('.input-daterange').datepicker({
	format: "yyyy/mm/dd",
	todayBtn: "linked",
	language: "kr",
	calendarWeeks: true,
	todayHighlight: true,
	autoclose: true
});
</script>

<!-- timeago -->
<?php getImport('jquery-timeago','jquery.timeago',false,'js')?>
<?php getImport('jquery-timeago','locales/jquery.timeago.'.$lang['mediaset']['a2057'],false,'js')?>
<script>
jQuery(document).ready(function() {
	$(".rb-update time").timeago();
});
</script>

<!-- basic -->
<script>
$(".checkAll-file-user").click(function(){
	$(".rb-file-user").prop("checked",$(".checkAll-file-user").prop("checked"));
	checkboxCheck();
});
function checkboxCheck()
{
	var f = document.listForm;
    var l = document.getElementsByName('upfile_members[]');
    var n = l.length;
    var i;
	var j=0;

	for	(i = 0; i < n; i++)
	{
		if (l[i].checked == true) j++;
	}
	if (j) getId('rb-action-btn').disabled = false;
	else getId('rb-action-btn').disabled = true;
}
function memberSelect(uid)
{
	var f = document.procForm;
	f.where.value = 'mbruid';
	f.keyw.value = uid;
	f.submit();
}
function dropDate(date1,date2)
{
	var f = document.procForm;
	f.d_start.value = date1;
	f.d_finish.value = date2;
	f.submit();
}
function actCheck(act)
{
	var f = document.listForm;
    var l = document.getElementsByName('upfile_members[]');
    var n = l.length;
	var j = 0;
    var i;

    for (i = 0; i < n; i++)
	{
		if(l[i].checked == true)
		{
			j++;
		}
	}
	if (!j)
	{
		alert('<?php echo _LANG('a2058','mediaset')?>      ');
		return false;
	}
	if (act == 'multi_delete')
	{
		if (confirm('<?php echo _LANG('a2059','mediaset')?>        '))
		{
			getIframeForAction(f);
			f.a.value = act;
			f.submit();
		}
	}

	return false;
}
</script>


