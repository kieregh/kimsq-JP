<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$_tmpdfile = $g['path_layout'].$layout.'/_var/_var.php';
include $themelang2 ? $themelang2 : $themelang1;
include $_tmpdfile;

$fp = fopen($_tmpdfile,'w');
fwrite($fp, "<?php\n");

foreach($d['layout']['dom'] as $_key => $_val)
{
	if(!count($_val[2])) continue;
	foreach($_val[2] as $_v)
	{
		if($_v[1] == 'checkbox')
		{
			foreach(${'layout_'.$_key.'_'.$_v[0].'_chk'} as $_chk)
			{
				${'layout_'.$_key.'_'.$_v[0]} .= $_chk.',';
			}

			fwrite($fp, "\$d['layout']['".$_key.'_'.$_v[0]."'] = \"".trim(${'layout_'.$_key.'_'.$_v[0]})."\";\n");
			${'layout_'.$_key.'_'.$_v[0]} = '';
		}
		else if ($_v[1] == 'textarea')
		{
			fwrite($fp, "\$d['layout']['".$_key.'_'.$_v[0]."'] = \"".trim(${'layout_'.$_key.'_'.$_v[0]})."\";\n");
		}
		else if ($_v[1] == 'file')
		{

			$tmpname	= $_FILES['layout_'.$_key.'_'.$_v[0]]['tmp_name'];
			if (is_uploaded_file($tmpname))
			{
				$realname	= $_FILES['layout_'.$_key.'_'.$_v[0]]['name'];
				$fileExt	= strtolower(getExt($realname));
				$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;
				$fileName	= 'logo.'.$fileExt;
				$saveFile	= $g['path_layout'].$layout.'/_var/'.$fileName;
				if (!strstr('[gif][jpg][png][swf]',$fileExt))
				{
					continue;
				}

				move_uploaded_file($tmpname,$saveFile);
				@chmod($saveFile,0707);
			}
			else {
				$fileName	= $d['layout'][$_key.'_'.$_v[0]];
				if ($fileName && ${'layout_'.$_key.'_'.$_v[0].'_del'})
				{
					unlink( $g['path_layout'].$layout.'/_var/'.$fileName);
					$fileName = '';
				}
			}
			fwrite($fp, "\$d['layout']['".$_key.'_'.$_v[0]."'] = \"".$fileName."\";\n");
		}
		else {
			fwrite($fp, "\$d['layout']['".$_key.'_'.$_v[0]."'] = \"".trim(${'layout_'.$_key.'_'.$_v[0]})."\";\n");
		}
	}
}

fwrite($fp, "?>");
fclose($fp);
@chmod($_tmpdfile,0707);

getLink('reload','parent.frames._ADMPNL_.',_LANG('a0004','site'),'');
?>