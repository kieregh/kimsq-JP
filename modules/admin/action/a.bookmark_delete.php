<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if ($deltype == 'hidden')
{
	$memberuid	= $my['uid'];
	$url		= $g['s'].'/?r='.$r.'&m='.$m.'&module='.$_addmodule.'&front='.$_addfront;
	$bookmark_rcd = getDbData($table['s_admpage'],'memberuid='.$memberuid." and url='".$url."'",'uid');
	$bookmark_uid = $bookmark_rcd['uid'];
	if (!$bookmark_uid)
	{
		getLink('','',_LANG('a4001','admin'),'');
	}
	getDbDelete($table['s_admpage'],'uid='.$bookmark_uid);
	?>
	<script>
	parent.getId('_bookmark_star_').className = 'fa fa-lg fa-star-o';
	parent.getId('_bookmark_notyet_').className = 'btn-group btn-group-sm dropdown';
	parent.getId('_bookmark_already_').className = 'btn-group btn-group-sm dropdown hidden';
	parent.getId('_now_bookmark_<?php echo $bookmark_uid?>').className = 'list-group-item hidden';
	<?php if(!getDbRows($table['s_admpage'],'memberuid='.$my['uid'])):?>
	parent.getId('_add_bookmark_').innerHTML = '<a class="list-group-item"><i class="fa fa-fw fa-file-text-o"></i><?php echo _LANG('a4002','admin')?></a>';
	<?php endif?>
	</script>
	<?php
	exit;
}
else {
	foreach ($bookmark_pages as $val)
	{
		getDbDelete($table['s_admpage'],'uid='.$val.' and memberuid='.$my['uid']);
	}

	getLink('reload','parent.','','');
}
?>