<?php 
$step_start = 1;
$pwd_start = $g['path_widget'];
$g['adm_href'] = $g['s']."/?r=".$r."&amp;system=".$system."&amp;iframe=".$iframe.($dropfield?"&amp;dropfield=".$dropfield:'').($option?"&amp;option=".$option:'').($isWcode?"&amp;isWcode=".$isWcode:'').($isEdit?"&amp;isEdit=".$isEdit:'');

if ($option)
{
	$wdgvar=array();
	//$swval=explode(',',getKRtoUTF(urldecode(str_replace('[!]','&',$option))));
	$swval=explode(',',urldecode(str_replace('[!]','&',$option)));
	$swidget=$swval[0];
	$pwd = $pwd_start.$swidget.'/';

	foreach($swval as $_cval)
	{
		$_xval=explode('^',$_cval);
		$wdgvar[$_xval[0]]=$_xval[1];
	}
}
else {
	$pwd = $pwd ? urldecode($pwd) : $pwd_start;
	$swidget = is_file($pwd.'main.php') ? str_replace($g['path_widget'],'',$pwd) : '';
	if ($swidget) $swidget = substr($swidget,0,strlen($swidget)-1);
}


if (strstr($pwd,'..'))
{
    getLink('','',_LANG('sa001','site'),'close');
}
if(!is_dir($pwd))
{
	getLink('','',_LANG('sa002','site'),'close');
}

function getDirexists($dir)
{
    $opendir = opendir($dir);
    while(false !== ($file = readdir($opendir)))
	{
        if(is_dir($dir.'/'.$file) && !strstr('[.][..][images][data]',$file)){$fex = 1; break;}
    }
    closedir($opendir);
    return $fex;
}
function getPrintdir( $nTab, $filepath, $files, $state ,$dir_ex)
{
    global $g,$pwd,$file,$step_start;
    
    if($step_start) { $nTab = $nTab - $step_start; }
	$css = strstr($pwd,$filepath) ? ' active' : '';
	$fname1 = getKRtoUTF($files);
	$fname2 = getFolderName($filepath);

    echo '<a href="'.$g['adm_href'].'&amp;pwd='.urlencode($filepath).'" class="list-group-item';
    if($state && $dir_ex) {
		echo '"><span><img src="'.$g['img_core'].'/blank.gif" width="'.(($nTab*17)+3).'" height="1" alt=""><i class="glyphicon glyphicon-folder-close"></i>&nbsp; ';
    }
    else if (!$state && $dir_ex) {
		echo '"><span><img src="'.$g['img_core'].'/blank.gif" width="'.(($nTab*17)+3).'" height="1" alt=""><i class="glyphicon glyphicon-folder-open"></i>&nbsp; ';
    }
    else {
		echo $css.'" style="color:#'.($css?'fff':'999').'"><span><img src="'.$g['img_core'].'/blank.gif" width="'.(($nTab*17)+3).'" height="1" alt=""><i class="fa fa-puzzle-piece"></i>&nbsp; ';
    }
	echo $fname2.'</span></a>';
}
function getDirlist($dirpath,$nStep)
{
    global $pwd;
    $arrPath = explode('/', $pwd );

    if( $dir_handle = opendir($dirpath) )
    {
        while( false !== ($files = readdir($dir_handle)) )
        {
            $subDir = $dirpath.$files.'/';
            if(is_dir($subDir) && !strstr('[.][..][images][data]',$files))
            {
                getPrintdir( $nStep, $subDir, $files, !strstr($pwd,$subDir) , getDirexists($subDir) );
                if( $arrPath[$nStep+1] == $files ) {
                    getDirlist( $subDir, $nStep+1);
                }
            }
        }
    }
    closedir( $dir_handle );
}
function getWidgetPreviewImg($path)
{
	if (is_file($path.'.jpg')) return $path.'.jpg';
	if (is_file($path.'.gif')) return $path.'.gif';
	if (is_file($path.'.png')) return $path.'.png';
	return false;
}
?>
<div id="widgetbox">
	<div class="category">
		<?php getDirlist($pwd_start,$step_start)?>
	</div>
	<div class="content">
		<?php if($swidget):?>
		<?php if($option):?>
		<input type="hidden" id="s_w" value="">
		<input type="hidden" id="s_h" value="">
		<input type="hidden" id="s_t" value="">
		<input type="hidden" id="s_l" value="">
		<?php endif?>

		<ul class="nav nav-tabs" role="tablist">
			<li class="active"><a href="#code" role="tab" data-toggle="tab"><?php echo _LANG('sa008','site')?></a></li>
			<li><a href="#preview" role="tab" data-toggle="tab"><?php echo _LANG('sa009','site')?></a></li>
			<?php if($isWcode=='Y'):?>
			<li class="pull-right"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=deletewidget&amp;pwd=<?php echo $pwd?>" title="<?php echo _LANG('sa011','site')?>" data-tooltip="tooltip" data-placement="left" onclick="return hrefCheck(this,true,'<?php echo _LANG('sa012','site')?>');"><i class="glyphicon glyphicon-trash"></i></a></li>
			<?php endif?>
		</ul>

		<div class="tab-content" style="padding-top:12px">
			<div class="tab-pane active" id="code">
				<?php include getLangFile($g['path_widget'].$swidget.'/lang.',$d['admin']['syslang'],'.php')?>
				<?php include $g['path_widget'].$swidget.'/admin.php'?>
			</div>
			<div class="tab-pane" id="preview">
				<?php $_widgetPreview=getWidgetPreviewImg($g['path_widget'].$swidget.'/thumb')?>
				<?php if($_widgetPreview):?>
				<a href="<?php echo $_widgetPreview?>" target="_blank"><img src="<?php echo $_widgetPreview?>" width="100%" style="margin-top:10px;" alt=""></a>
				<?php else:?>
				<div class="none">
					<i class="fa fa-puzzle-piece fa-5x"></i><br><br>
					<?php echo _LANG('sa010','site')?>
				</div>
				<?php endif?>
			</div>
		</div>

		<?php else:?>
		<?php if($isWcode=='Y'):?>
		<ul class="nav">
			<li class="pull-right"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=deletewidget&amp;pwd=<?php echo $pwd?>" title="<?php echo _LANG('sa011','site')?>" data-tooltip="tooltip" data-placement="left" onclick="return hrefCheck(this,true,'<?php echo _LANG('sa012','site')?>');"><i class="glyphicon glyphicon-trash"></i></a></li>
		</ul>
		<?php endif?>
		<div class="none">
			<i class="fa fa-puzzle-piece fa-5x"></i><br><br>
			<?php echo _LANG('sa003','site')?>
		</div>
		<?php endif?>
		<textarea id="rb-widget-code-result" class="hidden"></textarea>
	</div>
