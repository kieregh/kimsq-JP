<?php
if(!defined('__KIMS__')) exit;

if ($sitelang)
{
	$_langfile = $g['path_root'].'_install/language/'.$sitelang.'/lang.action.php';
	if (is_file($_langfile)) include $_langfile;
}

$moduledir = array();
$_oldtable = array();
$_tmptable = array();
$_tmpdfile = $g['path_var'].'db.info.php';
$_tmptfile = $g['path_var'].'table.info.php';
include $g['path_core'].'function/sys.func.php';
include $g['path_core'].'function/db.mysql.func.php';
$date = getVDate(0);

if (is_file($_tmpdfile)) getLink('./index.php','','','');

$DB_CONNECT = @mysql_connect($dbhost.':'.$dbport,$dbuser,$dbpass);
if (!$DB_CONNECT)
{
	echo '<script>parent.isSubmit=false;parent.stepCheck("prev");parent.stepCheck("prev");</script>';
	getLink('','',_LANG('a002','install'),'');
}
$DB_SELECT = @mysql_select_db($dbname,$DB_CONNECT);
if (!$DB_SELECT)
{
	echo '<script>parent.isSubmit=false;parent.stepCheck("prev");parent.stepCheck("prev");parent.procForm.dbname.focus();</script>';
	getLink('','',_LANG('a003','install'),'');
}

$ISRBDB = db_fetch_array(db_query('select count(*) from '.$dbhead.'_s_module',$DB_CONNECT));
if ($ISRBDB[0])
{
	echo '<script>parent.isSubmit=false;parent.stepCheck("prev");parent.stepCheck("prev");</script>';
	getLink('','',_LANG('a004','install'),'');
}

$vfile = $g['path_var'].'php.version.txt';
$fp = fopen($vfile,'w');
fwrite($fp,phpversion());
fclose($fp);
@chmod($vfile,0707);

$fp = fopen($_tmpdfile,'w');
fwrite($fp, "<?php\n");
fwrite($fp, "\$DB['host'] = '".$dbhost."';\n");
fwrite($fp, "\$DB['name'] = '".$dbname."';\n");
fwrite($fp, "\$DB['user'] = '".$dbuser."';\n");
fwrite($fp, "\$DB['pass'] = '".$dbpass."';\n");
fwrite($fp, "\$DB['head'] = '".$dbhead."';\n");
fwrite($fp, "\$DB['port'] = '".$dbport."';\n");
fwrite($fp, "\$DB['type'] = '".$dbtype."';\n");
fwrite($fp, "?>");
fclose($fp);
@chmod($_tmpdfile,0707);
$DB['type'] = $dbtype;
$DB['head'] = $dbhead;

if (is_file($_tmptfile)) 
{
	include_once $_tmptfile;
	$_oldtable = $table;
}

$dirh = opendir($g['path_module']); 
while(false !== ($_file = readdir($dirh))) 
{ 
	if($_file == '.' || $_file == '..') continue;

	if(is_file($g['path_module'].$_file.'/_setting/db.table.php')) 
	{	
		$table = array();
		$module= $_file;
		include $g['path_module'].$_file.'/_setting/db.table.php';
		include $g['path_module'].$_file.'/_setting/db.schema.php';

		foreach($table as $key => $val) $_tmptable[$key] = $val;
		rename($g['path_module'].$_file.'/_setting/db.table.php',$g['path_module'].$_file.'/_setting/db.table.php.done');

		$moduledir[$_file] = array($_file,count($table));
	}
	else {
		$moduledir[$_file] = array($_file,0);
	}
} 
closedir($dirh);

$fp = fopen($_tmptfile,'w');
fwrite($fp, "<?php\n");
foreach($_oldtable as $key => $val)
{
	if (!$_tmptable[$key])
	{
		fwrite($fp, "\$table['$key'] = \"$val\";\n");
	}
}
foreach($_tmptable as $key => $val)
{
	fwrite($fp, "\$table['$key'] = \"$val\";\n");
}
fwrite($fp, "?>");
fclose($fp);
@chmod($_tmptfile,0707);

include $_tmptfile;

$gid = 0;
$mdlarray = array('dashboard','market','admin','module','site','layout','mediaset','domain','device','notification','search');
foreach($mdlarray as $_val)
{
	$new_modulename = $g['path_module'].$moduledir[$_val][0].'/language/'.$sitelang.'/name.module.txt';

	$QUE = "insert into ".$table['s_module']." 
	(gid,system,hidden,mobile,name,id,tblnum,icon,d_regis,lang) 
	values 
	('".$gid."','1','".(strstr('[market][admin][site][layout]','['.$_val.']')?0:1)."','1','".($sitelang&&is_file($new_modulename)?implode('',file($new_modulename)):getFolderName($g['path_module'].$moduledir[$_val][0]))."','".$moduledir[$_val][0]."','".$moduledir[$_val][1]."','kf-".($_val=='site'?'home':($_val=='mediaset'?'upload':($_val=='notification'?'notify':$_val)))."','".$date['totime']."','')";
	db_query($QUE,$DB_CONNECT);
	$gid++;
}

$siteid = $siteid ? $siteid : 'home';
$layout = 'default/default.php';
$m_layout = 'mobile/default.php';

