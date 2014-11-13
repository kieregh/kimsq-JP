<?php
if (!$my['uid']) exit;

include $g['dir_module'].'function.php';

$S = 0;
$N = 0;
$P = array();

if ($dfiles)
{
	$ufilesArray = getArrayString($dfiles);
	foreach($ufilesArray['data'] as $_val)
	{
		$R = getUidData($table['s_upload'],$_val);
		if ($R['mbruid'] != $my['uid'] || ($R['type']!=0 && $R['type']!=5)) continue;
		$P[] = $R;
		$S += $R['size'];
		$N++;
	}
	$NUM = $N;
	$TPG = 1;
}
else {
	$sort	= $sort ? $sort : 'pid';
	$orderby= $orderby ? $orderby : 'asc';
	$recnum	= 50;

	$_WHERE = 'mbruid='.$my['uid'].' and (type=0 or type=5) and fileonly=0';
	if ($album)
	{
		$_album = $album;
		if ($album == 'none') $_album = 0;
		if ($album == 'trash') $_album = -1;
		$_WHERE .= ' and category='.$_album;
	}
	if ($where && $keyw)
	{
		if (strstr('[mbruid]',$where)) $_WHERE .= " and ".$where."='".$keyw."'";
		else $_WHERE .= getSearchSql($where,$keyw,$ikeyword,'or');	
	}
	$RCD = getDbArray($table['s_upload'],$_WHERE,'*',$sort,$orderby,$recnum,$p);
	$NUM = getDbRows($table['s_upload'],$_WHERE);
	$TPG = getTotalPage($NUM,$recnum);

	while($R = db_fetch_array($RCD))
	{
		$P[] = $R;
		$S += $R['size'];
		$N++;
	}
}
if ($tab == 'file_info')
{
	if (!$file_uid)
	{
		$file_uid = $P[0]['uid'];
		$_R = $P[0];
	}
	else {
		$_R = getUidData($table['s_upload'],$file_uid);
	}
}
$g['base_href'] = $g['s'].'/?r='.$r.'&m='.$m.'&iframe=Y&mdfile='.$mdfile.'&dropfield='.$dropfield.'&dropfiles='.$dropfiles.'&dfiles='.$dfiles;
?>

<?php getImport('bootstrap-select','bootstrap-select',false,'css')?>
<?php getImport('bootstrap-select','bootstrap-select',false,'js')?>

<form name="_upload_form_" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_upload_iframe_">
<input type="hidden" name="r" value="<?php echo $r?>">
<input type="hidden" name="m" value="<?php echo $m?>">
<input type="hidden" name="a" value="upload_vod">
<input type="hidden" name="saveDir" value="<?php echo $g['path_file']?>">
<input type="hidden" name="gparam" value="<?php echo $gparam?>">
<input type="hidden" name="category" value="<?php echo $_album?>">
<input type="hidden" name="mediaset" value="Y">
<input type="hidden" name="ablum_type" value="2">
<input name="upfiles[]" type="file" accept="video/mp4" id="filefiled" class="hidden" onchange="getFiles();">
</form>
<iframe name="_upload_iframe_" width="1" height="1" frameborder="0" scrolling="no"></iframe>

