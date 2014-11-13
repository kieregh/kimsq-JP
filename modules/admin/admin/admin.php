<?php
$R=array();
$mtype = $mtype  ? $mtype  : 'admin';
$recnum= $recnum ? $recnum : 10;
$sendsql= 'admin='.($mtype=='admin'?1:0);
$RCD = getDbArray($table['s_mbrdata'],$sendsql,'*','memberuid','asc',$recnum,$p);
$NUM = getDbRows($table['s_mbrdata'],$sendsql);
$TPG = getTotalPage($NUM,$recnum);
$_authset = array('',_LANG('aa001','admin'),_LANG('aa002','admin'),_LANG('aa003','admin'),_LANG('aa004','admin'));
?>


<div id="admin-users">
	<div class="page-header">
		<h4><?php echo _LANG('aa005','admin')?></h4>
	</div>
	<form name="listForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return false;">
	<input type="hidden" name="r" value="<?php echo $r?>">
	<input type="hidden" name="m" value="<?php echo $module?>">
	<input type="hidden" name="a" value="">
	<input type="hidden" name="auth" value="">

	<div class="panel panel-default">
		<div class="panel-heading clearfix">
			<label class="pull-left">
				<span class="dropdown">
					<a href="#" class="btn btn-default rb-username" data-toggle="dropdown">
						<span><?php echo $mtype=='admin'?_LANG('aa006','admin'):_LANG('aa007','admin')?> <?php echo sprintf(_LANG('aa008','admin'),$NUM)?></span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
						<li><a href="<?php echo $g['adm_href']?>&amp;mtype=admin"><i class="fa fa-user"></i> <?php echo _LANG('aa006','admin')?></a></li>
						<li><a href="<?php echo $g['adm_href']?>&amp;mtype=member"><i class="fa fa-user"></i> <?php echo _LANG('aa007','admin')?></a></li>
					</ul>
				</span>
			</label>

			<div class="btn-group pull-right">
				<button type="button" class="btn btn-default"<?php if($p-1<1):?> disabled<?php endif?> data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo _LANG('aa009','admin')?>" onclick="location.href=getPageGo(<?php echo $p-1?>,0);"><i class="fa fa-chevron-left fa-lg"></i></button>
				<button type="button" class="btn btn-default"<?php if($p+1>$TPG):?> disabled<?php endif?> data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo _LANG('aa010','admin')?>" onclick="location.href=getPageGo(<?php echo $p+1?>,0);"><i class="fa fa-chevron-right fa-lg"></i></button>
			</div>
		</div>
		
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th><label><input type="checkbox" id="checkAll-admin-user"></label></th>
						<th><?php echo _LANG('aa011','admin')?></th>
						<th><?php echo _LANG('aa012','admin')?></th>
						<th><?php echo _LANG('aa013','admin')?></th>
						<th><?php echo _LANG('aa014','admin')?></th>
						<th><?php echo _LANG('aa015','admin')?></th>
						<th><?php echo _LANG('aa016','admin')?></th>
						<th><?php echo _LANG('aa017','admin')?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $_P=array()?>
					<?php while($R=db_fetch_array($RCD)):?>
					<?php $_R=getUidData($table['s_mbrid'],$R['memberuid'])?>
					<?php if($R['memberuid']==$uid)$_P=$R?>
					<tr>
						<?php if($R['memberuid']==1):?>
						<td><input type="checkbox" disabled="disabled"></td>
						<?php else:?>
						<td class="side1"><input type="checkbox" name="mbrmembers[]" value="<?php echo $R['memberuid']?>" class="rb-admin-user" onclick="checkboxCheck();"></td>
						<?php endif?>
						<td><?php echo $_authset[$R['auth']]?></td>
						<?php if($R['now_log']):?>
						<td><small class="label label-primary" data-tooltip="tooltip" title="<?php echo _LANG('aa018','admin')?>"><?php echo $R['admin']?($R['adm_view']?_LANG('aa021','admin'):_LANG('aa020','admin')):_LANG('aa007','admin')?></small></td>
						<?php else:?>
						<td><small class="label label-default" data-tooltip="tooltip" title="<?php echo _LANG('aa019','admin')?>"><?php echo $R['admin']?($R['adm_view']?_LANG('aa021','admin'):_LANG('aa020','admin')):_LANG('aa007','admin')?></small></td>
						<?php endif?>

						<td><a href="#." data-toggle="modal" data-target="#modal_window" class="rb-modal-admininfo" onmousedown="admIdDrop('<?php echo $R['memberuid']?>','');"><?php echo $R['name']?></a></td>
						<td><?php echo $R['nic']?></td>
						<td><?php echo $_R['id']?></td>
						<td><?php echo $R['tel2']?$R['tel2']:$R['tel1']?></td>
						<td data-tooltip="tooltip" title="<?php echo getDateFormat($R['last_log'],$lang['admin']['aa022'])?>"><?php echo sprintf(_LANG('aa023','admin'),-getRemainDate($R['last_log']))?></td>
						<td>
						<?php if($my['uid']==1 && $R['admin']):?>
						<a href="#." data-toggle="modal" data-target="#modal_window" class="btn btn-default btn-xs rb-modal-admininfo" onmousedown="admIdDrop('<?php echo $R['memberuid']?>','perm');"<?php if($R['memberuid']==1):?> disabled<?php endif?>><?php echo _LANG('aa024','admin')?></a>
						<?php endif?>
						<a href="#." data-toggle="modal" data-target="#modal_window" class="btn btn-default btn-xs rb-modal-admininfo" onmousedown="admIdDrop('<?php echo $R['memberuid']?>','info');"><?php echo _LANG('aa025','admin')?></a>
						</td>
					</tr>
					<?php endwhile?>
				</tbody>
			</table>
		</div>

		<div class="panel-footer clearfix">
			<div class="row">
				<div class="col-sm-3">
					<div class="btn-group">
						<fieldset id="rb-action-btn" disabled>
							<div class="btn-group">
								<div class="btn-group dropup">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-wrench"></i> <?php echo _LANG('aa026','admin')?> <span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li role="presentation" class="dropdown-header"><?php echo _LANG('aa027','admin')?></li>
										<li><a href="#" onclick="actQue('admin_delete','4');"><?php echo _LANG('aa004','admin')?></a></li>
										<li><a href="#" onclick="actQue('admin_delete','1');"><?php echo _LANG('aa001','admin')?></a></li>
										<li><a href="#" onclick="actQue('admin_delete','3');"><?php echo _LANG('aa003','admin')?></a></li>
										<li><a href="#" onclick="actQue('admin_delete','2');"><?php echo _LANG('aa002','admin')?></a></li>
										<li class="divider"></li>
										<?php if($mtype=='admin'):?>
										<li><a href="#" onclick="actQue('admin_delete','');"><?php echo _LANG('aa028','admin')?></a></li>
										<?php else:?>
										<li><a href="#" onclick="actQue('admin_delete','A');"><?php echo _LANG('aa029','admin')?></a></li>
										<?php endif?>
										<li><a href="#" onclick="actQue('admin_delete','D');"><span class="text-danger"><?php echo _LANG('aa030','admin')?></span></a></li>
									</ul>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="btn-group">
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-admin-add"><i class="fa fa-plus-circle"></i> <?php echo $mtype=='admin'?_LANG('aa031','admin'):_LANG('aa032','admin')?></button>
					</div>
				</div>
			</div>
		</div>
	</div>	
	</form>
