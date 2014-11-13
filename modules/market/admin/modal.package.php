<?php $package_step = $package_step ? $package_step : 1?>
<div id="modal-package-install">
	<div class="modal-body">
		<ul>
			<li<?php if($package_step==1):?> class="active"<?php endif?>><span class="badge">Step 1</span> <span><?php echo _LANG('a4001','market')?></span></li>
			<li<?php if($package_step==2):?> class="active"<?php endif?>><span class="badge">Step 2</span> <span><?php echo _LANG('a4002','market')?></span></li>
			<li<?php if($package_step==3):?> class="active"<?php endif?>><span class="badge">Step 3</span> <span><?php echo _LANG('a4003','market')?></span></li>
		</ul>

		<div class="tab-content">
			<?php if($package_step==1):?>
			<form name="_upload_form_" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data">
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="m" value="<?php echo $module?>">
				<input type="hidden" name="a" value="add_package">
				<input type="hidden" name="package_step" value="<?php echo $package_step?>">
				<div id="tab1">
					<div class="row">
						<div class="col-sm-4 text-center rb-icon">
							<i class="fa fa-upload fa-3x"></i>
							<h4 class="text-center text-muted">
								<?php echo _LANG('a4004','market')?>
							</h4>
						</div>           
						<div class="col-sm-8">
							<div class="attach well form-horizontal">
								<div class="row">
									<div class="col-sm-3">
										<input type="file" name="upfile" id="packageupfile" class="hidden" onchange="progressbar();">
										<button type="button" class="btn btn-default" id="fileselectbtn" onclick="$('#packageupfile').click();"><?php echo _LANG('a4005','market')?></button>
									</div>
									<div class="col-sm-9" style="padding-top:7px">
										<div class="progress progress-striped active hidden" id="progress-bar">
											<div class="progress-bar" role="progressbar" aria-valuemax="100"></div>
										</div>
									</div>
								</div>
							</div>
							<ul>
							<li><?php echo _LANG('a4006','market')?></li>
							<li><?php echo _LANG('a4007','market')?></li>
							<li><?php echo _LANG('a4008','market')?></li>
							</ul>
						</div>
					</div>
				</form>
			</div>
			<?php endif?>

			<?php if($package_step==2):?>
			<?php include $g['path_tmp'].'app/'.$package_folder.'/_settings/var.php'?>
			<div id="tab2">
				<div class="row">
					<div class="col-sm-4 text-center rb-icon">
						<i class="fa fa-cube fa-3x"></i>
						<h4 class="text-center text-muted">
							<?php echo _LANG('a4009','market')?>
						</h4>
					</div>           
					<div class="col-sm-8">
						<form name="_upload_form_" action="<?php echo $g['s']?>/" method="post" class="form-horizontal" role="form">
							<input type="hidden" name="r" value="<?php echo $r?>">
							<input type="hidden" name="m" value="<?php echo $module?>">
							<input type="hidden" name="a" value="add_package">
							<input type="hidden" name="package_step" value="<?php echo $package_step?>">
							<input type="hidden" name="package_folder" value="<?php echo $package_folder?>">

							<div class="well">
								<div class="form-group">
									<label for="" class="col-sm-3 control-label"><?php echo _LANG('a4010','market')?></label>
									<div class="col-sm-9">
										<p class="form-control-static">
											<?php echo $d['package']['name']?>							
										</p>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-sm-3 control-label"><?php echo _LANG('a4011','market')?></label>
									<div class="col-sm-8">
										<select name="siteuid" class="form-control">
											<option value=""><?php echo _LANG('a4012','market')?></option>
											<option value="">-------------------------------</option>
											<?php $_SITES_ALL = getDbArray($table['s_site'],'','*','gid','asc',0,1)?>
											<?php while($_R = db_fetch_array($_SITES_ALL)):?>
											<option value="<?php echo $_R['uid']?>"><?php echo $_R['name']?></option>
											<?php endwhile?>
										</select>
										<span class="help-block"><?php echo _LANG('a4013','market')?></span>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<a class="collapsed" data-toggle="collapse" href="#package-options" onclick="detailCheck();"><i class="fa fa-cog"></i> <?php echo _LANG('a4014','market')?><span class="pull-right"></span></a>
								</div>


								<div class="panel-body collapse" id="package-options">
									<div class="form-group">
										<label class="col-sm-3 control-label"><?php echo _LANG('a4015','market')?></label>
										<div class="col-sm-9">
											<?php foreach($d['package']['execute'] as $_key => $_val):?>
											<div class="checkbox">
												<label>
													<input type="checkbox" name="ACT_<?php echo $_val[0]?>" value="1"<?php if($_val[2]):?> checked<?php endif?>>
													<?php echo $_val[1]?>
												</label>
											</div>
											<?php endforeach?>
										</div>
									</div>
									<?php if(is_file($g['path_tmp'].'app/'.$package_folder.'/_settings/readme.txt')):?>
									<div class="form-group">
										<label class="col-sm-3 control-label"><?php echo _LANG('a4016','market')?></label>
										<div class="col-sm-9">
											<?php readfile($g['path_tmp'].'app/'.$package_folder.'/_settings/readme.txt')?>
										</div>
									</div>
									<?php endif?>
								</div>


							</div>
						</form>
					</div>
				</div>
			</div>
			<?php endif?>

			<?php if($package_step==3):?>
			<div id="tab3">
				<div class="row">
					<div class="col-sm-4 text-center rb-icon">
						<i class="fa fa-home fa-3x"></i>
						<h4 class="text-center text-muted">
							<?php echo _LANG('a4017','market')?>
						</h4>
					</div>           
					<div class="col-sm-8">
						<div class="text-center">
							<br><br>
							<a href="<?php echo $g['s']?>/?r=<?php echo $siteid?>&amp;panel=Y" class="btn btn-primary btn-lg" target="_top"><i class="fa fa-share"></i> <?php echo _LANG('a4018','market')?></a>
							<br><br>
							<hr><?php echo sprintf(_LANG('a4019','market'),urldecode($package_name),urldecode($site_name))?>
						</div>
					</div>
				</div>
			</div>
			<?php endif?>

		</div>
	</div>
