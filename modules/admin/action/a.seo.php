<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if ($act == 'robots')
{
	$rfolder = $_SERVER['DOCUMENT_ROOT'];
	if(!is_writable($rfolder))
	{
		getLink('','',sprintf(_LANG('','admin'),$rfolder),'');
	}
	$rfile = $rfolder.'/robots.txt';
	$fp = fopen($rfile,'w');
	fwrite($fp, trim(stripslashes($robotstxt)));
	fclose($fp);
	@chmod($rfile,0707);
	
	getLink('','',_LANG('a7002','admin'),'');
}
if ($act == 'robots_delete')
{
	@unlink($_SERVER['DOCUMENT_ROOT'].'/robots.txt');
	getLink('reload','parent.',_LANG('a7003','admin'),'');
}
if ($act == 'sitemap_delete')
{
	@unlink('./sitemap.xml');
	getLink('reload','parent.',_LANG('a7003','admin'),'');
}
if ($act == 'sitemap_save')
{
	$gfile= './sitemap.xml';
	$fp = fopen($gfile,'w');
	fwrite($fp,trim(stripslashes($configdata)));
	fclose($fp);
	@chmod($gfile,0707);

	getLink('','',_LANG('a7002','admin'),'');
}
if ($act == 'sitemap_make')
{
	function getMenuUrlCode($site,$table,$parent,$depth,$uid,$code)
	{
		static $string;

		$xdepth = $depth+1;
		$CD=getDbSelect($table,($site?'site='.$site.' and ':'').'depth='.$xdepth.' and parent='.$parent.' and hidden=0 and reject=0 order by gid asc','*');
		while($C=db_fetch_array($CD))
		{
			$code1 = $code.$C['id'].'/';
			$_code = substr($code1,0,strlen($code1)-1);
			
			$string .= "<url><loc>".getRWurl('c='.$_code)."</loc></url>\n";
			
			if ($C['isson'])
			{
				getMenuUrlCode($site,$table,$C['uid'],$C['depth'],$uid,$code1);
			}
		}
		return $string;
	}
	function getRWurl($url)
	{
		global $_HS,$g;
		if ($_HS['rewrite'])
		{
			return 'http://'.$_SERVER['HTTP_HOST'].str_replace('./','/',RW($url));
		}
		else {
			return $g['url_root'].htmlspecialchars(str_replace('&amp;','&',str_replace('./','/',RW($url))));
		}
	}

	$gfile= './sitemap.xml';
	$fp = fopen($gfile,'w');

	fwrite($fp,"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
	fwrite($fp,"<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:image=\"http://www.google.com/schemas/sitemap-image/1.1\" xmlns:video=\"http://www.google.com/schemas/sitemap-video/1.1\">\n\n");
	fwrite($fp,getMenuUrlCode($s,$table['s_menu'],0,0,0,''));
	fwrite($fp,"\n");
	fwrite($fp,"</urlset>\n");
	fclose($fp);
	@chmod($gfile,0707);

	getLink('reload','parent.',_LANG('a7004','admin'),'');
}
exit;
?>