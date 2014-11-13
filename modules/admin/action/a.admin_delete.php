<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

foreach ($mbrmembers as $val)
{
	if ($my['uid'] == $val) continue;
	$M=getDbData($table['s_mbrid'],'uid='.$val,'*');
	if($auth)
	{
		if ($auth == 'D')
		{
			getDbDelete($table['s_mbrid'],'uid='.$M['memberuid']);
			getDbDelete($table['s_mbrdata'],'memberuid='.$M['memberuid']);
			getDbDelete($table['s_mbrcomp'],'memberuid='.$M['memberuid']);
			getDbDelete($table['s_paper'],'my_mbruid='.$M['memberuid']);
			getDbDelete($table['s_point'],'my_mbruid='.$M['memberuid']);
			getDbDelete($table['s_scrap'],'mbruid='.$M['memberuid']);
			getDbDelete($table['s_simbol'],'mbruid='.$M['memberuid']);
			getDbDelete($table['s_friend'],'my_mbruid='.$M['memberuid'].' or by_mbruid='.$M['memberuid']);
			getDbUpdate($table['s_mbrlevel'],'num=num-1','uid='.$M['level']);
			getDbUpdate($table['s_mbrgroup'],'num=num-1','uid='.$M['sosok']);
			getDbDelete($table['s_mbrsns'],'memberuid='.$M['memberuid']);

			if (is_file($g['path_var'].'avatar/'.$M['photo']))
			{
				unlink($g['path_var'].'avatar/'.$M['photo']);
			}
			if (is_file($g['path_var'].'avatar/180.'.$M['photo']))
			{
				unlink($g['path_var'].'avatar/180.'.$M['photo']);
			}
			$fp = fopen($g['path_tmp'].'out/'.$M['id'].'.txt','w');
			fwrite($fp,$date['totime']);
			fclose($fp);
			@chmod($g['path_tmp'].'out/'.$M['id'].'.txt',0707);
		}
		else if ($auth == 'A')
		{
			getDbUpdate($table['s_mbrdata'],"admin=1,adm_view='[admin]'",'memberuid='.$M['uid']);
		}
		else {
			getDbUpdate($table['s_mbrdata'],"auth='$auth'",'memberuid='.$M['uid']);
		}
	}
	else {
		getDbUpdate($table['s_mbrdata'],"admin=0,adm_view=''",'memberuid='.$M['uid']);
	}
}

getLink('reload','parent.','','');
?>