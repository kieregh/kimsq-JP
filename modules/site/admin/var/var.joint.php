<?php
$dropButtonUrl = ''; //모듈연결하기 버튼에 지정할 URL(미 지정시 모듈연결버튼 생략)
$recnum = 15;
$catque = 'site='.$s.' and pagetype>1';
if ($cat) $catque .= " and category='".$cat."'";
if ($_keyw) $catque .= " and ".$where." like '".$_keyw."%'";
$PAGES = getDbArray($table['s_page'],$catque,'*','uid','asc',$recnum,$p);
$NUM = getDbRows($table['s_page'],$catque);
$TPG = getTotalPage($NUM,$recnum);
?>


<div id="mjointbox">
	<div class="title">
		<form class="form-horizontal rb-form" role="form" action="<?php echo $g['s']?>/" method="get">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="system" value="<?php echo $system?>">
		<input type="hidden" name="iframe" value="<?php echo $iframe?>" />
		<input type="hidden" name="dropfield" value="<?php echo $dropfield?>">
		<input type="hidden" name="smodule" value="<?php echo $smodule?>">
		<input type="hidden" name="cmodule" value="<?php echo $cmodule?>">
		<input type="hidden" name="p" value="<?php echo $p?>">

		<div class="input-group">
			<div class="input-group input-group-justified">
				<span class="input-group-btn">
					<select class="form-control" name="cat" class="cat" onchange="this.form.submit();">
					<option value="">&nbsp;+ <?php echo _LANG('j001','site')?></option>
					<?php $_cats=array()?>
					<?php $CATS=db_query("select *,count(*) as cnt from ".$table['s_page']." group by category",$DB_CONNECT)?>
					<?php while($C=db_fetch_array($CATS)):$_cats[]=$C['category']?>
					<option value="<?php echo $C['category']?>"<?php if($C['category']==$cat):?> selected<?php endif?>>ㆍ<?php echo $C['category']?> (<?php echo $C['cnt']?>)</option>
					<?php endwhile?>
					</select>
				</span>
				<span class="input-group-btn">
					<select class="form-control" name="where">
					<option value="name"<?php if($where == 'name'):?> selected="selected"<?php endif?>><?php echo _LANG('j002','site')?></option>
					<option value="id"<?php if($where == 'id'):?> selected="selected"<?php endif?>><?php echo _LANG('j003','site')?></option>
					</select>
				</span>
				<span class="input-group-btn">
					<input class="form-control" placeholder="" type="text" name="_keyw" size="10" value="<?php echo addslashes($_keyw)?>">
				</span>
			</div>
			<span class="input-group-btn">
				<input type="submit" value=" <?php echo _LANG('j004','site')?> " class="btn btn-default">
				<input type="button" value=" <?php echo _LANG('j005','site')?> " class="btn btn-default" onclick="this.form.p.value=1;this.form.cat.value='';this.form._keyw.value='';this.form.submit();">
			</span>
		</div>

		</form>
	</div>

	<?php if($NUM):?>
	<table class="table">
		<?php while($PR = db_fetch_array($PAGES)):?>
		<tr>
		<td class="name">
			<a href="<?php echo RW('mod='.$PR['id'])?>" target="_blank" title="페이지보기" data-tooltip="tooltip">
				<i class="fa fa-file-text-o"></i> 
				<?php echo $PR['name']?>
			</a>
			<span>(<?php echo $PR['id']?>)</span>
		</td>
		<td>
			<button class="pull-right btn btn-default" type="button" onclick="dropJoint('<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $smodule?>&mod=<?php echo $PR['id']?>');">
				<i class="glyphicon glyphicon-save"></i> 
				<?php echo _LANG('j006','site')?>
			</button>
		</td>
		</tr>
		<?php endwhile?>
	</table>

	<div class="rb-page-box">
		<ul class="pagination">
		<script type="text/javascript">getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
		<?php //echo getPageLink(5,$p,$TPG,'')?>
		</ul>
	</div>
	<?php endif?>
</div>

<style>
#mjointbox {}
#mjointbox .title {padding:0 0 20px 0;}
#mjointbox table .name a {font-weight:bold;}
#mjointbox table .name a,
#mjointbox table .name span {position:relative;top:8px;}
#mjointbox table .name span {font-size:11px;color:#c0c0c0;padding-left:3px;}
#mjointbox .rb-page-box {text-align:center;border-top:#dfdfdf solid 1px;margin:20px 0 20px 0;}
</style>
