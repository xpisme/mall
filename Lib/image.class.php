<?php
namespace Lib;

class image {
	public static function getVerifyImg($width=100,$height=30,$type='png'){

		$im = imagecreate($width, $height)or die('Can not bulid image');
		imagecolorallocate($im, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
		$text_color  =  imagecolorallocate ( $im ,  mt_rand(100,255) ,  mt_rand(100,255) ,  mt_rand(100,255) );
		$line_color  =  imagecolorallocate ( $im ,  mt_rand(50,100) ,  mt_rand(50,100) ,  mt_rand(50,100) );
		
		$str = 'abcdefghjkmnpqrstuvwxyABCDEFGHJKMNPQRSTUVWXY3456789';
		$str = substr(str_shuffle($str), 0,4);
		$_SESSION['verifynum'] = md5(strtolower($str));
		for ($i=0; $i < 3; $i++) { 
			imageline($im, 0, mt_rand(0,$height), mt_rand(50,$width), mt_rand(0,$height), $line_color);
		}		
		for ($i=0; $i < 6; $i++) { 
			imagechar($im, 5, 15+$i*20+mt_rand(3,9), mt_rand(5,15), $str[$i], $text_color);
		}

        ob_clean();
        header("Content-type: image/".$type);
        $ImageFun='image'.$type;
        $ImageFun($im);
		imagedestroy ( $im );
	}
}



