<?php
if (!defined('__KIMS__') || !$my['admin']) exit;
$_MODULES = array();
$_MODULES_ALL = getDbArray($table['s_module'],'','*','gid','asc',0,1);
while($_R = db_fetch_array($_MODULES_ALL))
{
	$_MODULES['display'][] = $_R;
	$_MODULES['disp'.$_R['hidden']][] = $_R;
}

$_SITES = array();
$_SITES['list'] = array();
$_SITES_ALL = getDbArray($table['s_site'],'','*','gid','asc',0,1);
while($_R = db_fetch_array($_SITES_ALL))
{
	$_SITES['list'][] = $_R;
	$_SITES['count'.$_R['s004']]++;
}
$d['layout']['dom'] = array();
$_nowlayuotdir = dirname($_SESSION['setLayoutKind']?$_HS['m_layout']:$_HS['layout']);

$g['themelang1'] = $g['path_layout'].$_nowlayuotdir.'/_var/_var.config.php';
$g['themelang2'] = $g['path_layout'].$_nowlayuotdir.'/_languages/_var.config.'.$d['admin']['syslang'].'.php';
$g['layvarfile'] = $g['path_layout'].$_nowlayuotdir.'/_var/_var.php';

include getLangFile($g['path_module'].'admin/language/',$d['admin']['syslang'],'/lang.panel.php');
if (is_file($g['themelang2'])) include $g['themelang2'];
else if (is_file($g['themelang1'])) include $g['themelang1'];
if (is_file($g['layvarfile'])) include $g['layvarfile'];
$g['wcache'] = $d['admin']['cache_flag']?'?nFlag='.$date[$d['admin']['cache_flag']]:'';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang['admin']['flag']?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<meta name="robots" content="NOINDEX,NOFOLLOW">
<title><?php echo _LANG('p001','admin')?> (Rb V <?php echo $d['admin']['version']?>)</title>

<?php getImport('bootstrap','css/bootstrap.min',false,'css')?>
<?php getImport('bootstrap','css/bootstrap-theme.min',false,'css')?>

<?php getImport('jquery','jquery-'.$d['ov']['jquery'].'.min',false,'js')?>
<?php getImport('bootstrap','js/bootstrap.min',false,'js')?>

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $g['s']?>/_core/images/ico/apple-touch-icon-144-precomposed.png">
<link rel="shortcut icon" href="<?php echo $g['s']?>/_core/images/ico/favicon.ico">

<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
<?php getImport('font-awesome','css/font-awesome',false,'css')?> 
<?php getImport('font-kimsq','css/font-kimsq',false,'css')?> 

<link href="<?php echo $g['s']?>/_core/engine/adminpanel/main.css" rel="stylesheet">
<link href="<?php echo $g['s']?>/_core/engine/adminpanel/theme/<?php echo $d['admin']['pannellink']?>" rel="stylesheet">

<script>
var rooturl = '<?php echo $g['url_root']?>';
var rootssl = '<?php echo $g['ssl_root']?>';
var raccount= '<?php echo $r?>';
var moduleid= '<?php echo $m?>';
var memberid= '<?php echo $my['id']?>';
var is_admin= '<?php echo $my['admin']?>';
</script>

<script src="<?php echo $g['s']?>/_core/js/sys.js<?php echo $g['wcache']?>"></script>
</head>

