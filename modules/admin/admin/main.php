<div id="configbox">
	<form class="form-horizontal rb-form" role="form">
		<div class="page-header">
			<h4><?php echo _LANG('a1001','admin')?></h4>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1002','admin')?></label>
			<div class="col-md-9">
				<p class="form-control-static"><?php echo $_SERVER['SERVER_SOFTWARE']?></p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">PHP</label>
			<div class="col-md-9">
				<p class="form-control-static"><?php echo phpversion()?></p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">MySQL</label>
			<div class="col-md-9">
				<p class="form-control-static"><?php echo db_info()?> (<?php echo $DB['type']?>)</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">KimsQ Version</label>
			<div class="col-md-9">
				<p class="form-control-static"><?php echo $d['admin']['version']?></p>
			</div>
		</div>
	</form>
	<br>

	<form class="form-horizontal rb-form" role="form" name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="config">
		<input type="hidden" name="act" value="config">
		<input type="hidden" name="version" value="<?php echo $d['admin']['version']?>">
		<input type="hidden" name="autosave" value="">
		<input type="hidden" name="email" value="<?php echo $d['admin']['email']?>">
		<input type="hidden" name="smtp" value="<?php echo $d['admin']['email']?>">
		<input type="hidden" name="ftp" value="<?php echo $d['admin']['ftp']?>">
		<input type="hidden" name="type" value="">
		<input type="hidden" name="chk_email" value="">


		<div class="page-header">
			<h4><?php echo _LANG('a1007','admin')?></h4>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1008','admin')?></label>
			<div class="col-md-9">
				<select name="themepc" class="form-control">
					<?php $dirs = opendir($g['dir_module'].'theme')?>
					<?php while(false !== ($tpl = readdir($dirs))):?>
					<?php if($tpl=='.' || $tpl == '..')continue?>
					<option value="<?php echo $tpl?>"<?php if($d['admin']['themepc']==$tpl):?> selected<?php endif?>><?php echo $tpl?></option>
					<?php endwhile?>
					<?php closedir($dirs)?>
				</select>
				<p class="form-control-static"></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1009','admin')?></label>
			<div class="col-md-9">
				<select name="pannellink" class="form-control">
					<?php $dirs = opendir($g['path_core'].'engine/adminpanel/theme')?>
					<?php while(false !== ($tpl = readdir($dirs))):?>
					<?php if($tpl=='.' || $tpl == '..')continue?>
					<option value="<?php echo $tpl?>"<?php if($d['admin']['pannellink']==$tpl):?> selected<?php endif?>><?php echo str_replace('.css','',$tpl)?></option>
					<?php endwhile?>
					<?php closedir($dirs)?>
				</select>
				<p class="form-control-static"></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1010','admin')?></label>
			<div class="col-md-9">
				<select name="cache_flag" class="form-control">
					<option value=""<?php if($d['admin']['cache_flag']==''):?> selected<?php endif?>><?php echo _LANG('a1011','admin')?></option>
					<option value="totime"<?php if($d['admin']['cache_flag']=='totime'):?> selected<?php endif?>><?php echo _LANG('a1012','admin')?></option>
					<option value="nhour"<?php if($d['admin']['cache_flag']=='nhour'):?> selected<?php endif?>><?php echo _LANG('a1013','admin')?></option>
					<option value="today"<?php if($d['admin']['cache_flag']=='today'):?> selected<?php endif?>><?php echo _LANG('a1014','admin')?></option>
					<option value="month"<?php if($d['admin']['cache_flag']=='month'):?> selected<?php endif?>><?php echo _LANG('a1015','admin')?></option>
					<option value="year"<?php if($d['admin']['cache_flag']=='year'):?> selected<?php endif?>><?php echo _LANG('a1016','admin')?></option>
				</select>
				<p class="form-control-static"><small class="text-muted"><?php echo _LANG('a1017','admin')?></small></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1018','admin')?></label>
			<div class="col-md-9">
				<select name="uninstall" class="form-control">
					<option value=""<?php if(!$d['admin']['uninstall']):?> selected<?php endif?>><?php echo _LANG('a1019','admin')?></option>
					<option value="1"<?php if($d['admin']['uninstall']):?> selected<?php endif?>><?php echo _LANG('a1020','admin')?></option>
				</select>
				<p class="form-control-static">
					<small class="text-muted">
						<?php echo _LANG('a1021','admin')?>
					</small>
				</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1022','admin')?></label>
			<div class="col-md-9">
				<select name="dblclick" class="form-control">
					<option value="1"<?php if($d['admin']['dblclick']):?> selected<?php endif?>><?php echo _LANG('a1023','admin')?></option>
					<option value=""<?php if(!$d['admin']['dblclick']):?> selected<?php endif?>><?php echo _LANG('a1024','admin')?></option>
				</select>
				<p class="form-control-static">
					<small class="text-muted">
						<?php echo _LANG('a1025','admin')?>
					</small>
				</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1062','admin')?></label>
			<div class="col-md-9">
				<select name="codeeidt" class="form-control">
					<option value="">TEXTAREA</option>
					<?php $dirs = opendir($g['path_plugin'].'codemirror/'.$d['ov']['codemirror'].'/theme')?>
					<?php while(false !== ($tpl = readdir($dirs))):?>
					<?php if(substr($tpl,-4)!='.css')continue?>
					<?php $_codeedit=str_replace('.css','',$tpl)?>
					<option value="<?php echo $_codeedit?>"<?php if($d['admin']['codeeidt']==$_codeedit):?> selected<?php endif?>><?php echo ucfirst($_codeedit)?></option>
					<?php endwhile?>
					<?php closedir($dirs)?>
				</select>
				<p class="form-control-static">
					<small class="text-muted">
						<?php echo _LANG('a1063','admin')?>
					</small>
				</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1026','admin')?></label>
			<div class="col-md-9">
				<select name="editor" class="form-control">
					<?php $dirs = opendir($g['path_plugin'])?>
					<?php while(false !== ($tpl = readdir($dirs))):?>
					<?php if(!is_file($g['path_plugin'].$tpl.'/import.php'))continue?>
					<option value="<?php echo $tpl?>"<?php if($d['admin']['editor']==$tpl):?> selected<?php endif?>><?php echo $tpl?></option>
					<?php endwhile?>
					<?php closedir($dirs)?>
				</select>
				<p class="form-control-static">
					<small class="text-muted">
						<?php echo sprintf(_LANG('a1027','admin'),$g['path_plugin'])?>
					</small>
				</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1060','admin')?></label>
			<div class="col-md-9">
				<select name="sysmodule" class="form-control">
				<?php $MODULESRCD=getDbArray($table['s_module'],"system=0 or id='site'",'*','gid','asc',0,1)?>
				<?php while($_MDR=db_fetch_array($MODULESRCD)):?>
				<option value="<?php echo $_MDR['id']?>"<?php if($d['admin']['sysmodule']==$_MDR['id']):?> selected<?php endif?>><?php echo $_MDR['name']?>(<?php echo $_MDR['id']?>)</option>
				<?php endwhile?>
				</select>
				<p class="form-control-static">
					<small class="text-muted">
						<?php echo _LANG('a1061','admin')?>
					</small>
				</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1028','admin')?></label>
			<div class="col-md-9">
				<select name="syslang" class="form-control">
					<?php if(is_dir($g['path_module'].$module.'/language')):?>
					<?php $dirs = opendir($g['path_module'].$module.'/language')?>
					<?php while(false !== ($tpl = readdir($dirs))):?>
					<?php if($tpl=='.'||$tpl=='..')continue?>
					<option value="<?php echo $tpl?>"<?php if($d['admin']['syslang']==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_module'].$module.'/language/'.$tpl)?></option>
					<?php endwhile?>
					<?php closedir($dirs)?>
					<?php endif?>
				</select>
				<p class="form-control-static">
					<small class="text-muted">
						<?php echo _LANG('a1029','admin')?>
					</small>
				</p>
			</div>
		</div>
		<div class="page-header">
			<h4><?php echo _LANG('a1030','admin')?></h4>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Mail Type</label>
			<div class="col-md-9">
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-default<?php if(!$d['admin']['smtp_use']):?> active<?php endif?>" data-toggle="tab" data-target="#mail-sendmail">
						<input type="radio" name="smtp_use" value=""<?php if(!$d['admin']['smtp_use']):?> checked<?php endif?>> Sendmail
					</label>
					<label class="btn btn-default<?php if($d['admin']['smtp_use']=='1'):?> active<?php endif?>" data-toggle="tab" data-target="#mail-smtp" data-tooltip="tooltip" title="<?php echo _LANG('a1031','admin')?>">
						<input type="radio" name="smtp_use" value="1"<?php if($d['admin']['smtp_use']=='1'):?> checked<?php endif?>> SMTP
					</label>
				</div>
			</div>
		</div>

		<div class="tab-content" style="border:none;padding:0;margin:0;">
			<div id="mail-sendmail" class="tab-pane clearfix<?php if(!$d['admin']['smtp_use']):?> active<?php endif?>">
				<div class="form-group">
					<label class="col-md-2 control-label"></label>
					<div class="col-md-9">
						<small class="text-muted"><?php echo _LANG('a1032','admin')?></small>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label"><?php echo _LANG('a1003','admin')?></label>
				<div class="col-md-9">
					<div class="input-group">
					<input type="email" name="sysmail" value="<?php echo $d['admin']['sysmail']?$d['admin']['sysmail']:$my['email']?>" class="form-control">
					<span class="input-group-btn">
					<button class="btn btn-default" type="button" id="sendmailbtn" onclick="sendCheck(this.id);"><?php if($d['admin']['email']):?><i class="fa fa-info-circle fa-lg fa-fw"></i><?php echo _LANG('a1004','admin')?><?php else:?><?php echo _LANG('a1005','admin')?><?php endif?></button>
					</span>
					</div>
					<p class="form-control-static"><small class="text-muted"><?php echo _LANG('a1006','admin')?></small></p>
				</div>
			</div>

			<div id="mail-smtp" class="tab-pane clearfix<?php if($d['admin']['smtp_use']=='1'):?> active<?php endif?>">
				<div class="form-group">
					<label class="col-md-2 control-label">SMTP Server</label>
					<div class="col-md-9">
					<input class="form-control" type="text" name="smtp_host" value="<?php echo $d['admin']['smtp_host']?>" placeholder="<?php echo _LANG('a1033','admin')?>">
						<p class="form-control-static"><small class="text-muted"></small></p>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">SMTP Port</label>
					<div class="col-md-9">
						<input type="text" class="form-control" name="smtp_port" value="<?php echo $d['admin']['smtp_port']?$d['admin']['smtp_port']:465?>" placeholder="" style="width:100px">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-9">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="smtp_auth" value="1"<?php if($d['admin']['smtp_auth']):?> checked<?php endif?>><i></i> <?php echo _LANG('a1034','admin')?>
							</label>
						</div>
						<div>
							<label><input type="radio" name="smtp_ssl" value=""<?php if(!$d['admin']['smtp_ssl']):?> checked<?php endif?>> <?php echo _LANG('a1035','admin')?></label>
							<label><input type="radio" name="smtp_ssl" value="SSL"<?php if($d['admin']['smtp_ssl']=='SSL'):?> checked<?php endif?>> SSL</label>
							<label><input type="radio" name="smtp_ssl" value="TLS"<?php if($d['admin']['smtp_ssl']=='TLS'):?> checked<?php endif?>> TLS</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo _LANG('a1036','admin')?></label>
					<div class="col-md-9">
						<input type="text" class="form-control" name="smtp_user" value="<?php echo $d['admin']['smtp_user']?>" placeholder="<?php echo _LANG('a1036','admin')?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo _LANG('a1037','admin')?></label>
					<div class="col-md-9">
						<input type="password" class="form-control" name="smtp_pass" value="<?php echo $d['admin']['smtp_pass']?>" placeholder="<?php echo _LANG('a1037','admin')?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-10">
					<button type="button" class="btn btn-default" id="smtpbtn" onclick="sendCheck(this.id);"><?php if($d['admin']['smtp']):?><i class="fa fa-info-circle fa-lg fa-fw"></i><?php echo _LANG('a1004','admin')?><?php else:?><?php echo _LANG('a1038','admin')?><?php endif?></button>
					<p class="form-control-static"><small class="text-muted"><?php echo _LANG('a1039','admin')?></small></p>
					</div>
				</div>

	    	</div>
    	</div>
 
		<div class="page-header">
			<h4>FTP </h4>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label"><?php echo _LANG('a1040','admin')?></label>
			<div class="col-md-9">
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-default<?php if(!$d['admin']['ftp_use']):?> active<?php endif?>" data-toggle="tab" data-target="#ftp-nobody">
						<input type="radio" name="ftp_use" value=""<?php if(!$d['admin']['ftp_use']):?> checked<?php endif?>> Nobody 
					</label>
					<label class="btn btn-default<?php if($d['admin']['ftp_use']=='1'):?> active<?php endif?>" data-toggle="tab" data-target="#ftp-user">
						<input type="radio" name="ftp_use" value="1"<?php if($d['admin']['ftp_use']=='1'):?> checked<?php endif?>> User
					</label>
				</div>
			</div>
		</div>

		<div class="tab-content" style="border:none;padding:0;margin:0;">
			<div id="ftp-nobody" class="tab-pane clearfix<?php if(!$d['admin']['ftp_use']):?> active<?php endif?>">
				<div class="form-group">
					<label class="col-md-2 control-label"></label>
					<div class="col-md-9">
						<small class="text-muted"><?php echo _LANG('a1041','admin')?></small>
					</div>
				</div>
			</div>	
			<div id="ftp-user" class="tab-pane clearfix<?php if($d['admin']['ftp_use']=='1'):?> active<?php endif?>">

				<div class="form-group">
					<label class="col-md-2 control-label">FTP Type</label>
					<div class="col-md-9">
						<select name="ftp_type" class="form-control" onchange="ftp_select(this);">
						<option value=""<?php if(!$d['admin']['ftp_type']):?> selected<?php endif?>>FTP</option>
						<option value="sftp"<?php if($d['admin']['ftp_type']=='sftp'):?> selected<?php endif?>>SFTP</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">FTP Server</label>
					<div class="col-md-9">
						<input type="text" class="form-control" name="ftp_host" value="<?php echo $d['admin']['ftp_host']?>" placeholder="<?php echo _LANG('a1042','admin')?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">FTP Port</label>
					<div class="col-md-9">
						<input type="text" class="form-control" name="ftp_port" value="<?php echo $d['admin']['ftp_port']?$d['admin']['ftp_port']:'21'?>" placeholder="" style="width:100px;">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-9">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="ftp_pasv" value="1"<?php if($d['admin']['ftp_pasv']):?> checked<?php endif?>> <i></i>Passive Mode
							</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">FTP ID</label>
					<div class="col-md-9">
						<input type="text" class="form-control" name="ftp_user" value="<?php echo $d['admin']['ftp_user']?>" placeholder="FTP ID">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">Password</label>
					<div class="col-md-9">
						<input type="password" class="form-control" name="ftp_pass" value="<?php echo $d['admin']['ftp_pass']?>" placeholder="Password">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo _LANG('a1043','admin')?></label>
					<div class="col-md-9">
						<input type="text" class="form-control" name="ftp_rb" value="<?php echo $d['admin']['ftp_rb']?>" placeholder="">
						<p class="form-control-static">
							<small class="text-muted">
								<?php echo _LANG('a1044','admin')?><br>
								<?php echo _LANG('a1045','admin')?><br>
								<?php echo _LANG('a1046','admin')?><br>
							</small>
						</p>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-10">
						<button type="button" class="btn btn-default" id="ftpbtn" onclick="sendCheck(this.id);"><?php if($d['admin']['ftp']):?><i class="fa fa-info-circle fa-lg fa-fw"></i><?php echo _LANG('a1004','admin')?><?php else:?><?php echo _LANG('a1047','admin')?><?php endif?></button>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-md-offset-2 col-md-9">
				<button class="btn btn-primary btn-lg<?php if($g['device']):?> btn-block<?php endif?>" type="submit"><?php echo _LANG('a1048','admin')?></button>
			</div>
		</div>
	</form>
</div>
<div class="hidden"><iframe name="_autosave_"></iframe></div>



<!-- basic -->
<script>
var submitFlag = false;
function sendCheck(id)
{
	if (submitFlag == true)
	{
		alert('<?php echo _LANG('a1049','admin')?>');
		return false;
	}
	var f = document.procForm;
	if (id == 'sendmailbtn' || id == 'smtpbtn')
	{
		if (f.sysmail.value == '')
		{
			alert('<?php echo _LANG('a1050','admin')?>       ');
			f.email.focus();
			return false;
		}
		f.chk_email.value = f.sysmail.value;
	}
	if (id == 'smtpbtn')
	{
		if (f.smtp_host.value == '')
		{
			alert('<?php echo _LANG('a1051','admin')?>   ');
			f.smtp_host.focus();
			return false;
		}
		if (f.smtp_port.value == '')
		{
			alert('<?php echo _LANG('a1052','admin')?>    ');
			f.smtp_port.focus();
			return false;
		}
		if (f.smtp_user.value == '')
		{
			alert('<?php echo _LANG('a1053','admin')?>    ');
			f.smtp_user.focus();
			return false;
		}
		if (f.smtp_pass.value == '')
		{
			alert('<?php echo _LANG('a1054','admin')?>    ');
			f.smtp_pass.focus();
			return false;
		}
	}
	if (id == 'ftpbtn')
	{
		if (f.ftp_host.value == '')
		{
			alert('<?php echo _LANG('a1055','admin')?>   ');
			f.ftp_host.focus();
			return false;
		}
		if (f.ftp_port.value == '')
		{
			alert('<?php echo _LANG('a1056','admin')?>    ');
			f.ftp_port.focus();
			return false;
		}
		if (f.ftp_user.value == '')
		{
			alert('<?php echo _LANG('a1057','admin')?>     ');
			f.ftp_user.focus();
			return false;
		}
		if (f.ftp_pass.value == '')
		{
			alert('<?php echo _LANG('a1058','admin')?>    ');
			f.ftp_pass.focus();
			return false;
		}
		if (f.ftp_rb.value == '')
		{
			alert('<?php echo _LANG('a1059','admin')?>    ');
			f.ftp_rb.focus();
			return false;
		}
	}
	submitFlag = true;
	f.a.value = 'email_check';
	f.type.value = id;
	getId(id).innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
	getIframeForAction(f);
	f.submit();
}
function ftp_select(obj)
{
	if (obj.value == '') obj.form.ftp_port.value = '21';
	else obj.form.ftp_port.value = '22';
}
function saveCheck(f)
{
	getIframeForAction(f);
	return confirm('<?php echo _LANG('a0001','admin')?>     ');
}
</script>
