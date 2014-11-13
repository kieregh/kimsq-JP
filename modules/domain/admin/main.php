<?php
include_once $g['path_core'].'function/menu.func.php';
$ISCAT = getDbRows($table['s_domain'],'');

if($cat)
{
	$CINFO = getUidData($table['s_domain'],$cat);
	$ctarr = getMenuCodeToPath($table['s_domain'],$cat,0);
	$ctnum = count($ctarr);
	for ($i = 0; $i < $ctnum; $i++) $CXA[] = $ctarr[$i]['uid'];
}

$is_fcategory =  $CINFO['uid'] && $vtype != 'sub';
$is_regismode = !$CINFO['uid'] || $vtype == 'sub';
if ($is_regismode)
{
	$_fdomain = '.'.str_replace('www.','',$CINFO['name']);
	$CINFO['name'] = '';
	$CINFO['site'] = '';
}
?>


<div class="row">
	<div id="" class="col-sm-5 col-md-5 col-lg-4">

		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
			  <div class="panel-heading rb-icon">
				<div class="icon">
				<i class="fa fa-globe fa-2x"></i>
				</div>
				<h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapmetane"><?php echo _LANG('a1001','domain')?></a></h4>
			  </div>

			  <div class="panel-collapse collapse in" id="collapmetane">

				<div class="panel-body">

					<div style="min-height:300px">
						<?php if($ISCAT):?>
						<link href="<?php echo $g['s']?>/_core/css/tree.css" rel="stylesheet">
						<?php $_treeOptions=array('table'=>$table['s_domain'])?>
						<?php $_treeOptions['link'] = $g['adm_href'].'&amp;cat='?>
						<?php echo getTreeMenu($_treeOptions,$code,0,0,'')?>
						<?php else:?>
						<div class="rb-none">
							<?php echo _LANG('a1002','domain')?>
						</div>
						<?php endif?>

					</div>

				</div>
			  </div>
			</div>

			<div class="panel panel-default">
			  <div class="panel-heading rb-icon">
				<div class="icon">
				  <i class="fa fa-retweet fa-2x"></i>
				</div>
				<h4 class="panel-title">
				  <a class="accordion-toggle collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">
					<?php echo _LANG('a1003','domain')?>
				  </a>
				</h4>
			  </div>
			  <div class="panel-collapse collapse" id="collapseTwo">
				<?php if($CINFO['is_child']||(!$cat&&$ISCAT)):?>
				<form role="form" action="<?php echo $g['s']?>/" method="post">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="<?php echo $module?>">
					<input type="hidden" name="a" value="modifygid">
					
					<div class="panel-body" style="border-top:1px solid #DEDEDE;">
				        <div class="dd" id="nestable-menu">
				            <ol class="dd-list">
							<?php $_MENUS=getDbSelect($table['s_domain'],'parent='.intval($CINFO['uid']).' and depth='.($CINFO['depth']+1).' order by gid asc','*')?>
							<?php $_i=1;while($_M=db_fetch_array($_MENUS)):?>								
				                <li class="dd-item" data-id="<?php echo $_i?>">
									<input type="checkbox" name="menumembers[]" value="<?php echo $_M['uid']?>" checked class="hidden">
				                    <div class="dd-handle"><i class="fa fa-arrows fa-fw"></i> <?php echo $_M['name']?></div>
				                </li>
							<?php $_i++;endwhile?>
				            </ol>
				        </div>
					</div>
				</form>

				<!-- nestable : https://github.com/dbushell/Nestable -->
				<?php getImport('nestable','jquery.nestable',false,'js') ?>
				<script>
				$('#nestable-menu').nestable();
				$('.dd').on('change', function() {
					var f = document.forms[0];
					getIframeForAction(f);
					f.submit();
				});
				</script>

				<?php else:?>
				<div class="panel-body rb-blank">
					<?php echo _LANG('a1004','domain')?>
				</div>
				<?php endif?>
			  </div>
			</div>
			
		</div>
	</div>

	<div id="" class="col-sm-7 col-md-7 col-lg-8">

		<form class="form-horizontal rb-form" name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>" />
			<input type="hidden" name="m" value="<?php echo $module?>" />
			<input type="hidden" name="a" value="regisdomain" />
			<input type="hidden" name="cat" value="<?php echo $CINFO['uid']?>" />
			<input type="hidden" name="code" value="<?php echo $code?>" />
			<input type="hidden" name="depth" value="<?php echo intval($CINFO['depth'])?>" />
			<input type="hidden" name="parent" value="<?php echo intval($CINFO['uid'])?>" />
			<input type="hidden" name="vtype" value="<?php echo $vtype?>" />		
			<input type="hidden" name="_fdomain" value="<?php echo $_fdomain?>" />		

			<div class="page-header">
				<h4>
					<?php if($is_regismode):?>
						<?php if($vtype == 'sub'):?><?php echo _LANG('a1005','domain')?><?php else:?><?php echo _LANG('a1006','domain')?><?php endif?>
					<?php else:?>
						<?php echo _LANG('a1007','domain')?>
					<?php endif?>

					<a href="<?php echo $g['adm_href']?>&amp;type=makedomain" class="pull-right btn btn-link"><?php echo _LANG('a1006','domain')?></a>
				</h4>
			</div>

			<?php if($vtype == 'sub'):?>
			<div class="form-group">
				<label class="col-lg-2 control-label"><?php echo _LANG('a1008','domain')?></label>
				<div class="col-lg-9">
					<p class="form-control-static">
						<?php for ($i = 0; $i < $ctnum; $i++):$subcode=$subcode.($i?'/'.$ctarr[$i]['uid']:$ctarr[$i]['uid'])?>
						<a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $ctarr[$i]['uid']?>&amp;code=<?php echo $subcode?>"><?php echo $ctarr[$i]['name']?></a>
						<?php if($i < $ctnum-1):?> &gt; <?php endif?> 
						<?php endfor?>
					</p>
				</div>
			</div>
			<?php else:?>
			<?php if($cat):?>
			<div class="form-group">
				<label class="col-lg-2 control-label"><?php echo _LANG('a1008','domain')?></label>
				<div class="col-lg-9">
					<p class="form-control-static">
						<?php for ($i = 0; $i < $ctnum-1; $i++):$subcode=$subcode.($i?'/'.$ctarr[$i]['uid']:$ctarr[$i]['uid'])?>
						<a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $ctarr[$i]['uid']?>&amp;code=<?php echo $subcode?>"><?php echo $ctarr[$i]['name']?></a>
						<?php if($i < $ctnum-2):?> &gt; <?php endif?> 
						<?php $delparent=$ctarr[$i]['uid'];endfor?>
						<?php if(!$delparent):?><?php echo _LANG('a1009','domain')?><?php endif?>
					</p>
				</div>
			</div>
			<?php endif?>
			<?php endif?>

			<div class="form-group rb-outside">
			  <label class="col-lg-2 control-label"><?php echo _LANG('a1010','domain')?></label>
			  <div class="col-lg-9">

				<?php if($is_fcategory):?>

				<div class="input-group input-group-lg">
				  <input class="form-control col-md-6" placeholder="" type="text" name="name" value="<?php echo $CINFO['name']?>"<?php if(!$cat):?> autofocus<?php endif?>>
				  <span class="input-group-btn">
					<?php if($CINFO['depth']==1):?>
					<a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $cat?>&amp;code=<?php echo $code?>&amp;vtype=sub" class="btn btn-default" data-tooltip="tooltip" title="<?php echo _LANG('a1011','domain')?>">
					  <i class="fa fa-share fa-rotate-90 fa-lg"></i>
					</a>
					<?php endif?>
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletedomain&amp;cat=<?php echo $cat?>&amp;code=<?php echo $CINFO['depth']==1?$CINFO['uid']:$CINFO['parent']?>&amp;parent=<?php echo $delparent?>" class="btn btn-default" data-tooltip="tooltip" title="<?php echo _LANG('a1012','domain')?>" onclick="return hrefCheck(this,true,'<?php echo _LANG('a1013','domain')?>');">
					  <i class="fa fa-trash-o fa-lg"></i>
					</a>
				  </span>
				</div>
				<div class="help-block">
					<?php echo _LANG('a1014','domain')?>
				</div>

				<?php else:?>

					<div class="input-group input-group-lg">
						<input class="form-control" placeholder="" type="text" name="name" value="<?php echo $CINFO['name']?>" autofocus>
						<?php if($vtype=='sub'):?><span class="input-group-addon"><?php echo $_fdomain?></span><?php endif?>
						<span class="input-group-btn">
							<button class="btn btn-default rb-help-btn" type="button" data-toggle="collapse" data-target="#guide_new" data-tooltip="tooltip" title="<?php echo _LANG('a1015','domain')?>"><i class="fa fa-question fa-lg text-muted"></i></button>
						</span>
					</div>
					<p id="guide_new" class="form-control-static collapse"><?php echo _LANG('a1016','domain')?></p>	

				<?php endif?>

			  </div>
			</div>

			<div class="form-group rb-outside">
				<label class="col-lg-2 control-label"><?php echo _LANG('a1017','domain')?></label>
				<div class="col-lg-9">

					<select name="site" class="form-control input-lg">
					<option value=""><?php echo _LANG('a1018','domain')?></option>
					<?php $SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p)?>
					<?php while($S = db_fetch_array($SITES)):?>
					<option value="<?php echo $S['uid']?>"<?php if($CINFO['site']==$S['uid'] || $selsite==$S['uid']):?> selected<?php endif?>>ㆍ<?php echo $S['name']?></option>
					<?php endwhile?>
					<?php if(!db_num_rows($SITES)):?>
					<option value=""><?php echo _LANG('a1019','domain')?></option>
					<?php endif?>
					</select>

				</div>
			</div>

			<hr>

			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-9">
					<button type="submit" class="btn btn-primary btn-lg<?php if($g['device']):?> btn-block<?php endif?>"><?php echo $is_fcategory?_LANG('a1020','domain'):_LANG('a1030','domain')?></button>
					<?php if($vtype=='sub'):?><button type="button" class="btn btn-default btn-lg<?php if($g['device']):?> btn-block<?php endif?>" onclick="history.back();" /><?php echo _LANG('a1022','domain')?></button><?php endif?>
					<?php if($cat):?><button type="button" class="btn btn-default btn-lg<?php if($g['device']):?> btn-block<?php endif?>" onclick="window.open('http://<?php echo $CINFO['name']?>');"><i class="fa fa-share fa-fw fa-lg"></i> <?php echo _LANG('a1023','domain')?></button><?php endif?>

					<div class="well rb-help">
						<small>
							<ul>
								<li><?php echo _LANG('a1024','domain')?></li>
								<li><?php echo _LANG('a1025','domain')?></li>
								<li><?php echo _LANG('a1026','domain')?></li>
								<li><?php echo _LANG('a1027','domain')?></li>
							</ul>
						</small>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>


<!-- bootstrap Validator -->
<?php getImport('bootstrap-validator','dist/css/bootstrapValidator.min',false,'css')?>
<?php getImport('bootstrap-validator','dist/js/bootstrapValidator.min',false,'js')?>

<script>
function saveCheck(f)
{
	getIframeForAction(f);
	return true;	
}
$(document).ready(function() {
    $('.form-horizontal').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                message: 'The domain is not valid',
                validators: {
                    notEmpty: {
                        message: '<?php echo _LANG('a1028','domain')?>'
                    },
                    regexp: {
                        regexp: /^[a-z0-9_\-\.]+$/,
                        message: '<?php echo _LANG('a1029','domain')?>'
                    }
                }
            },
        }
    });
});
</script>

