<?php
@ini_set('memory_limit', '128M');

function ResizeWidth($picture,$smallfile,$rewidth) 
{
    $picsize=getimagesize($picture);

	if ($picsize[0] <= $rewidth)
	{
		copy($picture,$smallfile);
	}
	else {

		$reheight = intval(($rewidth * $picsize[1]) / $picsize[0]);
		if($picsize[0]>$rewidth)
		{ 
			$width=$picsize[0]-$rewidth; 
			$aa=$width/$picsize[0]; 
			$picsize[0]=intval($picsize[0]-$picsize[0]*$aa); 
			$picsize[1]=intval($picsize[1]-$picsize[1]*$aa); 
		} 
		if($picsize[1]>$reheight)
		{ 
			$height=$picsize[1]-$reheight; 
			$bb=$heigh/$picsize[1]; 
			$picsize[0]=intval($picsize[0]-$picsize[0]*$bb); 
			$picsize[1]=intval($picsize[1]-$picsize[1]*$bb); 
		}
		if($picsize[2]==1) 
		{ 
			//@header("Content-Type: imgage/gif"); 
			$dstimg=ImageCreatetruecolor($rewidth,$reheight); 
			$srcimg=@ImageCreateFromGIF($picture); 
			ImageCopyResized($dstimg, $srcimg,0,0,0,0,$rewidth,$reheight,ImageSX($srcimg),ImageSY($srcimg)); 
			Imagegif($dstimg,$smallfile,100); 
		} 
		elseif($picsize[2]==2) 
		{ 
			//@header("Content-Type: images/jpeg"); 
			$dstimg=ImageCreatetruecolor($rewidth,$reheight); 
			$srcimg=ImageCreateFromJPEG($picture); 
			imagecopyresampled($dstimg, $srcimg,0,0,0,0,$rewidth,$reheight,ImageSX($srcimg),ImageSY($srcimg)); 
			Imagejpeg($dstimg,$smallfile,100); 
		} 
		elseif($picsize[2]==3) 
		{ 
			//@header("Content-Type: images/png"); 
			$srcimg=ImageCreateFromPNG($picture); 
			$dstimg=imagecreate($rewidth,$reheight); 
			$black = imagecolorallocate($dstimg, 0x00, 0x00, 0x00);
			$white = imagecolorallocate($dstimg, 0xFF, 0xFF, 0xFF);
			$magenta = imagecolorallocate($dstimg, 0xFF, 0x00, 0xFF); 
			imagecolortransparent($dstimg,$black);
			imagecopyresampled($dstimg, $srcimg,0,0,0,0,$rewidth,$reheight,ImageSX($srcimg),ImageSY($srcimg)); 
			Imagepng($dstimg,$smallfile,0); 
		} 
		@ImageDestroy($dstimg); 
		@ImageDestroy($srcimg);
	}
}
function ResizeWidthHeight($picture,$smallfile,$rewidth,$reheight) 
{
    $picsize=getimagesize($picture); 

    if($picsize[2]==1) 
	{ 
		//@header("Content-Type: imgage/gif"); 
		$dstimg=ImageCreatetruecolor($rewidth,$reheight); 
		$srcimg=@ImageCreateFromGIF($picture); 
		ImageCopyResized($dstimg, $srcimg,0,0,0,0,$rewidth,$reheight,ImageSX($srcimg),ImageSY($srcimg)); 
		Imagegif($dstimg,$smallfile,100); 
    } 
    elseif($picsize[2]==2) 
	{ 
		//@header("Content-Type: images/jpeg"); 
		$dstimg=ImageCreatetruecolor($rewidth,$reheight); 
		$srcimg=ImageCreateFromJPEG($picture); 
		imagecopyresampled($dstimg, $srcimg,0,0,0,0,$rewidth,$reheight,ImageSX($srcimg),ImageSY($srcimg)); 
		Imagejpeg($dstimg,$smallfile,100); 
    } 
    elseif($picsize[2]==3) 
	{ 
		//@header("Content-Type: images/png"); 
		$srcimg=ImageCreateFromPNG($picture); 
		$dstimg=imagecreate($rewidth,$reheight); 
		$black = imagecolorallocate($dstimg, 0x00, 0x00, 0x00);
		$white = imagecolorallocate($dstimg, 0xFF, 0xFF, 0xFF);
		$magenta = imagecolorallocate($dstimg, 0xFF, 0x00, 0xFF); 
		imagecolortransparent($dstimg,$black);
		imagecopyresampled($dstimg, $srcimg,0,0,0,0,$rewidth,$reheight,ImageSX($srcimg),ImageSY($srcimg)); 
		Imagepng($dstimg,$smallfile,0); 
    } 
    @ImageDestroy($dstimg); 
    @ImageDestroy($srcimg); 
}

function overlay($backpic,$overpic,$x,$y,$w,$h)
{
    $backsize=getimagesize($backpic); 
    $oversize=getimagesize($overpic); 

	if ($backsize[2] == 1)
	{
		$dstimg=ImageCreateFromGIF($backpic); 
	}
	elseif ($backsize[2] == 2)
	{
		$dstimg=ImageCreateFromJPEG($backpic); 
	}
	elseif ($backsize[2] == 3)
	{
		$dstimg=ImageCreateFromPNG($backpic); 
	}
	if ($oversize[2] == 1)
	{
		$srcimg=ImageCreateFromGIF($overpic); 
	}
	elseif ($oversize[2] == 2)
	{
		$srcimg=ImageCreateFromJPEG($overpic); 
	}
	elseif ($oversize[2] == 3)
	{
		$srcimg=ImageCreateFromPNG($overpic); 
	}
	Imagecopymerge($dstimg, $srcimg, $x, $y, 0, 0, $w, $h, 100);
	if ($backsize[2] == 1)
	{
		Imagegif($dstimg,$backpic,100);
	}
	elseif ($backsize[2] == 2)
	{
		Imagejpeg($dstimg,$backpic,100);
	}
	elseif ($backsize[2] == 3)
	{
		Imagepng($dstimg,$backpic,0);
	}
    @ImageDestroy($dstimg); 
    @ImageDestroy($srcimg); 
}
?>