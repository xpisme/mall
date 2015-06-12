<?php 
/**
 * @Author:      xp
 * @DateTime:    2015-04-20 21:22:54
 * @Description: Description
 */
namespace Controller\Home;
use Controller;
use Lib;
defined('ACC')||exit('ACC Denied');

class IndexController extends Controller\Controller{
	public function index(){
        $goods = M('goods');
        $where = ' is_on_sale = 1 and is_delete = 0 ';
        $goodsimg = $goods->getAll('gid,goods_name,thumb_img',$where,'','','click_count desc','5');
        $images = $goods->getAll('gid,goods_sn,goods_name,thumb_img',$where,'','','rand()','6');
        $all = $goods->getAll('gid,goods_sn,sid,goods_name,shop_price,activi_price,goods_number,click_count,goods_desc,thumb_img,ori_img',$where,'','','',8);
        $this->assign('goods',formatgoods($all));
        $this->assign('images',formatgoods($images));
        $this->assign('goodsimg',formatgoods($goodsimg));
		$this->display('index');
	}
    public function gory(){
        if(!$_GET['z']) exit;
        $reg = '/bxve(\d+)/';
        preg_match($reg, $_GET['z'],$matches);
        if (count($matches)>1) {
            $cid = $matches[1];
        }else{
            $cid = 0;
        }
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
        if($cid == 0){
            $this->index();
        }else{
            $res = M('goods')->getAll('gid,goods_sn,sid,goods_name,shop_price,activi_price,goods_number,click_count,goods_desc,thumb_img,ori_img',$where,'','','click_count desc','8');
            $res = formatgoods($res);
            $pname = get_crumbs($cid);
            $childlist = M('cate')->getOne('childlist','cid='.$cid);
            $childs = !empty($childlist) ? M('cate')->getAll('cid,cname','cid in ('.$childlist.')') : '' ;
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
        $ajaxdata['res'] = formatgoods($res);
        $this->ajaxReturn($ajaxdata,'',1);
    }

    public function goods(){
        if(!isset($_GET['sn'])) $this->index();
        $sql = 'select s.name,s.tel,g.gid,g.goods_sn,g.cat_id,g.sid,g.goods_name,g.shop_price,g.activi_price,g.goods_number,g.click_count,g.goods_desc,g.thumb_img from m_goods g left join m_shop s on g.sid=s.sid where goods_sn="'.$_GET['sn'].'" limit 1';
        $goodinfo = M('goods')->query($sql);
        if(empty($goodinfo)) $this->index();
        $goodinfo = formatgoods($goodinfo);
        $goods = current($goodinfo);
        $where = 'cat_id='.$goods['cat_id'].' and gid <> '.$goods['gid'];
        $othergoods = M('goods')->getAll('gid,goods_sn,goods_name,thumb_img',$where,'','','click_count desc',6);
        M('goods')->query('update m_goods set click_count=click_count+1 where goods_sn="'.$_GET['sn'].'"');

        if(!empty($_SESSION['userid'])){
            $isfocus =  M('focus')->getOne('fid','gsn="'.$goods['goods_sn'].'" and uid='.$_SESSION['userid']);
            $isfocus = is_bool($isfocus) ? '关注一下' : '取消关注';
        }else{
            $isfocus = '关注一下';
        }
        $this->assign('isfocus',$isfocus);
        $this->assign('others',formatgoods($othergoods));
        $this->assign('goodsinfo',$goods);
        $this->display('goods');
    }
    public function focus(){
        if(empty($_POST)) echo '失败';
        if(empty($_SESSION['userid'])) $this->ajaxReturn('','未登录',0);
        $ajaxdata = array();
        $data = array();
        $foucs = M('focus');
        $data['uid'] = $_SESSION['userid'];
        $data['gsn'] = $_POST['sn'];
        // 判断是否已关注
        $where = 'gsn="'.remove_xss($_POST['sn']).'" and uid='.$_SESSION['userid'];
        $isf = $foucs->getOne('fid',$where);
        if(is_bool($isf)){
            if($foucs->add($data)){
                $this->ajaxReturn('','取消关注',1);
            }else{
                $this->ajaxReturn('','关注失败',0);
            }
        }else{
            if($foucs->delete($where)){
                $this->ajaxReturn('','关注一下',1);
            }else{
                $this->ajaxReturn('','取消关注失败',0);
            }
        }

    }
    public function care(){
        //关注 这里应该有个列表
        $config = C('config');
        $wheres = 'uid='.$_SESSION['userid'];
        $sql = 'select count(*) as total from '.$config["db"]["db_prefix"].'focus where '.$wheres.' ';
        $total = M('focus')->query($sql);
        $page = new Lib\page($total[0]['total']);
        $limit = $page->limit();
        $pagenav = $page->pagenav();
        $goodssn = M('focus')->getAll('gsn',$wheres,'','','fid desc',$limit);
        $data = array();
        foreach($goodssn as $sn){
            $where = ' goods_sn = "'.$sn['gsn'].'"';
            $data[] = M('goods')->getRow('gid,goods_sn,goods_name,shop_price,goods_desc,thumb_img',$where);
        }
        if(!empty($_SESSION['goods'])){
            $keys = array_keys($_SESSION['goods']);
        }else{
            $keys = array();
        }
        foreach($data as $k => $value){
            $data[$k]['iscart'] = 0;
            if(in_array($value['goods_sn'],$keys)){
                $data[$k]['iscart'] = 1;
            }
        }

        $isshop = is_string(M('shop')->getOne('sid',$wheres)) ? 1 : 0 ;
        $this->assign('isshop',$isshop);
        $this->assign('pagenav',$pagenav);
        $this->assign('lists',formatgoods($data));
        $this->display('Care');
    }


}



