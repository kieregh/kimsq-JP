<?php
if(!defined('__KIMS__')) exit;
include $g['path_module'].'notification/var/var.php';
$NT_DATA = explode('|',$my['noticeconf']);
?>

<script>
$('.rb-notifications-toggle').on('click', function () {
	if(getId('rb-notifications-layer'))
	{
		getId('rb-notifications-layer').innerHTML = getAjaxData('<?php echo $g['s']?>/?r=<?php echo $r?>&m=notification&a=notice_check&noticedata=Y');
		setTimeout("loadNotification();",1000);
	}
});
$('.rb-notifications-modal').on('click',function() {
	modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.notification')?>');
});
$('.rb-notifications-modal-view').on('click',function() {
	modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.notification&amp;callMod=view')?>');
});
$('.rb-notifications-modal-config').on('click',function() {
	modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.notification&amp;callMod=config')?>');
});
var bootboxNotificationConfirm = true
function pushNotification(num)
{
	var _num = (num >= <?php echo $d['ntfc']['num']?> ? '+<?php echo $d['ntfc']['num']?>' : num);
	if (parent.getId('rb-notification-name'))
	{
		parent.getId('rb-notification-name').innerHTML = _num;
		parent.getId('rb-notification-name').className = 'badge rb-notification-layer rb-notification-active' + (num == 0 ? ' hidden':'');
		parent.getId('rb-notification-badge').innerHTML = num;
	}

	if (getId('rb-notification-badge'))
	{
		getId('rb-notification-badge').innerHTML = _num;
		getId('rb-notification-badge').className = getId('rb-notification-badge').className.replace(' rb-notification-active','') + (num == 0 ? '':' rb-notification-active');
	}
	if (getId('rb-notification-badge-other'))
	{
		getId('rb-notification-badge-other').innerHTML = _num;
		getId('rb-notification-badge-other').className = getId('rb-notification-badge').className.replace(' rb-notification-active','') + (num == 0 ? '':' rb-notification-active');
	}
	<?php if($NT_DATA[1] && !$_SESSION['sh_notify_popup']):?>
	if(num > 0 && bootboxNotificationConfirm)
	{
		var notimsg = '<?php echo _LANG('en001','admin')?>';
		bootbox.dialog({
		title: '<i class="glyphicon glyphicon-info-sign" style="position:relative;top:3px;"></i> '+notimsg.replace('{num}',num),
		message: '<div style="text-align:center;"><i class="kf-notify" style="font-size:300px;"></i></div>',
		onEscape: function() {sessionSetting('sh_notify_popup','1','','');},
		backdrop: true,
		closeButton: true,
		animate: true,
		buttons: {
			success: {
				label: "<?php echo _LANG('en002','admin')?>",
				className: "btn-default btn-block btn-lg",
				callback: function() {sessionSetting('sh_notify_popup','1','','');}
			},
		}});
		bootboxNotificationConfirm = false;
	}
	<?php endif?>
}
function loadNotification()
{
	frames._action_frame_<?php echo $m?>.location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=notification&a=notice_check';
}
setTimeout("loadNotification();",<?php echo $d['ntfc']['sec']?>000);
pushNotification(<?php echo $my['num_notice']?>);
</script>
