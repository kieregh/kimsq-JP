<div id="seo-setting">

	<div class="page-header">
		<h4><?php echo _LANG('','admin')?>SEO 설정 <small>( Technical Search Engine Optimization )</small></h4>
	</div>

	<div class="tab-content">

		<ul class="nav nav-pills" role="tablist">
			<li<?php if(!$_SESSION['sh_admin_seo']||$_SESSION['sh_admin_seo']=='robots'):?> class="active"<?php endif?>><a href="#robots" role="tab" data-toggle="tab" onclick="sessionSetting('sh_admin_seo','robots','','');">Robots.txt</a></li>
			<li<?php if($_SESSION['sh_admin_seo']=='rewrite'):?> class="active"<?php endif?>><a href="#rewrite" role="tab" data-toggle="tab" onclick="sessionSetting('sh_admin_seo','rewrite','','');">URL rewrite</a></li>
			<li<?php if($_SESSION['sh_admin_seo']=='sitemap'):?> class="active"<?php endif?>><a href="#sitemap" role="tab" data-toggle="tab" onclick="sessionSetting('sh_admin_seo','sitemap','','');">Sitemap.xml</a></li>
			<li<?php if($_SESSION['sh_admin_seo']=='errorpage'):?> class="active"<?php endif?>><a href="#error" role="tab" data-toggle="tab" onclick="sessionSetting('sh_admin_seo','errorpage','','');">Error Page</a></li>
			<li<?php if($_SESSION['sh_admin_seo']=='redirect'):?> class="active"<?php endif?>><a href="#301" role="tab" data-toggle="tab" onclick="sessionSetting('sh_admin_seo','redirect','','');">Redirect</a></li>
		</ul>
		<br>

		<div class="tab-pane<?php if(!$_SESSION['sh_admin_seo'] || $_SESSION['sh_admin_seo']=='robots'):?> active in<?php endif?>" id="robots">
			<form class="form-horizontal rb-form" role="form" name="sendForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="seo">
			<input type="hidden" name="act" value="robots">
				<div class="well">
					<p>
						<?php echo _LANG('a3006','admin')?><br>
						<?php echo _LANG('a3007','admin')?>
						<?php echo _LANG('a3008','admin')?>
					</p>
				</div>
				<div class="rb-codeview">			
<?php if(is_file($_SERVER['DOCUMENT_ROOT'].'/robots.txt')):?>
<textarea name="robotstxt" class="form-control" rows="15">
<?php readfile($_SERVER['DOCUMENT_ROOT'].'/robots.txt')?>
</textarea>
<?php else:?>
<textarea name="robotstxt" class="form-control" rows="15" onclick="this.value=getId('robotstxt').innerHTML;">
<?php echo _LANG('a3009','admin')?> 
<?php echo _LANG('a3010','admin')?> 
<?php echo _LANG('a3011','admin')?> 
<?php echo _LANG('a3012','admin')?> 
</textarea>
<div id="robotstxt" class="hidden"><?php readfile('./robots.txt')?></div>
<?php endif?>
					<div class="rb-meta">
						<?php if(is_file($_SERVER['DOCUMENT_ROOT'].'/robots.txt')):?>
						<?php echo _LANG('a3001','admin')?> : /robots.txt
						<code><?php echo getSizeFormat(filesize($_SERVER['DOCUMENT_ROOT'].'/robots.txt'),2)?></code>
						<?php endif?>
						<span class="pull-right"><?php echo _LANG('a3013','admin')?></span>
					</div>
				</div>

				<div class="rb-submit">
					<?php if(is_file($_SERVER['DOCUMENT_ROOT'].'/robots.txt')):?>
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=seo&amp;act=robots_delete" onclick="return hrefCheck(this,true,'<?php echo _LANG('a3003','admin')?>');" class="btn btn-default"><?php echo _LANG('a3004','admin')?></a>
					<?php endif?>
					<button type="submit" class="btn btn-primary btn-lg<?php if($g['device']):?> btn-block<?php endif?>"><?php echo _LANG('a3005','admin')?></button>
				</div>
			</form>
		</div>

		<div class="tab-pane<?php if($_SESSION['sh_admin_seo']=='rewrite'):?> active in<?php endif?>" id="rewrite">

			<div class="well">
				<p>
					<strong><?php echo _LANG('a3014','admin')?></strong>
					<?php echo _LANG('a3015','admin')?><br> 
					<?php echo _LANG('a3016','admin')?>
					<?php echo _LANG('a3017','admin')?>
				</p>

				<p>
					<?php echo _LANG('a3018','admin')?>
				</p>		
			</div>

			<div class="rb-codeview">