<div id="photobox">
	
	<div class="category-box">

		<div class="list-group rb-list-group">
			<a href="<?php echo $g['base_href']?>" class="list-group-item<?php if(!$album):?> active<?php endif?>"><?php echo _LANG('m2000','mediaset')?><span class="badge"><?php echo getDbCnt($table['s_uploadcat'],'sum(r_num)','mbruid='.$my['uid'].' and type=2')?></span></a>
			<a href="<?php echo $g['base_href']?>&album=none" class="list-group-item<?php if($album=='none'):?> active<?php endif?>"><?php echo _LANG('m0001','mediaset')?><span class="badge"><?php echo getDbCnt($table['s_uploadcat'],'sum(r_num)','mbruid='.$my['uid']." and type=2 and name='none'")?></span></a>
			
			<?php $_TMP_CT = array()?>
			<?php $_CT_RCD = getDbArray($table['s_uploadcat'],'mbruid='.$my['uid']." and type=2 and name<>'none' and name<>'trash'",'*','gid','asc',0,1)?>
			<?php while($_CT=db_fetch_array($_CT_RCD)):$_TMP_CT[]=$_CT?>
			<a href="<?php echo $g['base_href']?>&album=<?php echo $_CT['uid']?>" class="list-group-item<?php if($album==$_CT['uid']):?> active<?php endif?>"><?php echo $_CT['name']?><span class="badge"><?php echo $_CT['r_num']?></span></a></li>
			<?php endwhile?>

			<a href="<?php echo $g['base_href']?>&album=trash" class="list-group-item<?php if($album=='trash'):?> active<?php endif?>"><?php echo _LANG('m0002','mediaset')?><span class="badge"><?php echo getDbCnt($table['s_uploadcat'],'sum(r_num)','mbruid='.$my['uid']." and type=2 and name='trash'")?></span></a>
		</div>
		<div class="list-group">
			<form action="<?php echo $g['s']?>/" method="post" target="_upload_iframe_" onsubmit="return AddAlbumRcheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $m?>">
			<input type="hidden" name="a" value="category_add">
			<input type="hidden" name="ablum_type" value="2">
			<div class="input-group">
				<input type="text" name="name" class="form-control" placeholder="<?php echo _LANG('m0003','mediaset')?>">
				<span class="input-group-btn">
				<input type="submit" class="btn btn-default" value="<?php echo _LANG('m0004','mediaset')?>">
				</span>
			</div>
			</form>
		</div>
	</div>

	<div class="photo-box">
		<div id="progressBar" class="progress progress-striped active">
		  <div id="progressPer" class="progress-bar progress-bar-danger" role="progressbar"></div>
		</div>

		<?php if($NUM):?>
		<?php if(!$dfiles):?>
		<div class="btn-toolbar well well-sm">
			<div class="btn-group">
				<button type="button" class="btn btn-default" title="<?php echo _LANG('m0005','mediaset')?>" data-tooltip="tooltip" onclick="elementsCheck('photomembers[]','true');"><i class="fa fa-check-square-o fa-lg"></i></button>
				<button type="button" class="btn btn-default" title="<?php echo _LANG('m0006','mediaset')?>" data-tooltip="tooltip" onclick="elementsCheck('photomembers[]','false');"><i class="fa fa-minus-square-o fa-lg"></i></button>
				<button type="button" class="btn btn-default" title="<?php echo _LANG('m0002','mediaset')?>" data-tooltip="tooltip" onclick="deleteCheck(1,'');"><i class="fa fa-trash-o fa-lg"></i></button>

				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-folder fa-lg"></i> <?php echo _LANG('m0007','mediaset')?>
					<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
					<li><a href="#." onclick="deleteCheck('move','0');"><i class="fa fa-folder"></i> <?php echo _LANG('m0001','mediaset')?></a></li>
					<?php foreach($_TMP_CT as $_CT):?>
					<li><a href="#." onclick="deleteCheck('move','<?php echo $_CT['uid']?>');"><i class="fa fa-folder"></i> <?php echo $_CT['name']?></a></li>
					<?php endforeach?>
					<li class="divider"></li>
					<li><a href="#." onclick="deleteCheck('delete','');"><i class="fa fa-times fa-lg"></i> <?php echo _LANG('m0008','mediaset')?></a></li>
					</ul>
				</div>
			</div>

			<div class="btn-group pull-right">
				<button type="button" class="btn btn-default"<?php if($p-1<1):?> disabled="disabled"<?php endif?> data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo _LANG('m0030','mediaset')?>" onclick="location.href=getPageGo(<?php echo $p-1?>,0);"><i class="fa fa-chevron-left fa-lg"></i></button>
				<button type="button" class="btn btn-default"<?php if($p+1>$TPG):?> disabled="disabled"<?php endif?> data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo _LANG('m0031','mediaset')?>" onclick="location.href=getPageGo(<?php echo $p+1?>,0);"><i class="fa fa-chevron-right fa-lg"></i></button>
			</div>

			<div class="btn-group pull-right">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php echo number_format($NUM)?><?php echo _LANG('m0012','mediaset')?> (<?php echo $p?>/<?php echo sprintf(_LANG('m0011','mediaset'),$TPG)?>)</button>
				<ul class="dropdown-menu" role="menu">
				<li<?php if($p==1):?> class="active"<?php endif?>><a href="#." onclick="location.href=getPageGo(1,0);"><?php echo _LANG('m0009','mediaset')?></a></li>
				<?php for($i=2;$i<$TPG;$i++):?>
				<li<?php if($p==$i):?> class="active"<?php endif?>><a href="#." onclick="location.href=getPageGo(<?php echo $i?>,0);"><?php echo sprintf(_LANG('m0011','mediaset'),$i)?></a></li>
				<?php endfor?>
				<?php if($TPG>1):?>
				<li<?php if($p==$TPG):?> class="active"<?php endif?>><a href="#." onclick="location.href=getPageGo(<?php echo $TPG?>,0);"><?php echo _LANG('m0010','mediaset')?></a></li>
				<?php else:?>
				<li class="disabled"><a><?php echo _LANG('m0010','mediaset')?></a></li>
				<?php endif?>
				</ul>
			</div> 
		</div>
		<?php endif?>

		<form name="photolistForm" action="<?php echo $g['s']?>/" method="post" target="_upload_iframe_">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $m?>">
		<input type="hidden" name="a" value="">
		<input type="hidden" name="mediaset" value="Y">
		<input type="hidden" name="dtype" value="">
		<input type="hidden" name="mcat" value="">

		<ul id="photoorder">
			<?php foreach($P as $val):?>
			<li<?php if($file_uid==$val['uid']):?> class="selected"<?php endif?> ondblclick="location.href='<?php echo $g['base_href']?>&file_uid=<?php echo $val['uid']?>&tab=file_info&album=<?php echo $album?>';">
				<input type="checkbox" class="rb-photo-check" name="photomembers[]" value="<?php echo $val['uid']?>|<?php echo $val['xurl'].$val['folder'].'/'.$val['tmpname']?>|<?php echo $val['name']?>|" onclick="photoCheck(<?php echo $val['uid']?>);"<?php if($dfiles):?> checked<?php endif?>>
				<span id="caption_<?php echo $val['uid']?>" class="hidden"><?php echo htmlspecialchars($val['caption'])?></span>
				<?php if($val['type']):?>
				<div id="vod_<?php echo $val['uid']?>" class="photo"><video src="<?php echo $val['url'].$val['folder'].'/'.$val['tmpname']?>" width="100%" height="100%"></video></div>
				<span id="vodsrc_<?php echo $val['uid']?>" class="hidden"><iframe src="<?php echo $g['url_root'].'/_core/opensrc/thumb/image.php?vod='.$val['url'].$val['folder'].'/'.$val['tmpname']?>" width="350" height="250" frameborder="0" scrolling="no"></iframe></span>
				<?php else:?>
				<div id="vod_<?php echo $val['uid']?>" class="photo" style="background:url('<?php echo getVodThumb($val['src'],'mqdefault')?>') center center no-repeat;"></div>
				<span id="vodsrc_<?php echo $val['uid']?>" class="hidden"><iframe width="350" height="250" src="http://www.youtube.com/embed/<?php echo getVodCode($val['src'])?>/?autohide=1&rel=0&wmode=transparent" frameborder="0" allowfullscreen></iframe></span>
				<?php endif?>

				<div class="btn-group">
					<button class="btn btn-default" type="button" title="<?php echo _LANG('m0013','mediaset')?>:<?php if($val['type']>0):?><?php echo _LANG('m2001','mediaset')?><?php else:?><?php echo _LANG('m2002','mediaset')?><?php endif?>" data-tooltip="tooltip">
					<i class="<?php if($val['type']>0):?>glyphicon glyphicon-cloud-upload<?php else:?>fa fa-link<?php endif?> fa-lg"></i>
					</button>

					<button class="btn btn-default" type="button" title="<?php echo _LANG('m0014','mediaset')?>" onclick="location.href='<?php echo $g['s']?>/?r=<?php echo $g['base_href']?>&file_uid=<?php echo $val['uid']?>&tab=file_info&album=<?php echo $album?>';">
					<i class="fa fa-edit fa-lg"></i>
					</button>

					<button class="btn btn-default" type="button" title="<?php echo _LANG('m0015','mediaset')?>" onclick="location.href='<?php echo $g['s']?>/?r=<?php echo $g['base_href']?>&file_uid=<?php echo $val['uid']?>&tab=file_info&autoplay=Y&album=<?php echo $album?>';">
					<i class="glyphicon glyphicon-play-circle fa-lg"></i>
					</button>

					<button class="btn btn-default" type="button" title="<?php echo _LANG('m0016','mediaset')?>" onclick="deleteCheck(0,<?php echo $val['uid']?>);">
					<i class="fa fa-trash-o fa-lg"></i>
					</button>
				</div>
			</li>
			<?php endforeach?>
		</ul>
		</form>
		
		<?php else:?>
		<div class="alert alert-success">
		<span class="glyphicon glyphicon-info-sign"></span>
		<?php echo _LANG('m2003','mediaset')?>
		</div>
		<?php endif?>
	</div>
