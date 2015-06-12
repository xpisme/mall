<?php

namespace Controller\Home;
use Controller\Controller;

class ShopController extends Controller{
    public function add(){
        if(empty($_POST)) exit($this->display('shop'));
        $data = array();
        $shop = M('shop');
        $shop->validata = array(
            array('name','require','4到10个字符之间','4,10'),
            array('name','unique','该值已存在'),
            array('tel','tel','错误手机号'),
            array('tel','unique','手机号已存在'),
            array('email','unique','邮箱已存在'),
            array('email','email','填写正确邮箱'),
            array('qq','unique','QQ已存在'),
            array('qq','qq','填写正确QQ'),
        );
        $data['uid'] = $_SESSION['userid'];
        $data['name'] = $_POST['shopName'];
        $data['tel'] = $_POST['tel'];
        $data['qq'] = $_POST['qq'];
        $data['email'] = $_POST['email'];
        $data['address'] = $_POST['address'];
        $data['descr'] = $_POST['describe'];
        if(!$shop->add($data)){
            $this->showMessage($shop->getError());
        }else{
            $this->showMessage('已提交，正在审核...');
        }
    }

}