<pre class="prettyprint linenums">
<?php readfile('./.htaccess')?>
</pre>
				<div class="rb-meta">
					<?php echo _LANG('a3001','admin')?> : <?php echo $g['s']?>/.htaccess
					<code><?php echo getSizeFormat(filesize('./.htaccess'),2)?></code>
					<span class="pull-right"><?php echo _LANG('a3019','admin')?></span>	
				</div>
			</div>
		</div>

		<div class="tab-pane<?php if($_SESSION['sh_admin_seo']=='sitemap'):?> active in<?php endif?>" id="sitemap">
			<form class="form-horizontal rb-form" role="form" name="sendForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="seo">
			<input type="hidden" name="act" value="sitemap_save">
			<div class="well">
				<p>
					<?php echo _LANG('a3020','admin')?><br>
					<?php echo _LANG('a3021','admin')?><br>
					<?php echo _LANG('a3022','admin')?><br>
				</p>
				<p>
					<?php echo _LANG('a3023','admin')?><br>
					<?php echo _LANG('a3024','admin')?><br>
				</p>
				<p>
					<?php echo _LANG('a3025','admin')?><br>
					<?php echo _LANG('a3026','admin')?>
				</p>
			</div>
			<div class="rb-codeview">
<?php if(is_file('./sitemap.xml')):?>
<textarea name="configdata">
<?php readfile('./sitemap.xml')?>
</textarea>
<?php else:?>
<textarea name="configdata">
<?php echo _LANG('a3027','admin')?> 
<?php echo _LANG('a3028','admin')?> 
<?php echo _LANG('a3029','admin')?> 
</textarea>
<?php endif?>
					<div class="rb-meta">
						<?php if(is_file('./sitemap.xml')):?>
						<?php echo _LANG('a3001','admin')?> : <?php echo $g['s']?>/sitemap.xml
						<code><?php echo getSizeFormat(filesize('./sitemap.xml'),2)?></code>
						<?php endif?>
						<span class="pull-right"><?php echo _LANG('a3030','admin')?></span>	
					</div>
				</div>
				<div class="rb-submit">
					<button type="button" class="btn btn-default btn-lg<?php if($g['device']):?> btn-block<?php endif?>" onclick="sitemap_make(this);"><?php echo _LANG('a3002','admin')?></button>
					<?php if(is_file('./sitemap.xml')):?>
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=seo&amp;act=sitemap_delete" onclick="return hrefCheck(this,true,'<?php echo _LANG('a3003','admin')?>');" class="btn btn-default"><?php echo _LANG('a3004','admin')?></a>
					<?php endif?>
					<button type="submit" class="btn btn-primary btn-lg<?php if($g['device']):?> btn-block<?php endif?>"><?php echo _LANG('a3005','admin')?></button>
				</div>
				<div class="well">
					<ul>
						<li><?php echo _LANG('a3031','admin')?></li>
						<li><?php echo _LANG('a3032','admin')?></li>
						<li><?php echo _LANG('a3033','admin')?></li>
					</ul>
				</div>
			</form>
		</div>

		<div class="tab-pane<?php if($_SESSION['sh_admin_seo']=='errorpage'):?> active in<?php endif?>" id="error">
			<div class="well">
				<ul>
					<li><?php echo _LANG('a3034','admin')?></li>
					<li><?php echo _LANG('a3035','admin')?></li>
					<li><?php echo _LANG('a3036','admin')?></li>
					<li><?php echo _LANG('a3037','admin')?></li>
					<li><?php echo _LANG('a3038','admin')?></li>
				</ul>
			</div>
			<hr>
			<ol>
				<li><?php echo _LANG('a3039','admin')?></li>
				<li><?php echo _LANG('a3040','admin')?></li>
			</ol>
		</div>

		<div class="tab-pane<?php if($_SESSION['sh_admin_seo']=='redirect'):?> active in<?php endif?>" id="301">
			<div class="well">
				<ul>
					<li><?php echo _LANG('a3041','admin')?></li>
					<li><?php echo _LANG('a3042','admin')?></li>
					<li><?php echo _LANG('a3043','admin')?></li>
				</ul>
			</div>
		</div>
	</div>
</div>



<script src="http://google-code-prettify.googlecode.com/svn/trunk/src/prettify.js"></script>
<script>
(function(jQuery){
  jQuery( document ).ready( function() {
    prettyPrint();
  } );
}(jQuery))
function sitemap_make(obj)
{
	if (confirm('<?php echo _LANG('a3044','admin')?>    '))
	{
		getIframeForAction(obj.form);
		obj.form.act.value = 'sitemap_make';
		obj.form.submit();
	}
}
function saveCheck(f)
{
	getIframeForAction(f);
	return confirm('<?php echo _LANG('a0001','admin')?>    ');
}
</script>