</div>

<?php if((($file_uid || $dropfield=='editor') && $NUM) || $outlink == 'Y'):$_sideOpen=true?>
<div id="infobox">
	<?php if($outlink=='Y'):?>
	<ul class="nav nav-tabs">
		<li class="active"><a href="#"><?php echo _LANG('m2004','mediaset')?></a></li>
	</ul>
	<div class="infobox-body">
		<div class="pic-info1">
			<div id="_vod_play_layer_" class="media-pic">
				
			</div>

			<form name="_upload_form1_" action="<?php echo $g['s']?>/" method="post" target="_upload_iframe_">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $m?>">
			<input type="hidden" name="a" value="upload_vod">
			<input type="hidden" name="gparam" value="<?php echo $gparam?>">
			<input type="hidden" name="category" value="<?php echo $_album?>">
			<input type="hidden" name="mediaset" value="Y">
			<input type="hidden" name="link" value="Y">

			<div class="panel-body">
				<div class="form-group">
					<label><?php echo _LANG('m2005','mediaset')?></label>
					<textarea name="src" id="_vod_embed_code_" class="form-control" rows="4"><?php echo $_R['src']?></textarea>
				</div>
			</div>
			</form>
		</div>
		<div class="pic-submit1">
			<div class="text-center">
				<button type="button" class="btn btn-default" onclick="getVodPreview();" style="margin-bottom:3px;"><?php echo _LANG('m2006','mediaset')?></button>
				<button type="button" class="btn btn-primary" onclick="getVodSave();"><?php echo _LANG('m2007','mediaset')?></button>
			</div>
		</div>
	</div>

	<?php else:?>

	<ul class="nav nav-tabs">
		<?php if($dropfield=='editor'):?>
		<li<?php if($file_uid):?> class="active"<?php endif?>><a href="<?php echo $g['base_href']?>&file_uid=<?php echo $file_uid?>&tab=file_info&album=<?php echo $album?>"><?php echo _LANG('m2008','mediaset')?></a></li>
		<li<?php if(!$file_uid):?> class="active"<?php endif?>><a href="<?php echo $g['base_href']?>&album=<?php echo $album?>"><?php echo _LANG('m0017','mediaset')?></a></li>
		<?php else:?>
		<li<?php if($file_uid):?> class="active"<?php endif?>><a href="<?php echo $g['base_href']?>&file_uid=<?php echo $file_uid?>&tab=file_info&album=<?php echo $album?>"><?php echo _LANG('m2008','mediaset')?></a></li>
		<?php endif?>
	</ul>

	<?php if($tab == 'file_info'):?>
	<?php $_videoSrc=getVodCode($_R['src'])?>
	<div class="infobox-body">
		<div class="pic-info">
			<div id="_vod_play_layer_" class="media-pic">
			<?php if($autoplay=='Y'):?>
				<?php if(!$_R['type']):?>
				<iframe width="90%" src="http://www.youtube.com/embed/<?php echo $_videoSrc?>/?autoplay=1&autohide=1&rel=0&wmode=transparent" frameborder="0" allowfullscreen style="margin:15px;"></iframe>
				<?php else:?>
				<video src="<?php echo $_R['url'].$_R['folder'].'/'.$_R['tmpname']?>" width="90%" controls autoplay preload="auto" style="margin:15px;"></video>
				<?php endif?>
			<?php else:?>
				<?php if(!$_R['type']):?>
				<iframe width="90%" src="http://www.youtube.com/embed/<?php echo $_videoSrc?>/?autoplay=0&autohide=0&rel=0&wmode=transparent" frameborder="0" allowfullscreen style="margin:15px;"></iframe>
				<?php else:?>
				<video src="<?php echo $_R['url'].$_R['folder'].'/'.$_R['tmpname']?>" width="90%" controls preload="auto" style="margin:15px;"></video>
				<?php endif?>
			<?php endif?>
			</div>

			<form name="captionForm" action="<?php echo $g['s']?>/" method="post" target="_upload_iframe_">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $m?>">
			<input type="hidden" name="a" value="caption_regis_vod">
			<input type="hidden" name="uid" value="<?php echo $_R['uid']?>">
			<div class="panel-body">

				<div class="form-group">
					<label>Video Name</label>
					<input type="text" class="form-control" name="name" value="<?php echo $_R['name']?>">
				</div>
				<div class="form-group">
					<label>Alt Text</label>
					<input type="text" class="form-control" name="alt" value="<?php echo $_R['alt']?>">
				</div>
				<div class="form-group">
					<label>Caption</label>
					<textarea class="form-control" name="caption" rows="3"><?php echo $_R['caption']?></textarea>
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea class="form-control" name="description" rows="3"><?php echo $_R['description']?></textarea>
				</div>
				<?php if(!$_R['type']):?>
				<div class="form-group">
					<label><?php echo _LANG('m2005','mediaset')?></label>
					<textarea name="src" id="_vod_embed_code_" class="form-control" rows="4"><?php echo $_R['src']?></textarea>
				</div>
				<?php endif?>
				<div class="form-group">
					<label class="control-label">License</label>
					<select name="license" class="selectpicker show-tick show-menu-arrow scrollMe" data-width="100%" data-style="btn btn-default" data-size="auto">
						<option value="0"<?php if($_R['license']==0):?> selected<?php endif?>><?php echo _LANG('m0036','mediaset')?></option>
						<option value="1"<?php if($_R['license']==1):?> selected<?php endif?>><?php echo _LANG('m0037','mediaset')?></option>
						<option value="2"<?php if($_R['license']==2):?> selected<?php endif?>><?php echo _LANG('m0038','mediaset')?></option>
						<option value="3"<?php if($_R['license']==3):?> selected<?php endif?>><?php echo _LANG('m0039','mediaset')?></option>
						<option value="4"<?php if($_R['license']==4):?> selected<?php endif?>><?php echo _LANG('m0040','mediaset')?></option>
						<option value="5"<?php if($_R['license']==5):?> selected<?php endif?>><?php echo _LANG('m0041','mediaset')?></option>
						<option value="6"<?php if($_R['license']==6):?> selected<?php endif?>><?php echo _LANG('m0042','mediaset')?></option>
					</select>
				</div>
			</div>
			</form>
		</div>
		<div class="pic-submit">
			<div class="text-center">
				<button type="button" class="btn btn-primary" onclick="infoCheck();"><?php echo _LANG('m0018','mediaset')?></button>
			</div>
		</div>
	</div>
	<?php else:?>
	<div class="layoutbox-body">
		
		<div class="selectbox">
			<select class="selectpicker show-tick show-menu-arrow scrollMe" data-width="100%" data-style="btn btn-default" data-size="auto" onchange="frames._template_iframe_.location.href='<?php echo $g['url_module']?>/modal/template/'+this.value;">
			<option value="video-base.html"><?php echo _LANG('m0033','mediaset')?></option>
			<option data-divider="true"></option>
			<?php $tdir = $g['dir_module'].'modal/template/'?>
			<?php $dirs = opendir($tdir)?>
			<?php while(false !== ($skin = readdir($dirs))):?>
			<?php if(!strstr($skin,'.html') || !strstr($skin,'video-') || $skin == 'video-base.html')continue?>
			<option value="<?php echo $skin?>"><?php echo $skin?></option>
			<?php endwhile?>
			<?php closedir($dirs)?>
			</select>
		</div>

		<div class="iframebox">
			<iframe name="_template_iframe_" src="<?php echo $g['dir_module']?>/modal/template/video-base.html" width="100%" height="100%" frameborder="0"></iframe>
		</div>
		
		<div class="optionbox">
			<div class="text-center">
				<button type="button" class="btn btn-primary" onclick="templateCheck();"><?php echo _LANG('m0017','mediaset')?></button>
			</div>
		</div>

	<?php endif?>
	<?php endif?>
	</div>
