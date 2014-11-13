<?php
if(!defined('__KIMS__')) exit;
$__SRC__ = str_replace("&lt;?php getWidget(",'<img class="rb-widget-edit-img" alt="getWidget(',$__SRC__);
$__SRC__ = str_replace("))?&gt;",'))" src="./_core/images/blank.gif">',$__SRC__);
?>


<div class="form-group">
	<textarea name="source" class="form-control" id="summernote"><?php echo $__SRC__?></textarea>
</div>

<?php if($d['admin']['codeeidt']):?>
<!-- codemirror -->
<style>
.CodeMirror {
	font-size: 13px;
	font-family: Menlo,Monaco,Consolas,"Courier New",monospace !important;
}
.note-group-select-from-files {
	display: none;
}
</style>
<?php getImport('codemirror','codemirror',false,'css')?>
<?php getImport('codemirror','codemirror',false,'js')?>
<?php getImport('codemirror','theme/'.$d['admin']['codeeidt'],false,'css')?>
<?php getImport('codemirror','mode/htmlmixed/htmlmixed',false,'js')?>
<?php getImport('codemirror','mode/xml/xml',false,'js')?>
<?php endif?>

<?php getImport('summernote','dist/summernote.min',false,'js')?>
<?php if($lang['site']['a4027']) getImport('summernote','lang/summernote-'.$lang['site']['a4027'],false,'js')?>
<?php getImport('summernote','dist/summernote',false,'css')?>

<script>
function InserHTMLtoEditor(sHTML)
{
	var nHTML = $('#summernote').code();
	$('#summernote').code(nHTML+sHTML);
}
$('#summernote').summernote({
	height: 500,
	<?php if($d['admin']['codeeidt']):?>
	codemirror: {
		mode: "text/html",
		indentUnit: 4,
		lineNumbers: true,
		matchBrackets: true,
		indentWithTabs: true,
		theme: '<?php echo $d['admin']['codeeidt']?>'
	},
	<?php endif?>
	minHeight: null,
	maxHeight: null,
	focus: true,
	<?php if($lang['site']['a4027']):?>lang: '<?php echo $lang['site']['a4027']?>'<?php endif?>
});
</script>