<body>
<div class="container-fluid rb-fixed-sidebar<?php if($_COOKIE['_tabShow1']):?> rb-minified-sidebar<?php endif?><?php if($_COOKIE['_tabShow2']):?> rb-hidden-system-admin<?php endif?><?php if($_COOKIE['_tabShow3']):?> rb-hidden-system-site<?php endif?>">
	<div class="rb-system-sidebar rb-system-admin rb-inverse" role="navigation">
		<div class="rb-icons">
			<span class="rb-icon-hide" title="<?php echo $_COOKIE['_tabShow2']?_LANG('p002','admin'):_LANG('p003','admin')?>" data-tooltip="tooltip"><i class="fa rb-icon"></i></span> 
			<span class="rb-icon-minify" title="<?php echo $_COOKIE['_tabShow1']?_LANG('p004','admin'):_LANG('p005','admin')?>" data-tooltip="tooltip"><i class="fa rb-icon"></i></span>
		</div>
		<div class="login-info">
			<span class="dropdown">
				<a href="#" class="rb-username" data-toggle="dropdown">
					<img src="<?php echo $g['s']?>/_var/avatar/<?php echo $my['photo']?$my['photo']:'0.gif'?>" alt="" class="img-circle"> 
					<span><?php echo $my[$_HS['nametype']]?></span>
					<small id="rb-notification-name"></small>
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
					<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-profile"><i class="fa fa-user"></i> <?php echo _LANG('p006','admin')?></a></li>
					<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-log"><i class="fa fa-clock-o"></i> <?php echo _LANG('p007','admin')?></a></li>
					<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-notification"><i class="kf kf-notify"></i> <?php echo _LANG('p008','admin')?> <small id="rb-notification-badge" class="badge pull-right"></small></a></li>
					<li class="divider"></li>
					<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;a=logout"><i class="fa fa-sign-out"></i> <?php echo _LANG('p009','admin')?></a></li>
				</ul>
			</span>
		</div>
		<div class="tabs-below">
			<div class="rb-buttons rb-content-padded">
				<div class="btn-toolbar" role="toolbar">
					<div class="btn-group" title="<?php echo _LANG('p010','admin')?>" data-tooltip="tooltip">
						<button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus fa-2x"></i></button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=site&amp;type=makesite" target="_ADMPNL_"><i class="fa fa-home"></i> <?php echo _LANG('p011','admin')?></a></li>
							<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=site&amp;front=menu" target="_ADMPNL_"><i class="fa fa-sitemap"></i> <?php echo _LANG('p012','admin')?></a></li>
							<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=site&amp;front=page" target="_ADMPNL_"><i class="fa fa-file-text-o"></i> <?php echo _LANG('p013','admin')?></a></li>
							<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;a=clear_wcache" target="_ACTION_"><i class="fa fa-refresh"></i> <?php echo _LANG('p014','admin')?></a></li>
						</ul>
					</div>
					<div class="btn-group" title="<?php echo _LANG('p015','admin')?>" data-tooltip="tooltip">
						<button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-photo fa-2x"></i></button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-photo"><i class="fa fa-photo"></i> <?php echo _LANG('p016','admin')?></a></li>
							<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-video"><i class="glyphicon glyphicon-facetime-video"></i> <?php echo _LANG('p017','admin')?></a></li>
							<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-widgetcode"><i class="fa fa-puzzle-piece"></i> <?php echo _LANG('p018','admin')?></a></li>
							<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-snippet"><i class="fa fa-scissors" style="width:12px"></i> <?php echo _LANG('p076','admin')?></a></li>
						</ul>
					</div>
					<div class="btn-group">
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=dashboard" target="_ADMPNL_" class="btn btn-link" title="<?php echo _LANG('p019','admin')?>" data-tooltip="tooltip"><i class="fa fa-dashboard fa-2x"></i></a>
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>" target="_ADMPNL_" class="btn btn-link" title="<?php echo _LANG('p020','admin')?>" data-tooltip="tooltip"><i class="fa fa-home fa-2x"></i></a>
					</div>
				</div>
			</div>
			<div class="rb-buttons rb-content-padded">
				<div class="btn-group">
					<a data-toggle="modal" data-target="#modal_window" class="btn btn-default rb-modal-add-package" style="width:170px"><i class="fa fa-plus-circle fa-lg"></i> <?php echo _LANG('p021','admin')?></a>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu pull-right" role="menu">
						<li role="presentation" class="dropdown-header"><?php echo _LANG('p022','admin')?></li>
						<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-add-module"><?php echo _LANG('p023','admin')?></a></li>
						<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-add-layout"><?php echo _LANG('p024','admin')?></a></li>
						<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-add-widget"><?php echo _LANG('p025','admin')?></a></li>
						<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-add-switch"><?php echo _LANG('p026','admin')?></a></li>
						<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-add-plugin"><?php echo _LANG('p027','admin')?></a></li>
						<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-add-dashboard"><?php echo _LANG('p028','admin')?></a></li>
						<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-add-etc"><?php echo _LANG('p029','admin')?></a></li>
					</ul>
				</div>
			</div>

			<div class="tab-content">
				<div class="tab-pane<?php if(!$_COOKIE['sideBottomTab']||$_COOKIE['sideBottomTab']=='quick'):?> active<?php endif?>" id="sidebar-quick">
					<nav>
						<ul class="list-group" id="sidebar-quick-tree">
							<?php $_i=0;$d['amenu']=array()?>
							<?php foreach($_MODULES['disp0'] as $_SM1):?>
							<?php if(strpos('_'.$my['adm_view'],'['.$_SM1['id'].']')) continue?>
							<?php include getLangFile($g['path_module'].$_SM1['id'].'/language/',$d['admin']['syslang'],'/lang.admin-menu.php')?>
							<?php $d['afile']=$g['path_module'].$_SM1['id'].'/admin/var/var.menu.php'?>
							<?php if(is_file($d['afile'])) include $d['afile']?>
							<li id="sidebar-quick-<?php echo $_SM1['id']?>" class="list-group-item panel">
								<a<?php if(!is_file($d['afile'])):?> href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=<?php echo $_SM1['id']?>" target="_ADMPNL_"<?php else:?> data-toggle="collapse" data-parent="#sidebar-quick-tree" href="#sidebar-quick-tree-<?php echo $_SM1['id']?>"<?php endif?> class="collapsed" onclick="_quickSelect('<?php echo $_SM1['id']?>');">
									<i class="<?php echo $_SM1['icon']?$_SM1['icon']:'glyphicon glyphicon-th-large'?>"></i> 
									<span class="menu-item-parent"><?php echo $_SM1['name']?></span>
									<?php if(is_file($d['afile'])):?><b class="collapse-sign"><em class="fa rb-icon"></em></b><?php endif?>
								</a>
								<?php if(count($d['amenu'])):?>
								<ul id="sidebar-quick-tree-<?php echo $_SM1['id']?>" class="collapse">
								<?php foreach($d['amenu'] as $_k => $_v):?>
									<li id="sidebar-quick-tree-<?php echo $_SM1['id']?>-<?php echo $_k?>">
										<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&module=<?php echo $_SM1['id']?>&amp;front=<?php echo $_k?>" target="_ADMPNL_" onclick="_quickSelect1('<?php echo $_SM1['id']?>','<?php echo $_k?>');"><?php echo $_v?></a>
									</li>
								<?php endforeach?>
								</ul>
								<?php endif;$d['amenu']=array()?>
							</li>
							<?php endforeach?>
						</ul>
					</nav>
				</div>
				<div class="tab-pane<?php if($_COOKIE['sideBottomTab']=='modules'):?> active<?php endif?>" id="sidebar-modules">
					<nav>
						<ul class="list-group">
							<?php $_i=0?>
							<?php foreach($_MODULES['display'] as $_SM1):?>
							<?php if(strpos('_'.$my['adm_view'],'['.$_SM1['id'].']')) continue?>
							<li id="sidebar-modules-<?php echo $_SM1['id']?>" class="list-group-item panel">
								<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=<?php echo $_SM1['id']?>" target="_ADMPNL_" class="collapsed" onclick="_moduleSelect('<?php echo $_SM1['id']?>');">
									<i class="<?php echo $_SM1['icon']?$_SM1['icon']:'glyphicon glyphicon-th-large'?>"></i> 
									<span class="menu-item-parent"><?php echo $_SM1['name']?></span>
								</a>
							</li>
							<?php endforeach?>
						</ul>
					</nav>
				</div>
				<div class="tab-pane<?php if($_COOKIE['sideBottomTab']=='sites'):?> active<?php endif?>" id="sidebar-sites">
					<nav>
						<ul class="list-group">
							<?php foreach($_SITES['list'] as $S):?>
							<li id="sidebar-sites-<?php echo $S['id']?>" class="list-group-item<?php if($r==$S['id']):?> active<?php endif?>">
								<span class="pull-right rb-blank"><a href="<?php echo $g['s']?>/?r=<?php echo $S['id']?>&amp;panel=N" target="_blank" class="btn btn-link btn-sm"><i class="fa fa-share" data-tooltip="tooltip" title="<?php echo _LANG('p030','admin')?>"></i></a></span>
								<a href="<?php echo $g['s']?>/?r=<?php echo $S['id']?>&amp;panel=Y" class="rb-inframe">
									<i class="<?php echo $S['icon']?$S['icon']:'glyphicon glyphicon-home'?>"></i> 
									<span class="menu-item-parent"><?php echo $S['name']?></span>
									<?php if($S['s004']==2):?><span class="badge pull-right inbox-badge"><i class="fa fa-lock"></i></span><?php endif?>
									<?php if($S['s004']==3):?><span class="badge pull-right inbox-badge"><i class="fa fa-lock"></i></span><?php endif?>
								</a>
							</li>
							<?php endforeach?>
						</ul>	
					</nav>
				</div>
			</div>
			<ul class="nav nav-tabs nav-justified" role="tablist">
				<li<?php if(!$_COOKIE['sideBottomTab']||$_COOKIE['sideBottomTab']=='quick'):?> class="active"<?php endif?>><a href="#sidebar-quick" role="tab" data-toggle="tab" title="<?php echo _LANG('p031','admin')?>" data-tooltip="tooltip" onclick="_cookieSetting('sideBottomTab','quick');"><i class="kf kf-bi-05 fa-2x"></i></a></li>
				<li<?php if($_COOKIE['sideBottomTab']=='modules'):?> class="active"<?php endif?>><a href="#sidebar-modules" role="tab" data-toggle="tab" title="<?php echo _LANG('p032','admin')?>" data-tooltip="tooltip"><i class="kf kf-module fa-2x" onclick="_cookieSetting('sideBottomTab','modules');"></i></a></li>
				<li<?php if($_COOKIE['sideBottomTab']=='sites'):?> class="active"<?php endif?>><a href="#sidebar-sites" role="tab" data-toggle="tab" title="<?php echo _LANG('p033','admin')?>" data-tooltip="tooltip" onclick="_cookieSetting('sideBottomTab','sites');"><i class="kf kf-home fa-2x"></i></a></li>
			</ul>
		</div>
	</div>

	<div class="rb-system-main" role="main">
		<div class="rb-full-overlay">
			<div id="site-preview" class="rb-full-overlay-main">
				<div class="rb-table">
					<div class="rb-table-cell">
						<?php if($_admpnl_):?>
						<iframe id="_ADMPNL_" name="_ADMPNL_" src="<?php echo urldecode($_admpnl_)?>"></iframe>
						<?php else:?>
						<iframe id="_ADMPNL_" name="_ADMPNL_" src="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo ($pickmodule?'admin&amp;module='.$pickmodule:$m)?>"></iframe>
						<?php endif?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="rb-system-sidebar rb-system-site rb-default" role="application">
		<div class="rb-opener"><i class="fa fa-caret-left fa-lg"></i></div>
		<div class="rb-panel-top">
			<span class="rb-icon-hide" title="<?php echo $_COOKIE['_tabShow3']?_LANG('p002','admin'):_LANG('p003','admin')?>" data-tooltip="tooltip"><i class="fa rb-icon"></i></span>
		</div>
		<div class="rb-content-padded">
			<ul class="nav nav-tabs" role="tablist">
				<li<?php if($_COOKIE['rightAdmTab']=='site'||!$_COOKIE['rightAdmTab']):?> class="active"<?php endif?>><a href="#site-settings" role="tab" data-toggle="tab" onclick="_cookieSetting('rightAdmTab','site');">Site</a></li>
				<li<?php if($_COOKIE['rightAdmTab']=='layout'):?> class="active"<?php endif?>><a href="#layout-settings" role="tab" data-toggle="tab" onclick="_cookieSetting('rightAdmTab','layout');">Layout</a></li>
				<li<?php if($_COOKIE['rightAdmTab']=='emulator'):?> class="active"<?php endif?>><a href="#device-emulator" role="tab" data-toggle="tab" onclick="_cookieSetting('rightAdmTab','emulator');">Emulator</a></li>
			</ul>

			<div class="tab-content" style="padding-top:15px;">
				<div class="tab-pane<?php if($_COOKIE['rightAdmTab']=='site'||!$_COOKIE['rightAdmTab']):?> active<?php endif?><?php if(!$_HS['uid']):?> hidden<?php endif?>" id="site-settings">
					<form action="<?php echo $g['s']?>/" method="post" target="_ACTION_" onsubmit="return _siteInfoSaveCheck(this);">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="site">
					<input type="hidden" name="a" value="regissitepanel" />
					<input type="hidden" name="site_uid" value="<?php echo $_HS['uid']?>">
					<input type="hidden" name="layout" value="">
					<input type="hidden" name="m_layout" value="">
					<input type="hidden" name="referer" value="">

					<div class="panel-group rb-scrollbar" id="site-settings-panels">
						<div class="panel panel-primary" id="site-settings-01">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#site-settings-panels" href="#site-settings-01-body">
										<i></i><?php echo _LANG('p034','admin')?>
									</a>
								</h4>
							</div>
							<div id="site-settings-01-body" class="panel-collapse collapse in">
								<div class="panel-body">
									<div class="form-group">
										<label><?php echo _LANG('p035','admin')?></label>
										<input type="text" class="form-control" name="name" value="<?php echo $_HS['name']?>">
									</div>
									<div class="form-group">
										<label><?php echo _LANG('p037','admin')?></label>
										<input type="text" class="form-control" name="id" value="<?php echo $_HS['id']?>">
									</div>									
									<div class="form-group">
										<label><?php echo _LANG('p036','admin')?></label>
										<input type="text" class="form-control" name="title" value="<?php echo $_HS['title']?>">
										<span class="help-block"><small><?php echo _LANG('p039','admin')?></small></span>
									</div>
									<button type="submit" class="btn btn-primary btn-block"><?php echo _LANG('p038','admin')?></button>
								</div>
							</div>
						</div>

						<div class="panel panel-default" id="site-settings-02">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#site-settings-panels" href="#site-settings-02-body"><i></i><?php echo _LANG('p040','admin')?></a>
								</h4>
							</div>
							<div id="site-settings-02-body" class="panel-collapse collapse">
								<div class="panel-body">
									<div class="form-group">
										<label><?php echo _LANG('p041','admin')?></label>
										<div id="rb-layout-select">
											<select class="form-control" name="layout_1" required onchange="getSubLayout(this,'rb-layout-select2','layout_1_sub','');">
												<?php $_layoutExp1=explode('/',$_HS['layout'])?>
												<?php $dirs = opendir($g['path_layout'])?>
												<?php $_i=0;while(false !== ($tpl = readdir($dirs))):?>
												<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
												<?php if(!$_i&&!$_HS['layout']) $_layoutExp1[0] = $tpl?>
												<option value="<?php echo $tpl?>"<?php if($_layoutExp1[0]==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo $tpl?>)</option>

												<?php $_i++;endwhile?>
												<?php closedir($dirs)?>
											</select>
										</div>
										<div id="rb-layout-select2" style="margin-top:5px;">
											<select class="form-control" name="layout_1_sub"<?php if(!$_layoutExp1[0]):?> disabled<?php endif?>>
												<?php $dirs1 = opendir($g['path_layout'].$_layoutExp1[0])?>
												<?php while(false !== ($tpl1 = readdir($dirs1))):?>
												<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
												<option value="<?php echo $tpl1?>"<?php if($_layoutExp1[1]==$tpl1):?> selected<?php endif?>><?php echo str_replace('.php','',$tpl1)?></option>
												<?php endwhile?>
												<?php closedir($dirs1)?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label><?php echo _LANG('p042','admin')?></label>
										<div id="rb-mlayout-select">
											<select class="form-control" name="m_layout_1" required onchange="getSubLayout(this,'rb-mlayout-select2','m_layout_1_sub','');">
												<option value="0"><?php echo _LANG('p043','admin')?></option>
												<?php $_layoutExp2=explode('/',$_HS['m_layout'])?>
												<?php $dirs = opendir($g['path_layout'])?>
												<?php while(false !== ($tpl = readdir($dirs))):?>
												<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
												<option value="<?php echo $tpl?>"<?php if($_layoutExp2[0]==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo $tpl?>)</option>
												<?php endwhile?>
												<?php closedir($dirs)?>
											</select>
										</div>
										<div id="rb-mlayout-select2" style="margin-top:5px;">
											<select class="form-control" name="m_layout_1_sub"<?php if(!$_HS['m_layout']):?> disabled<?php endif?>>
												<?php if(!$_HS['m_layout']):?><option><?php echo _LANG('p044','admin')?></option><?php endif?>
												<?php $dirs1 = opendir($g['path_layout'].$_layoutExp2[0])?>
												<?php while(false !== ($tpl1 = readdir($dirs1))):?>
												<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
												<option value="<?php echo $tpl1?>"<?php if($_layoutExp2[1]==$tpl1):?> selected<?php endif?>><?php echo str_replace('.php','',$tpl1)?></option>
												<?php endwhile?>
												<?php closedir($dirs1)?>
											</select>
										</div>
									</div>
									<button type="submit" class="btn btn-primary btn-block"><?php echo _LANG('p038','admin')?></button>
								</div>
							</div>
						</div>

						<div class="panel panel-default" id="site-settings-03">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#site-settings-panels" href="#site-settings-03-body"><i></i><?php echo _LANG('p045','admin')?></a>
								</h4>
							</div>
							<div id="site-settings-03-body" class="panel-collapse collapse">
								<div class="panel-body">
									<div class="form-group">
										<label><?php echo _LANG('p042','admin')?></label>
										<select name="startpage" class="form-control">
										<option><?php echo _LANG('p047','admin')?></option>
										<option disabled><i class="fa fa-edit"></i><?php echo _LANG('p046','admin')?> ↓</option>
										<?php $PAGES1 = getDbArray($table['s_page'],'site='.$s.' and ismain=1','*','uid','asc',0,1)?>
										<?php while($S = db_fetch_array($PAGES1)):?>
										<option value="<?php echo $S['uid']?>"<?php if($_HS['startpage']==$S['uid']):?> selected<?php endif?>><?php echo $S['name']?>(<?php echo $S['id']?>)</option>
										<?php endwhile?>
										</select>
									</div>
									<div class="form-group">
										<label><?php echo _LANG('p042','admin')?></label>
										<select name="m_startpage" class="form-control">
										<option><?php echo _LANG('p047','admin')?></option>
										<option disabled><i class="fa fa-edit"></i><?php echo _LANG('p046','admin')?> ↓</option>
										<?php $PAGES2 = getDbArray($table['s_page'],'site='.$s.' and mobile=1','*','uid','asc',0,1)?>
										<?php while($S = db_fetch_array($PAGES2)):?>
										<option value="<?php echo $S['uid']?>"<?php if($_HS['m_startpage']==$S['uid']):?> selected<?php endif?>><?php echo $S['name']?>(<?php echo $S['id']?>)</option>
										<?php endwhile?>
										</select>
									</div>
									<button type="submit" class="btn btn-primary btn-block"><?php echo _LANG('p038','admin')?></button>
								</div>
							</div>
						</div>

						<div class="panel panel-default" id="site-settings-04">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#site-settings-panels" href="#site-settings-04-body"><i></i><?php echo _LANG('p048','admin')?></a>
								</h4>
							</div>
							<div id="site-settings-04-body" class="panel-collapse collapse">
								<div class="panel-body">
									<div class="form-group">
										<label><?php echo _LANG('p049','admin')?></label>
										<ul>
											<?php $DOMAINS = getDbArray($table['s_domain'],'site='.$_HS['uid'],'*','gid','asc',0,1)?>
											<?php $DOMAINN = db_num_rows($DOMAINS)?>
											<?php if($DOMAINN):?>
											<?php while($D=db_fetch_array($DOMAINS)):?>
											<li><a href="http://<?php echo $D['name']?>" target="_blank"><?php echo $D['name']?></a></li>
											<?php endwhile?>
											<?php else:?>
											<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=domain&amp;selsite=<?php echo $_HS['uid']?>&amp;type=makedomain" target="_ADMPNL_"><?php echo _LANG('p050','admin')?></a></li>
											<?php endif?>
										</ul>
									</div>	
									<div class="form-group">
										<label><?php echo _LANG('p051','admin')?></label>
										<select name="open" class="form-control">
										<option value="1"<?php if($_HS['s004']=='1'):?> selected="selected"<?php endif?>><?php echo _LANG('p052','admin')?></option>
										<option value="2"<?php if($_HS['s004']=='2'):?> selected="selected"<?php endif?>><?php echo _LANG('p053','admin')?></option>
										<option value="3"<?php if($_HS['s004']=='3'):?> selected="selected"<?php endif?>><?php echo _LANG('p054','admin')?></option>
										</select>
									</div>		
									<button type="submit" class="btn btn-primary btn-block"><?php echo _LANG('p038','admin')?></button>
								</div>
							</div>
						</div>
					</div>
					</form>

					<div class="well rb-tab-pane-bottom">
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=site" target="_ADMPNL_" class="btn btn-default btn-block"><?php echo _LANG('p055','admin')?></a>
					</div>
				</div>

				<div class="tab-pane<?php if($_COOKIE['rightAdmTab']=='layout'):?> active<?php endif?><?php if(!$_HS['uid']):?> hidden<?php endif?>" id="layout-settings">
					<form action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_ACTION_" onsubmit="return _layoutInfoSaveCheck(this);">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="site">
					<input type="hidden" name="a" value="regislayoutpanel">
					<input type="hidden" name="site_uid" value="<?php echo $_HS['uid']?>">
					<input type="hidden" name="layout" value="<?php echo $_nowlayuotdir?>">
					<input type="hidden" name="themelang1" value="<?php echo $g['themelang1']?>">
					<input type="hidden" name="themelang2" value="<?php echo $d['admin']['syslang']=='DEFAULT'||!is_file($g['themelang2'])?'':$g['themelang2']?>">

					<div class="panel-group rb-scrollbar" id="layout-settings-panels">
						<?php $_i=1;foreach($d['layout']['dom'] as $_key => $_val):$__i=sprintf('%02d',$_i)?>
						<div class="panel panel-<?php echo $_i==1?'primary':'default'?>" id="layout-settings-<?php echo $__i?>">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#layout-settings-panels" href="#layout-settings-<?php echo $__i?>-body">
										<i></i><?php echo $_val[0]?>
									</a>
								</h4>
							</div>
							<div id="layout-settings-<?php echo $__i?>-body" class="panel-collapse collapse<?php echo $_i==1?' in':''?>">
								<div class="panel-body">
									<p><?php echo $_val[1]?></p>
									
									<?php if(count($_val[2])):?>
									<?php foreach($_val[2] as $_v):?>
									<div class="form-group">
										<?php if($_v[1]!='hidden'):?>
										<label><?php echo $_v[2]?></label>
										<?php endif?>

										<?php if($_v[1]=='hidden'):?>
										<input type="hidden" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $d['layout'][$_key.'_'.$_v[0]]?>">
										<?php endif?>
										
										<?php if($_v[1]=='input'):?>
										<input type="text" class="form-control" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $d['layout'][$_key.'_'.$_v[0]]?>">
										<?php endif?>

										<?php if($_v[1]=='color'):?>
										<div class="input-group">
											<input type="text" class="form-control" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" id="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $d['layout'][$_key.'_'.$_v[0]]?>">
											<span class="input-group-btn">
												<button class="btn btn-default" type="button" data-toggle="modal" data-target=".bs-example-modal-sm" onclick="getColorLayer(getId('layout_<?php echo $_key?>_<?php echo $_v[0]?>').value.replace('#',''),'layout_<?php echo $_key?>_<?php echo $_v[0]?>');"><i class="glyphicon glyphicon-tint"></i></button>
											</span>
										</div>
										<?php endif?>

										<?php if($_v[1]=='date'):?>
										<div class="input-group input-daterange">
											<input type="text" class="form-control" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" id="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $d['layout'][$_key.'_'.$_v[0]]?>">
											<span class="input-group-btn">
												<button class="btn btn-default" type="button" onclick="getCalCheck('<?php echo $_key?>_<?php echo $_v[0]?>');"><i class="glyphicon glyphicon-calendar"></i></button>
											</span>
										</div>
										<?php endif?>

										<?php if($_v[1]=='mediaset'):?>
										<div class="input-group">
											<input type="text" class="form-control rb-modal-photo-drop" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" id="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $d['layout'][$_key.'_'.$_v[0]]?>" onmousedown="_mediasetField='layout_<?php echo $_key?>_<?php echo $_v[0]?>&dfiles='+this.value;" title="<?php echo _LANG('p056','admin')?>" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window">
											<span class="input-group-btn">
												<button onmousedown="_mediasetField='layout_<?php echo $_key?>_<?php echo $_v[0]?>';" class="btn btn-default rb-modal-photo-drop" type="button" title="<?php echo _LANG('p016','admin')?>" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window"><i class="glyphicon glyphicon-picture"></i></button>
											</span>
										</div>
										<?php endif?>

										<?php if($_v[1]=='videoset'):?>
										<div class="input-group">
											<input type="text" class="form-control rb-modal-video-drop" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" id="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $d['layout'][$_key.'_'.$_v[0]]?>" onmousedown="_mediasetField='layout_<?php echo $_key?>_<?php echo $_v[0]?>&dfiles='+this.value;" title="<?php echo _LANG('p057','admin')?>" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window">
											<span class="input-group-btn">
												<button onmousedown="_mediasetField='layout_<?php echo $_key?>_<?php echo $_v[0]?>';" class="btn btn-default rb-modal-video-drop" type="button" title="<?php echo _LANG('p017','admin')?>" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window"><i class="glyphicon glyphicon-facetime-video"></i></button>
											</span>
										</div>
										<?php endif?>

										<?php if($_v[1]=='file'):?>
										<div class="input-group">
											<input type="text" class="form-control" id="layout_<?php echo $_key?>_<?php echo $_v[0]?>_name" value="<?php echo $d['layout'][$_key.'_'.$_v[0]]?>" onclick="$('#layout_<?php echo $_key?>_<?php echo $_v[0]?>').click();">
											<input type="file" class="hidden" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" id="layout_<?php echo $_key?>_<?php echo $_v[0]?>" onchange="getId('layout_<?php echo $_key?>_<?php echo $_v[0]?>_name').value='<?php echo _LANG('p058','admin')?>';">
											<span class="input-group-btn">
												<button class="btn btn-default" type="button" onclick="$('#layout_<?php echo $_key?>_<?php echo $_v[0]?>').click();"><i class="glyphicon glyphicon-picture"></i></button>
											</span>
										</div>
										<?php if($d['layout'][$_key.'_'.$_v[0]]):?>
										<div style="padding:3px 0 0 2px;"><input type="checkbox" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>_del" value="1"> <?php echo _LANG('p059','admin')?></div>
										<?php endif?>
										<?php endif?>
										
										<?php if($_v[1]=='textarea'):?>
										<textarea type="text" rows="<?php echo $_v[3]?>" class="form-control" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>"><?php echo $d['layout'][$_key.'_'.$_v[0]]?></textarea>
										<?php endif?>

										<?php if($_v[1]=='select'):?>
										<select name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" class="form-control">
											<?php $_sk=explode(',',$_v[3])?>
											<?php foreach($_sk as $_sa):?>
											<?php $_sa1=explode('=',$_sa)?>
											<option value="<?php echo $_sa1[1]?>"<?php if($d['layout'][$_key.'_'.$_v[0]] == $_sa1[1]):?> selected<?php endif?>><?php echo $_sa1[0]?></option>
											<?php endforeach?>
										</select>
										<?php endif?>

										<?php if($_v[1]=='radio'):?>
										<?php $_sk=explode(',',$_v[3])?>
										<?php foreach($_sk as $_sa):?>
										<?php $_sa1=explode('=',$_sa)?>
										<label class="rb-rabel"><input type="radio" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $_sa1[1]?>"<?php if($d['layout'][$_key.'_'.$_v[0]] == $_sa1[1]):?> checked<?php endif?>> <?php echo $_sa1[0]?></label>
										<?php endforeach?>
										<?php endif?>

										<?php if($_v[1]=='checkbox'):?>
										<?php $_sk=explode(',',$_v[3])?>
										<?php foreach($_sk as $_sa):?>
										<?php $_sa1=explode('=',$_sa)?>
										<label class="rb-rabel"><input type="checkbox" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>_chk[]" value="<?php echo $_sa1[1]?>"<?php if(strstr($d['layout'][$_key.'_'.$_v[0]],$_sa1[1])):?> checked<?php endif?>> <?php echo $_sa1[0]?></label>
										<?php endforeach?>
										<?php endif?>

									</div>
									<?php endforeach?>

									<button type="submit" class="btn btn-primary btn-block"><?php echo _LANG('p038','admin')?></button>
									<?php endif?>

								</div>
							</div>
						</div>
						<?php $_i++;endforeach?>

						<?php if($_i==1):?>
						<div class="panel panel-primary" id="layout-settings-01">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#layout-settings-panels" href="#layout-settings-01-body"><i></i><?php echo _LANG('p060','admin')?></a>
								</h4>
							</div>
							<div id="layout-settings-01-body" class="panel-collapse collapse in">
								<div class="panel-body">
									<p><?php echo _LANG('p061','admin')?></p>
								</div>
							</div>
						</div>
						<div class="panel panel-default" id="layout-settings-02">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#layout-settings-panels" href="#layout-settings-02-body"><i></i><?php echo _LANG('p062','admin')?></a>
								</h4>
							</div>
							<div id="layout-settings-02-body" class="panel-collapse collapse">
								<div class="panel-body">
									<p><?php echo _LANG('p063','admin')?></p>
								</div>
							</div>
						</div>
						<?php endif?>
					</div>

					<div class="well rb-tab-pane-bottom">
						<div class="form-group">
							<label class="sr-only"><small><?php echo _LANG('p064','admin')?></small></label>
							<select class="form-control" onchange="layoutChange(this);">
								<option value=""><?php echo _LANG('p065','admin')?></option>
								<?php if($_HS['m_layout']):?><option value="1"<?php if($_SESSION['setLayoutKind']):?> selected<?php endif?>><?php echo _LANG('p066','admin')?></option><?php endif?>
							</select>
						</div>
					</div>
					</form>
				</div>

				<div class="tab-pane<?php if($_COOKIE['rightAdmTab']=='emulator'):?> active<?php endif?>" id="device-emulator">
					<div class="btn-group rb-device-buttons clearfix" data-toggle="buttons">
						<label class="btn btn-default rb-btn-desktop<?php if($_COOKIE['rightemulTab']=='desktop'||!$_COOKIE['rightemulTab']):?> active<?php endif?>" title="Desktop" data-toggle="tooltip">
							<input type="radio" name="options" id="rightemulTab_desktop" checked> <i class="fa fa-desktop fa-3x"></i><br>Desktop
						</label>
						<label class="btn btn-default rb-btn-tablet<?php if($_COOKIE['rightemulTab']=='tablet'):?> active<?php endif?>" title="Tablet" data-toggle="tooltip">
							<input type="radio" name="options" id="rightemulTab_tablet"> <i class="fa fa-tablet fa-3x"></i><br>Tablet
						</label>
						<label class="btn btn-default rb-btn-mobile<?php if($_COOKIE['rightemulTab']=='mobile'):?> active<?php endif?>" title="Mobile" data-toggle="tooltip">
							<input type="radio" name="options" id="rightemulTab_mobile"> <i class="fa fa-mobile fa-3x"></i><br>phone
						</label>
					</div>

					<fieldset id="deviceshape"<?php if(!$_COOKIE['rightemulTab'] || $_COOKIE['rightemulTab'] == 'desktop'):?> disabled<?php endif?>>
						<div class="btn-group clearfix btn-group-justified" data-toggle="buttons">
							<label id="deviceshape_1" class="btn btn-default<?php if(!$_COOKIE['rightemulDir'] || $_COOKIE['rightemulDir'] == '1'):?> active<?php endif?>" title="Potrait" onclick="_deviceshape(1);">
								<input type="radio" name="deviceshape"><i class="fa fa-rotate-left fa-lg"></i> <?php echo _LANG('p068','admin')?>
							</label>
							<label id="deviceshape_2" class="btn btn-default<?php if($_COOKIE['rightemulDir'] == '2'):?> active<?php endif?>" title="Landscape" onclick="_deviceshape(2);">
								<input type="radio" name="deviceshape"> <i class="fa fa-rotate-right fa-lg"></i> <?php echo _LANG('p067','admin')?>
							</label>
						</div>
					</fieldset>

					<div class="rb-scrollbar" id="emuldevices">
					    <table class="table table-striped table-hover">
					        <thead>
					            <tr>
					                <th class="rb-name"><?php echo _LANG('p069','admin')?></th>
					                <th class="rb-brand"><?php echo _LANG('p070','admin')?></th>
					                <th class="rb-viewport"><?php echo _LANG('p071','admin')?></th>
					            </tr>
					        </thead>
					        <tbody>
								<?php $d['magent']= file($g['path_var'].'mobile.agent.txt')?>
								<?php $_i=0;foreach($d['magent'] as $_line):if($_i):if(!trim($_line))continue;$_val=explode(',',trim($_line));$_scSize=explode('*',$_val[2])?>
								<?php if(!$_firstPhone[0]&&$_val[3]=='phone'){$_firstPhone[0]=$_i;$_firstPhone[1]=$_scSize[0];$_firstPhone[2]=$_scSize[1];}?>
								<?php if(!$_firstTablet[0]&&$_val[3]=='tablet'){$_firstTablet[0]=$_i;$_firstTablet[1]=$_scSize[1];$_firstTablet[2]=$_scSize[0];}?>
					            <tr id="emdevice_<?php echo $_i?>" onclick="_emuldevice(this,'<?php echo $_val[2]?>','<?php echo $_val[3]?>');">
					                <td class="rb-name" title="<?php echo $_val[3]?>" data-tooltip="tooltip"><?php echo $_val[0]?></td>
					                <td class="rb-brand"><?php echo $_val[1]?></td>
					                <td class="rb-viewport"><?php echo $_scSize[0]?><var>x</var><?php echo $_scSize[1]?></td>
					            </tr>
								<?php endif;$_i++;endforeach?>
					        </tbody>
					    </table>
					</div>

					<div class="well rb-tab-pane-bottom rb-form">
						<ul class="list-group">
							<li class="list-group-item">
								<fieldset>
									<div class="checkbox">
										<label>
											<input type="checkbox"<?php if($g['mobile']):?> checked<?php endif?> onclick="viewbyMobileDevice(this);"> <i></i><small><?php echo _LANG('p072','admin')?></small>
											<span class="fa fa-question-circle" style="position:relative;" data-popover="popover" title="<?php echo _LANG('p073','admin')?>" data-content="<small><?php echo _LANG('p074','admin')?></small>"></span>
										</label>
									</div>
								</fieldset>
							</li>
							<li class="list-group-item">
								<div class="input-group input-group-sm">
									<input id="outlink_url" type="text" class="form-control" placeholder="http://" onkeypress="getOuturl(0);">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button" data-tooltip="tooltip" title="Go" onclick="getOuturl(1);">Go!</button>
									</span>
								</div>
							</li>
							<li class="list-group-item">
								<small><i class="fa fa-info-circle fa-4x pull-left"></i><?php echo _LANG('p075','admin')?></small>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<nav class="navbar navbar-default navbar-fixed-bottom visible-xs" style="border-top:#efefef solid 1px;">
	<div class="container">
		<div class="btn-group">
			<div class="login-info">
				<span class="dropdown" style="top:5px;">
					<a href="#" class="rb-username" data-toggle="dropdown">
						<img src="<?php echo $g['s']?>/_var/avatar/<?php echo $my['photo']?$my['photo']:'0.gif'?>" alt="" class="img-circle"> 
						<span style="width:105px;overflow:hidden;color:#666;">
							<span>
								<?php echo $my[$_HS['nametype']]?>
							</span>
							<span class="caret"></span>
						</span>
					</a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
					<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-profile"><i class="fa fa-user" style="padding-top:3px;padding-bottom:3px;"></i> <?php echo _LANG('p006','admin')?></a></li>
					<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-log"><i class="fa fa-clock-o" style="padding-top:3px;padding-bottom:3px;"></i> <?php echo _LANG('p007','admin')?></a></li>
					<li class="divider"></li>
					<li style="padding-bottom:3px;"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;a=logout"><i class="fa fa-sign-out"></i> <?php echo _LANG('p009','admin')?></a></li>
					</ul>
				</span>
			</div>
		</div>
		<div class="btn-group pull-right">
			<div class="btn-group dropup">
				<a class="btn btn-link" data-toggle="dropdown" style="font-size:21px;top:4px;">
					<i class="kf kf-bi-06"></i>
				</a>
				<ul class="dropdown-menu rb-device-bottom" role="menu" style="max-height:400px;overflow:auto;left:-55px;">
				<?php $_i=0;$_dmnum=count($_MODULES['disp0'])-1;foreach($_MODULES['disp0'] as $_SM1):?>
				<?php if(strpos('_'.$my['adm_view'],'['.$_SM1['id'].']')) continue?>
				<li style="padding-top:5px;padding-bottom:4px;<?php if($_i<$_dmnum):?>border-bottom:#dfdfdf solid 1px;<?php endif?>">
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=<?php echo $_SM1['id']?>" target="_ADMPNL_">
						<i class="<?php echo $_SM1['icon']?$_SM1['icon']:'fa-th-large'?>"></i> 
						<span class="menu-item-parent"><?php echo $_SM1['name']?></span>
					</a>
				</li>
				<?php $_i++;endforeach?>
				</ul>
			</div>
			<div class="btn-group dropup">
				<?php $_smnum=count($_SITES['list'])-1?>
				<a href="<?php echo $g['s']?>/?r=<?php echo $r?>" target="_ADMPNL_" class="btn btn-link"<?php if($_smnum):?> data-toggle="dropdown"<?php endif?> style="top:4px;">
					<i class="fa fa-home fa-2x"></i>
				</a>
				<?php if($_smnum):?>
				<ul class="dropdown-menu rb-device-bottom" role="menu" style="max-height:400px;overflow:auto;left:-55px;">
				<?php $_i=0;foreach($_SITES['list'] as $S):?>
				<li id="bottombar-sites-<?php echo $S['id']?>"<?php if($r==$S['id']):?> class="active<?php endif?>">
					<a href="<?php echo $g['s']?>/?r=<?php echo $S['id']?>&amp;panel=Y" style="padding-top:7px;padding-bottom:6px;<?php if($_i<$_smnum):?>border-bottom:#dfdfdf solid 1px;<?php endif?>">
						<i class="<?php echo $S['icon']?$S['icon']:'glyphicon glyphicon-home'?>"></i> &nbsp;
						<span class="menu-item-parent" style="position:absolute;width:100px;overflow:hidden;"><?php echo $S['name']?></span>
					</a>
				</li>
				<?php $_i++;endforeach?>
				</ul>
				<?php endif?>
				<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=dashboard&amp;front=mobile.shortcut" target="_ADMPNL_" class="btn btn-link" style="font-size:22px;top:2px;">
					<i class="glyphicon glyphicon-th"></i>
				</a>
			</div>
		</div>
	</div>
