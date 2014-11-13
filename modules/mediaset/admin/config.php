<?php include $g['path_module'].$module.'/var/var.php' ?>

<div id="configbox">

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);" class="form-horizontal">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="config">
		<input type="hidden" name="ftp_connect" value="<?php echo $d['mediaset']['use_fileserver']?>">

		<div class="page-header">
			<h4><?php echo _LANG('a1001','mediaset')?></h4>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo _LANG('a1002','mediaset')?></label>
			<div class="col-sm-10">
				<div class="row">
					<div class="col-sm-3">
						<div class="input-group">
							<input type="text" name="maxnum_file" value="<?php echo $d['mediaset']['maxnum_file']?>" class="form-control">
							<span class="input-group-addon"><?php echo _LANG('a1003','mediaset')?></span>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<input type="text" name="maxsize_file" value="<?php echo $d['mediaset']['maxsize_file']?>" class="form-control">
							<span class="input-group-addon"><?php echo _LANG('a1004','mediaset')?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo _LANG('a1005','mediaset')?></label>
			<div class="col-sm-10">
				<div class="row">
					<div class="col-sm-3">
						<div class="input-group">
							<input type="text" name="maxnum_img" value="<?php echo $d['mediaset']['maxnum_img']?>" class="form-control">
							<span class="input-group-addon"><?php echo _LANG('a1003','mediaset')?></span>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<input type="text" name="maxsize_img" value="<?php echo $d['mediaset']['maxsize_img']?>" class="form-control">
							<span class="input-group-addon"><?php echo _LANG('a1004','mediaset')?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo _LANG('a1006','mediaset')?></label>
			<div class="col-sm-10">
				<div class="row">
					<div class="col-sm-3">
						<div class="input-group">
							<input type="text" name="maxnum_vod" value="<?php echo $d['mediaset']['maxnum_vod']?>" class="form-control">
							<span class="input-group-addon"><?php echo _LANG('a1003','mediaset')?></span>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<input type="text" name="maxsize_vod" value="<?php echo $d['mediaset']['maxsize_vod']?>" class="form-control">
							<span class="input-group-addon"><?php echo _LANG('a1004','mediaset')?></span>
						</div>
					</div>
				</div>
				<p class="form-control-static text-muted"><?php echo sprintf(_LANG('a1007','mediaset'),str_replace('M','',ini_get('upload_max_filesize')))?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo _LANG('a1008','mediaset')?></label>
			<div class="col-sm-10">
				<div class="row">
					<div class="col-sm-3">
						<div class="input-group">
							<input type="text" name="thumbsize" value="<?php echo $d['mediaset']['thumbsize']?>" class="form-control">
							<span class="input-group-addon"><?php echo _LANG('a1009','mediaset')?></span>
						</div>
					</div>
				</div>
				<p class="form-control-static text-muted">
					<?php echo _LANG('a1010','mediaset')?><br>
					<?php echo _LANG('a1011','mediaset')?>
				</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo _LANG('a1012','mediaset')?></label>
			<div class="col-sm-10">
				<div class="row">
					<div class="col-sm-3">
						<select name="use_fileserver" class="form-control" onchange="serverChange(this);">
						<option value=""<?php if(!$d['mediaset']['use_fileserver']):?> selected<?php endif?>><?php echo _LANG('a1013','mediaset')?></option>
						<option value="1"<?php if($d['mediaset']['use_fileserver']):?> selected<?php endif?>><?php echo _LANG('a1014','mediaset')?></option>
						</select>
					</div>
				</div>
				<p class="form-control-static text-muted">
					<?php echo _LANG('a1015','mediaset')?>
				</p>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary btn-lg<?php if($g['device']):?> btn-block<?php endif?>"><?php echo _LANG('a1016','mediaset')?></button>
			</div>
		</div>

		<div id="use_fileserver"<?php if(!$d['mediaset']['use_fileserver']):?> class="hidden"<?php endif?>>
			<div class="page-header">
				<h4><?php echo _LANG('a1017','mediaset')?></h4>
			</div>


			<div class="form-group">
				<label class="col-sm-2 control-label">FTP Type</label>
				<div class="col-sm-9">
					<select name="ftp_type" class="form-control" onchange="ftp_select(this);">
					<option value=""<?php if(!$d['mediaset']['ftp_type']):?> selected<?php endif?>>FTP</option>
					<option value="sftp"<?php if($d['mediaset']['ftp_type']=='sftp'):?> selected<?php endif?>>SFTP</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">FTP Server</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="ftp_host" value="<?php echo $d['mediaset']['ftp_host']?>" placeholder="<?php echo _LANG('a1018','mediaset')?>">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">FTP Port</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="ftp_port" value="<?php echo $d['mediaset']['ftp_port']?$d['mediaset']['ftp_port']:'21'?>" placeholder="" style="width:100px;">
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-9">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="ftp_pasv" value="1"<?php if($d['mediaset']['ftp_pasv']):?> checked<?php endif?>> <i></i>Passive Mode
						</label>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">FTP ID</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="ftp_user" value="<?php echo $d['mediaset']['ftp_user']?>" placeholder="FTP ID">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Password</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" name="ftp_pass" value="<?php echo $d['mediaset']['ftp_pass']?>" placeholder="Password">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo _LANG('a1019','mediaset')?></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="ftp_folder" value="<?php echo $d['mediaset']['ftp_folder']?>" placeholder="">
					<p class="form-control-static">
						<small class="text-muted">
							<?php echo _LANG('a1020','mediaset')?><br>
							<?php echo _LANG('a1021','mediaset')?><br>
							<?php echo _LANG('a1022','mediaset')?><br>
						</small>
					</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo _LANG('a1023','mediaset')?></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="ftp_urlpath" value="<?php echo $d['mediaset']['ftp_urlpath']?>" placeholder="">
					<p class="form-control-static">
						<small class="text-muted">
							<?php echo _LANG('a1024','mediaset')?><br>
							<?php echo _LANG('a1025','mediaset')?><br>
							<?php echo _LANG('a1026','mediaset')?>
						</small>
					</p>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="button" class="btn btn-default" id="ftpbtn" onclick="sendCheck(this.id);"><?php if($d['mediaset']['ftp']):?><i class="fa fa-info-circle fa-lg fa-fw"></i><?php echo _LANG('a1027','mediaset')?><?php else:?><?php echo _LANG('a1028','mediaset')?><?php endif?></button>
					<button type="submit" class="btn btn-primary<?php if($g['device']):?> btn-block<?php endif?>"><?php echo _LANG('a1016','mediaset')?></button>
				</div>
			</div>
		</div>


	</form>
