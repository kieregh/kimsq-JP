<div id="bookmark" class="row">

	<div class="col-sm-5">

		<div class="panel panel-default">
			<div class="panel-heading rb-icon">
				<div class="icon">
				<i class="fa fa-star-o fa-2x"></i>
				</div>
				<h4 class="panel-title"><?php echo _LANG('ab001','admin')?></h4>
			</div>
			<div class="panel-body">
				<form action="<?php echo $g['s']?>/" method="post" class="rb-form">
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="m" value="<?php echo $module?>">
				<input type="hidden" name="a" value="">
					<div class="dd" id="nestable-menu">
				        <ol class="dd-list">
							<?php $ADMPAGE = getDbArray($table['s_admpage'],'memberuid='.$my['uid'],'*','gid','asc',0,1)?>
							<?php $_i=1;while($R=db_fetch_array($ADMPAGE)):?>
				            <li class="dd-item dd3-item" data-id="<?php echo $_i?>">
				                <div class="dd-handle dd3-handle"></div>
				                <div class="dd3-content"><a href="<?php echo $R['url']?>"><?php echo $R['name']?></a></div>
				                <div class="dd-checkbox">
									<input type="checkbox" class="hidden" name="bookmark_pages_order[]" value="<?php echo $R['uid']?>" checked>
									<input type="checkbox" name="bookmark_pages[]" value="<?php echo $R['uid']?>"><i></i>
								</div>
				            </li>
							<?php $_i++;endwhile?>
							<?php if(!db_num_rows($ADMPAGE)):?>
							<li class="rb-none">
								<?php echo _LANG('ab002','admin')?>
							</li>
							<?php endif?>	
				        </ol>
					</div>
		        </form>
			</div>
			<div class="panel-footer">
				<ul class="list-inline clearfix">
					<li class="pull-left">
						<button type="button" class="btn btn-default"<?php if($_i==1):?> disabled<?php endif?> onclick="checkboxChoice('bookmark_pages[]',true);">
							<?php echo _LANG('ab003','admin')?>
						</button>
						<button type="button" class="btn btn-default"<?php if($_i==1):?> disabled<?php endif?> onclick="checkboxChoice('bookmark_pages[]',false);">
							<?php echo _LANG('ab004','admin')?>
						</button>
					</li>
					<li class="pull-right">
						<button type="button" class="btn btn-primary"<?php if($_i==1):?> disabled<?php endif?> onclick="actQue('bookmark_delete');">
							<?php echo _LANG('ab005','admin')?>
						</button>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="col-sm-7">

		<div class="page-header">
			<h4><?php echo _LANG('ab006','admin')?></h4>
		</div>
		<p>
			<?php echo _LANG('ab007','admin')?><br>
			<?php echo _LANG('ab008','admin')?><br>
		</p>
	</div>
</div>




<!-- nestable : https://github.com/dbushell/Nestable -->
<?php getImport('nestable','jquery.nestable',false,'js') ?>
<script>
$('#nestable-menu').nestable();
$('.dd').on('change', function() {
	var f = document.forms[0];
	getIframeForAction(f);
	f.a.value = 'bookmark_order';
	f.submit();
});
</script>


<!-- basic -->
<script>
function actQue(act)
{
	var f  = document.forms[0];
    var l = document.getElementsByName('bookmark_pages[]');
    var n = l.length;
    var i;
	var j=0;

	for (i=0; i < n; i++)
	{
		if (l[i].checked == true)
		{
			j++;
		}
	}

	if (act == 'bookmark_delete')
	{
		if (j == 0)
		{
			alert('<?php echo _LANG('ab009','admin')?>   ');
		}
		else 
		{
			if (confirm('<?php echo _LANG('ab010','admin')?>   '))
			{
				getIframeForAction(f);
				f.a.value = act;
				f.submit();
			}
		}
	}
}
</script>