</nav>



<script>
var _mediasetField='';
$(document).ready(function(){
	$(".rb-system-admin .rb-icon-minify").click(function(){
		$(".container-fluid").toggleClass("rb-minified-sidebar");
		if ($(".container-fluid").hasClass("rb-minified-sidebar")) 
		{ 
			$(".rb-system-sidebar .rb-icon-minify").attr("data-original-title", "<?php echo _LANG('p004','admin')?>"); 
		} else 
		{ 
			$(".rb-system-sidebar .rb-icon-minify").attr("data-original-title", "<?php echo _LANG('p005','admin')?>");	 
		}
		if(getCookie('_tabShow1')=='') setCookie('_tabShow1',1,1);
		else setCookie('_tabShow1','',1);
	});

	$(".rb-system-admin .rb-icon-hide").click(function(){
		$(".container-fluid").toggleClass("rb-hidden-system-admin");
		if ($(".container-fluid").hasClass("rb-hidden-system-admin")) 
		{ 
			$(".rb-system-sidebar .rb-icon-hide").attr("data-original-title", "<?php echo _LANG('p002','admin')?>"); 
		}
		else 
		{ 
			$(".rb-system-sidebar .rb-icon-hide").attr("data-original-title", "<?php echo _LANG('p003','admin')?>");	 
		} 
		if(getCookie('_tabShow2')=='') setCookie('_tabShow2',1,1);
		else setCookie('_tabShow2','',1);
	});

	$(".rb-system-site .rb-icon-hide").click(function(){
		$(".container-fluid").toggleClass("rb-hidden-system-site");
		
		if ($(".container-fluid").hasClass("rb-hidden-system-site")) 
		{ 
			$(".rb-system-site .rb-icon-hide").attr("data-original-title", "<?php echo _LANG('p002','admin')?>"); 
		}
		else 
		{ 
			$(".rb-system-site .rb-icon-hide").attr("data-original-title", "<?php echo _LANG('p003','admin')?>");	 
		}
		if(getCookie('_tabShow3')=='') setCookie('_tabShow3',1,1);
		else setCookie('_tabShow3','',1);
	});

	$('body').tooltip({
		selector: '[data-tooltip=tooltip]',
		placement : 'auto',
		html: 'true',
		container: 'body'
	});
	$('body').popover({
		selector: '[data-popover=popover]',
		placement : 'auto',
		html: 'true',
		trigger: 'hover',
		container: 'body',
	});
	if(navigator.userAgent.indexOf("Mac") > 0) {
		$("body").addClass("mac-os");
	}

	$(".rb-btn-desktop").click(function(){
		getId('_ADMPNL_').style.display = '';
		getId('_ADMPNL_').style.width = '';
		getId('_ADMPNL_').style.height = '';
		setCookie('rightemulTab','desktop',1);
		$("#emuldevices tr").removeClass("active");
		$(".rb-full-overlay-main").removeClass( "mobile tablet" ).addClass( "desktop" );
		getId('deviceshape').disabled = true;
		_nowSelectedDevice = '';
	});

	$(".rb-btn-tablet").click(function(){
		setCookie('rightemulTab','tablet',1);
		setCookie('rightemulDir',2,1);
		$("#emuldevices tr").removeClass("active");
		$("#emdevice_<?php echo $_firstTablet[0]?>").addClass("active");
		$("#deviceshape_1").removeClass("active");
		$("#deviceshape_2").addClass("active");
		$(".rb-full-overlay-main").removeClass( "desktop mobile" ).addClass( "tablet" );
		getId('_ADMPNL_').style.display = 'block';
		getId('_ADMPNL_').style.width = '<?php echo $_firstTablet[2]?>px';
		getId('_ADMPNL_').style.height = '<?php echo $_firstTablet[1]?>px';
		getId('deviceshape').disabled = false;
		_nowSelectedDevice = 'emdevice_<?php echo $_firstTablet[0]?>';
	});

	$(".rb-btn-mobile").click(function(){
		setCookie('rightemulTab','mobile',1);
		setCookie('rightemulDir',1,1);
		$("#emuldevices tr").removeClass("active");
		$("#emdevice_<?php echo $_firstPhone[0]?>").addClass("active");
		$("#deviceshape_1").addClass("active");
		$("#deviceshape_2").removeClass("active");
		$(".rb-full-overlay-main").removeClass( "desktop tablet" ).addClass( "mobile" );
		getId('_ADMPNL_').style.display = 'block';
		getId('_ADMPNL_').style.width = '<?php echo $_firstPhone[1]?>px';
		getId('_ADMPNL_').style.height = '<?php echo $_firstPhone[2]?>px';
		getId('deviceshape').disabled = false;
		_nowSelectedDevice = 'emdevice_<?php echo $_firstPhone[0]?>';
	});

	<?php if($_COOKIE['rightemulTab'] && $_COOKIE['rightemulTab'] != 'desktop'):?>
	$(".rb-btn-<?php echo $_COOKIE['rightemulTab']?>").click();
	<?php else:?>
	getId('deviceshape').disabled = true;
	<?php endif?>

	$('.rb-modal-profile').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=admin&amp;front=modal.admininfo&amp;uid='.$my['uid'].'&amp;tab=info')?>');
	});
	$('.rb-modal-log').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=admin&amp;front=modal.admininfo&amp;uid='.$my['uid'].'&amp;tab=log')?>');
	});
	$('.rb-modal-notification').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.notification')?>');//&amp;callMod=view
	});
	$('.rb-modal-photo').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media')?>');
	});
	$('.rb-modal-video').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.video.media')?>');
	});
	$('.rb-modal-photo-drop').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=')?>'+_mediasetField);
	});
	$('.rb-modal-video-drop').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.video.media&amp;dropfield=')?>'+_mediasetField);
	});
	$('.rb-modal-widgetcode').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.widget&amp;isWcode=Y')?>');
	});
	$('.rb-modal-add-package').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=market&amp;front=modal.package')?>');
	});
	$('.rb-modal-add-module').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=market&amp;front=modal.add&amp;addType=module')?>');
	});
	$('.rb-modal-add-layout').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=market&amp;front=modal.add&amp;addType=layout')?>');
	});
	$('.rb-modal-add-widget').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=market&amp;front=modal.add&amp;addType=widget')?>');
	});
	$('.rb-modal-add-switch').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=market&amp;front=modal.add&amp;addType=switch')?>');
	});
	$('.rb-modal-add-plugin').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=market&amp;front=modal.add&amp;addType=plugin')?>');
	});
	$('.rb-modal-add-dashboard').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=market&amp;front=modal.add&amp;addType=dashboard')?>');
	});
	$('.rb-modal-add-etc').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=market&amp;front=modal.add&amp;addType=etc')?>');
	});
	$('.rb-modal-snippet').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.snippet')?>');
	});
});
var _nowSelectedDevice = '';
function _emuldevice(obj,size,type)
{
	var s = size.split('*');
	type = type == 'phone' ? 'mobile' : type;
	setCookie('rightemulTab',type,1);
	$(".rb-device-buttons label").removeClass( "active" );
	$(".rb-btn-"+type).addClass( "active" );
	$(".rb-full-overlay-main").removeClass( "desktop" ).removeClass( "tablet" ).removeClass( "mobile" ).addClass( type );
	$("#emuldevices tr").removeClass("active");
	$("#"+obj.id).addClass("active");
	getId('deviceshape').disabled = false;

	getId('_ADMPNL_').style.display = 'block';
	if(getCookie('rightemulDir') == '2')
	{
		if (type == 'mobile')
		{
			getId('_ADMPNL_').style.width = s[1]+'px';
			getId('_ADMPNL_').style.height = s[0]+'px';
		}
		else {
			getId('_ADMPNL_').style.width = s[0]+'px';
			getId('_ADMPNL_').style.height = s[1]+'px';
		}
	}
	else {
		if (type == 'mobile')
		{
			getId('_ADMPNL_').style.width = s[0]+'px';
			getId('_ADMPNL_').style.height = s[1]+'px';
		}
		else {
			getId('_ADMPNL_').style.width = s[1]+'px';
			getId('_ADMPNL_').style.height = s[0]+'px';
		}
	}
	_nowSelectedDevice = obj.id;
}
function _deviceshape(n)
{
	setCookie('rightemulDir',n,1);
	$("#"+_nowSelectedDevice).click();
}
function _quickSelect(id)
{	
	$("#sidebar-quick .list-group-item").removeClass("active");
	$("#sidebar-quick-"+id).addClass("active");
}
function _quickSelect1(id,_k)
{	
	$("#sidebar-quick-tree-"+id+" li").removeClass("active");
	$("#sidebar-quick-tree-"+id+"-"+_k).addClass("active");
}
function _siteSelect(id)
{	
	$(".rb-device-bottom li").removeClass("active");
	$("#bottombar-sites-"+id).addClass("active");
}
function _moduleSelect(id)
{	
	$("#sidebar-modules .list-group-item").removeClass("active");
	$("#sidebar-modules-"+id).addClass("active");
}
function _cookieSetting(name,tab)
{
	setCookie(name,tab,1);
}
function _siteInfoSaveCheck(f)
{
	f.layout.value = f.layout_1.value + '/' + f.layout_1_sub.value;
	if(f.m_layout_1.value != '0') f.m_layout.value = f.m_layout_1.value + '/' + f.m_layout_1_sub.value;
	else f.m_layout.value = '';
	f.referer.value = frames._ADMPNL_.location.href;
	return confirm('정말로 변경하시겠습니까?    ');
}
function _layoutInfoSaveCheck(f)
{
	return confirm('정말로 변경하시겠습니까?    ');
}
function getOuturl(n)
{
	if (n == 0)
	{
		if(event.keyCode != 13) return false;
	}
	if (getId('outlink_url').value != '')
	{
		var url = 'http://' + getId('outlink_url').value.replace('http://');
		frames._ADMPNL_.location.href = url;
	}
}
function viewbyMobileDevice(obj)
{
	frames._ACTION_.location.href = rooturl + '/?a=sessionsetting&target=parent.frames._ADMPNL_.&name=pcmode&value=' + (obj.checked ? 'E' : '');
}
function layoutChange(obj)
{
	frames._ACTION_.location.href = rooturl + '/?a=sessionsetting&target=parent.&name=setLayoutKind&value=' + obj.value;
}
function getColorLayer(color,layer)
{
	getId('_small_modal_').innerHTML = '<iframe id="_small_modal_iframe_" src="<?php echo $g['s']?>/_core/opensrc/colorjack/color.php?color='+color+'&dropf='+layer+'&callback=" frameborder="0" scrolling="no"></iframe>';
}
function _small_modal_close_()
{
	$('.bs-example-modal-sm').modal('s003');
}
$('#site-settings-01-body').on('show.bs.collapse', function () {
  $("#site-settings-01").addClass("panel-primary").removeClass("panel-default");
});