</div>








<!-- 회원추가 모달 -->
<div class="modal fade" id="modal-admin-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="procForm" class="form-horizontal" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" onsubmit="return saveCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="admin_member_add">
			<input type="hidden" name="check_id" value="0">
			<input type="hidden" name="check_nic" value="0">
			<input type="hidden" name="check_email" value="0">
			<?php if($mtype=='admin'):?>
			<input type="hidden" name="admin" value="1">
			<?php endif?>

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title"><?php echo $mtype=='admin'?_LANG('aa031','admin'):_LANG('aa032','admin')?></h4>
			</div>
			<div class="modal-body">
	
				<div class="form-group rb-outside">
					<label for="inputEmail3" class="col-sm-2 control-label"><?php echo _LANG('aa015','admin')?></label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="text" class="form-control" name="id" placeholder="<?php echo _LANG('aa033','admin')?>" value="" maxlength="12" autofocus onchange="sendCheck('rb-idcheck','id');">
							<span class="input-group-btn">
								<button type="button" class="btn btn-default" id="rb-idcheck" onclick="sendCheck('rb-idcheck','id');"><?php echo _LANG('aa034','admin')?></button>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo _LANG('aa035','admin')?></label>
					<div class="col-sm-9">
						<input type="password" class="form-control" name="pw1" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-9">
						<input type="password" class="form-control" name="pw2" placeholder="">
					</div>
				</div>
				<hr>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label"><?php echo _LANG('aa036','admin')?></label>
					<div class="col-sm-9">
						<div class="media">
							<span class="pull-left">
								<img class="media-object img-circle" src="<?php echo $g['s']?>/_var/avatar/0.gif" alt="" style="width:45px">
							</span>
							<div class="media-body">
								<input type="file" name="upfile" class="hidden" id="rb-upfile-avatar" accept="image/jpg" onchange="getId('rb-photo-btn').innerHTML='<?php echo _LANG('aa037','admin')?>';">
								<button type="button" class="btn btn-default" onclick="$('#rb-upfile-avatar').click();" id="rb-photo-btn"><?php echo _LANG('aa038','admin')?></button>
								<small class="help-block"><?php echo _LANG('aa039','admin')?></small>
							</div>
						</div>
					</div>		
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo _LANG('aa013','admin')?></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="name" placeholder="<?php echo _LANG('aa040','admin')?>" value="<?php echo $regis_name?>" maxlength="10">
					</div>
				</div>
				<div class="form-group rb-outside">
					<label class="col-sm-2 control-label"><?php echo _LANG('aa014','admin')?></label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="text" class="form-control" name="nic" placeholder="<?php echo _LANG('aa041','admin')?>" value="" maxlength="20" onchange="sendCheck('rb-nickcheck','nic');">
							<span class="input-group-btn">
								<button type="button" class="btn btn-default" id="rb-nickcheck" onclick="sendCheck('rb-nickcheck','nic');"><?php echo _LANG('aa034','admin')?></button>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group rb-outside">
					<label class="col-sm-2 control-label"><?php echo _LANG('aa042','admin')?></label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="email" class="form-control" name="email" placeholder="<?php echo _LANG('aa043','admin')?>" value="" onchange="sendCheck('rb-emailcheck','email');">
							<span class="input-group-btn">
								<button type="button" class="btn btn-default" id="rb-emailcheck" onclick="sendCheck('rb-emailcheck','email');"><?php echo _LANG('aa034','admin')?></button>
							</span>
						</div>
						<p class="form-control-static"><small class="text-muted"><?php echo _LANG('aa044','admin')?></small></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo _LANG('aa016','admin')?></label>
					<div class="col-sm-9">
						<input type="tel" class="form-control" name="tel2" placeholder="<?php echo _LANG('aa045','admin')?>" value="">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo _LANG('aa046','admin')?></button>
				<button type="submit" class="btn btn-primary"><?php echo _LANG('aa047','admin')?></button>
			</div>
		</form>
		<form name="actionform" action="<?php echo $g['s']?>/" method="post">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="admin_member_add_check">
			<input type="hidden" name="type" value="">
			<input type="hidden" name="fvalue" value="">
		</form>
		</div>
	</div>
