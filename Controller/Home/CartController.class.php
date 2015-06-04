<?php
namespace Controller\Home;

use Controller;
//购物车
class CartController extends Controller\Controller{
    public function __construct(){

    }
    // 增加商品
    public function add(){
        $this->check();
        M('goods')->getRow('goods_number','goods_sn="'.$_POST['sn'].'"');
    }

    protected function check(){
        if(empty($_POST['sn'])) exit ;
    }
}