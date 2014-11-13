<?php
function LIB_getPageLink($lnum,$p,$tpage,$img)
{
	$_N = $GLOBALS['g']['pagelink'].'&amp;';
	if ($img)
	{
		$g_p1 = '<img src="'.$img.'/p1.gif" alt="Previous page('.$lnum.')" alt="">';
		$g_p2 = '<img src="'.$img.'/p2.gif" alt="Previous page('.$lnum.')" alt="">';
		$g_n1 = '<img src="'.$img.'/n1.gif" alt="Next page('.$lnum.')" alt="">';
		$g_n2 = '<img src="'.$img.'/n2.gif" alt="Next page('.$lnum.')" alt="">';
		$g_cn = '<img src="'.$img.'/l.gif" class="split" alt="">';
		$g_q  = $p > 1 ? '<a href="'.$_N.'p=1"><img src="'.$img.'/fp.gif" alt="First page"></a>' : '<img src="'.$img.'/fp1.gif" alt="First page">';
		if($p < $lnum+1) { $g_q .= $g_p1; }
		else{ $pp = (int)(($p-1)/$lnum)*$lnum; $g_q .= '<a href="'.$_N.'p='.$pp.'">'.$g_p2.'</a>';} $g_q .= $g_cn;
		$st1 = (int)(($p-1)/$lnum)*$lnum + 1;
		$st2 = $st1 + $lnum;
		for($jn = $st1; $jn < $st2; $jn++)
		if ( $jn <= $tpage)
		($jn == $p)? $g_q .= '<span class="selected" title="Page '.$jn.'">'.$jn.'</span>'.$g_cn : $g_q .= '<a href="'.$_N.'p='.$jn.'" class="notselected" title="Page '.$jn.'">'.$jn.'</a>'.$g_cn;
		if($tpage < $lnum || $tpage < $jn) { $g_q .= $g_n1; }
		else{$np = $jn; $g_q .= '<a href="'.$_N.'p='.$np.'">'.$g_n2.'</a>'; }
		$g_q  .= $tpage > $p ? '<a href="'.$_N.'p='.$tpage.'"><img src="'.$img.'/lp.gif" alt="Last page"></a>' : '<img src="'.$img.'/lp1.gif" alt="Last page">';
		return $g_q;
	}
	else {
		$g_q  = $p > 1 ? '<li><a href="'.$_N.'p=1" data-toggle="tooltip" title="First page"><i class="fa fa-angle-double-left"></i></a></li>' : '<li class="disabled"><a href="#." data-toggle="tooltip" title="First page"><i class="fa fa-angle-double-left"></i></a></li>';
		if($p < $lnum+1) { $g_q .= '<li class="disabled"><a href="#." data-toggle="tooltip" title="Previous page"><i class="fa fa-angle-left"></i></a></li>'; }
		else{ $pp = (int)(($p-1)/$lnum)*$lnum; $g_q .= '<li><a href="'.$_N.'p='.$pp.'" data-toggle="tooltip" title="Previous page"><i class="fa fa-angle-left"></i></a></li>';}
		$st1 = (int)(($p-1)/$lnum)*$lnum + 1;
		$st2 = $st1 + $lnum;
		for($jn = $st1; $jn < $st2; $jn++)
		if ( $jn <= $tpage)
		($jn == $p)? $g_q .= '<li class="active"><span>'.$jn.'</span></li>' : $g_q .= '<li><a href="'.$_N.'p='.$jn.'">'.$jn.'</a></li>';
		if($tpage < $lnum || $tpage < $jn) { $g_q .= '<li class="disabled"><a href="#." data-toggle="tooltip" title="Next page"><i class="fa fa-angle-right"></i></a></li>'; }
		else{$np = $jn; $g_q .= '<li><a href="'.$_N.'p='.$np.'" data-toggle="tooltip" title="Next page"><i class="fa fa-angle-right"></i></a></li>'; }
		$g_q  .= $tpage > $p ? '<li><a href="'.$_N.'p='.$tpage.'" data-toggle="tooltip" title="Last page('.$tpage.')"><i class="fa fa-angle-double-right"></i></a></li>' : '<li class="disabled"><a href="#." data-toggle="tooltip" title="Last page('.$tpage.')"><i class="fa fa-angle-double-right"></i></a></li>';
		return $g_q;
	}
}
?>