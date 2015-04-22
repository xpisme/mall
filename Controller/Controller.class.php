<?php 

/**
 * @Author:      xp
 * @DateTime:    2015-04-18 09:00:56
 * @Description: 控制器基类
 */
namespace Controller;
defined('ACC')||exit('ACC Denied');

class Controller{
	public $data;
	public function assign($name,$value){
		$this->data[$name] = $value;
	}
	public function display($file){
		$data = $this->data;
		if(file_exists(VIEW.$file.'.php'))
		require VIEW.$file.'.php';
	}
	/*
	*展示信息
	*/
	public function showMessage($mes){

	}
}


 ?>