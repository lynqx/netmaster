<?php
// Image resizing function

function ak_img_resize($target, $newcopy, $w, $h, $ext) {
	list($w_orig, $h_orig) = getimagesize($target);
	$scale_ratio = $w_orig/$h_orig;
	if(($w / $h) > $scale_ratio) {
	$w = $h * $scale_ratio;	
		} else {
			$h = $w / $scale_ratio;
		}
			$img = "";
			if ($ext == "gif" || $ext == "GIF") {
				$img = imagecreatefromgif($target);
				
				} elseif ($ext == "png" || $ext == "PNG") {
				$img = imagecreatefrompng($target);
				
				} else { 
				$img = imagecreatefromjpeg($target);
					
		}
		$tci = imagecreatetruecolor($w, $h);
		imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
		imagejpeg($tci, $newcopy, 80);
}
?>