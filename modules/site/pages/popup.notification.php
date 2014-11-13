<?php 
include $g['path_module'].'notification/var/var.php';
if($callMod == 'config')
{
	$NT_DATA = explode('|',$my['noticeconf']);
	$nt_rcv = $NT_DATA[0];
	$nt_rcvtype = $NT_DATA[1];
	$nt_rcvdel = $NT_DATA[2];
	$nt_modules = getArrayString($NT_DATA[3]);
	$nt_members = getArrayString($NT_DATA[4]);
	$nt_email = $NT_DATA[5];
	$_SESSION['sh_notify_auto_del'] = '';
	$_SESSION['sh_notify_popup'] = '';
}
else if ($callMod == 'view')
{
	$recnum = 1000;
	$NUM = getDbRows($table['s_notice'],'mbruid='.$my['uid']);
	$TPG = getTotalPage($NUM,$recnum);
}
?>

<div id="rb-modal-body">
	<?php if($callMod == 'config'):?>
	<div class="callMod-config">
		<form name="procForm" class="form-horizontal" action="<?php echo $g['s']?>/" method="post">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="notification">
		<input type="hidden" name="a" value="notice_config_user">

		<div class="well">
			<i class="glyphicon glyphicon-info-sign fa-2x pull-left"></i> 
			<small>
				<?php echo _LANG('s8001','site')?><br>
			</small>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label"><?php echo _LANG('s8002','site')?></label>
			<div class="col-sm-10">
				<div class="btn-toolbar">
					<div class="btn-group btn-group-justified" data-toggle="buttons">
						<label class="btn <?php if($nt_rcv==''):?>btn-primary active<?php else:?>btn-default<?php endif?>" onclick="btnCheck(this);">
							<input type="radio" value="" name="nt_rcv"<?php if($nt_rcv==''):?> checked<?php endif?>> <?php echo _LANG('s8003','site')?>
						</label>
						<label class="btn <?php if($nt_rcv=='1'):?>btn-primary active<?php else:?>btn-default<?php endif?>" onclick="btnCheck(this);">
							<input type="radio" value="1" name="nt_rcv"<?php if($nt_rcv=='1'):?> checked<?php endif?>> <?php echo _LANG('s8004','site')?>
						</label>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label"><?php echo _LANG('s8005','site')?></label>
			<div class="col-sm-10">
				<div class="btn-toolbar">
					<div class="btn-group btn-group-justified" data-toggle="buttons">
						<label class="btn <?php if($nt_rcvtype==''):?>btn-primary active<?php else:?>btn-default<?php endif?>" onclick="btnCheck(this);">
							<input type="radio" value="" name="nt_rcvtype"<?php if($nt_rcvtype==''):?> checked<?php endif?>> <?php echo _LANG('s8006','site')?>
						</label>
						<label class="btn <?php if($nt_rcvtype=='1'):?>btn-primary active<?php else:?>btn-default<?php endif?>" onclick="btnCheck(this);">
							<input type="radio" value="1" name="nt_rcvtype"<?php if($nt_rcvtype=='1'):?> checked<?php endif?>> <?php echo _LANG('s8007','site')?>
						</label>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label"><?php echo _LANG('s8008','site')?></label>
			<div class="col-sm-10">
				<div class="btn-toolbar">
					<div class="btn-group btn-group-justified" data-toggle="buttons">
						<label class="btn <?php if($nt_email=='1'):?>btn-primary active<?php else:?>btn-default<?php endif?>" onclick="btnCheck(this);">
							<input type="radio" value="1" name="nt_email"<?php if($nt_email=='1'):?> checked<?php endif?>> <?php echo _LANG('s8009','site')?>
						</label>
						<label class="btn <?php if($nt_email==''):?>btn-primary active<?php else:?>btn-default<?php endif?>" onclick="btnCheck(this);">
							<input type="radio" value="" name="nt_email"<?php if($nt_email==''):?> checked<?php endif?>> <?php echo _LANG('s8010','site')?>
						</label>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label"><?php echo _LANG('s8011','site')?></label>
			<div class="col-sm-10">
				<div class="btn-toolbar">
					<div class="btn-group btn-group-justified" data-toggle="buttons">
						<label class="btn <?php if($nt_rcvdel=='1'):?>btn-primary active<?php else:?>btn-default<?php endif?>" onclick="btnCheck(this);">
							<input type="radio" value="1" name="nt_rcvdel"<?php if($nt_rcvdel=='1'):?> checked<?php endif?>> <?php echo _LANG('s8012','site')?>
						</label>
						<label class="btn <?php if($nt_rcvdel==''):?>btn-primary active<?php else:?>btn-default<?php endif?>" onclick="btnCheck(this);">
							<input type="radio" value="" name="nt_rcvdel"<?php if($nt_rcvdel==''):?> checked<?php endif?>> <?php echo _LANG('s8013','site')?>
						</label>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo _LANG('s8014','site')?></label>
			<div class="col-sm-10">
				<div class="rb-tbl-box">
					<table class="table table-hover">
						<thead>
							<tr>
								<th class="rb-tbl-left"><span><?php echo _LANG('s8015','site')?></span></th>
								<th class="rb-tbl-right"><?php echo _LANG('s8016','site')?></th>
							</tr>
						</thead>
					</table>
					<div class="rb-tbl-box1">
						<table class="table">
							<tbody>

								<?php foreach($nt_modules['data'] as $_md):?>
								<?php $_R=getDbData($table['s_module'],"id='".$_md."'",'*')?>
								<tr>
									<td class="rb-tbl-left">
										<span>
											<i class="<?php echo $_R['icon']?>"></i> 
											<?php echo $_R['name']?>
											<small> <?php echo ucfirst($_R['id'])?></small>
										</span>
									</td>
									<td class="rb-tbl-right">
										<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=notification&amp;a=notice_config_user&amp;module_id=<?php echo $_R['id']?>" onclick="return hrefCheck(this,true,'<?php echo _LANG('s8017','site')?>');"><?php echo _LANG('s8018','site')?></a>
									</td>
								<tr>
								<?php endforeach?>
							</tbody>
						</table>
					</div>
					<?php if(!$nt_modules['count']):?>
					<div class="rb-none">
						<i class="glyphicon glyphicon-ok-sign"></i> <?php echo _LANG('s8019','site')?>
					</div>
					<?php endif?>
				</div>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo _LANG('s8020','site')?></label>
			<div class="col-sm-10">
				<div class="rb-tbl-box">
					<table class="table table-hover">
						<thead>
							<tr>
								<th class="rb-tbl-left"><span><?php echo _LANG('s8021','site')?></span></th>
								<th class="rb-tbl-right"><?php echo _LANG('s8016','site')?></th>
							</tr>
						</thead>
					</table>
					<div class="rb-tbl-box1">
						<table class="table">
							<tbody>

								<?php $_i=0;foreach($nt_members['data'] as $_md):?>
								<?php $_R=getDbData($table['s_mbrdata'],'memberuid='.$_md,'*')?>
								<tr>
									<td class="rb-tbl-left">
										<span>
											<a href="#." id='_rb-popover-from-<?php echo $_i?>' data-placement="right" data-popover="popover" data-content="<div id='rb-popover-from-<?php echo $_i?>'><script>getPopover('member','<?php echo $_R['memberuid']?>','rb-popover-from-<?php echo $_i?>')</script></div>">
												<i class="glyphicon glyphicon-user"></i> 
												<?php echo $_R['nic']?> (<?php echo $_R['name']?>)
											</a>
										</span>
									</td>
									<td class="rb-tbl-right">
										<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=notification&amp;a=notice_config_user&amp;member_uid=<?php echo $_R['memberuid']?>" onclick="return hrefCheck(this,true,'<?php echo _LANG('s8017','site')?>');"><?php echo _LANG('s8018','site')?></a>
									</td>
								<tr>
								<?php $_i++;endforeach?>
							</tbody>
						</table>
					</div>
					<?php if(!$nt_members['count']):?>
					<div class="rb-none">
						<i class="glyphicon glyphicon-ok-sign"></i> <?php echo _LANG('s8022','site')?>
					</div>
					<?php endif?>
				</div>
			</div>
		</div>
		</form>
	</div>
	<?php else:?>
	<form name="listForm" action="<?php echo $g['s']?>/" method="post">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="notification">
		<input type="hidden" name="a" value="">
		<input type="hidden" name="deltype" value="">
		<div id="rb-notifications-layer" class="list-group callMod-<?php echo $callMod?>">
		<!-- 여기에 알림정보를 실시간으로 받아옴 -->
		</div>
	</form>
	<?php if($callMod=='view'):?>
	<div class="rb-page-block">
		<fieldset<?php if(!$NUM):?> disabled<?php endif?>>
			<div class="btn-group">
				<div class="btn-group dropup">
					<a class="btn btn-default" href="#." onclick="actCheck('multi_delete_user','cut_member');"><i class="glyphicon glyphicon-ban-circle"></i> <?php echo _LANG('s8023','site')?></a>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li role="presentation" class="dropdown-header"><?php echo _LANG('s8024','site')?></li>
						<li class="divider"></li>
						<li><a href="#." onclick="actCheck('multi_delete_user','cut_member');"><i class="glyphicon glyphicon-lock"></i> <?php echo _LANG('s8025','site')?></a></li>
						<li><a href="#." onclick="actCheck('multi_delete_user','cut_module');"><i class="glyphicon glyphicon-lock"></i> <?php echo _LANG('s8026','site')?></a></li>
					</ul>
				</div>
			</div>
			<div class="btn-group pull-right">
				<button type="button" onclick="chkFlag('noti_members[]');noti_check_all();" class="btn btn-default checkAll-noti-user"><i class="glyphicon glyphicon-ok"></i></button>
				<div class="btn-group dropup">
					<a class="btn btn-default" href="#." onclick="actCheck('multi_delete_user','delete_select');"><i class="glyphicon glyphicon-trash"></i> <?php echo _LANG('s8027','site')?></a>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu pull-right" role="menu">
						<li role="presentation" class="dropdown-header"><?php echo _LANG('s8028','site')?></li>
						<li class="divider"></li>
						<li><a href="#." onclick="actCheck('multi_delete_user','delete_read');"><i class="glyphicon glyphicon-remove"></i> <?php echo _LANG('s8029','site')?></a></li>
						<li><a href="#." onclick="actCheck('multi_delete_user','delete_all');"><i class="glyphicon glyphicon-remove"></i> <?php echo _LANG('s8030','site')?></a></li>
					</ul>
				</div>
			</div>
		</fieldset>
	</div>
	<?php endif?>
	<?php endif?>
