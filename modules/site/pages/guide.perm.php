<meta name="robots" content="noindex">

<div class="rb-guide-wrapper">
	<div class="rb-guide-wrapper-inner">
		<div class="container">
			<h1>
				<i class="fa fa-lock fa-3x text-muted"></i><br>
				<?php echo _LANG('s0001','site')?>
			</h1>
			<p class="text-muted">
				<?php echo _LANG('s2001','site')?><br class="hidden-xs">
				<?php echo _LANG('s2002','site')?><br class="hidden-xs">
				<?php echo _LANG('s2003','site')?>
			</p>
			<p>
				<button type="button" class="btn btn-default" onclick="goBack();"><?php echo _LANG('s0002','site')?></button>
			</p>
		</div>
	</div>
</div>

<script>
function goBack() {
	window.history.back()
}
</script>