</div>


<script>
function serverChange(obj)
{
	if (obj.value == '1')
	{
		getId('use_fileserver').className = '';
	}
	else {
		getId('use_fileserver').className = 'hidden';
	}
}
var submitFlag = false;
function sendCheck(id)
{
	if (submitFlag == true)
	{
		alert('<?php echo _LANG('a1029','mediaset')?>');
		return false;
	}
	var f = document.procForm;

	if (f.ftp_host.value == '')
	{
		alert('<?php echo _LANG('a1030','mediaset')?>   ');
		f.ftp_host.focus();
		return false;
	}
	if (f.ftp_port.value == '')
	{
		alert('<?php echo _LANG('a1031','mediaset')?>    ');
		f.ftp_port.focus();
		return false;
	}
	if (f.ftp_user.value == '')
	{
		alert('<?php echo _LANG('a1032','mediaset')?>     ');
		f.ftp_user.focus();
		return false;
	}
	if (f.ftp_pass.value == '')
	{
		alert('<?php echo _LANG('a1033','mediaset')?>    ');
		f.ftp_pass.focus();
		return false;
	}
	if (f.ftp_folder.value == '')
	{
		alert('<?php echo _LANG('a1034','mediaset')?>    ');
		f.ftp_folder.focus();
		return false;
	}
	if (f.ftp_urlpath.value == '')
	{
		alert('<?php echo _LANG('a1035','mediaset')?>    ');
		f.ftp_urlpath.focus();
		return false;
	}
	f.a.value = 'ftp_check';
	getId(id).innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
	getIframeForAction(f);
	f.submit();
	submitFlag = true;
}
function saveCheck(f)
{
	if (f.use_fileserver.value == '1')
	{
		if (f.ftp_host.value == '')
		{
			alert('<?php echo _LANG('a1030','mediaset')?>   ');
			f.ftp_host.focus();
			return false;
		}
		if (f.ftp_port.value == '')
		{
			alert('<?php echo _LANG('a1031','mediaset')?>    ');
			f.ftp_port.focus();
			return false;
		}
		if (f.ftp_user.value == '')
		{
			alert('<?php echo _LANG('a1032','mediaset')?>     ');
			f.ftp_user.focus();
			return false;
		}
		if (f.ftp_pass.value == '')
		{
			alert('<?php echo _LANG('a1033','mediaset')?>    ');
			f.ftp_pass.focus();
			return false;
		}
		if (f.ftp_folder.value == '')
		{
			alert('<?php echo _LANG('a1034','mediaset')?>    ');
			f.ftp_folder.focus();
			return false;
		}
		if (f.ftp_urlpath.value == '')
		{
			alert('<?php echo _LANG('a1035','mediaset')?>    ');
			f.ftp_urlpath.focus();
			return false;
		}
	}
	if (f.ftp_connect.value == '')
	{
		alert('<?php echo _LANG('a1036','mediaset')?>   ');
		return false;
	}
	getIframeForAction(f);
	return confirm('<?php echo _LANG('a1037','mediaset')?>         ');
}
function ftp_select(obj)
{
	if (obj.value == '') obj.form.ftp_port.value = '21';
	else obj.form.ftp_port.value = '22';
}
</script>