</div>
<?php endif?>


<!----------------------------------------------------------------------------
@부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->

<div id="_modal_header" class="hidden">
    <button type="button" class="close rb-close-white" style="position:absolute;right:15px;z-index:1;" data-dismiss="modal" aria-hidden="true">&times;</button>

	<ul class="nav nav-tabs" style="position:relative;left:5px;margin-bottom:-20px;z-index:0;">
		<?php if(!$dfiles && !$dropfield):?>
		<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&iframe=Y&mdfile=modal.photo.media&dropfield=<?php echo $dropfield?>&dropfiles=<?php echo $dropfiles?>" target="_modal_iframe_modal_window"><?php echo _LANG('m0034','mediaset')?></a></li>
		<?php endif?>
		<li class="active"><a href="#"><?php echo _LANG('m0035','mediaset')?></a></li>
	</ul>
</div>

<div id="_modal_footer" class="hidden">
	<button type="button" class="btn btn-primary pull-left" <?php if($album!='trash'):?>onclick="frames._modal_iframe_modal_window.getId('filefiled').click();"<?php else:?>disabled<?php endif?>><i class="fa fa-cloud-upload fa-lg"></i> <?php echo _LANG('m2009','mediaset')?></button>
	<button type="button" class="btn btn-primary pull-left" <?php if($album!='trash'):?>onclick="frames._modal_iframe_modal_window.vodAdd();"<?php else:?>disabled<?php endif?>><i class="fa fa-link fa-lg"></i> <?php echo _LANG('m2010','mediaset')?></button>

	<?php if($album>0):?>
	<button type="button" class="btn btn-default pull-left" onclick="frames._modal_iframe_modal_window.catDelete();"><?php echo _LANG('m0019','mediaset')?></button>
	<?php endif?>
	<?php if($NUM>1):?>
	<?php if($album>0):?>
	<button type="button" class="btn btn-default pull-left" onclick="frames._modal_iframe_modal_window.orderCheck();"><?php echo _LANG('m0020','mediaset')?></button>
	<?php endif?>
	<?php endif?>

	<?php if($NUM&&$album=='trash'):?>
	<button type="button" class="btn btn-default pull-left" onclick="frames._modal_iframe_modal_window.deleteCheck(3,'');"><?php echo _LANG('m0021','mediaset')?></button>
	<?php endif?>

	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" id="_modalclosebtn_"><?php echo _LANG('m0022','mediaset')?></button>
	<?php if($dropfield&&$dropfield!='editor'):?>
	<button type="button" class="btn btn-danger" onclick="frames._modal_iframe_modal_window.fieldDrop();"><?php echo _LANG('m0023','mediaset')?></button>
	<?php endif?>
