<?php
//TIME얻기
function getCurrentDate()
{
	$MicroTsmp = explode(' ',microtime());
	return $MicroTsmp[0]+$MicroTsmp[1];
}
//링크
function getLink($url,$target,$alert,$history)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/getLink.lib.php';
}
//윈도우오픈
function getWindow($url,$alert,$option,$backurl,$target)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/getWindow.lib.php';
}
//검색sql
function getSearchSql($w,$k,$ik,$h)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/searchsql.lib.php';
	return LIB_getSearchSql($w,$k,$ik,$h);
}
//페이징
function getPageLink($lnum,$p,$tpage,$img)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/page.lib.php';
	return LIB_getPageLink($lnum,$p,$tpage,$img);
}
//문자열끊기
function getStrCut($long_str,$cutting_len,$cutting_str)
{
	$rtn = array();$long_str = trim($long_str);
    return preg_match('/.{'.$cutting_len.'}/su', $long_str, $rtn) ? $rtn[0].$cutting_str : $long_str;
}
//링크필터링
function getLinkFilter($default,$arr)
{
	foreach($arr as $val) if ($GLOBALS[$val]) $default .= '&amp;'.$val.'='.urlencode($GLOBALS[$val]);
	return $default;
}
//총페이지수
function getTotalPage($num,$rec)
{
	return @intval(($num-1)/$rec)+1;
}
//날짜포맷
function getDateFormat($d,$f)
{
	return $d ? getDateCal($f,$d,0) : '';
}
//시간조정/포맷
function getDateCal($f,$d,$h)
{
	return date($f,mktime((int)substr($d,8,2)+$h,(int)substr($d,10,2),(int)substr($d,12,2),substr($d,4,2),substr($d,6,2),substr($d,0,4)));
}
//시간값
function getVDate($t)
{
	$date['PROC']	= $t ? getDateCal('YmdHisw',date('YmdHis'),$t) : date('YmdHisw');
	$date['totime'] = substr($date['PROC'],0,14);
	$date['year']	= substr($date['PROC'],0,4);
	$date['month']	= substr($date['PROC'],0,6);
	$date['today']  = substr($date['PROC'],0,8);
	$date['nhour']  = substr($date['PROC'],0,10);
	$date['tohour'] = substr($date['PROC'],8,6);
	$date['toweek'] = substr($date['PROC'],14,1);
	return $date;
}
//남은날짜
function getRemainDate($d)
{
	if(!$d) return 0;
	return ((substr($d,0,4)-date('Y')) * 365) + (date('z',mktime(0,0,0,substr($d,4,2),substr($d,6,2),substr($d,0,4)))-date('z'));
}
//지난시간
function getOverTime($d1,$d2)
{
	if (!$d2) return array(0);
	$d1 = date('U',mktime(substr($d1,8,2),substr($d1,10,2),substr($d1,12,2),substr($d1,4,2),substr($d1,6,2),substr($d1,0,4)));
	$d2 = date('U',mktime(substr($d2,8,2),substr($d2,10,2),substr($d2,12,2),substr($d2,4,2),substr($d2,6,2),substr($d2,0,4)));
	$tx = $d1-$d2;$ar = array(1,60,3600,86400,2592000,31104000);
	for ($i = 0; $i < 5; $i++) if ($tx < $ar[$i+1]) return array((int)($tx/$ar[$i]),$i);
	return array(substr($d1,0,4)-substr($d2,0,4),5);
}
//요일
function getWeekday($n)
{
	return $GLOBALS['lang']['admin']['week'][$n];
}
//시간비교
function getNew($time,$term)
{
	if(!$time) return false;
	$dtime = date('YmdHis',mktime(substr($time,8,2)+$term,substr($time,10,2),substr($time,12,2),substr($time,4,2),substr($time,6,2),substr($time,0,4)));
	if ($dtime > $GLOBALS['date']['totime']) return true;
	else return false;
}
//퍼센트
function getPercent($a,$b,$flag)
{
	return round($a / $b * 100 , $flag);
}
//지정문자열필터링
function filterstr($str)
{
	$str = str_replace(',','',$str);
	$str = str_replace('.','',$str);
	$str = str_replace('-','',$str);
	$str = str_replace(':','',$str);
	$str = str_replace(' ','',$str);
	return $str;
}
//문자열복사
function strCopy($str1,$str2)
{
	$badstrlen = getUTFtoUTF($str1) == $str1 ? strlen($str1) : intval(strlen($str1)/3);
	return str_pad('',($badstrlen?$badstrlen:1),$str2);
}
//아웃풋
function getContents($str,$html)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/getContent.lib.php';
	return LIB_getContents($str,$html);
}
//쿠키배열
function getArrayCookie($ck,$split,$n)
{
	$arr = explode($split,$ck);
	return $arr[$n];
}
//대괄호배열
function getArrayString($str)
{
	$arr1 = array();
	$arr1['data'] = array();
	$arr2 = explode('[',$str);
	foreach($arr2 as $val)
	{
		if($val=='') continue;
		$arr1['data'][] = str_replace(']','',$val);
	}
	$arr1['count'] = count($arr1['data']);
	return $arr1;
}
//성별
function getSex($flag)
{
	return $GLOBALS['lang']['admin']['sex'][$flag-1];
}
//생일->나이
function getAge($birth)
{
	if (!$birth) return 0;
	return substr($GLOBALS['date']['today'],0,4) - substr($birth,0,4) + 1;
}
//나이->출생년도
function getAgeToYear($age)
{
	return substr($GLOBALS['date']['today'],0,4)-($age-1);
}
//사이즈포멧
function getSizeFormat($size,$flag)
{
	if ($size/(1024*1024*1024)>1) return round($size/(1024*1024*1024),$flag).'GB';
	if ($size/(1024*1024)>1) return round($size/(1024*1024),$flag).'MB';
	if ($size/1024>1) return round($size/1024,$flag).'KB';
	if ($size/1024<1) return $size.'B';
}
//파일타입
function getFileType($ext)
{
	if (strpos('_gif,jpg,jpeg,png,bmp,',strtolower($ext))) return 2;
	if (strpos('_swf,',strtolower($ext))) return 3;
	if (strpos('_mid,wav,mp3,',strtolower($ext))) return 4;
	if (strpos('_mp4,asf,asx,avi,mpg,mpeg,wmv,wma,mov,flv,',strtolower($ext))) return 5;
	if (strpos('_doc,xls,ppt,hwp',strtolower($ext))) return 6;
	if (strpos('_zip,tar,gz,tgz,alz,',strtolower($ext))) return 7;
	return 1;
}
//파일확장자
function getExt($name)
{
	$nx=explode('.',$name);
	return $nx[count($nx)-1];
}
//이미지추출
function getImgs($code,$type) 
{  
	$erg = '/src[ =]+[\'"]([^\'"]+\.(?:'.$type.'))[\'"]/i';  
	preg_match_all($erg, $code, $mtc, PREG_PATTERN_ORDER);
	return $mtc[1];
}
//이미지체크
function getThumbImg($img)
{
	$arr=array('.jpg','.gif','.png');
	foreach($arr as $val) if(is_file($img.$val)) return $GLOBALS['g']['s'].'/'.str_replace('./','',$img).$val;
}
function getUploadImage($upfiles,$d,$content,$ext)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/getUploadImage.lib.php';
	return LIB_getUploadImage($upfiles,$d,$content,$ext);
}
//도메인
function getDomain($url)
{
	$urlexp = explode('/',$url);
	return $urlexp[2];
}
//키워드
function getKeyword($url)
{
	$urlexp = explode('?' , urldecode($url));
	if (!trim($urlexp[1])) return '';
	$queexp = explode('&' , $urlexp[1]);
	$quenum = count($queexp);
	for ($i = 0; $i < $quenum; $i++){$valexp = explode('=',trim($queexp[$i])); if (strstr(',query,q,p,',','.$valexp[0].',')&&!is_numeric($valexp[1])) return $valexp[1] == getUTFtoUTF($valexp[1]) ? $valexp[1] : getKRtoUTF($valexp[1]);}
	return '';
}
//검색엔진
function getSearchEngine($url)
{
	$set = array('naver','nate','daum','yahoo','google');
	foreach($set as $val) if (strpos($url,$val)) return $val;
	return 'etc';
}
//브라우져
function getBrowzer($agent)
{
	if(isMobileConnect($agent)) return 'Mobile';
	$set = array('rv:12','rv:11','MSIE 10','MSIE 9','MSIE 8','MSIE 7','MSIE 6','Firefox','Opera','Chrome','Safari');
	foreach($set as $val) if (strpos('_'.$agent,$val)) return str_replace('rv:','MSIE ',$val);
	return '';
}
//디바이스종류
function getDeviceKind($agent,$type)
{
	if (!$type) return 'desktop';
	if ($type == 'ipad' || (strstr($agent,'android')&&!strstr($agent,'mobile'))) return 'tablet';
	return 'phone';   
}
//모바일접속체크
function isMobileConnect($agent)
{
	if($_SESSION['pcmode']=='E') return 'RB-Emulator';
	$_xagent = strtolower($agent);
	$_agents = array('android','iphone','ipad','ipod','blackberry','windows phone');
	foreach($_agents as $_key) if(strpos($_xagent,$_key)) return $_key;
	return '';
}
//폴더네임얻기
function getFolderName($file)
{
	if(is_file($file.'/name.txt')) return implode('',file($file.'/name.txt'));
	return basename($file);
}
function getKRtoUTF($str)
{
	return iconv('euc-kr','utf-8',$str);
}
function getUTFtoKR($str)
{
	return iconv('utf-8','euc-kr',$str);
}
function getUTFtoUTF($str)
{
	return iconv('utf-8','utf-8',$str);
}
//관리자체크
function checkAdmin($n)
{
	if(!$GLOBALS['my']['admin']) getLink('','',_LANG('fs001','admin'),$n?$n:'');
}
//MOD_rewrite
function RW($rewrite)
{
	if ($GLOBALS['_HS']['rewrite'])
	{
		if(!$rewrite) return $GLOBALS['g']['r']?$GLOBALS['g']['r']:'/';
		$rewrite = str_replace('c=','c/',$rewrite);
		$rewrite = str_replace('mod=','p/',$rewrite);
		$rewrite = str_replace('m=admin','admin',$rewrite);
		return $GLOBALS['g']['r'].'/'.$rewrite;
	}
	else return $GLOBALS['_HS']['usescode']?('./?r='.$GLOBALS['_HS']['id'].($rewrite?'&amp;'.$rewrite:'')):'./'.($rewrite?'?'.$rewrite:'');
}
//위젯불러오기
function getWidget($widget,$wdgvar)
{
	global $DB_CONNECT,$table,$date,$my,$r,$s,$m,$g,$d,$c,$mod,$_HH,$_HD,$_HS,$_HM,$_HP,$_CA;
	static $wcsswjsc;
	if (!is_file($g['wdgcod']) && !strpos('_'.$wcsswjsc,'['.$widget.']'))
	{
		$wcss = $g['path_widget'].$widget.'/main.css';
		$wjsc = $g['path_widget'].$widget.'/main.js';
		if (is_file($wcss)) $g['widget_cssjs'] .= '<link href="'.$g['s'].'/widgets/'.$widget.'/main.css" rel="stylesheet">'."\n";
		if (is_file($wjsc)) $g['widget_cssjs'] .= '<script src="'.$g['s'].'/widgets/'.$widget.'/main.js"></script>'."\n";
		$wcsswjsc.='['.$widget.']';
	}
	$wdgvar['widget_id'] = str_replace('/','-',$widget);
	$wdgvar['widgetlang'] = $_HS['lang']?$_HS['lang']:$d['admin']['syslang'];
	include getLangFile($g['path_widget'].$widget.'/lang.',$wdgvar['widgetlang'],'.php');
	include $g['path_widget'].$widget.'/main.php';
}
//문자열필터(@ 1.1.0)
function getStripTags($string)
{
	return str_replace('&nbsp;',' ',str_replace('&amp;nbsp;',' ',strip_tags($string)));
}
//스위치로드(@ 1.1.0)
function getSwitchInc($pos)
{
	$incs = array();
	if(isset($GLOBALS['d']['switch'][$pos]))
	{
		foreach ($GLOBALS['d']['switch'][$pos] as $switch => $sites)
		{
			if(strpos('_'.$sites,'['.$GLOBALS['r'].']'))
			$incs[] = $GLOBALS['g']['path_switch'].$pos.'/'.$switch.'/main.php';
		}
	}
	return $incs;
}
//알림기록(@ 2.0.0)
function putNotice($rcvmember,$sendmodule,$sendmember,$message,$referer,$target)
{
	global $g,$d,$s,$table,$date,$my,$_HS;
	include $g['path_module'].'notification/var/var.php';
	if ($rcvmember && $message && !strstr($d['ntfc']['cut_modules'],'['.$sendmodule.']'))
	{
		$R=getDbData($table['s_mbrdata'],'memberuid='.$rcvmember,'noticeconf');
		$N = explode('|',$R['noticeconf']);
		if (!$N[0] && !strstr($N[3],'['.$sendmodule.']') && !strstr($N[4],'['.$sendmember.']'))
		{
			$message = $my['admin'] ? $message : strip_tags($message);
			$QKEY = 'uid,mbruid,site,frommodule,frommbr,message,referer,target,d_regis,d_read';
			$QVAL = "'".$g['time_srnad']."','".$rcvmember."','".$s."','".$sendmodule."','".$sendmember."','".$message."','".$referer."','".$target."','".$date['totime']."',''";
			getDbInsert($table['s_notice'],$QKEY,$QVAL);
			getDbUpdate($table['s_mbrdata'],'num_notice='.getDbRows($table['s_notice'],'mbruid='.$rcvmember." and d_read=''"),'memberuid='.$rcvmember);
			if ($N[5])
			{
				include_once $g['path_core'].'function/email.func.php';
				$M = getDbData($table['s_mbrdata'],'memberuid='.$rcvmember,'name,email');
				getSendMail($M['email'].'|'.$M['name'],$my['email'].'|'.$my['nic'],'['.$_HS['name'].'] 새 알림이 도착했습니다.',$message,'HTML');
			}
		}
	}
}
//모달링크(@ 2.0.0)
function getModalLink($modal)
{
	global $g,$r;
	return $g['s'].'/?r='.$r.'&amp;iframe=Y&amp;modal='.$modal;
}
//JS/CSS임포트(@ 2.0.0)
function getImport($plugin,$path,$version,$kind)
{
	global $g,$d;
	if ($kind == 'js') echo '<script src="'.$g['s'].'/plugins/'.$plugin.'/'.($version?$version:$d['ov'][$plugin]).'/'.$path.'.js"></script>';
	else echo '<link href="'.$g['s'].'/plugins/'.$plugin.'/'.($version?$version:$d['ov'][$plugin]).'/'.$path.'.css" rel="stylesheet">';
}
//썸네일(@ 2.0.0)
function getThumbPic($width,$height,$crop,$img)
{
	global $g;
	return $g['s'].'/_core/opensrc/thumb/image.php?width='.($width?$width:'').'&amp;height='.($height?$height:'').'&amp;cropratio='.$crop.'&amp;image='.$img;
}
//트리(@ 2.0.0)
function getTreeMenu($conf,$code,$depth,$parent,$tmpcode)
{
	$ctype = $conf['ctype']?$conf['ctype']:'uid';
	$id = 'tree_'.filterstr(microtime());
	$tree = '<div class="rb-tree"><ul id="'.$id.'">';
	$CD=getDbSelect($conf['table'],($conf['site']?'site='.$conf['site'].' and ':'').'depth='.($depth+1).' and parent='.$parent.($conf['dispHidden']?' and hidden=0':'').($conf['mobile']?' and mobile=1':'').' order by gid asc','*');
	$_i = 0;
	while($C=db_fetch_array($CD))
	{
		$rcode= $tmpcode?$tmpcode.'/'.$C[$ctype]:$C[$ctype];
		$topen= $rcode==substr($code,0,strlen($rcode))?true:false;
		$tree.= '<li>';
		if ($C['is_child'])
		{
			$tree.= '<a data-toggle="collapse" href="#'.$id.'-'.$_i.'-'.$C['uid'].'" class="rb-branch'.($conf['allOpen']||$topen?'':' collapsed').'"></a>';
			if ($conf['userMenu']=='link') $tree.= '<a href="'.RW('c='.$rcode).'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			else if($conf['userMenu']=='bookmark') $tree.= '<a data-scroll href="#rb-tree-menu-'.$C['id'].'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			else $tree.= '<a href="'.$conf['link'].$C['uid'].'&amp;code='.$rcode.($conf['bookmark']?'#'.$conf['bookmark']:'').'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			if($conf['dispCheckbox']) $tree.= '<input type="checkbox" name="tree_members[]" value="'.$C['uid'].'">';
			if($C['hidden']) $tree.='<u title="'._LANG('fs002','admin').'" data-tooltip="tooltip">';
			$tree.= $C['name'];
			if($C['hidden']) $tree.='</span>';
			$tree.='</u></a>';

			if($conf['dispNum']&&$C['num']) $tree.= ' <small>('.$C['num'].')</small>';
			if(!$conf['hideIcon'])
			{
				if($C['mobile']) $tree.= '<i class="glyphicon glyphicon-phone" title="'._LANG('fs005','admin').'" data-tooltip="tooltip"></i>&nbsp;';
				if($C['target']) $tree.= '<i class="glyphicon glyphicon-new-window" title="'._LANG('fs004','admin').'" data-tooltip="tooltip"></i>&nbsp;';
				if($C['reject']) $tree.= '<i class="glyphicon glyphicon-ban-circle" title="'._LANG('fs003','admin').'" data-tooltip="tooltip"></i>';
			}

			$tree.= '<ul id="'.$id.'-'.$_i.'-'.$C['uid'].'" class="collapse'.($conf['allOpen']||$topen?' in':'').'">';
			$tree.= getTreeMenu($conf,$code,$C['depth'],$C['uid'],$rcode);
			$tree.= '</ul>';
		}
		else {
			$tree.= '<a href="#." class="rb-leaf"></a>';
			if ($conf['userMenu']=='link') $tree.= '<a href="'.RW('c='.$rcode).'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			else if ($conf['userMenu']=='bookmark') $tree.= '<a data-scroll href="#rb-tree-menu'.$C['id'].'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			else $tree.= '<a href="'.$conf['link'].$C['uid'].'&amp;code='.$rcode.($conf['bookmark']?'#'.$conf['bookmark']:'').'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			if($conf['dispCheckbox']) $tree.= '<input type="checkbox" name="tree_members[]" value="'.$C['uid'].'">';
			if($C['hidden']) $tree.='<u title="'._LANG('fs002','admin').'" data-tooltip="tooltip">';
			$tree.= $C['name'];
			if($C['hidden']) $tree.='</u>';
			$tree.='</span></a>';

			if($conf['dispNum']&&$C['num']) $tree.= ' <small>('.$C['num'].')</small>';
			if(!$conf['hideIcon'])
			{
				if($C['mobile']) $tree.= '<i class="glyphicon glyphicon-phone" title="'._LANG('fs005','admin').'" data-tooltip="tooltip"></i>&nbsp;';
				if($C['target']) $tree.= '<i class="glyphicon glyphicon-new-window" title="'._LANG('fs004','admin').'" data-tooltip="tooltip"></i>&nbsp;';
				if($C['reject']) $tree.= '<i class="glyphicon glyphicon-ban-circle" title="'._LANG('fs003','admin').'" data-tooltip="tooltip"></i>';
			}
		}
		$tree.= '</li>';
		$_i++;
	}
	$tree.= '</ul></div>';
	return $tree;
}
//현재경로(@ 2.0.0)
function getLocation($loc)
{
	if ($loc) return str_replace(' - Home - ','',strip_tags(str_replace('<li',' - <li',$loc)));
	else {
		global $g,$table,$_HS,$_HP,$_HM,$_CA,$c;
		$_loc = '<li><a href="'.RW(0).'">Home</a></li>';
		if ($_HM['uid'])
		{
			$_cnt = count($_CA)-1;
			$_cod = '';
			for ($i = 0; $i < $_cnt; $i++)
			{
				$_val  = getDbData($table['s_menu'],"id='".$_CA[$i]."'",'id,name');
				$_cod .= $_val['id'].'/';
				$_loc .= '<li><a href="'.RW('c='.substr($_cod,0,strlen($_cod)-1)).'">'.$_val['name'].'</a></li>';
			}
			$_loc .= '<li class="active">'.$_HM['name'].'</li>';		
		}
		else if ($_HP['uid'])
		{
			if ($_HP['linkedmenu'])
			{
				$_sok = explode('/',$_HP['linkedmenu']);
				$_cnt = count($_sok);
				$_cod = '';
				for ($i = 0; $i < $_cnt; $i++)
				{
					$_val  = getDbData($table['s_menu'],"id='".$_CA[$i]."'",'id,name');
					$_cod .= $_val['id'].'/';
					$_loc .= '<li><a href="'.RW('c='.substr($_cod,0,strlen($_cod)-1)).'">'.$_val['name'].'</a></li>';
				}
			}
			$_loc .= '<li class="active">'.$_HP['name'].'</li>';					
		}
		else if ($g['push_location'])
		{
			$_loc .= $g['push_location'];								
		}
		return $_loc;
	}
}
//페이지타이틀(@ 2.0.0)
function getPageTitile()
{
	global $g,$_HS,$_HP,$_HM;
	$title = str_replace('{site}',$_HS['name'],$_HS['title']);
	$title = str_replace('{location}',getLocation($g['location']),$title);
	if ($_HM['uid']) $title = str_replace('{subject}',$_HM['name'],$title);
	else if ($_HP['uid']) $title = str_replace('{subject}',$_HP['name'],$title); 
	else $title = $_HS['name'];
	return $title;
}
//메타이미지(@ 2.0.0)
function getMetaImage($str)
{
	if (!$str) return '';
	if (strstr($str,'://'))	return $str;
	$imgs = getArrayString($str);
	$R = getUidData($GLOBALS['table']['s_upload'],$imgs['data'][0]);
	if ($R['type'] == 2 || $R['type'] == 5) return $R['url'].$R['folder'].'/'.$R['tmpname'];
	if ($R['type'] == -1) return $R['src'];
	return '';
}
//암호화(@ 2.0.0)
function getCrypt($str,$salt)
{
	$salt = substr(base64_encode($salt.'salt'),0,22);
	$ver0 = implode('',file($GLOBALS['g']['path_var'].'php.version.txt'));
	$ver1 = explode('.',$ver0);
	if ($ver1[0] > 5 || ($ver1[0] > 4 && $ver1[1] > 4 && $ver1[1] > 4))
	if(function_exists('password_hash')) return password_hash($str,PASSWORD_BCRYPT,array('cost'=>10,'salt'=>$salt)).'$1';
	if ($ver1[0] > 5 || ($ver1[0] > 4 && $ver1[1] > 0 && $ver1[1] > 1))
	{
		if (in_array('sha512',hash_algos())) return hash('sha512',$str.$salt).'$2';
		else if (in_array('sha256',hash_algos())) return hash('sha256',$str.$salt).'$3';
	}
	return md5(sha1(md5($str.$salt))).'$4';
}
//언언반환(@ 2.0.0)
function _LANG($kind,$module)
{
	return $GLOBALS['lang'][$module][$kind];
}
//언언셋인클루드(@ 2.0.0)
function getLangFile($path,$lang,$file)
{
	$langFile1 = $path.$lang.$file;
	$langFile2 = $path.'DEFAULT'.$file;
	if (is_file($langFile1)) return $langFile1;
	else if(is_file($langFile2)) return $langFile2;
	else return $GLOBALS['g']['path_var'].'empty.php';
}
?>