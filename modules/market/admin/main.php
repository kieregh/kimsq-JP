<?php 
include $g['path_module'].$module.'/var/var.php';
if($d['market']['url']):
include $g['path_core'].'function/rss.func.php';
$marketData = getUrlData($d['market']['url'].'&iframe=Y&page=client.front&_clientu='.$g['s'].'&_clientr='.$r.'&cat='.$cat.'&theme='.$theme.'&sort='.$sort.'&orderby='.$orderby.'&type='.$type.'&ptype='.$ptype.'&p='.$p.'&todayfree='.$todayfree.'&sailing='.$sailing.'&where='.$where.'&keyword='.$keyword.'&brand='.$brand.'&id='.$d['market']['id'].'&pw='.$d['market']['pw'].'&version=2',10);
$marketData = explode('[RESULT:',$marketData);
$marketData = explode(':RESULT]',$marketData[1]);
$marketData = $marketData[0];
echo $marketData;
else:?>
<div class="noconfig">
<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=config"><?php echo _LANG('a2001','market')?></a>
</div>
<?php endif?>