$('#site-settings-01-body').on('hide.bs.collapse', function () {
  $("#site-settings-01").addClass("panel-default").removeClass("panel-primary");
});

$('#site-settings-02-body').on('show.bs.collapse', function () {
  $("#site-settings-02").addClass("panel-primary").removeClass("panel-default");
});

$('#site-settings-02-body').on('hide.bs.collapse', function () {
  $("#site-settings-02").addClass("panel-default").removeClass("panel-primary");
});


$('#site-settings-03-body').on('show.bs.collapse', function () {
  $("#site-settings-03").addClass("panel-primary").removeClass("panel-default");
});

$('#site-settings-03-body').on('hide.bs.collapse', function () {
  $("#site-settings-03").addClass("panel-default").removeClass("panel-primary");
});

$('#site-settings-04-body').on('show.bs.collapse', function () {
  $("#site-settings-04").addClass("panel-primary").removeClass("panel-default");
});

$('#site-settings-04-body').on('hide.bs.collapse', function () {
  $("#site-settings-04").addClass("panel-default").removeClass("panel-primary");
});

$('#layout-settings-01-body').on('show.bs.collapse', function () {
  $("#layout-settings-01").addClass("panel-primary").removeClass("panel-default");
});

$('#layout-settings-01-body').on('hide.bs.collapse', function () {
  $("#layout-settings-01").addClass("panel-default").removeClass("panel-primary");
});

