<?php 
/**
 * @Author:      xp
 * @DateTime:    2015-04-20 21:22:54
 * @Description: Description
 */
namespace Controller\Home;
use Controller;
defined('ACC')||exit('ACC Denied');

class IndexController extends Controller\Controller{
	public function index(){
        $goods = M('goods');
        $where = ' is_on_sale = 1 and is_delete = 0 ';
        $goodsimg = $goods->getAll('gid,goods_name,thumb_img',$where,'','','click_count desc','5');
        $images = $goods->getAll('gid,goods_sn,goods_name,thumb_img',$where,'','','rand()','6');
        $all = $goods->getAll('gid,goods_sn,sid,goods_name,shop_price,activi_price,goods_number,click_count,goods_desc,thumb_img,ori_img',$where,'','','',8);
        $this->assign('goods',$all);
        $this->assign('images',$images);
        $this->assign('goodsimg',$goodsimg);
		$this->display('index');
	}
    public function gory(){
        if(!$_GET['z']) exit;
        $cid = substr($_GET['z'],stripos($_GET['z'],'bxve')+4);
        get_all_child(GC('category'),$cid,$childs);
        if($childs){
            $str = implode(',',$childs).','.$cid;
        }else{
            $str = $cid;
        }
        $where = 'cat_id in ('.$str.') and is_on_sale = 1 and is_delete = 0 ';
        if(isset($_GET['price'])){
            $price = explode(',',$_GET['price']);
            if($price[1] == '*'){
                $where .= ' and shop_price >'.$price[0];
            }else{
                $where .= ' and shop_price >'.$price[0].' and shop_price <'.$price[1];
            }
        }
        $goods = M('goods');
        if($cid == 0){
            $this->index();
        }else{
            $res = $goods->getAll('gid,goods_sn,sid,goods_name,shop_price,activi_price,goods_number,click_count,goods_desc,thumb_img,ori_img',$where,'','','click_count desc','8');
            echo $goods->lastSql();
            $pname = get_crumbs($cid);
            $childlist = M('cate')->getOne('childlist','cid='.$cid);
            $childs = M('cate')->getAll('cid,cname','cid in ('.$childlist.')');
        }


        $this->assign('cid',$cid);
        $this->assign('childs',$childs);
        $this->assign('crumbs',$pname);
        $this->assign('goods',$res);
        $this->display('show');
    }
    public function getgoods(){
        if(!$_POST['len']) exit;
        $ajaxdata = array();
        $goods = M('goods');
        if(isset($_GET['price'])){
            $price = explode(',',$_GET['price']);
            if($price[1] == '*'){
                $where = ' and shop_price >'.$price[0];
            }else{
                $where = ' and shop_price >'.$price[0].' and shop_price <'.$price[1];
            }
        }else{
            $where = '';
        }
        $sql = 'select gid,goods_sn,sid,goods_name,shop_price,activi_price,goods_number,click_count,goods_desc,thumb_img,ori_img from m_goods where is_on_sale = 1 and is_delete = 0 '.$where.' limit 8 offset '.$_POST['len'];
        $res = $goods->query($sql);
        $ajaxdata['res'] = $res;
        $this->ajaxReturn($ajaxdata,'',1);
    }

    public function goods(){
        if(!isset($_GET['sn'])) $this->index();
        $sql = 'select s.name,s.tel,g.gid,g.goods_sn,g.cat_id,g.sid,g.goods_name,g.shop_price,g.activi_price,g.goods_number,g.click_count,g.goods_desc,g.thumb_img from m_goods g left join m_shop s on g.sid=s.sid where goods_sn="'.$_GET['sn'].'" limit 1';
        $goodinfo = M('goods')->query($sql);
        if(empty($goodinfo)) $this->index();
        $goods = current($goodinfo);
        $where = 'cat_id='.$goods['cat_id'].' and gid <> '.$goods['gid'];
        $othergoods = M('goods')->getAll('gid,goods_sn,goods_name,thumb_img',$where,'','','click_count desc',6);
        $this->assign('others',$othergoods);
        $this->assign('goodsinfo',$goods);
        $this->display('goods');
    }


}



