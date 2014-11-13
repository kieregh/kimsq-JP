<?php 
include $g['path_core'].'function/rss.func.php';
include $g['path_module'].'market/var/var.php';
$_serverinfo = explode('/',$d['market']['url']);
$_updatelist = getUrlData('http://'.$_serverinfo[2].'/__update/update.v2.txt',10);
$_updatelist = explode("\n",$_updatelist);
$_updatelength = count($_updatelist)-1;
$_version = explode('.',$d['admin']['version']);
$recnum	=  10;
$TPG = getTotalPage($_updatelength,$recnum);
?>

<div id="update-body">
	<div class="page-header">
	  <h4><?php echo _LANG('a8001','admin')?></h4>
	</div>

	<div class="media well">
	  <div class="pull-left version">
		<span class="fa kf-bi-01"></span> Rb <i><?php echo $d['admin']['version']?></i>
	  </div>
	  <div class="media-body hidden-xs">
		<?php echo _LANG('a8002','admin')?>
	  </div>
	</div>

	<div class="update-info table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr class="active">
					<th><?php echo _LANG('a8003','admin')?></th>
					<th><?php echo _LANG('a8004','admin')?></th>
					<th><?php echo _LANG('a8005','admin')?></th>
					<th><?php echo _LANG('a8006','admin')?></th>
					<th><?php echo _LANG('a8007','admin')?></th>
				</tr>
			</thead>
			<tbody>

				<?php $_ishistory=false?>
				<?php for($i = $_updatelength-(($p-1)*$recnum)-1; $i > $_updatelength-($p*$recnum)-1; $i--):?>
				<?php $_update=trim($_updatelist[$i]);if(!$_update)continue?>
				<?php $var1=explode(',',$_update)?>
				<?php $var2=explode(',',$_updatelist[$i-1])?>
				<?php $_updatefile=$g['path_var'].'update/'.$var1[1].'.txt'?>
				<?php if(is_file($_updatefile)):?>
				<?php $_supdate=explode(',',implode('',file($_updatefile)))?>

				<tr class="active">
					<td>
						<span><?php echo $var1[0]?></span>
					</td>
					<td>
						<span>
							<?php if($var1[2]):?>
							<a href="<?php echo $var1[2]?>" target="_blank" data-tooltip="tooltip" title="<?php echo _LANG('a8008','admin')?>"><?php echo $var1[0]?>_<?php echo $var1[1]?></a>
							<?php else:?>
							<a href="#." data-tooltip="tooltip" title="<?php echo _LANG('a8009','admin')?>"><?php echo $var1[0]?>_<?php echo $var1[1]?></a>
							<?php endif?>
							&nbsp;
							<a href="http://<?php echo $_serverinfo[2]?>/__update/files/v2/<?php echo $var1[1]?>.zip" class="rb-update-download" data-tooltip="tooltip" title="<?php echo _LANG('a8010','admin')?>"><i class="glyphicon glyphicon-download-alt"></i></a>
						</span>
					</td>
					<td>
						<span><?php echo getDateFormat($_supdate[0],'Y.m.d')?></span>
					</td>
					<td>
						<button class="btn btn-default disabled">
							<i class="fa fa-circle-o"></i> <?php echo _LANG('a8011','admin')?> <?php if($_supdate[1]):?>(<?php echo _LANG('a8012','admin')?>)<?php else:?>(<?php echo _LANG('a8013','admin')?>)<?php endif?>
						</button>
					</td>
					<td>
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;a=update&amp;type=delete&amp;ufile=<?php echo $var1[1]?>" title="<?php echo _LANG('a8014','admin')?>" onclick="return hrefCheck(this,true,'<?php echo _LANG('a8015','admin')?>');" class="btn btn-default"><i class="fa fa-times"></i> <?php echo _LANG('a8016','admin')?></a>
					</td>
				</tr>

				<?php else:?>

				<tr>
					<td>
						<span><?php echo $var1[0]?></span>
					</td>
					<td>
						<span>
							<?php if($var1[2]):?>
							<a href="<?php echo $var1[2]?>" target="_blank" data-tooltip="tooltip" title="<?php echo _LANG('a8008','admin')?>"><?php echo $var1[0]?>_<?php echo $var1[1]?></a>
							<?php else:?>
							<a href="#." data-tooltip="tooltip" title="<?php echo _LANG('a8009','admin')?>"><?php echo $var1[0]?>_<?php echo $var1[1]?></a>
							<?php endif?>
							&nbsp;
							<a href="http://<?php echo $_serverinfo[2]?>/__update/files/v2/<?php echo $var1[1]?>.zip" class="rb-update-download" data-tooltip="tooltip" title="<?php echo _LANG('a8010','admin')?>"><i class="glyphicon glyphicon-download-alt"></i></a>
						</span>
					</td>
					<td></td>
					<td>
						<button class="btn btn-default disabled">
							<i class="glyphicon glyphicon-pause"></i> <?php echo _LANG('a8017','admin')?>
						</button>					
					</td>
					<td>
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;a=update&amp;type=auto&amp;ufile=<?php echo $var1[1]?>" onclick="return hrefCheck(this,true,'<?php echo _LANG('a8018','admin')?>');" class="btn btn-primary"><i class="glyphicon glyphicon-download-alt"></i> <?php echo _LANG('a8019','admin')?></a>
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;a=update&amp;type=manual&amp;ufile=<?php echo $var1[1]?>" onclick="return hrefCheck(this,true,'<?php echo _LANG('a8020','admin')?>');" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i> <?php echo _LANG('a8021','admin')?></a>
					</td>
				</tr>

				<?php endif?>
				<?php endfor?>
				<?php if(!$_updatelength):?>
				<tr>
				<td colspan="5"><?php echo _LANG('a8022','admin')?></td>
				</tr>
				<?php endif?>
			</tbody>
		</table>

		<?php if($TPG>1):?>
		<div class="text-center">
			<ul class="pagination">
			<script>getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'');</script>
			<?php //echo getPageLink(10,$p,$TPG,'')?>
			</ul>
		</div>
		<?php endif?>

	</div>


	<div class="well">
		<p class="clearfix">
			<i class="fa fa-question-circle fa-lg"></i>
			<strong><?php echo _LANG('a8023','admin')?></strong>
		</p>

		<ul>
		<li><?php echo _LANG('a8024','admin')?></li>
		<li><?php echo _LANG('a8025','admin')?></li>
		<li><?php echo _LANG('a8026','admin')?></li>
		<li><?php echo _LANG('a8027','admin')?></li>
		</ul>
	</div>
</div>