</div>


<?php if($NUM>1&&$album>0):?>
<script src="<?php echo $g['s']?>/_core/opensrc/tool-man/core.js"></script>
<script src="<?php echo $g['s']?>/_core/opensrc/tool-man/events.js"></script>
<script src="<?php echo $g['s']?>/_core/opensrc/tool-man/css.js"></script>
<script src="<?php echo $g['s']?>/_core/opensrc/tool-man/coordinates.js"></script>
<script src="<?php echo $g['s']?>/_core/opensrc/tool-man/drag.js"></script>
<script src="<?php echo $g['s']?>/_core/opensrc/tool-man/dragsort.js"></script>
<script>
var dragsort = ToolMan.dragsort();
dragsort.makeListSortable(getId("photoorder"));
</script>
<?php endif?>


<script>
var isGetVod = false;
function getVodPreview()
{
	if (getId('_vod_embed_code_').value.indexOf('<iframe') == -1)
	{
		alert('<?php echo _LANG('m2011','mediaset')?>   ');
		getId('_vod_embed_code_').focus();
		return false;
	}
	var gx1 = getId('_vod_embed_code_').value.split('src="');
	var gx2 = gx1[1].split('"');

	getId('_vod_play_layer_').innerHTML = '<iframe width="90%" src="'+gx2[0]+'" frameborder="0" allowfullscreen style="margin:15px;"></iframe>';
	isGetVod = true;
}
function getVodSave()
{
	if (isGetVod == false)
	{
		alert('<?php echo _LANG('m2012','mediaset')?>   ');
		return false;
	}
	//if (confirm('<?php echo _LANG('m0032','mediaset')?>    '))
	//{
		var f = document._upload_form1_;
		f.submit();
	//}
	return false;
}
function vodAdd()
{
	location.href = '<?php echo $g['base_href']?>&outlink=Y&album=<?php echo $album?>';
}
function getFiles()
{
	for (var i = 0; i < parent.getId('_modal_footer_modal_window').children.length; i++)
	{
		parent.getId('_modal_footer_modal_window').children[i].disabled = true;
	}
	getId('progressBar').style.display = 'block';

	var f = document._upload_form_;
	f.submit();
}
function gridProgress()
{
	setTimeout("location.reload();",1000);
}
function fieldDrop()
{
	var f = document.photolistForm;
    var l = document.getElementsByName('photomembers[]');
    var n = l.length;
    var i;
	var j = 0;
	var s = '';
	var x;

	for (i = 0; i < n; i++)
	{
		if (l[i].checked == true)
		{
			j++;
			x = l[i].value.split('|');
			s += '['+x[0]+']';
		}
	}
	if (!j)
	{
		alert('<?php echo _LANG('m2013','mediaset')?>   ');
		return false;
	}
	parent.getId('<?php echo $dropfield?>').value <?php if(!$dfiles):?>+<?php endif?>= s;
	parent.$('#modal_window').modal('hide');
}
function AddAlbumRcheck(f)
{
	if (f.name.value == '')
	{
		alert('<?php echo _LANG('m0024','mediaset')?>   ');
		f.name.focus();
		return false;
	}
	return true;
}
function catDelete()
{
	if (confirm('<?php echo _LANG('m0025','mediaset')?>   '))
	{
		var f = document._upload_form_;	
		f.a.value = 'category_delete';
		f.submit();
	}
	return false;
}
function elementsCheck(members,flag)
{
    var l = document.getElementsByName(members);
    var n = l.length;
    var i;
    for (i = 0; i < n; i++)
	{
		if (flag == 'true')
		{
			l[i].checked = true;
		}
		else {
			l[i].checked = false;
		}
	}
	return false;
}
function deleteCheck(x,uid)
{
	var f = document.photolistForm;
    var l = document.getElementsByName('photomembers[]');
    var n = l.length;
    var i;
	var j = 0;

	if (x == 3)
	{
		if (confirm('<?php echo _LANG('m0026','mediaset')?>'))
		{
			f.a.value = 'files_empty_vod';
			f.submit();
		}
		return false;
	}

	for (i = 0; i < n; i++)
	{
		if (x == 0)
		{
			gx = l[i].value.split('|');
			if (uid != parseInt(gx[0])) l[i].checked = false;
			else l[i].checked = true;
		}
		if (x == 2) l[i].checked = true;
		if (l[i].checked == true)
		{
			j++;
		}
	}
	if (x == 'move')
	{
		if (!j)
		{
			alert('<?php echo _LANG('m2014','mediaset')?>');
			return false;
		}
		if (confirm('<?php echo _LANG('m0027','mediaset')?>'))
		{
			f.a.value = 'files_delete_vod';
			f.dtype.value = x;
			f.mcat.value = uid;
			f.submit();
		}
	}
	else if (x == 'delete')
	{
		if (!j)
		{
			alert('<?php echo _LANG('m2015','mediaset')?>');
			return false;
		}
		if (confirm('<?php echo _LANG('m0025','mediaset')?>'))
		{
			f.a.value = 'files_delete_vod';
			f.dtype.value = x;
			f.submit();
		}
	}
	else {

		if (!j)
		{
			alert('<?php echo _LANG('m2016','mediaset')?>');
			return false;
		}
		if (confirm('<?php echo _LANG('m0025','mediaset')?>'))
		{
			f.a.value = 'files_delete_vod';
			f.submit();
		}
	}
	return false;
}
function orderCheck()
{
	var f = document.photolistForm;
    var l = document.getElementsByName('photomembers[]');
    var n = l.length;
    var i;
	if (confirm('<?php echo _LANG('m0028','mediaset')?>'))
	{
		for (i = 0; i < n; i++)
		{
			l[i].checked = true;
		}
		f.a.value = 'files_order';
		f.submit();
	}
	return false;
}
function infoCheck()
{
	var f = document.captionForm;
	f.submit();
}
function photoCheck(uid)
{

}
function templateCheck()
{
	var ifr = frames._template_iframe_;

	if(ifr.select_tpl == '')
	{
		alert('<?php echo _LANG('m0029','mediaset')?>  ');
		return false;
	}

	if (ifr.select_tpl == '__tpl__all')
	{
		var table = '';
		var stable = ifr.document.getElementById(ifr.select_tpl).innerHTML;
		var _stable = stable;
		var _stable1 = '';
		var f = document.photolistForm;
		var l = document.getElementsByName('photomembers[]');
		var n = l.length;
		var i;

		for (i = 0; i < n; i++)
		{
			val = l[i].value.split('|');
			_stable = stable.replace('[VOD]',getId('vodsrc_'+val[0]).innerHTML).replace('[CAPTION]',getId('caption_'+val[0]).innerHTML);
			_stable1 += _stable;
		}
		table = _stable1;
	}
	else {

		var table = ifr.document.getElementById(ifr.select_tpl).innerHTML;
		var f = document.photolistForm;
		var l = document.getElementsByName('photomembers[]');
		var n = l.length;
		var i;
		var j = 0;
		var val;

		for (i = 0; i < n; i++)
		{
			if(l[i].checked == true)
			{
				val = l[i].value.split('|');
				table = table.replace('[VOD-'+j+']',getId('vodsrc_'+val[0]).innerHTML);
				table = table.replace('[CAPTION-'+j+']',getId('caption_'+val[0]).innerHTML);
				j++;
			}
		}

		if(!j)
		{
			alert('<?php echo _LANG('m2017','mediaset')?>  ');
			return false;
		}
	}

	parent.InserHTMLtoEditor(table);
	parent.$('#modal_window').modal('hide');

}
function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.position = 'absolute';
	parent.getId('modal_window_dialog_modal_window').style.display = 'block';
	parent.getId('modal_window_dialog_modal_window').style.width = '100%';
	parent.getId('modal_window_dialog_modal_window').style.padding = '0 20px 0 20px';
	parent.getId('modal_window_dialog_modal_window').style.top = '0';
	parent.getId('modal_window_dialog_modal_window').style.left = '0';
	parent.getId('modal_window_dialog_modal_window').style.right = '0';
	parent.getId('modal_window_dialog_modal_window').style.bottom = '0';
	parent.getId('modal_window_dialog_modal_window').children[0].style.height = '100%';

	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_header_modal_window').style.height = '57px';

	parent.getId('_modal_body_modal_window').style.position = 'absolute';
	parent.getId('_modal_body_modal_window').style.display = 'block';
	parent.getId('_modal_body_modal_window').style.paddingRight = '2px';
	parent.getId('_modal_body_modal_window').style.top = '50px';
	parent.getId('_modal_body_modal_window').style.left = '0';
	parent.getId('_modal_body_modal_window').style.right = '0';
	parent.getId('_modal_body_modal_window').style.bottom = '15px';

	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
	parent.getId('_modal_footer_modal_window').style.position = 'absolute';
	parent.getId('_modal_footer_modal_window').style.background = '#fff';
	parent.getId('_modal_footer_modal_window').style.width = '100%';
	parent.getId('_modal_footer_modal_window').style.bottom = '0';

	parent.getId('_modal_iframe_modal_window').style.overflow = 'hidden';
	parent.getId('_modal_iframe_modal_window').scrolling = 'no';

	parent.getId('_modal_header_modal_window').style.background = '#3F424B';
	parent.getId('_modal_header_modal_window').style.color = '#fff';
}
modalSetting();
$('.selectpicker').selectpicker();
</script>

