<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$joint = trim(str_replace('&amp;','&',$joint));
$codhead = trim($codhead);
$codfoot = trim($codfoot);
$addinfo = trim($addinfo);
$id = trim($id);
$title = trim($title);
$keywords = trim($keywords);
$description = trim($description);
$classification = trim($classification);
$addattr = trim($addattr);
$mediaset = trim($mediaset);
$image_src = trim($image_src);

if (!$redirect&&(strstr($joint,'&c=')||strstr($joint,'?c=')))
{
	getLink('','',_LANG('a5001','site'),'');
}
if(!$redirect&&$menutype==1)
{
	include $g['path_core'].'function/menu.func.php';
}

if ($cat && !$vtype)
{
	$R = getUidData($table['s_menu'],$cat);
	$imghead = $R['imghead'];
	$imgfoot = $R['imgfoot'];
	$imgset = array('head','foot');

	if ($id != $R['id'])
	{
		$ISMCODE = getDbData($table['s_menu'],"id='".$id."' and site=".$s,'*');
		if ($ISMCODE['uid']) getLink('','',sprintf(_LANG('a5002','site'),$ISMCODE['id'],$ISMCODE['name']),'');
	}

	for ($i = 0; $i < 2; $i++)
	{
		$tmpname	= $_FILES['img'.$imgset[$i]]['tmp_name'];
		$realname	= $_FILES['img'.$imgset[$i]]['name'];
		$fileExt	= strtolower(getExt($realname));
		$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;
		$userimg	= sprintf('%05d',$R['uid']).'_'.$imgset[$i].'.'.$fileExt;
		$saveFile	= $g['path_var'].'menu/'.$userimg;

		if (is_uploaded_file($tmpname))
		{
			if (!strstr('[gif][jpg][png][swf]',$fileExt))
			{
				getLink('','',_LANG('a5003','site'),'');
			}
			move_uploaded_file($tmpname,$saveFile);
			@chmod($saveFile,0707);

			${'img'.$imgset[$i]} = $userimg;
		}
	}

	if(!$redirect&&$menutype==1&&strstr($joint,'cync=Y'))
	{
		$ctarr = getMenuCodeToPath($table['s_menu'],$R['uid'],0);
		$catcode = '';
		$ctnum = count($ctarr);
		for ($i = 0; $i < $ctnum; $i++) $catcode .= $ctarr[$i]['id'].'/';
		$c = substr($catcode,0,strlen($catcode)-1);
		$joint = str_replace('cync=Y','cync=['.$m.'][c'.$R['uid'].'][,,,][][][c:'.$c.']',$joint);
	}

	$QVAL = "id='$id',menutype='$menutype',mobile='$mobile',hidden='$hidden',reject='$reject',name='$name',target='$target',";
	$QVAL.= "redirect='$redirect',joint='$joint',perm_g='$perm_g',perm_l='$perm_l',";
	$QVAL.= "layout='$layout',imghead='$imghead',imgfoot='$imgfoot',addattr='$addattr',addinfo='$addinfo',mediaset='$mediaset'";
	getDbUpdate($table['s_menu'],$QVAL,'uid='.$cat);
	
	$_SEO = getDbData($table['s_seo'],'uid='.(int)$seouid,'uid');
	if($_SEO['uid']) getDbUpdate($table['s_seo'],"title='$title',keywords='$keywords',description='$description',classification='$classification',image_src='$image_src'",'uid='.$_SEO['uid']);
	else getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'1','$cat','$title','$keywords','$description','$classification','$image_src'");


	$vfile = $g['path_page'].$r.'-menus/'.$id;
	if ($id != $R['id'])
	{
		$vfile1 = $g['path_page'].$r.'-menus/'.$R['id'];
		rename($vfile1.'.php',$vfile.'.php');
		rename($vfile1.'.widget.php',$vfile.'.widget.php');
		if(is_file($vfile1.'.css')) rename($vfile1.'.css',$vfile.'.css');
		if(is_file($vfile1.'.js')) rename($vfile1.'.js',$vfile.'.js');		
		if(is_file($vfile1.'.header.php')) rename($vfile1.'.header.php',$vfile.'.header.php');
		if(is_file($vfile1.'.footer.php')) rename($vfile1.'.footer.php',$vfile.'.footer.php');
		if(is_file($vfile1.'.txt')) rename($vfile1.'.txt',$vfile.'.txt');
		if(is_file($vfile1.'.cache')) rename($vfile1.'.cache',$vfile.'.cache');
		if(is_file($vfile1.'.widget.cache')) rename($vfile1.'.widget.cache',$vfile.'.widget.cache');
		if(is_file($vfile1.'.mobile.cache')) rename($vfile1.'.mobile.cache',$vfile.'.mobile.cache');
	}

	if (trim($codhead))
	{
		$fp = fopen($vfile.'.header.php','w');
		fwrite($fp, trim(stripslashes($codhead)));
		fclose($fp);
		@chmod($vfile.'.header.php',0707);
	}
	else {
		if(is_file($vfile.'.header.php'))
		{
			unlink($vfile.'.header.php');
		}
	}

	if (trim($codfoot))
	{
		$fp = fopen($vfile.'.footer.php','w');
		fwrite($fp, trim(stripslashes($codfoot)));
		fclose($fp);
		@chmod($vfile.'.footer.php',0707);
	}
	else {
		if(is_file($vfile.'.footer.php'))
		{
			unlink($vfile.'.footer.php');
		}
	}

	if ($cachetime)
	{
		$fp = fopen($vfile.'.txt','w');
		fwrite($fp, $cachetime);
		fclose($fp);
		@chmod($vfile.'.txt',0707);
	}
	else {
		if(is_file($vfile.'.txt'))
		{
			unlink($vfile.'.txt');
		}
	}


	if ($subcopy == 1)
	{
		include_once $g['path_core'].'function/menu.func.php';
		$subQue = getMenuCodeToSql($table['s_menu'],$cat,'uid');
		if ($subQue)
		{
			getDbUpdate($table['s_menu'],"hidden='".$hidden."',reject='".$reject."',perm_g='".$perm_g."',perm_l='".$perm_l."',layout='".$layout."'","uid <> ".$cat." and (".$subQue.")");
		}
	}
	getLink('reload','parent.','','');
}
else {

	$MAXC = getDbCnt($table['s_menu'],'max(gid)','depth='.($depth+1).' and parent='.$parent);
	$sarr = explode(',' , trim($name));
	$slen = count($sarr);

	for ($i = 0 ; $i < $slen; $i++)
	{
		if (!$sarr[$i]) continue;

		$gid	= $MAXC+1+$i;
		$xdepth	= $depth+1;
		$xname	= trim($sarr[$i]);
		$xnarr	= explode('=',$xname);

		$QKEY = "gid,site,is_child,parent,depth,id,menutype,mobile,hidden,reject,name,target,redirect,joint,perm_g,perm_l,layout,imghead,imgfoot,addattr,num,d_last,addinfo,mediaset";
		$QVAL = "'$gid','".$_HS['uid']."','0','$parent','$xdepth','$xnarr[1]','$menutype','$mobile','$hidden','$reject','$xnarr[0]','$target','$redirect','$joint','$perm_g','$perm_l','$layout','','','$addattr','0','','$addinfo','$mediaset'";

		getDbInsert($table['s_menu'],$QKEY,$QVAL);
		$lastmenu = getDbCnt($table['s_menu'],'max(uid)','');
		getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'1','$lastmenu','$title','$keywords','$description','$classification','$image_src'");


		if(!$redirect&&$menutype==1&&strstr($joint,'cync=Y'))
		{
			$ctarr = getMenuCodeToPath($table['s_menu'],$lastmenu,0);
			$catcode = '';
			$ctnum = count($ctarr);
			for ($j = 0; $j < $ctnum; $j++) $catcode .= $ctarr[$j]['id'].'/';
			$c = substr($catcode,0,strlen($catcode)-1);
			$joint = str_replace('cync=Y','cync=['.$m.'][c'.$lastmenu.'][,,,][][][c:'.$c.']',$joint);
		}
		if (!$xnarr[1])
		{
			$_newId = $lastmenu;
			getDbUpdate($table['s_menu'],"id='".$lastmenu."',joint='".$joint."'",'uid='.$lastmenu);
		}
		else {
			$_newId = $xnarr[1];
			$ISMCODE = getDbData($table['s_menu'],"uid<> ".$lastmenu." and id='".$xnarr[1]."' and site=".$s,'*');
			if ($ISMCODE['uid'])
			{
				$_newId = $lastmenu;
				getDbUpdate($table['s_menu'],"id='".$lastmenu."',joint='".$joint."'",'uid='.$lastmenu);
			}
		}

		$mfile = $g['path_page'].$r.'-menus/'.$_newId;

		$fp = fopen($mfile.'.php','w');
		fwrite($fp,'');
		fclose($fp);
		@chmod($mfile.'.php',0707);

		$fp = fopen($mfile.'.widget.php','w');
		fwrite($fp,'');
		fclose($fp);
		@chmod($mfile.'.widget.php',0707);

		if (trim($codhead))
		{
			$fp = fopen($mfile.'.header.php','w');
			fwrite($fp, trim(stripslashes($codhead)));
			fclose($fp);
			@chmod($mfile.'.header.php',0707);
		}

		if (trim($codfoot))
		{
			$fp = fopen($mfile.'.footer.php','w');
			fwrite($fp, trim(stripslashes($codfoot)));
			fclose($fp);
			@chmod($mfile.'.footer.php',0707);
		}

		if ($cachetime)
		{
			$fp = fopen($mfile.'.txt','w');
			fwrite($fp, $cachetime);
			fclose($fp);
			@chmod($mfile.'.txt',0707);
		}
	}
	
	if ($parent)
	{
		getDbUpdate($table['s_menu'],'is_child=1','uid='.$parent);
	}
	db_query("OPTIMIZE TABLE ".$table['s_menu'],$DB_CONNECT); 
	
	if ($i > 1)
	{
		getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=menu&cat='.$parent.'&code='.$code.'&vtype='.$vtype,'parent.','','');
	}
	else {
		getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=menu&cat='.$lastmenu.'&code='.$code.'/'.$lastmenu.'#site-menu-info','parent.','','');
	}
}
?>