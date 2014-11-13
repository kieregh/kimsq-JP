<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$_tmpdfile = $g['dir_module'].'var/var.search.php';
$fp = fopen($_tmpdfile,'w');
fwrite($fp, "<?php\n");
fwrite($fp, "\$d['search']['theme'] = \"".$theme."\";\n");
fwrite($fp, "\$d['search']['num1'] = \"".$num1."\";\n");
fwrite($fp, "\$d['search']['num2'] = \"".$num2."\";\n");
fwrite($fp, "\$d['search']['term'] = \"".$term."\";\n");
fwrite($fp, "\$d['search']['layout'] = \"".$layout."\";\n");
fwrite($fp, "?>");
fclose($fp);
@chmod($_tmpdfile,0707);

$_tmpdfile = $g['dir_module'].'var/search.list.txt';
$fp = fopen($_tmpdfile,'w');
fwrite($fp,trim(stripslashes($searchlist)));
fclose($fp);
@chmod($_tmpdfile,0707);

getLink('reload','parent.',_LANG('a1001','search'),'');
?>