<div id="jointbox">
	<div class="category">
		<?php $MODULES = getDbArray($table['s_module'],'','*','gid','asc',0,1)?>
		<?php while($R=db_fetch_array($MODULES)):?>
		<?php $_jfile0 = $g['path_module'].$R['id'].'/admin/var/var.joint.php'?>
		<?php if(!is_file($_jfile0)||strstr($cmodule,'['.$R['id'].']'))continue?>
		<?php if($smodule==$R['id']) $g['var_joint_file'] = is_file($_jfile0)?$_jfile0:(is_file($_jfile1)?$_jfile1:$_jfile2)?>
		<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;system=<?php echo $system?>&amp;iframe=<?php echo $iframe?>&amp;dropfield=<?php echo $dropfield?>&amp;smodule=<?php echo $R['id']?>&amp;cmodule=<?php echo $cmodule?>" class="list-group-item<?php if($smodule==$R['id']):?> active<?php endif?>"><i class="kf <?php echo $R['icon']?$R['icon']:'kf-'.$R['id']?>"></i> <?php echo $R['name']?><span class="badge"><?php echo $R['id']?></span></a>
		<?php endwhile?>
	</div>
	<div class="content">
		<?php if($smodule):?>
		<?php include getLangFile($g['path_module'].$smodule.'/language/',$d['admin']['syslang'],'/lang.joint.php')?>
		<?php include $g['var_joint_file']?>
		<?php else:?>
		<div class="none">
			<i class="kf kf-module fa-5x"></i><br><br>
			<?php echo _LANG('s6001','site')?>
		</div>
		<?php endif?>
	</div>
</div>



<!----------------------------------------------------------------------------
@부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->

<div id="_modal_header" class="hidden">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><i class="kf-module kf-lg"></i> <?php echo _LANG('s6002','site')?></h4>
</div>

<div id="_modal_footer" class="hidden">
	<?php if($dropButtonUrl):?>
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal" aria-hidden="true" id="_modalclosebtn_"><?php echo _LANG('s0003','site')?></button>
	<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window.dropJoint('<?php echo $dropButtonUrl?>');"><?php echo _LANG('s6003','site')?></button>
	<?php else:?>
	<button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" id="_modalclosebtn_"><?php echo _LANG('s0003','site')?></button>
	<?php endif?>
</div>
	



<script>
function dropJoint(m)
{
	var f = parent.getId('<?php echo $dropfield?>');
	f.value = m;
	parent.$('#modal_window').modal('hide');
}
function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.width = '100%';
	parent.getId('modal_window_dialog_modal_window').style.paddingRight = '20px';
	parent.getId('modal_window_dialog_modal_window').style.maxWidth = '800px';
	parent.getId('_modal_iframe_modal_window').style.height = '430px';
	parent.getId('_modal_body_modal_window').style.height = '430px';

	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_body_modal_window').style.padding = '0';
	parent.getId('_modal_body_modal_window').style.margin = '0';

	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
}
modalSetting();
</script>