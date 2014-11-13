<!-- 사이트 풋터 코드 -->
<?php echo $_HS['footercode'] ?>

<!-- 푸터 스위치 -->
<?php foreach($g['switch_3'] as $_switch) include $_switch ?>

<div id="_box_layer_"></div>
<div id="_action_layer_"></div>
<div id="_hidden_layer_"></div>
<div id="_overLayer_"></div>
<div id="rb-context-menu" class="dropdown"><a data-toggle="dropdown" href="#."></a><ul class="dropdown-menu" role="menu"></ul></div>
<iframe name="_action_frame_<?php echo $m?>" width="0" height="0" frameborder="0" scrolling="no" class="hidden"></iframe>

<?php
$g['wdgcod'] = $g['path_tmp'].'widget/c'.$_HM['uid'].'.p'.$_HP['uid'].'.cache';
if(is_file($g['wdgcod'])) include $g['wdgcod'];
if($g['widget_cssjs']) include $g['path_core'].'engine/widget.cssjs.php';
if($my['uid']) include $g['path_core'].'engine/notification.engine.php';
?>

<script>
<?php if($_HS['dtd']):?>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', '<?php echo $_HS['dtd']?>', 'auto');
ga('send', 'pageview');
<?php endif?>
<?php if($my['uid']):?>
<?php if($my['admin'] && $d['admin']['dblclick'] && $panel!='N'):?>
document.ondblclick = function(event)
{
	<?php if($_HM['uid']):?>
	getContext('<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=menu&cat=<?php echo $_HM['uid']?>"><?php echo _LANG('ef001','admin')?></a></li><?php if($_HM['menutype']>1):?><li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=_edit&_mtype=menu&cat=<?php echo $_HM['uid']?>&uid=<?php echo $_HM['uid']?>&type=<?php echo $_HM['menutype']==3?'source':'widget'?>"><?php echo $_HM['menutype']==3?_LANG('ef003','admin'):_LANG('ef004','admin')?></a></li><?php if($_HM['menutype']==3):?><li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=_edit&_mtype=menu&cat=<?php echo $_HM['uid']?>&uid=<?php echo $_HM['uid']?>&type=source&wysiwyg=Y"><?php echo _LANG('ef005','admin')?></a></li><?php endif?><?php endif?><li class="divider"></li><li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=menu"><?php echo _LANG('ef006','admin')?></a></li>',event);
	<?php elseif($_HP['uid']):?>
	getContext('<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=page&uid=<?php echo $_HP['uid']?>"><?php echo _LANG('ef002','admin')?></a></li><?php if($_HP['pagetype']>1):?><li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=_edit&_mtype=page&uid=<?php echo $_HP['uid']?>&type=<?php echo $_HP['pagetype']==3?'source':'widget'?>"><?php echo $_HP['pagetype']==3?_LANG('ef003','admin'):_LANG('ef004','admin')?></a></li><?php if($_HP['pagetype']==3):?><li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=_edit&_mtype=page&uid=<?php echo $_HP['uid']?>&type=source&wysiwyg=Y"><?php echo _LANG('ef005','admin')?></a></li><?php endif?><?php endif?><li class="divider"></li><li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=page"><?php echo _LANG('ef007','admin')?></a></li>',event);
	<?php else:?>
	getContext('<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=<?php echo $m?>"><?php echo _LANG('ef008','admin')?></a></li><li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=module&front=main&id=<?php echo $m?>"><?php echo _LANG('ef009','admin')?></a></li>',event);
	<?php endif?>
}
<?php endif?>
<?php else:?>
$('.rb-modal-login').on('click',function() {
	modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.login')?>');
});
<?php endif?>
</script>
