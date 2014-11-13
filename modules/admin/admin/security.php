<div id="configbox">

	<form class="form-horizontal" role="form" name="sendForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return sslCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="config">
		<input type="hidden" name="act" value="security">

		<div class="page-header">
			<h4><?php echo _LANG('a5001','admin')?></h4>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a5002','admin')?></label>
			<div class="col-md-9">
				<input type="text" class="form-control" name="secu_tags" value="<?php echo $d['admin']['secu_tags']?>" placeholder="">
				<p class="form-control-static">
					<small class="text-muted">
						<?php echo _LANG('a5003','admin')?><br>
						<?php echo _LANG('a5004','admin')?><br>
						<?php echo _LANG('a5005','admin')?><br>
						<?php echo _LANG('a5006','admin')?><br>
					</small>
				</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a5007','admin')?></label>
			<div class="col-md-9">
				<input type="text" class="form-control" name="secu_domain" value="<?php echo $d['admin']['secu_domain']?>" placeholder="">
				<p class="form-control-static">
					<small class="text-muted">
						<?php echo _LANG('a5008','admin')?><br>
						<?php echo _LANG('a5009','admin')?><br>
						<?php echo _LANG('a5010','admin')?><br>
					</small>
				</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a5011','admin')?></label>
			<div class="col-md-9">
				<input type="text" class="form-control" name="secu_param" value="<?php echo $d['admin']['secu_param']?>" placeholder="">
				<p class="form-control-static">
					<small class="text-muted">
						<?php echo _LANG('a5012','admin')?><br>
						<?php echo _LANG('a5013','admin')?><br>
					</small>
				</p>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-md-offset-2 col-md-9">
				<button class="btn btn-primary btn-lg<?php if($g['device']):?> btn-block<?php endif?>" type="submit"><?php echo _LANG('a5014','admin')?></button>
			</div>
		</div>

	</form>
</div>


<script>
function sslCheck(f)
{
	getIframeForAction(f);
	return confirm('<?php echo _LANG('a0001','admin')?>        ');
}
</script>