</div>


<!----------------------------------------------------------------------------
@부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->

<div id="_modal_header" class="hidden">
    <button type="button" class="close" onclick="frames._modal_iframe_modal_window.mClose();">&times;</button>
    <h4 class="modal-title"><i class="fa fa-plus-circle fa-lg"></i> Install KimsQ Package</h4>
</div>
<div id="_modal_footer" class="hidden">
	<?php if($package_step==3):?>
	<button type="button" class="btn btn-default pull-left" disabled><?php echo _LANG('a4997','market')?></button>
	<button type="button" class="btn btn-primary" disabled><?php echo _LANG('a4999','market')?></button>
	<?php else:?>
	<button type="button" class="btn btn-default pull-left" onclick="frames._modal_iframe_modal_window.mClose();"><?php echo _LANG('a4997','market')?></button>
	<?php if($package_step==2):?>
	<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window.install();"><?php echo _LANG('a4998','market')?></button>
	<?php endif?>
	<?php if($package_step==1):?>
	<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window.getFiles();" id="afterChooseFileNext" disabled><?php echo _LANG('a4998','market')?></button>
	<?php endif?>
	<?php endif?>
</div>

	
<script>
var _per = 0;
function progressbar()
{
	if(_per == 0) $('#progress-bar').removeClass('hidden');

	if (_per < 100)
	{
		_per = _per + 10;
		getId('progress-bar').children[0].style.width = (_per>100?100:_per)+ '%';
		setTimeout("progressbar();",100);
	}
	else {
		parent.getId('afterChooseFileNext').disabled = false;
	}
}
function detailCheck()
{
/*
	var h = document.body.scrollHeight;

	parent.getId('_modal_iframe_modal_window').style.height = (h+400)+'px'
	parent.getId('_modal_body_modal_window').style.height = (h+400)+'px';
*/
}
function nextStep()
{
	location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=admin&module=<?php echo $module?>&front=modal.package&package_type=<?php echo $package_type?>&&package_step=2';
}
function install()
{
	var f = document._upload_form_;
	getIframeForAction(f);
	f.submit();
	parent.getId('afterChooseFileNext').innerHTML = '<i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> Installing ...';
	parent.getId('afterChooseFileNext').disabled = true;
}
function getFiles()
{
	var f = document._upload_form_;
	if (f.upfile.value == '')
	{
		alert('<?php echo _LANG('a3024','market')?>   ');
		return false;
	}
	getIframeForAction(f);
	f.submit();
	parent.getId('afterChooseFileNext').innerHTML = '<i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> Uploading ...';
	parent.getId('afterChooseFileNext').disabled = true;
}
function mClose()
{
	location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $module?>&a=add_package&package_step=delete';
	parent.$('#modal_window').modal('hide');
}
function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.width = '100%';
	parent.getId('modal_window_dialog_modal_window').style.paddingRight = '20px';
	parent.getId('modal_window_dialog_modal_window').style.maxWidth = '800px';
	parent.getId('_modal_iframe_modal_window').style.height = '400px'
	parent.getId('_modal_body_modal_window').style.height = '400px';

	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_body_modal_window').style.padding = '0';
	parent.getId('_modal_body_modal_window').style.margin = '0';

	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
}
document.body.onresize = document.body.onload = function()
{
	setTimeout("modalSetting();",100);
	setTimeout("modalSetting();",200);
}
</script>