$('#layout-settings-02-body').on('show.bs.collapse', function () {
  $("#layout-settings-02").addClass("panel-primary").removeClass("panel-default");
});

$('#layout-settings-02-body').on('hide.bs.collapse', function () {
  $("#layout-settings-02").addClass("panel-default").removeClass("panel-primary");
});

$('#layout-settings-03-body').on('show.bs.collapse', function () {
  $("#layout-settings-03").addClass("panel-primary").removeClass("panel-default");
});

$('#layout-settings-03-body').on('hide.bs.collapse', function () {
  $("#layout-settings-03").addClass("panel-default").removeClass("panel-primary");
});

$('#layout-settings-04-body').on('show.bs.collapse', function () {
  $("#layout-settings-04").addClass("panel-primary").removeClass("panel-default");
});

$('#layout-settings-04-body').on('hide.bs.collapse', function () {
  $("#layout-settings-04").addClass("panel-default").removeClass("panel-primary");
});

$('#layout-settings-05-body').on('show.bs.collapse', function () {
  $("#layout-settings-05").addClass("panel-primary").removeClass("panel-default");
});

$('#layout-settings-05-body').on('hide.bs.collapse', function () {
  $("#layout-settings-05").addClass("panel-default").removeClass("panel-primary");
});


$('#layout-settings-06-body').on('show.bs.collapse', function () {
  $("#layout-settings-06").addClass("panel-primary").removeClass("panel-default");
});

