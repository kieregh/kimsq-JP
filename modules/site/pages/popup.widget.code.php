<?php include getLangFile($g['dir_module'].'language/',$d['admin']['syslang'],'/lang.system.php')?>
<div class="modal-header">
	<button type="button" class="close" onclick="hideModal();">&times;</button>
	<h4 class="modal-title"><i class="fa fa-code fa-lg"></i> <?php echo _LANG('sb001','site')?></h4>
</div>
<div class="modal-body">
	<textarea id="rb-widget-code-area"></textarea>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="hideModal();"><?php echo _LANG('s0003','site')?></button>
	<button type="button" class="btn btn-primary rb-clipboard" data-clipboard-target="rb-widget-code-area" onclick="hideModal();"><?php echo _LANG('sb002','site')?></button>
</div>


<!-- zero-clipboard -->
<?php getImport('zero-clipboard','ZeroClipboard.min',false,'js') ?>
<script>
var client = new ZeroClipboard($(".rb-clipboard"));
client.on( "ready", function( readyEvent ) {});
function hideModal()
{
	parent.$('.rb-modal-x').modal('hide');
}
function modalSetting()
{
	getId('rb-widget-code-area').innerHTML = parent.frames._modal_iframe_modal_window.getId('rb-widget-code-result').value;
	parent.getId('_modal_dialog_top_').style.top = '120px';
	parent.getId('_modal_dialog_top_').style.paddingRight = '20px';
	parent.getId('_modal_dialog_top_').style.width = '100%';
	parent.getId('_modal_dialog_top_').style.maxWidth = '500px';
	parent.getId('_modal_iframe_sub_').style.height = '250px';
}
modalSetting();
</script>


<style>
.modal-header .close {font-size:35px;font-weight:normal;}
.modal-header .modal-title i {position:relative;top:-3px;}
.modal-body {height:130px;background:#333;}
#rb-widget-code-area {width:100%;height:100%;border:0;padding:20px;line-height:150%;color:#fff;background:#333;}
</style>
