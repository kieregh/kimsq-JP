<div id="rb-search-body">

	<form name="RbSearchForm" action="<?php echo $g['s']?>/" class="form-horizontal page-header" role="form">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $m?>">
		<input type="hidden" name="where" value="<?php echo $where?>">
		<input type="hidden" name="swhere" value="<?php echo $swhere?>">
		<input type="hidden" name="sort" value="<?php echo $sort?>">
		<input type="hidden" name="orderby" value="<?php echo $orderby?>">

		<div class="form-group">
			<label class="col-sm-3 control-label hidden-xs"><h1><i class="fa fa-search"></i> <?php echo _LANG('t001','search')?></h1></label>
			<div class="col-sm-9">
				<div class="input-group input-group-lg">
					<input type="text" name="keyword" class="form-control" value="<?php echo $_keyword?>">
					<span class="input-group-btn">
						<?php if($keyword):?><a class="btn btn-default" href="<?php echo $g['url_reset']?>"><?php echo _LANG('t002','search')?></a><?php endif?>
						<button class="btn btn-default" type="submit"><?php echo _LANG('t003','search')?></button>
					</span>
				</div>
			</div>
		</div>
	</form>

	<div class="row">
		<div class="col-sm-9 col-sm-push-3">
			<?php if($keyword):?>
			<div id="rb-sortbar" class="rb-sortbar well well-sm clearfix hidden-xs">
				<h3>
					<span><?php echo _LANG('t004','search')?></span>
					<div class="pull-right" style="margin-left:5px">
					    <select class="selectpicker show-tick show-menu-arrow" data-header="<?php echo _LANG('t005','search')?>" data-style="btn-default btn-sm" data-width="auto" onchange="searchSortChange(this);">
					        <option value="desc" data-icon="glyphicon glyphicon-arrow-down"<?php if($orderby=='desc'):?> selected<?php endif?>><?php echo _LANG('t006','search')?></option>
					        <option value="asc" data-icon="glyphicon glyphicon-arrow-up"<?php if($orderby=='asc'):?> selected<?php endif?>><?php echo _LANG('t007','search')?></option>
					    </select>
					</div>
				</h3>	
			</div>
			<?php endif?>
			
			<?php $_ResultArray['num']=array()?>
			<?php if($keyword):?>
			<?php foreach($d['search_order'] as $_key => $_val):if(!strstr($_val[1],'['.$r.']'))continue?>
				<?php $_iscallpage=($swhere == 'all' || $swhere == $_key)?>
				<?php if($_iscallpage):?>
					<?php if(is_file($_val[2].'.css')) echo '<link href="'.$_val[2].'.css" rel="stylesheet">'?>
			<div id="rb_search_panel_<?php echo $_key?>" class="panel rb-panel panel-default">
				<div class="panel-heading rb-panel-heading">
					<h4>
						<?php echo $_val[0]?>
						<small>(<span id="rb_sresult_num_tt_<?php echo $_key?>">0</span><?php echo $lang['search']['t013']?>)</small>
					</h4>
				</div>
				<?php endif?>
				
				<!-- 검색결과 -->
				<div class="panel-body rb-panel-body">
				<?php include $_val[2].'.php'?>
				</div>
				<!-- @검색결과 -->
			
				<?php if($_iscallpage):?>
					<?php if($swhere==$_key):?>
				<div class="panel-footer rb-panel-footer">
					<ul class="pagination">
						<script>getPageLink(5,<?php echo $p?>,<?php echo getTotalPage($_ResultArray['num'][$_key],$d['search']['num2'])?>,'');</script>
					</ul>
				</div>
					<?php else:?>
						<?php if($_ResultArray['num'][$_key] > $d['search']['num1']):?>
				<div class="panel-footer rb-panel-footer">
					<div class="rb-more-search">
						<a href="<?php echo $g['url_where'].$_key?>"><?php echo _LANG('t008','search')?> <i class="fa fa-angle-right"></i></a>
					</div>
				</div>
						<?php endif?>
					<?php endif?>
			</div>
				<?php endif?>
			<?php endforeach?>
			<?php else:?>
			<div id="rb-searchresult-none">
				<div class="jumbotron">
					<br>
					<br>
					<i class="fa fa-search"></i>
					<br>
					<h3><?php echo _LANG('t009','search')?></h3>
					<br>
					<br>
					<br>
				</div>
			</div>
			<?php endif?>
			<div id="rb-searchpage-none" class="hidden">
				<div class="jumbotron">
					<i class="glyphicon glyphicon-exclamation-sign"></i>
					<h3><?php echo _LANG('t010','search')?></h3>
				</div>
			</div>
		</div>
		<div class="col-sm-3 col-sm-pull-9">
			<hr class="visible-xs">
			<div class="list-group">
				<a href="<?php echo $g['url_where']?>all" class="list-group-item<?php if($swhere=='all'):?> active<?php endif?>"><?php echo _LANG('t011','search')?></a>
				<?php $_ResultArray['spage']=0;foreach($d['search_order'] as $_key => $_val):if(!strstr($_val[1],'['.$r.']'))continue?>
				<a href="<?php echo $g['url_where'].$_key?>" class="list-group-item<?php if($swhere==$_key):?> active<?php endif?>">
					<?php echo $_val[0]?>
					<span id="rb_sresult_num_bg_<?php echo $_key?>" class="badge pull-right">0</span>
				</a>
				<?php $_ResultArray['spage']++;endforeach?>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading"><?php echo _LANG('t012','search')?></div>
				<div class="list-group">
					<?php $_search_engines=file($g['dir_module'].'var/search.list.txt')?>
					<?php foreach($_search_engines as $_key):$_val=explode(',',trim($_key))?>
					<a href="<?php echo $_val[1].($keyword?urlencode($keyword):'')?>" class="list-group-item" target="_blank"><?php echo $_val[0]?></a>
					<?php endforeach?>
				</div>
			</div>
		</div>
	</div>
</div>



<!-- bootstrap-select -->
<?php getImport('bootstrap-select','bootstrap-select',false,'css')?>
<?php getImport('bootstrap-select','bootstrap-select',false,'js')?>

<script>
function searchSortChange(obj)
{
	var f = document.RbSearchForm;
	f.orderby.value = obj.value;
	f.submit();
}
$('select').selectpicker();

<?php $total = 0?>
<?php foreach($_ResultArray['num'] as $_key => $_val):$total+=$_val?>
if(getId('rb_sresult_num_tt_<?php echo $_key?>')) getId('rb_sresult_num_tt_<?php echo $_key?>').innerHTML = '<?php echo $_val?>';
if(getId('rb_sresult_num_bg_<?php echo $_key?>')) getId('rb_sresult_num_bg_<?php echo $_key?>').innerHTML = '<?php echo $_val?>';
<?php if(!$_val):?>getId('rb_search_panel_<?php echo $_key?>').className = 'hidden';<?php endif?>
<?php endforeach?>
if(getId('rb_sresult_num_all')) getId('rb_sresult_num_all').innerHTML = '<?php echo $swhere=='all'?$total:$_ResultArray['num'][$swhere]?>';
<?php if(!$_ResultArray['spage']):?>
if(getId('rb-searchresult-none')) getId('rb-searchresult-none').className = 'hidden';
if(getId('rb-sortbar')) getId('rb-sortbar').className = 'hidden';
getId('rb-searchpage-none').className = '';
<?php endif?>
</script>

