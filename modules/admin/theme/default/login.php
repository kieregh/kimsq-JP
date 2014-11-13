<?php include getLangFile($g['dir_module'].'language/',$d['admin']['syslang'],'/lang.admin-theme-default.php')?>
<div class="rb-root">
	<div id="rb-login">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h1 class="panel-title"><a href="<?php echo $g['r']?>/"><i class="kf-bi-01"></i></a> <small>Admin Mode</small></h1>
			</div>
			<div class="panel-body">
				<form class="loginForm" role="form" name="loginform" action="<?php echo $g['s']?>/" method="post" onsubmit="return loginCheck(this);">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="a" value="login">
					<input type="hidden" name="referer" value="<?php echo $referer ? $referer : $_SERVER['HTTP_REFERER']?>">
					<input type="hidden" name="usertype" value="admin">
					<div class="form-group">
						<label for="id" class="control-label">Email or UserID </label>
						<input type="text" name="id"  class="form-control input-lg" id="id" placeholder="" value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',0)?>" required>
					</div>
					<div class="form-group">
						<label for="pw" class="control-label">Password</label>
						<input type="password" name="pw" class="form-control input-lg" id="pw" placeholder="" value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',1)?>" required>
					</div>
					<button type="submit" class="btn btn-primary">Log in</button>
					<div class="checkbox">
						<label>
							<input class="rb-confirm" type="checkbox" name="idpwsave" value="checked" <?php if($_COOKIE['svshop']):?> checked<?php endif?>>Remember me
						</label>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- bootstrap Validator -->
<?php getImport('bootstrap-validator','dist/css/bootstrapValidator.min',false,'css')?>
<?php getImport('bootstrap-validator','dist/js/bootstrapValidator.min',false,'js')?>
<script>
$(document).ready(function() {
    $('.loginForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            id: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The Email or Username is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9\_\-\@\.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
                    }
                }
            },
            pw: {
                message: '<?php echo _LANG('tl001','admin')?>',
                validators: {
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    },
                }
            },
        }
    });
});

var bootmsg = '<div class="media"><i class="pull-left fa fa-exclamation-circle fa-4x hidden-xs"></i><div class="media-body">';
	bootmsg+= '<h4 class="media-heading"><?php echo _LANG('tl002','admin')?></h4>';
	bootmsg+= '<?php echo _LANG('tl003','admin')?>';
	bootmsg+= '</div></div>';

$('.rb-confirm').on('click', function() {
	bootbox.confirm(bootmsg, function(result){
		document.loginform.idpwsave.checked = result;
	});
});
function loginCheck(f)
{
	getIframeForAction(f);
	return true;
}
</script>
