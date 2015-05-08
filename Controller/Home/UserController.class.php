<?php

/**
 * @Author:      xp
 * @DateTime:    2015-04-17 21:03:35
 * @Description: Description
 */
namespace Controller\Home;
use Controller;
use Lib;
defined('ACC')||exit('ACC Denied');

class UserController extends Controller\Controller{
	
	public function getverify(){
		Lib\image::getVerifyImg();
	}
	public function signin(){
        if(empty($_POST)) {
            $this->display('signIn');return;
        }
        if(md5($_POST['verifynum']) != $_SESSION['verifynum']){
            exit('验证码错误');
        }
        $username = $_POST['username'];
        $password = $_POST['password'];
        $where = 'uname = "'.$username.'" ';
        $customer = M('customer');
        $res = $customer->getOne('upass',$where);
        if(md5(md5($password)) !== $res['upass']){
            exit('密码错误');
        }
        $_SESSION['username'] = $data['uname'];
        header ( 'Location: '.SITE );
	}
	public function signup(){
        if(isset($_SESSION['username']) && $_SESSION['username'] != ''){
            $this->display('index');
            return;
        }
        if(empty($_POST)) {
            $this->display('signUp');
            exit;
        }
		$data['uname'] = $_POST['username'];
		$data['upass'] = md5(md5($_POST['password']));
		$data['umail'] = $_POST['email'];
		$model = M('customer');
		$model->validata = array(
			array('uname','require','4到10个字符之间','4,10'),
			array('uname','unique','该值已存在','4,10'),
			array('upass','require','密码不能为空'),
			array('umail','unique','该值已存在'),
			array('umail','email','填写正确邮箱'),
		);
		if($model->add($data)){
			$_SESSION['username'] = $data['uname'];
			header ( 'Location: '.SITE );
        }
	}
}




 ?>