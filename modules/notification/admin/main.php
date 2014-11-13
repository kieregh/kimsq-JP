<?php
$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 301 ? $recnum : 30;
$sqlque	= 'uid';

if ($siteuid) $sqlque .= ' and site='.$siteuid;
if ($moduleid) $sqlque .= " and frommodule='".$moduleid."'";
if ($isread)
{
	if ($isread == 1) $sqlque .= " and d_read<>''";
	else $sqlque .= " and d_read=''";
}
if ($where && $keyw)
{
	$sqlque .= getSearchSql($where,$keyw,$ikeyword,'or');	
}

$RCD = getDbArray($table['s_notice'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_notice'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);
?>


<div id="notification">

	<div class="page-header">
		<h4><?php echo _LANG('','a2001','notification')?></h4>
	</div>

	<form name="procForm" action="<?php echo $g['s']?>/" method="get" class="form-horizontal">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $m?>">
		<input type="hidden" name="module" value="<?php echo $module?>">
		<input type="hidden" name="front" value="<?php echo $front?>">

		<div class="rb-heading well well-sm">

			<div class="form-group">
				<label class="col-sm-1 control-label"><?php echo _LANG('a2002','notification')?></label>
				<div class="col-sm-10">
					<div class="row">
						<div class="col-sm-4">
							<select name="siteuid" class="form-control input-sm" onchange="this.form.submit();">
							<option value=""><?php echo _LANG('a2003','notification')?></option>
							<?php $SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p)?>
							<?php while($S = db_fetch_array($SITES)):?>
							<option value="<?php echo $S['uid']?>"<?php if($S['uid']==$siteuid):?> selected<?php endif?>><?php echo $S['name']?> (<?php echo $S['id']?>)</option>
							<?php endwhile?>
							</select>
						</div>
						<div class="col-sm-4">
							<select name="moduleid" class="form-control input-sm" onchange="this.form.submit();">
							<option value=""><?php echo _LANG('a2004','notification')?></option>
							<?php $MODULES = getDbArray($table['s_module'],'','*','gid','asc',0,$p)?>
							<?php while($MD = db_fetch_array($MODULES)):?>
							<option value="<?php echo $MD['id']?>"<?php if($MD['id']==$moduleid):?> selected<?php endif?>><?php echo $MD['name']?> (<?php echo $MD['id']?>)</option>
							<?php endwhile?>
							</select>
						</div>
						<div class="col-sm-4">
							<select name="isread" class="form-control input-sm" onchange="this.form.submit();">
							<option value=""><?php echo _LANG('a2005','notification')?></option>
							<option value="1"<?php if($isread==1):?> selected<?php endif?>><?php echo _LANG('a2006','notification')?></option>
							<option value="2"<?php if($isread==2):?> selected<?php endif?>><?php echo _LANG('a2007','notification')?></option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div id="search-more" class="collapse<?php if($_SESSION['sh_noti']):?> in<?php endif?>">
				<div class="form-group">
					<label class="col-sm-1 control-label"><?php echo _LANG('a2008','notification')?></label>
					<div class="col-sm-10">

						<div class="btn-toolbar">
							<div class="btn-group btn-group-sm" data-toggle="buttons">
								<label class="btn btn-default<?php if($sort=='uid'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="uid" name="sort"<?php if($sort=='uid'):?> checked<?php endif?>> <?php echo _LANG('a2009','notification')?>
								</label>
								<label class="btn btn-default<?php if($sort=='d_read'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="d_read" name="sort"<?php if($sort=='d_read'):?> checked<?php endif?>> <?php echo _LANG('a2010','notification')?>
								</label>
							</div>

							<div class="btn-group btn-group-sm" data-toggle="buttons">
								<label class="btn btn-default<?php if($orderby=='desc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="desc" name="orderby"<?php if($orderby=='desc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-desc"></i> <?php echo _LANG('a2011','notification')?>
								</label>
								<label class="btn btn-default<?php if($orderby=='asc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="asc" name="orderby"<?php if($orderby=='asc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-asc"></i> <?php echo _LANG('a2012','notification')?>
								</label>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-1 control-label"><?php echo _LANG('a2013','notification')?></label>
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-btn hidden-xs" style="width: 120px">
								<select name="where" class="form-control btn btn-default">
									<option value="message"<?php if($where=='message'):?> selected="selected"<?php endif?>><?php echo _LANG('a2014','notification')?></option>
									<option value="referer"<?php if($where=='referer'):?> selected="selected"<?php endif?>>URL</option>
								</select>
							</span>
							<input type="text" name="keyw" value="<?php echo stripslashes($keyw)?>" class="form-control">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><?php echo _LANG('a2015','notification')?></button>
							</span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-1 control-label"><?php echo _LANG('a2016','notification')?></label>
					<div class="col-sm-3">
						<select name="recnum" onchange="this.form.submit();" class="form-control">
							<?php for($i=30;$i<=300;$i=$i+30):?>
							<option value="<?php echo $i?>"<?php if($i==$recnum):?> selected="selected"<?php endif?>><?php echo sprintf(_LANG('a2017','notification'),$i)?></option>
							<?php endfor?>
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-10">
					<button type="button" class="btn btn-link rb-advance<?php if(!$_SESSION['sh_noti']):?> collapsed<?php endif?>" data-toggle="collapse" data-target="#search-more" onclick="sessionSetting('sh_noti','1','','1');"><?php echo _LANG('a2018','notification')?> <small></small></button>
					<a href="<?php echo $g['adm_href']?>" class="btn btn-link"><?php echo _LANG('a2019','notification')?></a>
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=notice_testonly" onclick="return hrefCheck(this,true,'<?php echo _LANG('a2020','notification')?>     ');" class="btn btn-link"><?php echo _LANG('a2021','notification')?></a>
					<a href="#." class="btn btn-link rb-notifications-modal" role="button" data-toggle="modal" data-target="#modal_window"><?php echo _LANG('a2022','notification')?></a>
				</div>
			</div>

		</div>
	</form>

	<form name="listForm" action="<?php echo $g['s']?>/" method="post">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="">

		<div class="table-responsive">
			<table class="table table-striped">
				<tr>
					<th><label data-tooltip="tooltip" title="<?php echo _LANG('a2023','notification')?>"><input type="checkbox" class="checkAll-noti-user"></label></th>
					<th><?php echo _LANG('a2023','notification')?></th>
					<th><?php echo _LANG('a2024','notification')?></th>
					<th><?php echo _LANG('a2025','notification')?></th>
					<th class="rb-message"><?php echo _LANG('a2026','notification')?></th>
					<th><?php echo _LANG('a2027','notification')?></th>
					<th><?php echo _LANG('a2028','notification')?></th>
					<th><?php echo _LANG('a2029','notification')?></th>
				</tr>
				<?php $_i=0;while($R=db_fetch_array($RCD)):?>
				<?php $SM1=$R['mbruid']?getDbData($table['s_mbrdata'],'memberuid='.$R['mbruid'],'name,nic'):array()?>
				<?php $SM2=$R['frommbr']?getDbData($table['s_mbrdata'],'memberuid='.$R['frommbr'],'name,nic'):array()?>
				<tr>
					<td><input type="checkbox" name="noti_members[]" value="<?php echo $R['uid']?>" class="rb-noti-user" onclick="checkboxCheck();"></td>
					<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
					<td>
						<?php if($SM2['name']):?>
						<a href="#." id='_rb-popover-from-<?php echo $_i?>' data-placement="auto" data-popover="popover" data-content="<div id='rb-popover-from-<?php echo $_i?>'><script>getPopover('member','<?php echo $R['frommbr']?>','rb-popover-from-<?php echo $_i?>')</script></div>"><?php echo $SM2['name']?></a>
						<?php else:?>
						<?php echo _LANG('a2030','notification')?>
						<?php endif?>
					</td>
					<td>
						<a href="#." id='_rb-popover-to-<?php echo $_i?>' data-placement="auto" data-popover="popover" data-content="<div id='rb-popover-to-<?php echo $_i?>'><script>getPopover('member','<?php echo $R['mbruid']?>','rb-popover-to-<?php echo $_i?>')</script></div>"><?php echo $SM1['name']?></a>
					</td>
					<td class="rb-message">
						<?php echo $R['message']?>
					</td>
					<td>
						<?php if($R['referer']):?>
						<a href="<?php echo $R['referer']?>" target="<?php echo $R['target']?>"><?php echo _LANG('a2031','notification')?></a>
						<?php else:?>
						<span class="rb-none"><?php echo _LANG('a2032','notification')?></span>
						<?php endif?>
					</td>
					<td class="rb-update">
						<time class="timeago" data-toggle="tooltip" datetime="<?php echo getDateFormat($R['d_regis'],'c')?>" data-tooltip="tooltip" title="<?php echo getDateFormat($R['d_regis'],$lang['notification']['a2040'])?>"></time>	
					</td>
					<td class="rb-update">
						<?php if($R['d_read']):?>
						<time class="timeago" data-toggle="tooltip" datetime="<?php echo getDateFormat($R['d_read'],'c')?>" data-tooltip="tooltip" title="<?php echo getDateFormat($R['d_read'],$lang['notification']['a2040'])?>"></time>	
						<?php else:?>
						<span class="label label-primary"><?php echo _LANG('a2033','notification')?></span>
						<?php endif?>
					</td>
				</tr>
				<?php $_i++;endwhile?>
			</table>
		</div>

		<?php if(!$NUM):?>
		<div class="rb-none"><?php echo _LANG('a2034','notification')?></div>
		<?php endif?>

		<div class="rb-footer clearfix">
			<div class="pull-right">
				<ul class="pagination">
				<script>getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
				<?php //echo getPageLink(5,$p,$TPG,'')?>
				</ul>
			</div>	
			<div>
				<button type="button" onclick="chkFlag('noti_members[]');checkboxCheck();" class="btn btn-default btn-sm"><?php echo _LANG('a2035','notification')?></button>
				<button type="button" onclick="actCheck('multi_delete');" class="btn btn-default btn-sm" id="rb-action-btn" disabled><?php echo _LANG('a2036','notification')?></button>
			</div>
		</div>
	</form>

</div>

<!-- timeago -->
<?php getImport('jquery-timeago','jquery.timeago',false,'js')?>
<?php getImport('jquery-timeago','locales/jquery.timeago.'.$lang['notification']['a2039'],false,'js')?>
<script>
jQuery(document).ready(function() {
	$(".rb-update time").timeago();
});
</script>

<!-- basic -->
<script>
$(".checkAll-noti-user").click(function(){
	$(".rb-noti-user").prop("checked",$(".checkAll-noti-user").prop("checked"));
	checkboxCheck();
});
function checkboxCheck()
{
	var f = document.listForm;
    var l = document.getElementsByName('noti_members[]');
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
function actCheck(act)
{
	var f = document.listForm;
    var l = document.getElementsByName('noti_members[]');
    var n = l.length;
	var j = 0;
    var i;
	var s = '';

    for (i = 0; i < n; i++)
	{
		if(l[i].checked == true)
		{
			j++;
			s += '['+l[i].value+']';
		}
	}
	if (!j)
	{
		alert('<?php echo _LANG('a2037','notification')?>      ');
		return false;
	}
	
	if (act == 'multi_delete')
	{
		if(confirm('<?php echo _LANG('a2038','notification')?>    '))
		{
			getIframeForAction(f);
			f.a.value = act;
			f.submit();
		}
	}
	return false;
}
</script>

