<footer class="rb-footer" role="contentinfo">
    <p>
    	<a class="btn btn-default btn-sm" href="<?php echo RW(0)?>"><?php echo _LANG('s4001','xlayout')?></a>
    	
		<?php if($d['layout']['header_login']=='true'):?>
		<?php if($my['uid']):?>
    	<a class="btn btn-default btn-sm" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;a=logout"><?php echo _LANG('s4002','xlayout')?></a>
    	<?php else:?>
		<a class="btn btn-default btn-sm rb-modal-login" href="#" data-toggle="modal" data-target="#modal_window"><?php echo _LANG('s4003','xlayout')?></a>
    	<?php endif?>
		<?php endif?>

    	<a class="btn btn-default btn-sm" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;a=pcmode"><?php echo _LANG('s4004','xlayout')?></a>
    	<a class="btn btn-default btn-sm" href="#content-main"><?php echo _LANG('s4005','xlayout')?></a>
    </p>
	<ul class="list-inline">
		<li><a href="<?php echo RW('mod=privacy')?>"><?php echo _LANG('s4006','xlayout')?></a></li>
		<li><a href="<?php echo RW('mod=terms')?>"><?php echo _LANG('s4007','xlayout')?></a></li>
	</ul>
	<p>© <?php echo $date['year']?></span> <?php echo $_SERVER['HTTP_HOST']?></p>
</footer>
