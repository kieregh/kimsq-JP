<?php include $g['path_module'].$module.'/var/var.php'?>

<div id="configbox">

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);" class="form-horizontal">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="config">

		<div class="page-header">
			<h4><?php echo _LANG('a1001','notification')?></h4>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo _LANG('a1002','notification')?></label>
			<div class="col-sm-10">
				<select name="sec" class="form-control">
					<?php for($i = 10; $i < 61; $i=$i+5):?>
					<option value="<?php echo $i?>"<?php if($d['ntfc']['sec']==$i):?> selected<?php endif?>><?php echo sprintf(_LANG('a1003','notification'),$i)?></option>
					<?php endfor?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo _LANG('a1004','notification')?></label>
			<div class="col-sm-10">
				<select name="num" class="form-control">
					<option value="10"<?php if($d['ntfc']['num']==10):?> selected<?php endif?>><?php echo sprintf(_LANG('a1005','notification'),10)?> +10</option>
					<option value="50"<?php if($d['ntfc']['num']==50):?> selected<?php endif?>><?php echo sprintf(_LANG('a1005','notification'),50)?> +50</option>
					<option value="99"<?php if($d['ntfc']['num']==99):?> selected<?php endif?>><?php echo sprintf(_LANG('a1005','notification'),99)?> +99</option>
					<option value="100"<?php if($d['ntfc']['num']==100):?> selected<?php endif?>><?php echo sprintf(_LANG('a1005','notification'),100)?> +100</option>
					<option value="999"<?php if($d['ntfc']['num']==999):?> selected<?php endif?>><?php echo sprintf(_LANG('a1005','notification'),999)?> +999</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo _LANG('a1006','notification')?></label>
			<div class="col-sm-10">

				<?php $_MODULES=getDbArray($table['s_module'],'','*','gid','asc',0,1)?>
				<?php while($_MD=db_fetch_array($_MODULES)):?>
				<label class="rb-label">
					<input type="checkbox" name="module_members[]" value="<?php echo $_MD['id']?>"<?php if(strstr($d['ntfc']['cut_modules'],'['.$_MD['id'].']')):?> checked<?php endif?>> <i></i><strong><?php echo $_MD['name']?></strong> <small class="text-muted">(<?php echo $_MD['id']?>)</small>
				</label>
				<?php endwhile?>

				<p class="form-control-static text-muted">
					<?php echo _LANG('a1007','notification')?>
				</p>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary btn-lg<?php if($g['device']):?> btn-block<?php endif?>"><?php echo _LANG('a1008','notification')?></button>
			</div>
		</div>
	</form>

</div>

<script>
function saveCheck(f)
{
	getIframeForAction(f);
	return true;
}
</script>

