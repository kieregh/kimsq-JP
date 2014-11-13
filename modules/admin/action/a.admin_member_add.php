<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$id			= trim($_POST['id']);
$pw			= trim($_POST['pw1']);
$name		= trim($_POST['name']);
$nic		= trim($_POST['nic']);
$nic		= $nic ? $nic : $name;
$email		= trim($_POST['email']);

if (!$id || !$name) getLink('','',_LANG('a0001','admin'),'');
if (!$check_id || !$check_nic || !$check_email)
{
	getLink('','',_LANG('a0001','admin'),'');
}

$tmpname	= $_FILES['upfile']['tmp_name'];
$realname	= $_FILES['upfile']['name'];

if ($avatar_delete)
{
	$photo = '';
	$saveFile1	= $g['path_var'].'avatar/'.$avatar;
	$saveFile2	= $g['path_var'].'avatar/180.'.$avatar;
}
else {
	$photo = $avatar;
	if (is_uploaded_file($tmpname))
	{
		$fileExt	= strtolower(getExt($realname));
		$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;

		if (strstr('[jpg]',$fileExt))
		{
			$wh = getimagesize($tmpname);
			if ($wh[0] > 180 && $wh[1] > 180)
			{
				$photo		= $id.'.'.$fileExt;
				$saveFile1	= $g['path_var'].'avatar/'.$photo;
				$saveFile2	= $g['path_var'].'avatar/180.'.$photo;

				if (is_file($saveFile1)) unlink($saveFile1);
				if (is_file($saveFile2)) unlink($saveFile2);

				include $g['path_core'].'function/thumb.func.php';

				move_uploaded_file($tmpname,$saveFile2);
				ResizeWidth($saveFile2,$saveFile2,180);
				ResizeWidthHeight($saveFile2,$saveFile1,50,50);
				@chmod($saveFile1,0707);
				@chmod($saveFile2,0707);
			}
		}
	}
}

if ($uid)
{
	getDbUpdate($table['s_mbrid'],'pw='.getCrypt($pw,$date['totime']),'uid='.$uid);
	getDbUpdate($table['s_mbrdata'],"email='$email',name='$name',nic='$nic',photo='$photo',tel2='$tel2'",'memberuid='.$uid);
}
else {
	getDbInsert($table['s_mbrid'],'site,id,pw',"'$s','$id','".getCrypt($pw,$date['totime'])."'");
	$memberuid  = getDbCnt($table['s_mbrid'],'max(uid)','');

	$auth		= 1;
	$mygroup	= 1;
	$level		= 1;
	$comp		= 0;
	$adm_view	= $admin ? '[admin]' : '';
	$home		= '';
	$birth1		= 0;
	$birth2		= 0;
	$birthtype	= 0;
	$tel1		= $tel2 && substr($tel2,0,2) != '01' ? $tel2 : '';
	$tel2		= $tel2 && substr($tel2,0,2) == '01' ? $tel2 : '';
	$zip		= '';
	$addr0		= '';
	$addr1		= '';
	$addr2		= '';
	$job		= '';
	$marr1		= 0;
	$marr2		= 0;
	$sms		= 1;
	$mailing	= 1;
	$smail		= 0;
	$point		= 0;
	$usepoint	= 0;
	$money		= 0;
	$cash		= 0;
	$num_login	= 1;
	$pw_q		= '';
	$pw_a		= '';
	$now_log	= 0;
	$last_log	= '';
	$last_pw	= $date['totime'];
	$is_paper	= 0;
	$d_regis	= $date['totime'];
	$sns		= '';
	$noticeconf	= '';
	$num_notice	= 0;
	$addfield	= '';

	$_QKEY = "memberuid,site,auth,mygroup,level,comp,admin,adm_view,";
	$_QKEY.= "email,name,nic,grade,photo,home,sex,birth1,birth2,birthtype,tel1,tel2,zip,";
	$_QKEY.= "addr0,addr1,addr2,job,marr1,marr2,sms,mailing,smail,point,usepoint,money,cash,num_login,pw_q,pw_a,now_log,last_log,last_pw,is_paper,d_regis,tmpcode,sns,noticeconf,num_notice,addfield";
	$_QVAL = "'$memberuid','$s','$auth','$mygroup','$level','$comp','$admin','$adm_view',";
	$_QVAL.= "'$email','$name','$nic','','$photo','$home','$sex','$birth1','$birth2','$birthtype','$tel1','$tel2','$zip',";
	$_QVAL.= "'$addr0','$addr1','$addr2','$job','$marr1','$marr2','$sms','$mailing','$smail','$point','$usepoint','$money','$cash','$num_login','$pw_q','$pw_a','$now_log','$last_log','$last_pw','$is_paper','$d_regis','','$sns','$noticeconf','$num_notice','$addfield'";
	getDbInsert($table['s_mbrdata'],$_QKEY,$_QVAL);
	getDbUpdate($table['s_mbrlevel'],'num=num+1','uid='.$level);
	getDbUpdate($table['s_mbrgroup'],'num=num+1','uid='.$mygroup);
}
getLink('reload','parent.','','');
?>