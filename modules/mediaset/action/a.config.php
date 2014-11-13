<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
$ftp_port = $ftp_port ? trim($ftp_port) : '21';
$_tmpdfile = $g['dir_module'].'var/var.php';
$fp = fopen($_tmpdfile,'w');
fwrite($fp, "<?php\n");
fwrite($fp, "\$d['mediaset']['maxnum_file'] = \"".$maxnum_file."\";\n");
fwrite($fp, "\$d['mediaset']['maxsize_file'] = \"".$maxsize_file."\";\n");
fwrite($fp, "\$d['mediaset']['maxnum_img'] = \"".$maxnum_img."\";\n");
fwrite($fp, "\$d['mediaset']['maxsize_img'] = \"".$maxsize_img."\";\n");
fwrite($fp, "\$d['mediaset']['maxnum_vod'] = \"".$maxnum_vod."\";\n");
fwrite($fp, "\$d['mediaset']['maxsize_vod'] = \"".$maxsize_vod."\";\n");
fwrite($fp, "\$d['mediaset']['thumbsize'] = \"".$thumbsize."\";\n");
fwrite($fp, "\$d['mediaset']['use_fileserver'] = \"".$use_fileserver."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_type'] = \"".$ftp_type."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_host'] = \"".trim($ftp_host)."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_port'] = \"".$ftp_port."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_user'] = \"".trim($ftp_user)."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_pasv'] = \"".$ftp_pasv."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_pass'] = \"".trim($ftp_pass)."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_folder'] = \"".trim($ftp_folder)."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_urlpath'] = \"".trim($ftp_urlpath)."\";\n");
fwrite($fp, "?>");
fclose($fp);
@chmod($_tmpdfile,0707);

getLink('reload','parent.',_LANG('a0006','mediaset'),'');
?>