<!----------------------------------------------------------------------------
//부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->



<style>
<?php $_isIE = strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')||strpos($_SERVER['HTTP_USER_AGENT'],'rv:1')?true:false?>

#photobox {position:absolute;display:block;top:0;left:0;bottom:0;right:<?php echo $_sideOpen?290:0?>px;overflow:hidden;}
#photobox .category-box {position:absolute;display:block;top:0;left:0;bottom:0;width:<?php echo $dfiles?'0px':'195px'?>;padding-top:25px;overflow-x:hidden;overflow-y:auto;}
#photobox .photo-box {position:absolute;display:block;top:0;left:<?php echo $dfiles?'0px':'210px'?>;bottom:0;right:0;padding-top:45px;overflow-x:hidden;overflow-y:auto;}
#photobox .alert {margin-right:<?php echo $_sideOpen=true?'15':'305'?>px;}

#photobox .btn-toolbar {position:relative;top:-15px;left:15px;margin-right:40px;}

#photoorder {padding:0 0 10px 0;}
#photoorder .rb-photo-check {position:absolute;margin-left:5px;}
#photoorder li {float:left;list-style-type:none;border:#dfdfdf solid 3px;padding:0;margin:0 9px 20px 10px;}
#photoorder .selected {border:#FC5F4A solid 3px;}
#photoorder li .photo {width:170px;height:98px;cursor:move;}
#photoorder li .btn-group {display:none;}
#photoorder li:hover .btn-group {display:block;position:absolute;}
#photoorder li:hover .btn-group button {top:-34px;}

