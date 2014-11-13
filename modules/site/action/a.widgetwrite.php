<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$vfile = $type == 'menu' ? $g['path_page'].$r.'-menus/'.$id.'.widget.php' : $g['path_page'].$r.'-pages/'.$id.'.widget.php';
$fp = fopen($vfile,'w');

fwrite($fp, "<?php\r\n");
fwrite($fp, "\$d['page']['mainheight'] = \"".$mainheight."\";\r\n");
fwrite($fp, stripslashes($escapevar)."\r\n");
fwrite($fp, "?>");

fclose($fp);
@chmod($vfile,0707);
$cachefile = str_replace('.php','.cache',$vfile);
if(file_exists($cachefile)) unlink($cachefile);

getLink('reload','parent.',_LANG('a0003','site'),'');
?>