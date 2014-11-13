<div id="configbox">

	<form class="form-horizontal" role="form" name="sendForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return sslCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="config">
		<input type="hidden" name="act" value="ssl">

		<div class="page-header">
			<h4><?php echo _LANG('a4001','admin')?></h4>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a4002','admin')?></label>
			<div class="col-md-9">
				<label class="radio-inline">
					<i></i><input type="radio" name="ssl_type" value=""<?php if(!$d['admin']['ssl_type']):?> checked<?php endif?>><?php echo _LANG('a4003','admin')?>
				</label>
				<label class="radio-inline">
					<i></i><input type="radio" name="ssl_type" value="2"<?php if($d['admin']['ssl_type']==2):?> checked<?php endif?>><?php echo _LANG('a4004','admin')?>
				</label>
				<label class="radio-inline">
					<i></i><input type="radio" name="ssl_type" value="1"<?php if($d['admin']['ssl_type']==1):?> checked<?php endif?> onclick="alert('<?php echo _LANG('a4005','admin')?>');"><?php echo _LANG('a4006','admin')?>
				</label>
				<p id="ssl_guide" class="form-control-static">
					<small class="text-muted">
					<?php echo _LANG('a4007','admin')?><br>
					<?php echo _LANG('a4008','admin')?><br>
					<?php echo _LANG('a4009','admin')?><br>
					</small>
				</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a4010','admin')?></label>
			<div class="col-md-9">
				<input type="text" class="form-control" name="http_port" value="<?php echo $d['admin']['http_port']?>"  placeholder="" style="width:100px;">
				<p class="form-control-static">
					<small class="text-muted"><?php echo _LANG('a4011','admin')?></small>
				</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a4012','admin')?></label>
			<div class="col-md-9">
				<input type="text" class="form-control" name="ssl_port" value="<?php echo $d['admin']['ssl_port']?>"  placeholder="" style="width:100px;">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a4013','admin')?></label>
			<div class="col-md-9">
				<input type="text" class="form-control" name="ssl_module" value="<?php echo $d['admin']['ssl_module']?>" placeholder="">
				<p class="form-control-static">
					<small class="text-muted">
						<?php echo _LANG('a4014','admin')?><br>
						<?php echo _LANG('a4015','admin')?><br>
					</small>
				</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a4016','admin')?></label>
			<div class="col-md-9">
				<input type="text" class="form-control" name="ssl_menu" value="<?php echo $d['admin']['ssl_menu']?>" placeholder="">
				<p class="form-control-static">
					<small class="text-muted">
						<?php echo _LANG('a4017','admin')?><br>
						<?php echo _LANG('a4018','admin')?><br>
					</small>
				</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a4019','admin')?></label>
			<div class="col-md-9">
				<input type="text" class="form-control" name="ssl_page" value="<?php echo $d['admin']['ssl_page']?>" placeholder="">
				<p class="form-control-static">
					<small class="text-muted">
						<?php echo _LANG('a4020','admin')?><br>
						<?php echo _LANG('a4021','admin')?><br>
					</small>
				</p>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-md-offset-2 col-md-9">
				<button class="btn btn-primary btn-lg<?php if($g['device']):?> btn-block<?php endif?>" type="submit"><?php echo _LANG('a4022','admin')?></button>
			</div>
		</div>

	</form>
</div>




<script>
function sslCheck(f)
{
	getIframeForAction(f);
	return confirm('<?php echo _LANG('a0001','admin')?>         ');
}
</script>




