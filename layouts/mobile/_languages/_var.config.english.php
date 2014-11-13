<?php
if(!defined('__KIMS__')) exit;

//***********************************************************************************
// 여기에 이 레이아웃에서 사용할 변수들을 정의합니다. 
// 변수 작성법은 매뉴얼을 참고하세요.
//***********************************************************************************

$d['layout']['show'] = true; // 관리패널에 레이아웃 관리탭을 보여주기
$d['layout']['date'] = false;  // 데이트픽커 사용

//***********************************************************************************
// 테마검색
//***********************************************************************************

$_tmp['themestr']  = 'None=disabled';
$_tmp['themepath'] = $g['path_plugin'].'bootstrap/'.$d['ov']['bootstrap'].'/css/themes';
$_tmp['themehnd']  = opendir($_tmp['themepath']); 
while(false !== ($_tmp['themedir'] = readdir($_tmp['themehnd']))) 
{ 
	if(strstr($_tmp['themedir'],'.')) continue;
	$_tmp['themestr'] .= ','.$_tmp['themedir'].'='.$_tmp['themedir'];
} 
closedir($_tmp['themehnd']);

//***********************************************************************************
// 설정배열
//***********************************************************************************

$d['layout']['dom'] = array(

	/* 테마 */
	'theme' => array(
		'Themes',
		'Please choose theme for this site. The appearance of site can be changed from theme changing.',
		array(
			array('kind','select','Select Theme',$_tmp['themestr']),
			array('snap','checkbox','Use Flicking','Open the menu by flicking=flicking'),
		),
	),

	/* 헤더 */
	'header' => array(
		'Header',
		'',
		array(
			array('title','input','Site Title',''),
			array('login','select','Display Login-form','Yes=true,No=false'),
			array('notify','select','Display Notification','Yes=true,No=false'),
		),
	),

	/* 프론트 */
	'front' => array(
		'Main Page',
		'Please set the contents to display on front desk(main page). Select photos using mediaset.',
		array(
			array('slide','mediaset','Display Sliding Photos',''),
			array('people','mediaset','Display People Photos',''),
		),
	),

	/* 도움말 */
	'help' => array(
		'Help',
		'Mobile Only (Mobile Only) layouts provided by KimsQ 2.0 layout. Therefore, it may not work properly in the desktop using the actual mobile device, check the correct implementation of UI.',
		array(

		),
	),
);

//***********************************************************************************
?>