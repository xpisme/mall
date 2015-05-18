<?php 
/**
 * @Author:      xp
 * @DateTime:    2015-04-27 17:32:43
 * @Description: Description
 */
namespace Controller\Admin;
use Controller;
use Lib;

defined('ACC')||exit('ACC Denied');

class GoodsController extends Controller\Controller{
    public function __construct(){
        parent::__construct();
        if(empty($_SESSION['username'])) header('location:'.SITE);
        $this->assign('username',$_SESSION['username']);
    }
    public function lists(){
        $goods = M('goods');
        $config = C('config');
        if(isset($_GET['page']) && $_GET['page']>0) {
            $page = $_GET['page']+0;
        }else{
            $page = 1;
        }
        $prepage = 9;
        $limit = ' limit '. ($page-1)*$prepage . ','.$prepage;
        $sql = 'select gid,name,left(goods_name,7)as gname,goods_name,goods_number,shop_price,activi_price,click_count,left(add_time,10) as addtime from '.$config["db"]["db_prefix"].'goods a left join '.$config["db"]["db_prefix"].'shop b on a.sid=b.sid where a.is_delete = 0 and b.uid='.$_SESSION['userid'].$limit;
        $lists = $goods->query($sql);
        $sql=  'select count(*) as total from '.$config["db"]["db_prefix"].'goods a left join '.$config["db"]["db_prefix"].'shop b on a.sid=b.sid where a.is_delete = 0 and b.uid='.$_SESSION['userid'];
        $total = $goods->query($sql);
        if($prepage < $total[0]['total']){
            $page = new Lib\page($total[0]['total'],$page,$prepage);
            $pagenav = $page->show();
        }else{
            $pagenav = '';
        }
        $this->assign('pagenav',$pagenav);
        $this->assign('lists',$lists);
        $this->display('goods_list');
    }

    public function edit(){
        if(empty($_POST)){
            $where = 'gid='.$_GET['gid'];
            $goods = M('goods');
            $info = $goods->getRow('gid,cat_id, goods_name, shop_price, activi_price, goods_number, goods_desc, thumb_img',$where);
            $info['thumb_img'] = explode(',',$info['thumb_img']);
            $this->assign('info',$info);
            $this->display('goods_edit');
        }else{
            $data = array();
            if(!$_FILES['fileimg']['error']){ //不为空，则图片修改了
                $res = Lib\image::upimage($_FILES);
                if(!$res['info']) $this->showMessage($res['msg']);
                $data['thumb_img'] = $data['ori_img'] = implode(',',$res['filename']);
            }
            $goods = M('goods');
            $shop = M('shop');
            $goods->validata = array(
                array('goods_name','require','商品名不能为空'),
                array('goods_number','number','数量必须为数字'),
                array('shop_price','number','价格不正确'),
                array('activi_price','number','价格不正确'),
                array('cat_id','number','请确认')
            );
            $data['goods_name'] = $_POST['goods_name'];
            $data['goods_number'] = $_POST['goods_number'];
            $data['shop_price'] = $_POST['shop_price'];
            $data['activi_price'] = $_POST['activi_price'];
            $data['cat_id'] = $_POST['catid'];
            $data['goods_desc'] = $_POST['describe'];
            $data['sid'] = $shop->getOne('sid','uid='.$_SESSION['userid']);
            $where = 'gid='.$_POST['gid'];
            if(!$goods->update($data,$where)){
                $this->showMessage($goods->getError());
            }else{
                $this->lists();
            }
        }

    }
    public function add(){
        if(empty($_POST)) return $this->display('goods_add');
        $data = array();
        $res = Lib\image::upimage($_FILES);
        if(!$res['info']) $this->showMessage($res['msg']);
        $data['thumb_img'] = $data['ori_img'] = implode(',',$res['filename']);
        $goods = M('goods');
        $shop = M('shop');
        $goods->validata = array(
            array('goods_name','require','商品名不能为空'),
            array('goods_number','number','数量必须为数字'),
            array('shop_price','number','价格不正确'),
            array('activi_price','number','价格不正确'),
            array('cat_id','number','请确认')
        );
        $data['goods_name'] = $_POST['goods_name'];
        $data['goods_number'] = $_POST['goods_number'];
        $data['shop_price'] = $_POST['shop_price'];
        $data['activi_price'] = $_POST['activi_price'];
        $data['cat_id'] = $_POST['catid'];
        $data['goods_desc'] = $_POST['describe'];
        $data['goods_sn'] = substr(str_shuffle('ABCDEFGHIJKLMNOPKRSTUXWXYZ'),0,5).crc32($data['goods_name']);
        $data['sid'] = $shop->getOne('sid','uid='.$_SESSION['userid']);
        if(!$goods->add($data)){
            $this->showMessage($goods->getError());
        }else{
            $this->lists();
        }
    }

    public function dele(){
        $where = 'gid='.$_GET['gid'];
        $goods = M('goods');
        if($goods->delete($where)){
            $this->showMessage('删除成功');
        }else{
            $this->showMessage('删除失败');
        }
    }

}



 ?>