$('#layout-settings-06-body').on('hide.bs.collapse', function () {
  $("#layout-settings-06").addClass("panel-default").removeClass("panel-primary");
});

$('#layout-settings-07-body').on('show.bs.collapse', function () {
  $("#layout-settings-07").addClass("panel-primary").removeClass("panel-default");
});

$('#layout-settings-07-body').on('hide.bs.collapse', function () {
  $("#layout-settings-07").addClass("panel-default").removeClass("panel-primary");
});
</script>

<?php if($d['layout']['date']):?>
<?php getImport('bootstrap-datepicker','css/datepicker3',false,'css')?>
<?php getImport('bootstrap-datepicker','js/bootstrap-datepicker',false,'js')?>
<?php getImport('bootstrap-datepicker','js/locales/bootstrap-datepicker.kr',false,'js')?>
<script>
$('.input-daterange').datepicker({
format: "yyyy/mm/dd",
todayBtn: "linked",
language: "kr",
calendarWeeks: true,
todayHighlight: true,
autoclose: true
});
function getCalCheck(layer)
{
	$('#layout_'+layer).focus();
}
</script>
<?php endif?>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true"><div id="_small_modal_body_" class="modal-dialog modal-sm"><div class="modal-content" id="_small_modal_"></div></div></div>
<div id="_box_layer_"></div>
<div id="_action_layer_"></div>
<div id="_hidden_layer_"></div>
<div id="_overLayer_"></div>
<iframe id="_ACTION_" name="_ACTION_" class="hidden"></iframe>
</body>
</html>
