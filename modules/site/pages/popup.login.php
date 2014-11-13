<div id="rb-modal-body">
	<form name="LayoutLogForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return layoutLogCheck(this);" role="form">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="a" value="login">
		<input type="hidden" name="referer" value="">
		<input type="hidden" name="isModal" value="Y">
		
		<div class="form-group">
			<label class="sr-only" for="username"><?php echo _LANG('s7001','site')?></label>
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input type="text" value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',0)?>" id="username" name="id" placeholder="<?php echo _LANG('s7001','site')?>" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="sr-only" for="password">Password</label>
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
				<input type="password" id="password" name="pw" value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',1)?>" placeholder="<?php echo _LANG('s7002','site')?>" class="form-control">
			</div>
		</div>
		<div class="checkbox">
			<label><input name="idpwsave" class="rb-confirm" type="checkbox" value="checked"<?php if($_COOKIE['svshop']):?> checked<?php endif?>> <?php echo _LANG('s7003','site')?></label>
		</div>
		<button type="submit" class="btn btn-primary btn-block btn-lg"><?php echo _LANG('s7004','site')?></button>
	</form>
</div>



<!----------------------------------------------------------------------------
@부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->

<div id="_modal_header" class="hidden">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="myModalLabel"><i class="fa fa-sign-in fa-lg"></i> <?php echo _LANG('s7004','site')?> </h4>
</div>

<div id="_modal_footer" class="hidden">
	<a href="#" class="btn btn-default btn-block" data-dismiss="modal" aria-hidden="true"><?php echo _LANG('s0003','site')?></a>
</div>
	



<script>
var bootmsg = '<div class="media"><div class="media-body" style="font-size:12px;">';
	bootmsg+= '<h4 class="media-heading"><?php echo _LANG('s7005','site')?></h4>';
	bootmsg+= '<?php echo _LANG('s7006','site')?>';
	bootmsg+= '</div></div>';

$('.rb-confirm').on('click', function() {
	bootbox.confirm(bootmsg, function(result){
		document.LayoutLogForm.idpwsave.checked = result;
	});
	$('.bootbox .media-heading').css({'font-weight':'bold','margin-bottom':'8px'});
	$('.bootbox .modal-footer').css({'margin-top':'0','background-color':'#f2f2f2'});
	$('.bootbox .modal-footer .btn-default').addClass('pull-left');
});
function layoutLogCheck(f)
{
	if (f.id.value == '')
	{
		alert('<?php echo _LANG('s7007','site')?>');
		f.id.focus();
		return false;
	}
	if (f.pw.value == '')
	{
		alert('<?php echo _LANG('s7008','site')?>');
		f.pw.focus();
		return false;
	}
	f.referer.value = parent.location.href;
	getIframeForAction(f);
	return true;
}
function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.width = '100%';
	parent.getId('modal_window_dialog_modal_window').style.paddingRight = '20px';
	parent.getId('modal_window_dialog_modal_window').style.maxWidth = '400px';
	parent.getId('_modal_iframe_modal_window').style.height = '210px';
	parent.getId('_modal_body_modal_window').style.height = '210px';

	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_body_modal_window').style.padding = '0';
	parent.getId('_modal_body_modal_window').style.margin = '0';

	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
}
modalSetting();
</script>
