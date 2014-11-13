<!DOCTYPE html>
<html lang="<?php echo $lang['xlayout']['lang']?>">
<head>
<?php include $g['dir_layout'].'/_includes/_import.head.php'?>
</head>
<body id="rb-body">

	<?php include $g['path_layout'].$d['layout']['dir'].'/_includes/preloader.php'?>

	<div class="snap-drawers">   
	    <div class="snap-drawer snap-drawer-left scrollable" id="left-drawer">
			<!-- 좌측 drawer -->
		</div>
	    <div class="snap-drawer snap-drawer-right scrollable" id="right-drawer">
	        <?php include $g['path_layout'].$d['layout']['dir'].'/_includes/drawer-menu.php'?>
	    </div>
	</div> 

	<div class="snap-content" id="content-wrap">
	    <?php include  $g['path_layout'].$d['layout']['dir'].'/_includes/header.php'?>
	    <div class="rb-content-position rb-content-position-top scrollable"<?php if(!$d['layout']['theme_snap']):?> data-snap-ignore="true"<?php endif?>>
	        <div class="container" id="content-main">
	            <?php if($_HM['uid']||$_HP['uid']) include $g['path_layout'].$d['layout']['dir'].'/_includes/page-header.php'?>
	            <?php include __KIMS_CONTENT__ ?>
	            <?php include $g['path_layout'].$d['layout']['dir'].'/_includes/page-footer.php'?>
	        </div>
	    </div>
	    <?php include $g['path_layout'].$d['layout']['dir'].'/_includes/footer.php'?>
	</div>

	<?php include $g['dir_layout'].'/_includes/_import.foot.php'?>

</body>
</html>
