<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$_ufile = $g['dir_module'].'var/var.order.php';
$fp = fopen($_ufile,'w');
fwrite($fp, "<?php\n");

foreach ($searchmembers as $_key)
{
	$_val = explode('|',$_key);
	fwrite($fp, "\$d['search_order']['".$_val[0]."'] = array('".$_val[1]."','".$_val[2]."','".$_val[3]."');\n");

}
fwrite($fp, "?>");
fclose($fp);
@chmod($_ufile,0707);

if ($autoCheck) exit;
getLink('reload','parent.',$auto?'':_LANG('a3001','search'),'');
?>