$QKEY = "gid,id,name,title,titlefix,icon,layout,startpage,m_layout,m_startpage,lang,open,dtd,nametype,timecal,rewrite,buffer,usescode,headercode,footercode";
$QVAL = "'0','".$siteid."','$sitename','{subject} | {site}','0','','$layout','0','$m_layout','0','','1','','nic','0','$rewrite','0','1','',''";
getDbInsert($table['s_site'],$QKEY,$QVAL);
db_query("OPTIMIZE TABLE ".$table['s_site'],$DB_CONNECT); 
$S = getDbData($table['s_site'],"id='".$siteid."'",'*');
$LASTUID = $S['uid'];
getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'0','$LASTUID','','','','ALL',''");

mkdir($g['path_page'].$siteid.'-menus',0707);
mkdir($g['path_page'].$siteid.'-pages',0707);
mkdir($g['path_page'].$siteid.'-menus/images',0707);
mkdir($g['path_page'].$siteid.'-pages/images',0707);
@chmod($g['path_page'].$siteid.'-menus',0707);
@chmod($g['path_page'].$siteid.'-pages',0707);
@chmod($g['path_page'].$siteid.'-menus/images',0707);
@chmod($g['path_page'].$siteid.'-pages/images',0707);

$pagesarray = array
(
	'privacy'=>array(_LANG('a005','install'),'3','default/_full_layout.php'),
	'terms'=>array(_LANG('a006','install'),'3','default/_full_layout.php'),
);

foreach($pagesarray as $_key => $_val)
{
	$QUE = "insert into ".$table['s_page']." 
	(site,pagetype,ismain,mobile,id,category,name,perm_g,perm_l,layout,joint,hit,d_regis,d_update,mediaset)
	values
	('$LASTUID','$_val[1]','0','0','$_key','"._LANG('a007','install')."','$_val[0]','','0','$_val[2]','','0','".$date['totime']."','','0')";
	db_query($QUE,$DB_CONNECT);
	$lastpage = getDbCnt($table['s_page'],'max(uid)','');
	getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'2','$lastpage','$title','$keywords','$description','ALL',''");

	$mfile = $g['path_page'].$siteid.'-pages/'.$_key.'.php';
	$fp = fopen($mfile,'w');
	fwrite($fp,$_val[0]);
	fclose($fp);
	@chmod($mfile,0707);
	$mfile = $g['path_page'].$siteid.'-pages/'.$_key.'.widget.php';
	$fp = fopen($mfile,'w');
	fwrite($fp,'');
	fclose($fp);
	@chmod($mfile,0707);
}

db_query("insert into ".$table['s_mbrid']." (site,id,pw)values('1','".$id."','".getCrypt($pw1,$date['totime'])."')",$DB_CONNECT);
$my['admin'] = 1;
$nick = $nick ? $nick : _LANG('a008','install');
$sex = $sex ? $sex : 0;
$cellphone = $tel_1 && $tel_2 && $tel_3 ? $tel_1.'-'.$tel_2.'-'.$tel_3 : '';
$birth1 = $birth_1 ? $birth_1 : 0;
$birth2 = $birth_2 && $birth_3 ? $birth_2.$birth_3 : 0;

$QUE = "insert into ".$table['s_mbrdata']." 
(memberuid,site,auth,mygroup,level,comp,admin,adm_view,
email,name,nic,grade,photo,home,sex,birth1,birth2,birthtype,tel1,tel2,zip,
addr0,addr1,addr2,job,marr1,marr2,sms,mailing,smail,point,usepoint,money,cash,num_login,pw_q,pw_a,now_log,last_log,last_pw,is_paper,d_regis,tmpcode,sns,noticeconf,num_notice,addfield)
values
('1','1','1','1','1','0','".$my['admin']."','',
'".$email."','".$name."','".$nick."','','','','".$sex."','".$birth1."','".$birth2."','".$birthtype."','','".$cellphone."','',
'','','','','0','0','1','1','0','0','0','0','0','1','"._LANG('a09','install')."','".$pw1."','1','".$date['totime']."','".$date['today']."','0','".$date['totime']."','','','','0','')";
db_query($QUE,$DB_CONNECT);

$groupset = array('A','B','C','D','E','F','G','H');
$i = 0;
foreach ($groupset as $_val)
{
	getDbInsert($table['s_mbrgroup'],'gid,name,num',"'".$i."','"._LANG('a010','install').$_val."','".(!$i?1:0)."'");
	$i++;
}
for ($i = 1; $i < 101; $i++) getDbInsert($table['s_mbrlevel'],'gid,name,num,login,post,comment',"'".($i==20?1:0)."','"._LANG('a011','install').$i."','".($i==1?1:0)."','0','0','0'");

$_tmpdfile = $g['path_module'].'admin/var/var.system.php';
include $_tmpdfile;
if ($d['admin']['syslang'] != $sitelang)
{
	$d['admin']['syslang'] = $sitelang;
	$fp = fopen($_tmpdfile,'w');
	fwrite($fp, "<?php\n");
	foreach ($d['admin'] as $key => $val)
	{
		fwrite($fp, "\$d['admin']['".$key."'] = \"".addslashes(stripslashes($val))."\";\n");
	}
	fwrite($fp, "?>");
	fclose($fp);
	@chmod($_tmpdfile,0707);
}

setcookie('svshop', $id.'|'.$pw1, time()+60*60*24*30, '/');
$_SESSION['mbr_uid'] = 1;
$_SESSION['mbr_pw']  = getCrypt($pw1,$date['totime']);

putNotice(1,'admin',0,sprintf(_LANG('a012','install'),$name,$name),'','');
getLink('./index.php?r='.$siteid.'&iframe=Y&system=guide.install','parent.','','');
?>