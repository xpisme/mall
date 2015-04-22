<?php

/**
 * @Author:      xp
 * @DateTime:    2015-04-17 21:03:35
 * @Description: Description
 */
namespace Controller;
defined('ACC')||exit('ACC Denied');

class UserController extends Controller{
	public function index(){
		echo '默认';
	}
	public function reg(){
		$model = M('staff');
		$resdata = $model->getAll();
		$this->assign('data',$resdata);
		$this->display('reg');
	}
	public function add(){
		$data['name'] = $_POST['name'];
		$data['passwd'] = $_POST['passwd'];
		$data['dept'] = $_POST['dept'];
		$data['salary'] = $_POST['salary'];
		$data['regtime'] = time();
		$model = M('staff');
		$model->validata = array(
			array('name','between','4到10个字符之间','4,10'),
			array('passwd','require','密码不能为空'),
			array('salary','number','必须为数字'),
		);
		var_dump($model->add($data));
	}
}




 ?>