</div>

<!-- bootstrap Validator -->
<?php getImport('bootstrap-validator','dist/css/bootstrapValidator.min',false,'css')?>
<?php getImport('bootstrap-validator','dist/js/bootstrapValidator.min',false,'js')?>
<script>
$(document).ready(function() {
    $('.form-horizontal').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },

        fields: {
            id: {
                validators: {
                    notEmpty: {
                        message: '<?php echo _LANG('aa048','admin')?>'
                    },
                    regexp: {
                        regexp: /^[a-z0-9]+$/,
                        message: '<?php echo _LANG('aa049','admin')?>'
                    }
                }
            },
            pw1: {
                message: 'The password is not valid',
                validators: {
                    notEmpty: {
                        message: '<?php echo _LANG('aa050','admin')?>'
                    }
                }
            },

            pw2: {
                message: 'The password is not valid',
                validators: {
                    notEmpty: {
                        message: '<?php echo _LANG('aa051','admin')?>'
                    }
                }
            },
            name: {
                message: 'The name is not valid',
                validators: {
                    notEmpty: {
                        message: '<?php echo _LANG('aa052','admin')?>'
                    }
                }
            },
            nic: {
                message: 'The name is not valid',
                validators: {
                    notEmpty: {
                        message: '<?php echo _LANG('aa053','admin')?>'
                    }
                }
            },
            email: {
                message: '',
                validators: {
                    notEmpty: {
                        message: '<?php echo _LANG('aa054','admin')?>'
                    }
                }
            },
        }
    });
});
</script>

