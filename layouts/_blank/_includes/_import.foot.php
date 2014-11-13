<div id="_box_layer_"></div>
<div id="_action_layer_"></div>
<div id="_hidden_layer_"></div>
<div id="_overLayer_"></div>
<div id="rb-context-menu" class="dropdown"><a data-toggle="dropdown" href="#."></a><ul class="dropdown-menu" role="menu"></ul></div>
<iframe name="_action_frame_<?php echo $m?>" width="0" height="0" frameborder="0" scrolling="no"></iframe>

<script>
$('body').tooltip({
	selector: '[data-tooltip=tooltip]',
	html: 'true',
	container: 'body'
});
$('body').popover({
	selector: '[data-popover=popover]',
	html: 'true',
	container: 'body',
});
</script>


<?php if($my['uid']&&$m=='admin') include $g['path_core'].'engine/notification.engine.php'?>
