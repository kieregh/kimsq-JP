<div id="uninstall">

	<div class="panel panel-danger">
		<div class="panel-heading">Danger Zone</div>
		<div class="panel-body">
			<div class="page-header"><h4>kimsQ Rb Uninstall</h4></div>

			<div class="media">
				<h1 class="pull-left"><span class="fa fa-trash fa-lg"></span></h1>
				<div class="media-body">
				<ul>	
					<li><?php echo _LANG('a9001','admin')?></li>
					<li><?php echo _LANG('a9002','admin')?></li>
					<li><?php echo _LANG('a9003','admin')?></li>
					<li><?php echo _LANG('a9004','admin')?></li>
				</ul>
				</div>
			</div>


			<div class="page-header"><h4><?php echo _LANG('a9005','admin')?></h4></div>


			<dl class="dl-horizontal">
				<dt><?php echo _LANG('a9006','admin')?></dt>
				<dd><code><?php echo $g['s']?>/*</code></dd>
				<dt><?php echo _LANG('a9007','admin')?></dt>
				<dd><code><?php echo $DB['head']?>*</code></dd>
			</dl>

			<hr>

			<?php if($d['admin']['ftp_use']):?>
			<div class="form-group">
				<label for="" class="sr-only"><?php echo _LANG('a9008','admin')?></label>
				<div class="input-group input-group-lg">
					<input type="password" class="form-control" id="_ftp_pass_" placeholder="<?php echo _LANG('a9009','admin')?>">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default" id="ftpbtn_uninstall" onclick="sendCheck(this.id);"><?php if($d['admin']['ftp']):?><i class="fa fa-info-circle fa-lg fa-fw"></i><?php echo _LANG('a9010','admin')?><?php else:?><?php echo _LANG('a9011','admin')?><?php endif?></button>
					</span>
				</div>
			</div>
			<?php else:?>
			<div class="well">
				<?php echo _LANG('a9012','admin')?>
				<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>"><?php echo _LANG('a9013','admin')?></a> 
			</div>
			<?php endif?>

		</div>
		<div class="panel-footer">
			<button type="button" class="btn btn-default btn-lg btn-block rb-danger" data-toggle="modal" data-target="#modal-uninstall" ><?php echo _LANG('a9014','admin')?></button>
		</div>
	</div>

</div>



<!-- Modal -->
<div class="modal fade" id="modal-uninstall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo _LANG('a9015','admin')?></h4>
			</div>
			<div class="modal-body">
				<ul>	
					<li><?php echo _LANG('a9016','admin')?></li>
					<li><?php echo _LANG('a9017','admin')?></li>
					<li><?php echo _LANG('a9018','admin')?></li>
					<li><?php echo _LANG('a9019','admin')?></li>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-lg btn-block" onclick="uninstall();"><?php echo _LANG('a9020','admin')?></button>
			</div>
		</div>
	</div>
</div>

<form name="sendForm" action="<?php echo $g['s']?>/" method="post">
<input type="hidden" name="r" value="<?php echo $r?>">
<input type="hidden" name="m" value="<?php echo $module?>">
<input type="hidden" name="a" value="">
<input type="hidden" name="type" value="">
<input type="hidden" name="pass" value="">
</form>

<script>
function sendCheck(id)
{
	if (getId('_ftp_pass_').value == '')
	{
		alert('<?php echo _LANG('a9021','admin')?>   ');
		getId('_ftp_pass_').focus();
		return false;
	}
	var f = document.sendForm;
	f.a.value = 'email_check';
	f.type.value = id;
	f.pass.value = getId('_ftp_pass_').value;
	getId(id).innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
	getIframeForAction(f);
	f.submit();
}
function uninstall()
{
	var f = document.sendForm;
	f.a.value = 'uninstall';
	getIframeForAction(f);
	f.submit();
}
</script>