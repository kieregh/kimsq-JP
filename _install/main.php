<?php
if(!defined('__KIMS__')) exit;
$sitelang = $sitelang ? $sitelang : 'english';
$_langfile = $g['path_root'].'_install/language/'.$sitelang.'/lang.install.php';
if (is_file($_langfile)) include $_langfile;
if(!is_file($g['path_root'].'LICENSE')):
include $g['path_root'].'_install/rss.func.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang['install']['flag']?>">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,target-densitydpi=medium-dpi">
		<meta name="apple-mobile-web-app-capable" content="no">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<title><?php echo _LANG('i001','install')?></title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link href="./_install/font-kimsq/css/font-kimsq.css" rel="stylesheet">
		<link href="./_install/main.css" rel="stylesheet">
		<script><?php include './_install/main.js'?></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</head>
	<body id="rb-body-install">
		<div class="container rb-ready">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h1 class="panel-title">
						<span id="_lang_" class="pull-right" style="margin-top: -4px">
							<select class="form-control input-sm" onchange="location.href='./index.php?sitelang='+this.value;">
							<?php $dirs = opendir($g['path_root'].'_install/language/')?>
							<?php while(false !== ($tpl = readdir($dirs))):?>
							<?php if($tpl=='.'||$tpl=='..')continue?>
							<option value="<?php echo $tpl?>"<?php if($sitelang==$tpl):?> selected<?php endif?> title="<?php echo $tpl?>"><?php echo implode('',file($g['path_root'].'_install/language/'.$tpl.'/name.txt'))?> &nbsp; </option>
							<?php endwhile?>
							<?php closedir($dirs)?>
							</select>
						</span>
						<i class="kf kf-bi-01 fa-lg"></i> Rb  <small>Installer</small>
					</h1>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3 text-center rb-symbol">
							<i class="kf kf-bi-05 hidden-xs"></i>
						</div>
						<div class="col-sm-9">
							<fieldset id="btn-group">
								<div class="form-group">
									<label><?php echo _LANG('i002','install')?></label>
									<select id="version" class="form-control input-lg">
									<?php echo getUrlData('http://www.kimsq.co.kr/__update/core/rb2-install-list-'.$sitelang.'.txt',10)?>
									</select>
									<p class="help-block">
										<?php echo _LANG('i003','install')?>
									</p>
								</div>
							  	<button type="submit" class="btn btn-primary btn-lg btn-block" onclick="getDownload(document.getElementById('btn-group'),document.getElementById('version'),'<?php echo $sitelang?>');"><?php echo _LANG('i004','install')?></button>
						  </fieldset>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<form action="./index.php" method="post" enctype="multipart/form-data" target="download_frame">
						<input type="hidden" name="install" value="download">
						<input type="hidden" name="version" value="1">
						<input type="hidden" name="sitelang" value="<?php echo $sitelang?>">
						<input type="file" name="upfile" id="upfile" class="hidden" onchange="getUploadPackage(this);">
					</form>
					<?php echo _LANG('i005','install')?>
					<button type="button" class="btn btn-link" onclick="document.getElementById('upfile').click();"><i class="fa fa-upload fa-fw"></i> <?php echo _LANG('i006','install')?></button>
				</div>
			</div>
		</div>
		<iframe name="download_frame" width="0" height="0" frameborder="0" scrolling="no"></iframe>
	</body>
