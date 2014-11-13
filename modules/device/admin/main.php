<?php 
$R = getDbData($table['s_mobile'],'','*');
?>
<div id="mobilebox">
	<form class="form-horizontal rb-form" name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $module?>" />
		<input type="hidden" name="a" value="mobile" />
		<input type="hidden" name="checkm" value="<?php echo $R['usemobile']?$R['usemobile']:0?>" />

		<div class="page-header">
			<h4><?php echo _LANG('a1001','device')?></h4>
		</div>
		<div class="form-group">
			<label for="" class="sr-only"><?php echo _LANG('a1001','device')?></span></label>
			<div class="col-md-11">
				<ul class="list-inline">
					<li><i class="fa fa-tablet fa-5x"></i></li>
					<li><i class="fa fa-mobile fa-4x"></i></li>
					<li><h2><?php echo _LANG('a1002','device')?></h2></li>
				</ul>
				<div class="btn-group btn-group-lg" data-toggle="buttons">
					<a href="#usemobile-00" class="btn btn-default<?php if(!$R['usemobile']):?> active<?php endif?>" style="height:46px;font-size:18px;" data-toggle="tab">
						<input type="radio" name="usemobile" value="0"<?php if(!$R['usemobile']):?> checked="checked"<?php endif?>> <?php echo _LANG('a1003','device')?>
					</a>
					<a href="#usemobile-02" class="btn btn-default<?php if($R['usemobile']==2):?> active<?php endif?>" style="height:46px;font-size:18px;" data-toggle="tab">
						<input type="radio" name="usemobile" value="2"<?php if($R['usemobile']==2):?> checked="checked"<?php endif?>> <?php echo _LANG('a1004','device')?>
					</a>
					<a href="#usemobile-01" class="btn btn-default<?php if($R['usemobile']==1):?> active<?php endif?>" style="height:46px;font-size:18px;" data-toggle="tab">
						<input type="radio" name="usemobile" value="1"<?php if($R['usemobile']==1):?> checked="checked"<?php endif?>> <?php echo _LANG('a1005','device')?>
					</a>
				</div>
				<div class="tab-content">
					<div class="tab-pane well fade<?php if(!$R['usemobile']):?> in active<?php endif?>" id="usemobile-00">
						<p class="form-control-static">
							<?php echo _LANG('a1006','device')?>
						</p>
					</div>
					<div class="tab-pane well fade<?php if($R['usemobile']==2):?> in active<?php endif?>" id="usemobile-02">
						<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-lg fa-fw kf kf-domain"></i></span>
							<select name="startdomain" class="form-control" style="height:50px;">
								<option value=""><?php echo _LANG('a1007','device')?></option>
								<?php $SITES = getDbArray($table['s_domain'],'','*','gid','asc',0,$p)?>
								<?php while($S = db_fetch_array($SITES)):?>
								<option value="http://<?php echo $S['name']?>"<?php if('http://'.$S['name']==$R['startdomain']):?> selected<?php endif?>>ㆍ<?php echo $S['name']?></option>
								<?php endwhile?>
								<?php if(!db_num_rows($SITES)):?>
								<option value=""><?php echo _LANG('a1008','device')?></option>
								<?php endif?>
							</select>
						</div>
						<p class="form-control-static">
							<?php echo _LANG('a1009','device')?>
							<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=domain&amp;type=makedomain" class="btn btn-link"><?php echo _LANG('a1010','device')?></a>
						</p>
					</div>
					<div class="tab-pane well fade<?php if($R['usemobile']==1):?> in active<?php endif?>" id="usemobile-01">
						<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-lg fa-fw kf kf-home"></i></span>
							<select name="startsite" class="form-control" style="height:50px;">
								<option value=""><?php echo _LANG('a1011','device')?></option>
								<?php $SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p)?>
								<?php while($S = db_fetch_array($SITES)):?>
								<option value="<?php echo $S['uid']?>"<?php if($S['uid']==$R['startsite']):?> selected<?php endif?>>ㆍ<?php echo $S['name']?></option>
								<?php endwhile?>
								<?php if(!db_num_rows($SITES)):?>
								<option value=""><?php echo _LANG('a1012','device')?></option>
								<?php endif?>
							</select>
						</div>
						<p class="form-control-static">
							<?php echo _LANG('a1013','device')?>
							<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=site&amp;type=makesite" class="btn btn-link"><?php echo _LANG('a1014','device')?></a>
						</p>
					</div>
				</div>
			</div>
		</div>

		<div class="page-header">
			<h4><?php echo _LANG('a1015','device')?></h4>
		</div>
		
		<div class="form-group">
			<label for="" class="sr-only"><?php echo _LANG('a1015','device')?></label>
			<div class="col-md-11">
				<textarea name="agentlist" rows="12" class="form-control"><?php echo trim(implode('',file($g['path_var'].'mobile.agent.txt')))?></textarea>
				<p class="form-control-static hidden"><?php echo _LANG('a1016','device')?></p>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-11">
				<button type="submit" class="btn btn-primary btn-block btn-lg"><?php echo _LANG('a1017','device')?></button>
			</div>
		</div>
	
</form>
</div>

<script>
function saveCheck(f)
{
	if (f.checkm.value == '1')
	{
		if (f.startsite.value == '')
		{
			alert('<?php echo _LANG('a1018','device')?>   ');
			f.startsite.focus();
			return false;
		}
	}
	if (f.checkm.value == '2')
	{
		if (f.startdomain.value == '')
		{
			alert('<?php echo _LANG('a1019','device')?>   ');
			f.startdomain.focus();
			return false;
		}
	}
	if (confirm('<?php echo _LANG('a1020','device')?>       '))
	{
		getIframeForAction(f);
		$(".btn-primary").addClass("disabled");
		return true;
	}
	return false;
}
</script>
