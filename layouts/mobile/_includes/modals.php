

<!-- Modal : 알림 -->
<div class="modal rb-modal-profile fade" id="rb-modal-notification" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><i class="fa fa-bell-o fa-lg"></i> <?php echo _LANG('s3001','xlayout')?> <span id="rb-notification-badge-other" class="badge"><?php echo $my['num_notice']?></span></h4>
			</div>
			<div class="modal-body">
				<div id="rb-notifications-layer" class="list-group">
				<!-- .rb-notifications-toggle 클릭시 여기에 알림정보를 실시간으로 받아옴 -->
				</div>
			</div>
			<div class="modal-footer">
				<div class="btn-group btn-group-justified">
					<a href="#" class="btn btn-default"><?php echo _LANG('s3002','xlayout')?></a>
					<a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?php echo _LANG('s3003','xlayout')?></a>
				</div>
			</div>
		</div>
	</div>
</div>