<!-- basic -->
<script>
var _admModalUid;
var _admModalMod;
function admIdDrop(uid,mod)
{
	_admModalUid = uid;
	_admModalMod = mod;
}
var submitFlag = false;
function sendCheck(id,t)
{
	var f = document.actionform;
	var f1 = document.procForm;

	if (submitFlag == true)
	{
		alert('<?php echo _LANG('aa055','admin')?>');
		return false;
	}
	if (eval("f1."+t).value == '')
	{
		eval("f1."+t).focus();
		return false;
	}
	f.type.value = t;
	f.fvalue.value = eval("f1."+t).value;
	getId(id).innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
	getIframeForAction(f);
	f.submit();
	submitFlag = true;
}
function saveCheck(f)
{
	if (f.pw1.value != f.pw2.value)
	{
		alert('<?php echo _LANG('aa056','admin')?>');
		return false;
	}
	getIframeForAction(f);
	return true;
}
function actQue(flag,ah)
{
	var f = document.listForm;
    var l = document.getElementsByName('mbrmembers[]');
    var n = l.length;
    var i;
	var j=0;
	
	if (flag == 'admin_delete')
	{
		for	(i = 0; i < n; i++)
		{
			if (l[i].checked == true)
			{
				j++;
			}
		}
		if (!j)
		{
			alert('<?php echo _LANG('aa057','admin')?>     ');
			return false;
		}

		if (confirm('<?php echo _LANG('a0001','admin')?>      '))
		{
			getIframeForAction(f);
			f.a.value = flag;
			f.auth.value = ah;
			f.submit();
		}
	}
	return false;
}
function checkboxCheck()
{
	var f = document.listForm;
    var l = document.getElementsByName('mbrmembers[]');
    var n = l.length;
    var i;
	var j=0;

	for	(i = 0; i < n; i++)
	{
		if (l[i].checked == true) j++;
	}
	if (j) getId('rb-action-btn').disabled = false;
	else getId('rb-action-btn').disabled = true;
}
$("#checkAll-admin-user").click(function(){
	$(".rb-admin-user").prop("checked",$("#checkAll-admin-user").prop("checked"));
	checkboxCheck();
});
$('.rb-modal-admininfo').on('click',function() {
	modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=admin&amp;front=modal.admininfo&amp;uid=')?>'+_admModalUid+'&amp;tab='+_admModalMod);
});
</script>