<style>
#rb-body {
	background-color: #fff;
}
#modal-package-install,
#modal-package-install h4 {
    font-family: 'Open Sans', "돋움", dotum !important;
} {
    font-family: 'Open Sans', "돋움", dotum !important;
}

#modal-package-install .modal-body {
    min-height: 400px;
    max-height: calc(100vh - 175px);
    overflow-y: auto;
    padding: 15px
}

#modal-package-install .tab-content {
    padding: 20px 0
}


/* breadcrumb */

#modal-package-install .breadcrumb {
    margin: -15px -15px 15px;
    border-radius: 0;
    padding: 10px 15px;
}

#modal-package-install .breadcrumb a {
    color: #999;
}

#modal-package-install .breadcrumb a:hover {
    text-decoration: none;
}

#modal-package-install .breadcrumb .active a{
    color: #428bca;
    font-weight: bold;
}

#modal-package-install .breadcrumb .badge {
    background-color: #999;
}

#modal-package-install .breadcrumb .active .badge {
    background-color: #428bca;
}


#modal-package-install h4 {
    line-height: 1.5
}

#modal-package-install .page-header {
    margin-top: 20px;
}

#modal-package-install .list-group {
    margin-bottom: 10px; 
}

#modal-package-install .rb-icon {
    font-size: 70px
}

#modal-package-install .label {
    display: inline;
    padding: .2em .6em .3em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25em;
}

#modal-package-install .pager {
    margin: 0; 
}


/* tab2 */

#tab2 .well {
    margin-bottom: 10px
}

#tab2 .panel-heading a {
    display: inline-block;
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
}

#tab2 .panel-heading a {
    color: #666;
    display: block;
}
#tab2 .panel-heading a:hover {
    text-decoration: none;
}

#tab2 .panel-heading span:before {
    content: " \f078";
}
#tab2 .panel-heading .collapsed span:before {
    content: " \f054";
}


/* responsive */

@media (min-width: 992px) {
    .modal-lg {
        width: 780px;
    }
}

@media (max-width: 768px) {

    #modal-package-install .breadcrumb .badge {
        padding: 5px 15px
    }

    #modal-package-install .breadcrumb .badge {
        font-size: 18px
    }

    #modal-package-install .rb-icon {
        font-size: 40px
    }

    #modal-package-install .tab-content {
        padding: 0
    }

    #tab1 .btn {
        display: block;
        width: 100%
    }
}


/* 김성호 */
#modal-package-install ul {
	padding: 0;
	margin: 0;
	list-style-type: none;
	background: #f5f5f5;
	padding: 10px 0 10px 30px;
	height: 40px;
}
#modal-package-install ul {
	color: #999;
}
#modal-package-install ul .active {
	font-weight:bold;
	color: #428BCA;
}
#modal-package-install ul .active .badge {
	background: #428BCA;
}
#modal-package-install ul li {
	float: left;
	margin-right: 15px;
}

#modal-package-install .modal-body {
	padding: 0;
}
#modal-package-install .tab-content {
	clear: both;
	padding: 40px 20px 0 20px;
}
#rb-body .tab-content {
	border: 0;
}
</style>