</div>


<!----------------------------------------------------------------------------
@부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->

<div id="_modal_header" class="hidden">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title"><i class="kf-widget kf-lg"></i> <?php echo _LANG('sa004','site')?></h4>
</div>

<div id="_modal_footer" class="hidden">
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal" aria-hidden="true" id="_modalclosebtn_"><?php echo _LANG('s0003','site')?></button>
	<?php if(!$isWcode||$isEdit):?>
	<?php if($isCodeOnly):?>
	<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window._widgetCode();modalSetting('.rb-modal-x','<?php echo getModalLink('site/pages/popup.widget.code')?>');" data-toggle="modal" data-target=".rb-modal-x"<?php if(!$swidget):?> disabled<?php endif?>><?php echo _LANG('sa005','site')?></a>
	<button type="button" class="btn btn-default" disabled><?php echo _LANG('sa006','site')?></button>
	<?php else:?>
	<button type="button" class="btn btn-default" onclick="frames._modal_iframe_modal_window._widgetCode();modalSetting('.rb-modal-x','<?php echo getModalLink('site/pages/popup.widget.code')?>');" data-toggle="modal" data-target=".rb-modal-x"<?php if(!$swidget):?> disabled<?php endif?>><?php echo _LANG('sa005','site')?></a>
	<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window._saveCheck(<?php echo $isEdit?1:0?>);"<?php if(!$swidget):?> disabled<?php endif?>><?php echo _LANG('sa007','site')?></button>
	<?php endif?>
	<?php else:?>
	<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window._widgetCode();modalSetting('.rb-modal-x','<?php echo getModalLink('site/pages/popup.widget.code')?>');" data-toggle="modal" data-target=".rb-modal-x"<?php if(!$swidget):?> disabled<?php endif?>><?php echo _LANG('sa005','site')?></a>
	<?php endif?>
</div>
	



<script>
function _widgetCode()
{
	getId('rb-widget-code-result').innerHTML = widgetCode(0);
}
function _saveCheck(n)
{
	saveCheck(n);
	parent.$('#modal_window').modal('hide');
}
function dropJoint(m)
{
	var f = opener.getId('<?php echo $dropfield?>');
	f.value = m;
	f.focus();
	top.close();
}

<?php if($swidget && $option):?>
var dp = <?php echo $dropfield?>;
var sz = parent.moveObject[dp];
getId('s_w').value = parseInt(sz.style.width);
getId('s_h').value = parseInt(sz.style.height);
getId('s_t').value = parseInt(sz.style.top);
getId('s_l').value = parseInt(sz.style.left);
<?php endif?>

function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.width = '100%';
	parent.getId('modal_window_dialog_modal_window').style.paddingRight = '20px';
	parent.getId('modal_window_dialog_modal_window').style.maxWidth = '800px';
	parent.getId('_modal_iframe_modal_window').style.height = '430px';
	parent.getId('_modal_body_modal_window').style.height = '430px';

	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_body_modal_window').style.padding = '0';
	parent.getId('_modal_body_modal_window').style.margin = '0';

	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
}
modalSetting();
</script>