var _isFullSize = false;
var _isCodeEdit = false;
function editFullSize(id,obj)
{
	if (_isCodeEdit)
	{
		_codefullscreen();
	}
	else {
		if (_isFullSize == false)
		{
			obj.title = '원래대로';
			$('#'+id).addClass('rb-fullsize');
			_isFullSize = true;
		}
		else {
			obj.title = '전체화면';
			$('#'+id).removeClass('rb-fullsize');
			_isFullSize = false;
		}
	}
}
