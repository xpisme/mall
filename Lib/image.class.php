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

    /**
     * @param $files 图片的数据
     * return 图片存储的路径
     */
    public static function upimage($files){
        $config  = C('config');
        $max_size = $config['upload_max_size'];
        $type = $config['image_type'];
        $filenum = count(current($files)['name']);
        $data = array();
        $_path = date('Y',time()).'/'.date('md',time()).'/';
        $path = UPLOAD.$_path;
        if(!is_dir($path)) mkdir($path,0777,true);
        if( (count($files) > 1) || ($filenum == 1) ){
            foreach($files as $file){
                if($file['error']){
                    $data['info'] = false;
                    $data['msg'] .= $file['name'] . '上传失败';
                    continue;
                }
                if($file['size'] > $max_size){
                    $data['info'] = false;
                    $data['msg'] .= $file['name'] . '过大';
                    continue;
                }
                if( stripos($type,$file['type']) === false ){
                    $data['info'] = false;
                    $data['msg'] .= $file['name'].'类型不符';
                    continue;
                }

                $name = time().mt_rand(0,1000).'.'.end(explode('.',$file['name']));
                $filename = $path.$name;
                $data['filename'][] = 'Upload/'.$_path.$name;
                if(!move_uploaded_file($file['tmp_name'],$filename)){
                    $data['info'] = false;
                    $data['msg'] .= $file['name'].'移动失败';
                }else{
                    $data['info'] = true;
                }
            }
        }elseif($filenum > 1){
            $file = current($files);
            for($i=0;$i<count($file['name']);$i++){
                 if($file['error'][$i]){
                     $data['info'] = false;
                     $data['msg'] .= $file['name'][$i] . '上传失败';
                     continue;
                 }
                if($file['size'][$i] > $max_size){
                    $data['info'] = false;
                    $data['msg'] .= $file['name'][$i] . '过大';
                    continue;
                }
                if(stripos($type,$file['type'][$i]) === false ){
                    $data['info'] = false;
                    $data['msg'] .= $file['name'][$i] . '类型不符';
                    continue;
                }
                $name = time().mt_rand(0,1000).'.'.end(explode('.',$file['name'][$i]));
                $filename = $path.$name;
                $data['filename'][] = 'Upload/'.$_path.$name;
                if(!move_uploaded_file($file['tmp_name'][$i],$filename)){
                    $data['info'] = false;
                    $data['msg'] .= $file['name'][$i].'移动失败';
                }else{
                    $data['info'] = true;
                }
            }
        }

        return $data;
    }
}