</html>
<?php 
exit; 
endif;
$g['s'] = str_replace('/index.php','',$_SERVER['SCRIPT_NAME']);
$g['url_root'] = 'http'.($_SERVER['HTTPS']=='on'?'s':'').'://'.$_SERVER['HTTP_HOST'].$g['s'];
require $g['path_var'].'plugin.var.php';
require $g['path_core'].'function/sys.func.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang['install']['flag']?>">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,target-densitydpi=medium-dpi">
		<meta name="apple-mobile-web-app-capable" content="no">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<title><?php echo _LANG('i007','install')?></title>
		<?php getImport('bootstrap','css/bootstrap.min',false,'css')?>
		<?php getImport('font-awesome','css/font-awesome',false,'css')?> 
		<?php getImport('font-kimsq','css/font-kimsq',false,'css')?>
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script>
		var mbrclick= false;
		var rooturl = '<?php echo $g['url_root']?>';
		</script>
		<script src="./_core/js/sys.js"></script>
		<script><?php include './_install/main.js'?></script>
		<link href="./_install/main.css" rel="stylesheet">
		<?php getImport('bootbox','bootbox',false,'js')?>
	</head>
	<body id="rb-body-install">

		<div class="container">
			<div class="panel panel-default rb-installer">

				<div class="panel-heading">
					<h1 class="panel-title">
						<span id="_lang_" class="pull-right" style="margin-top: -4px">
							<select class="form-control input-sm" onchange="location.href='./index.php?sitelang='+this.value;">
							<?php $dirs = opendir($g['path_root'].'_install/language/')?>
							<?php while(false !== ($tpl = readdir($dirs))):?>
							<?php if($tpl=='.'||$tpl=='..')continue?>
							<option value="<?php echo $tpl?>"<?php if($sitelang==$tpl):?> selected<?php endif?> title="<?php echo $tpl?>"><?php echo implode('',file($g['path_root'].'_install/language/'.$tpl.'/name.txt'))?> &nbsp; </option>
							<?php endwhile?>
							<?php closedir($dirs)?>
							</select>
						</span>
						<i class="kf kf-bi-01 fa-lg"></i> Rb  <small>Installer</small>
					</h1>
				</div>

				<form name="procForm" class="form-horizontal" role="form" id="wizard" action="./" method="post" target="_action_frame_" onsubmit="return installCheck(this);">
					<input type="hidden" name="install" value="a.install">
					<input type="hidden" name="sitelang" value="<?php echo $sitelang?>">

					<div class="panel-body">
						<div class="row">

							<!-- 스텝 -->
							<div class="col-sm-3 side-steps hidden-xs">
								<div id="step-1" class="rb-active"><i class="fa fa-check-square-o fa-2x"></i><?php echo _LANG('i008','install')?></div>
								<div id="step-2"><i class="fa kf-dbmanager fa-2x"></i><?php echo _LANG('i009','install')?></div>
								<div id="step-3"><i class="fa fa-user fa-2x"></i><?php echo _LANG('i010','install')?></div>
								<div id="step-4"><i class="fa fa-home fa-2x"></i><?php echo _LANG('i011','install')?></div>
							</div>
							<div class="col-sm-9 rb-step-body">

								<!-- 라이선스 -->
								<div id="step-1-body">
									<div class="page-header visible-xs">
										<h3><i class="fa fa-check-square-o fa-lg fa-fw"></i> <?php echo _LANG('i012','install')?></h3>
									</div>
									<div class="form-group">
										<br>
										<label><?php echo _LANG('i013','install')?> <span class="label label-default">LGPL 3.0</span></label>
										<textarea class="form-control" rows="15"><?php readfile('LICENSE'.(is_file('LICENSE-'.$sitelang)?'-'.$sitelang:''))?></textarea>
									</div>

									<div class="checkbox">
										<label>
											<input type="checkbox" onclick="agreecheck(this);"> <strong><?php echo _LANG('i014','install')?></strong>
										</label>
									</div>
								</div>

								<!-- 데이터베이스 -->
								<div id="step-2-body" class="hidden">
		
									<div class="page-header visible-xs">
										<h3><i class="fa kf-dbmanager fa-lg fa-fw"></i> <?php echo _LANG('i015','install')?></h3>
									</div>

									<ul class="nav nav-pills">
										<li class="rb-active1" onclick="tabSelect(this,'db-info');"><a href="#."><?php echo _LANG('i016','install')?></a></li>
										<li onclick="tabSelect(this,'db-option');"><a href="#."><?php echo _LANG('i017','install')?></a></li>
									</ul>

									<div class="tab-panel" id="db-info">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i018','install')?> </label>
											<div class="col-sm-8">
												<select class="form-control" name="dbkind">
													<option>MySQL</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i019','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="dbname" value="<?php echo $_SESSION['_live_dbname']?>" placeholder="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i020','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="dbuser" value="<?php echo $_SESSION['_live_dbuser']?>" placeholder="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="password"><?php echo _LANG('i021','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="password" name="dbpass" value="<?php echo $_SESSION['_live_dbpass']?>" id="password">
											</div>
										</div>
									</div>	
									<div id="db-info-well" class="well">
										<i class="fa fa-info-circle fa-2x pull-left fa-border"></i>
										<small>
										<?php echo _LANG('i022','install')?>
										</small>
									</div>

									<div class="tab-panel hidden" id="db-option">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i023','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="dbhost" value="<?php echo $_SESSION['_live_dbhost']?$_SESSION['_live_dbhost']:'localhost'?>">
												<span class="help-block"><?php echo _LANG('i024','install')?></span>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i025','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="dbport" value="<?php echo $_SESSION['_live_dbport']?$_SESSION['_live_dbport']:'3306'?>">
												<span class="help-block"><?php echo _LANG('i026','install')?></span>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i027','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="dbhead" value="<?php echo $_SESSION['_live_dbhead']?$_SESSION['_live_dbhead']:'rb'?>">
												<span class="help-block"><?php echo _LANG('i028','install')?></span>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i029','install')?></label>
											<div class="col-sm-8">
												<select name="dbtype" class="form-control">
													<option>MyISAM</option>
													<option>InnoDB</option>
												</select>
												<span class="help-block"><?php echo _LANG('i030','install')?></span>
											</div>
										</div>
									</div>
									<div id="db-option-well" class="well hidden">
										<i class="fa fa-info-circle fa-2x pull-left fa-border"></i>
										<small>
										<?php echo _LANG('i031','install')?>
										</small>
									</div>
								</div>							

							
								<!-- 사용자 등록 -->
								<div id="step-3-body" class="hidden">

									<div class="page-header visible-xs">
										<h3><i class="fa fa-user fa-lg fa-fw"></i> <?php echo _LANG('i032','install')?></h3>
									</div>

									<ul class="nav nav-pills">
										<li class="rb-active1" onclick="tabSelect1(this,'user-info');"><a href="#."><?php echo _LANG('i033','install')?></a></li>
										<li onclick="tabSelect1(this,'user-option');"><a href="#."><?php echo _LANG('i034','install')?></a></li>
									</ul>
									<div class="tab-panel" id="user-info">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i035','install')?> </label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="name" value="<?php echo $_SESSION['_live_name']?>"  placeholder="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i036','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="email" name="email" value="<?php echo $_SESSION['_live_email']?>" placeholder="">
											</div>
										</div>		
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i037','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="id" value="<?php echo $_SESSION['_live_id']?>" placeholder="<?php echo _LANG('i038','install')?>">
												<span class="help-block"></span>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="password"><?php echo _LANG('i039','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="password" value="<?php echo $_SESSION['_live_pw']?>" name="pw0" placeholder="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="password2"><?php echo _LANG('i040','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="password" value="<?php echo $_SESSION['_live_pw']?>" name="pw1" placeholder="">
											</div>
										</div>
									</div>
									<div class="tab-panel hidden" id="user-option">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i041','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="nick" value="" placeholder="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i042','install')?></label>
											<div class="col-sm-8">
												<label class="radio-inline">
													<input type="radio" name="sex" value="1"> <?php echo _LANG('i043','install')?>
												</label>
												<label class="radio-inline">
													<input type="radio" name="sex" value="2"> <?php echo _LANG('i044','install')?>
												</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i045','install')?></label>
											<div class="col-sm-8">
												<div class="row rb-input-row">
													<div class="col-xs-4">
														<select name="birth_1" class="form-control">
														<option value="">Year</option>
														<?php for($i = date('Y'); $i > 1930; $i--):?>
														<option value="<?php echo $i?>"><?php echo $i?></option>
														<?php endfor?>
														</select>
													</div>
													<div class="col-xs-4">
														<select name="birth_2" class="form-control">
														<option value="">Month</option>
														<?php for($i = 1; $i < 13; $i++):?>
														<option value="<?php echo sprintf('%02d',$i)?>"><?php echo $i?></option>
														<?php endfor?>
														</select>
													</div>
													<div class="col-xs-4">
														<select name="birth_3" class="form-control">
														<option value="">Day</option>
														<?php for($i = 1; $i < 32; $i++):?>
														<option value="<?php echo sprintf('%02d',$i)?>"><?php echo $i?></option>
														<?php endfor?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"></label>
											<div class="col-sm-8">
												<div class="checkbox">
													<label>
														<input type="checkbox" name="birthtype" value="1">
														<?php echo _LANG('i046','install')?>
													</label>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i047','install')?></label>
											<div class="col-sm-8">
												<div class="row rb-input-row">
													<div class="col-xs-4">
														<select name="tel_1" class="form-control">
														<option value="010">010</option>
														<option value="011">011</option>
														<option value="016">016</option>
														<option value="017">017</option>
														<option value="018">018</option>
														<option value="019">019</option>
														</select>
													</div>
													<div class="col-xs-4">
														<input class="form-control" type="number" name="tel_2" value="" placeholder="">
													</div>
													<div class="col-xs-4">
														<input class="form-control" type="number" name="tel_3" value="" placeholder="">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="well">
										<i class="fa fa-info-circle fa-2x pull-left fa-border"></i>
										<small>
										<?php echo _LANG('i048','install')?>
										</small>
									</div>
								</div>


								<!-- 사이트 생성 -->
								<div id="step-4-body" class="hidden">

									<div class="page-header visible-xs">
										<h3><i class="fa fa-home fa-lg fa-fw"></i>  <?php echo _LANG('i049','install')?></h3>
									</div>

									<div class="tab-panel">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i050','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="sitename" value="<?php echo $_SESSION['_live_sitename']?>" placeholder="<?php echo _LANG('i051','install')?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i052','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="siteid" value="home" placeholder="">
												<div class="help-block">
													<?php echo _LANG('i053','install')?>
													<br>
													<code><?php echo $g['url_root']?>/<?php echo _LANG('i054','install')?></code>
												</div>
												<div class="checkbox">
													<label>
														<input type="checkbox" name="rewrite" value="1">
														<?php echo _LANG('i055','install')?>
													</label>
												</div>
												<div class="help-block">
													<?php echo _LANG('i056','install')?>
													<br>
													<code><?php echo $g['url_root']?>/?r=home&c=menu</code> <i class="glyphicon glyphicon-arrow-down"></i> <br>
													<code><?php echo $g['url_root']?>/home/c/menu</code>
												</div>
											</div>
										</div>
									</div>
									<div class="well">
										<i class="fa fa-info-circle fa-2x pull-left fa-border"></i>
										<small>
										<?php echo _LANG('i057','install')?>
										</small>
									</div>
								</div>

							</div>

						</div>

					</div>

					<div class="panel-footer clearfix">
						<button class="btn btn-default pull-left" type="button" id="_prev_btn_" onclick="stepCheck('prev');" disabled>
							<i class="fa fa-caret-left fa-lg"></i>&nbsp; <?php echo _LANG('i058','install')?></button>
						<button class="btn btn-primary pull-right" type="button" id="_next_btn_" onclick="stepCheck('next');" disabled>
							<?php echo _LANG('i059','install')?> &nbsp;<i class="fa fa-caret-right fa-lg"></i>
						</button>
					</div>

				</form>

			</div>
		</div>

		<iframe name="_action_frame_" width="0" height="0" frameborder="0" scrolling="no"></iframe>
	</body>
</html>
