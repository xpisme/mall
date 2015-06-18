<?php
namespace Controller\Home;

use Controller;
//购物车
class CartController extends Controller\Controller{
    public function __construct(){
        parent::__construct();
        if(empty($_SESSION['username']))
            $this->showMessage('未登录','index.php?m=home&c=user&a=signin');
    }

    // 增加商品
    public function add(){
        $this->check();
        $info = $this->goodsinfo();
        if($info['goods_number']>0){
            $data = array();
            $data['goods_number'] = $info['goods_number']-1;
            $this->modDB($data);
            if($this->hasItem()){
                $item = array();
                $item['goods_sn'] = $_GET['sn'];
                $item['goods_name'] = $info['goods_name'];
                $item['shop_price'] = $info['shop_price'];
                $item['thumb_img'] = $info['thumb_img'];
                $item['goods_number'] = 1;
                $_SESSION['goods'][$_GET['sn']] = $item;
            }else{
                $_SESSION['goods'][$_GET['sn']]['goods_number'] += 1;
            }
            /*if($info['goods_number']<10){
                // 通知商家 商品的数量不够了
            }*/
            header('location: index.php?m=home&c=cart');
        }else{
            $this->showMessage('商品的数量不够了!','index.php?m=home&c=index&a=goods&sn='.$_GET["sn"]);
        }
    }

    // 增加商品数量
    public function incr(){
        $this->check();
        $info = $this->goodsinfo();
        if($info['goods_number']<1){
            $this->ajaxReturn('','商品的数量不够',0);
        }
        $config = C('config');
        $pre = $config['db']['db_prefix'];
        $sql = 'update m_goods set goods_number=goods_number-1 where goods_sn = "'.$_GET['sn'].'"';
        $_SESSION['goods'][$_GET['sn']]['goods_number'] += 1;

        if(M('goods')->query($sql)){
            $this->ajaxReturn('','成功',1);
        }else{
            $this->ajaxReturn(M('goods')->getError(),'失败',0);
        }
    }
    // 减少商品数量
    public function decr(){
        $this->check();
        $config = C('config');
        $pre = $config['db']['db_prefix'];
        if(!empty($_SESSION['goods'][$_GET['sn']])){
            $_SESSION['goods'][$_GET['sn']]['goods_number'] -= 1;
        }else{
            $this->ajaxReturn('','该商品不存在与购物车',0);
        }
        if($_SESSION['goods'][$_GET['sn']]['goods_number'] == 0){
            unset($_SESSION['goods'][$_GET['sn']]);
        }
        $sql = 'update m_goods set goods_number=goods_number+1 where goods_sn = "'.$_GET['sn'].'"';
        if(M('goods')->query($sql)){
            $this->ajaxReturn('','成功',1);
        }else{
            $this->ajaxReturn(M('goods')->getError(),'失败',0);
        }
    }
    // 删除商品
    public function delitem(){
        $this->check();
        $number = $_SESSION['goods'][$_GET['sn']]['goods_number'];
        unset($_SESSION['goods'][$_GET['sn']]);
        $config = C('config');
        $pre = $config['db']['db_prefix'];
        $sql = 'update m_goods set goods_number=goods_number+'.$number.' where goods_sn = "'.$_GET['sn'].'"';
        if(M('goods')->query($sql)){
            $this->ajaxReturn('','成功',1);
        }else{
            $this->ajaxReturn(M('goods')->getError(),'失败',0);
        }
    }
    // 删除商品
    public function delitems(){
        if(empty($_POST['sn'])) $this->ajaxReturn('','删除失败',0) ;
        $sns = $_POST['sn'];
        foreach($sns as $sn){
            $number = $_SESSION['goods'][$sn]['goods_number'];
            unset($_SESSION['goods'][$sn]);
            $config = C('config');
            $pre = $config['db']['db_prefix'];
            $sql = 'update m_goods set goods_number=goods_number+'.$number.' where goods_sn = "'.$sn.'"';
            if(!M('goods')->query($sql)){
                $this->ajaxReturn(M('goods')->getError(),'失败',0);
            }
        }
        $this->ajaxReturn('','成功',1);
    }

    protected function modDB($data){
        $where = 'goods_sn = "'.$_GET['sn'].'"';
        return M('goods')->update($data,$where);
    }

    protected  function goodsinfo(){
        return M('goods')->getRow('goods_name,goods_number,shop_price,thumb_img','goods_sn="'.$_GET['sn'].'"');
    }

    protected function check(){
        if(empty($_GET['sn'])) exit ;
    }
    // 购物车
    public function index(){
        $items = array();
        $items = isset($_SESSION['goods']) ? $_SESSION['goods'] : array() ;
        $temps = M('focus')->getAll('gsn','uid='.$_SESSION['userid']);
        $focus = array();
        foreach($temps as $temp){
            $focus[] = $temp['gsn'];
        }
        foreach($items as $k=>$item){
            $items[$k]['flag'] = 0;
            if(in_array($item['goods_sn'],$focus)){
                $items[$k]['flag'] = 1;
            }
        }
        $this->assign('items',formatgoods($items));
         $this->display('cart');
    }

    // 判断购物车是否有该商品
    public function hasItem(){
        return empty($_SESSION['goods'][$_GET['sn']]);
    }

    //购物车结算
    public function pay(){
        $items = array();
        $items = isset($_SESSION['goods']) ? $_SESSION['goods'] : '' ;
        $total = '';
        foreach($items as $k=>$item){
            $total += $item['shop_price']*$item['goods_number'];
            $items[$k]['sintotal'] =  $item['shop_price']*$item['goods_number'];
        }
        $gains = M('gain')->getAll('gname,prov,city,country,address,phone','uid='.$_SESSION['userid']);
        $gains = empty($gains) ? 0 : $gains ;
        $this->assign('gains',$gains);
        $this->assign('total',$total);
        $this->assign('items',formatgoods($items));
        $this->display('payFor');
    }

    // ajax收货人增加地址
    public function address(){
        if(empty($_POST)) $this->ajaxReturn('','没有传值',0);
        $data = array();
        $gain =  M('gain');
        $gain->validata = array(
            array('gname','require','收款人不能为空'),
            array('prov','require','省份不能为空'),
            array('city','require','城市不能为空'),
            array('address','require','详细地址不能为空'),
            array('phone','tel','填写正确手机号'),
        );
        $data['uid'] = $_SESSION['userid'];
        $data['gname'] = $_POST['name'];
        $data['prov'] = $_POST['provice'];
        $data['city'] = $_POST['city'];
        $data['country'] = $_POST['country'];
        $data['address'] = $_POST['address'];
        $data['phone'] = $_POST['phone'];
        if($gain->add($data)){
            $ajaxdata = $gain->getAll('gname,prov,city,country,address,phone','uid='.$_SESSION['userid']);
            $this->ajaxReturn($ajaxdata,'成功',1);
        }else{
            $this->ajaxReturn('',$gain->getError(),0);
        }
    }

}