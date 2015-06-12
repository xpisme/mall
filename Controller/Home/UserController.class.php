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
        if(isset($_SESSION['username']) && $_SESSION['username'] != '') exit($this->display('index'));
        if(empty($_POST)) return $this->display('signIn');
        if(md5($_POST['verifynum']) != $_SESSION['verifynum']) $this->showMessage('验证码错误');
        $username = $_POST['username'];
        $password = $_POST['password'];
        $where = 'uname = "'.$username.'" ';
        $customer = M('customer');
        $res = $customer->getRow('uid,upass',$where);
        if(!$res) $this->showMessage('该用户不存在');
        if(md5(md5($password)) !== $res['upass']){
            $this->showMessage('密码错误');
        }
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $res['uid'];
        header ( 'Location: '.SITE );
	}
	public function signup(){
        if(isset($_SESSION['username']) && $_SESSION['username'] != '') exit($this->display('index'));
        if(empty($_POST))  exit($this->display('signUp'));
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
			$_SESSION['userid'] = $model->insertId();
			header ( 'Location: '.SITE );
        }else{
            $this->showMessage($model->getError());
        }
	}

    public function logout(){
        unset($_SESSION['username']);
        unset($_SESSION['userid']);
        unset($_SESSION['goods']);
        header ( 'Location: '.SITE );
    }
}




 ?>