</div>



<!----------------------------------------------------------------------------
@부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->

<div id="_modal_header" class="hidden">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="myModalLabel"><i class="fa fa-bell-o fa-lg"></i> <?php echo _LANG('s8031','site')?> <?php if($callMod=='config'):?><?php echo _LANG('s8032','site')?><?php elseif($callMod=='view'):?><?php echo _LANG('s8033','site')?> <span id="rb-notification-modal-num" class="badge" style="position:relative;top:-3px;"><?php echo $NUM?></span><?php else:?><span id="rb-notification-modal-num" class="badge" style="position:relative;top:-3px;">x</span><?php endif?></h4>
</div>

<div id="_modal_footer" class="hidden">
	<div class="btn-group btn-group-justified">
		<a href="#." class="btn btn-default" onclick="frames._modal_iframe_modal_window.getViewNotification('view');"><?php echo _LANG('s8034','site')?></a>
		<a href="#." class="btn btn-default" onclick="frames._modal_iframe_modal_window.getViewNotification('config');"><?php echo _LANG('s8032','site')?></a>
		<a href="#." class="btn btn-default" data-dismiss="modal" aria-hidden="true" id="_close_btn_"><?php echo _LANG('s8035','site')?></a>
	</div>
</div>
	



<script>
function actCheck(act,type)
{
	var f = document.listForm;
	var l = document.getElementsByName('noti_members[]');
	var n = l.length;
	var j = 0;
	var i;

	if (type == 'delete_all' || type == 'delete_read')
	{
		if (confirm('<?php echo _LANG('s8036','site')?>   '))
		{
			getIframeForAction(f);
			f.a.value = act;
			f.deltype.value = type;
			f.submit();
		}
		return false;
	}

	for (i = 0; i < n; i++)
	{
		if(l[i].checked == true)
		{
			j++;
		}
	}
	if (!j)
	{
		alert('<?php echo _LANG('s8037','site')?>      ');
		return false;
	}

	var xtypestr = type == 'delete_select' ? '<?php echo _LANG('s8038','site')?>' : '<?php echo _LANG('s8039','site')?>';
	
	if(confirm(xtypestr))
	{
		getIframeForAction(f);
		f.a.value = act;
		f.deltype.value = type;
		f.submit();
	}
	return false;
}
function noti_check_child(obj)
{
	noti_check_all();
}
function noti_check_all()
{
	var l = document.getElementsByName('noti_members[]');
	var n = l.length;
	var i;
	var val;

	for	(i = 0; i < n; i++)
	{
		val = l[i].value.split('|');
		if (l[i].checked == true) getId('noti-'+val[0]).className = 'btn btn-primary ';
		else getId('noti-'+val[0]).className = 'btn btn-default';
	}
}
function btnCheckSubmit()
{
	var f = document.procForm;
	getIframeForAction(f);
	f.submit();
}
function btnCheck(obj)
{
	obj.parentNode.children[0].className = 'btn btn-default';
	obj.parentNode.children[1].className = 'btn btn-default';
	obj.className = 'btn btn-primary';
	setTimeout("btnCheckSubmit();",100);
}
function getViewNotification(type)
{
	location.href = rooturl + '/?r=' + raccount + '&iframe=Y&system=<?php echo $system?>&callMod='+type;
}
function getNotificationNum(num)
{
	<?php if(!$callMod):?>
	var badge = parent.getId('rb-notification-modal-num');
	var _num = (num >= <?php echo $d['ntfc']['num']?> ? '+<?php echo $d['ntfc']['num']?>' : num);
	badge.innerHTML = _num;
	if(_num > 0) badge.style.background = '#ff0000';
	<?php endif?>
}
function modalSetting()
{
	<?php if($callMod != 'config'):?>
	getId('rb-notifications-layer').innerHTML = getAjaxData('<?php echo $g['s']?>/?r=<?php echo $r?>&m=notification&a=notice_check&noticedata=Y&isModal=Y&callMod=<?php echo $callMod?>&p=<?php echo $p?>&recnum=<?php echo $recnum?$recnum:10?>');
	<?php endif?>
	
	var ht = 400;
	
	parent.getId('modal_window_dialog_modal_window').style.width = '100%';
	parent.getId('modal_window_dialog_modal_window').style.paddingRight = '20px';
	parent.getId('modal_window_dialog_modal_window').style.maxWidth = '550px';
	parent.getId('_modal_iframe_modal_window').style.height = <?php echo $g['device']?"'400px'":"ht + 'px'"?>;
	parent.getId('_modal_body_modal_window').style.height = <?php echo $g['device']?"'400px'":"ht + 'px'"?>;

	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_body_modal_window').style.padding = '0';
	parent.getId('_modal_body_modal_window').style.margin = '0';

	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
}
modalSetting();
</script>