#infobox {position:absolute;display:block;width:290px;top:15px;right:0;bottom:0;overflow:hidden;}
#infobox .infobox-body {display:block;width:100%;height:100%;border-left:#dfdfdf solid 1px;overflow:hidden;}
#infobox .infobox-body .pic-info {position:absolute;display:block;width:100%;top:42px;bottom:<?php echo $_isIE?'95px':'55px'?>;overflow-x:hidden;overflow-y:auto;}
#infobox .infobox-body .pic-info img {padding:15px 15px 0 15px;}
#infobox .infobox-body .pic-submit {position:absolute;display:block;width:100%;bottom:<?php echo $_isIE?'40px':'0'?>;border-top:#dfdfdf solid 1px;padding:10px 15px 10px 15px;}

#infobox .infobox-body .pic-info1 {position:absolute;display:block;width:100%;top:42px;bottom:<?php echo $_isIE?'132px':'92px'?>;overflow-x:hidden;overflow-y:auto;}
#infobox .infobox-body .pic-submit1 {position:absolute;display:block;width:100%;bottom:<?php echo $_isIE?'40px':'0'?>;border-top:#dfdfdf solid 1px;padding:10px 15px 10px 15px;}

#infobox .text-center .btn {width:100%;}

#infobox .layoutbox-body {display:block;width:100%;height:100%;border-left:#dfdfdf solid 1px;overflow:hidden;}
#infobox .layoutbox-body .selectbox {position:absolute;display:block;width:100%;left:0;right:0;padding:10px 15px 0 15px;}
#infobox .layoutbox-body .iframebox {position:absolute;display:block;width:100%;top:95px;bottom:<?php echo $_isIE?'105px':'55px'?>;padding:0 0 0 15px;overflow:hidden;border-top:#dfdfdf solid 1px;}
#infobox .layoutbox-body .optionbox {position:absolute;display:block;width:100%;padding:1px 15px 10px 15px;bottom:<?php echo $_isIE?'40px':'0'?>;border-top:#dfdfdf solid 1px;}
#infobox .layoutbox-body .optionbox .text-center {border-top:0; padding-top:10px;padding-bottom:0;}

#progressBar {display:none;margin-right:15px;}
#progressPer {}

.rb-list-group a {padding:8px 5px 3px 7px;}
.rb-list-group a span {font-weight:normal;}
</style>