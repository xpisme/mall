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

class GoodsController extends AdminController
{
    public function lists()
    {
        $goods = M('goods');
        $config = C('config');
        $sql=  'select count(*) as total from '.$config["db"]["db_prefix"].'goods a left join '.$config["db"]["db_prefix"].'shop b on a.sid=b.sid where a.is_delete = 0 and b.uid='.$_SESSION['userid'];
        $total = $goods->query($sql);
        $page = new Lib\page($total[0]['total'], 10);
        $limit = $page->limit();
        $pagenav = $page->pagenav();
        $sql = 'select gid,name,left(goods_name,7)as gname,goods_name,goods_number,shop_price,activi_price,click_count,left(add_time,10) as addtime from '.$config["db"]["db_prefix"].'goods a left join '.$config["db"]["db_prefix"].'shop b on a.sid=b.sid where a.is_delete = 0 and b.uid='.$_SESSION['userid'].' limit '.$limit;
        $lists = $goods->query($sql);

        $this->assign('pagenav', $pagenav);
        $this->assign('lists', $lists);
        $this->display('goods_list');
    }

    public function edit()
    {
        if (empty($_POST)) {
            $where = 'gid='.$_GET['gid'];
            $goods = M('goods');
            $info = $goods->getRow('gid,cat_id, goods_name, shop_price, activi_price, goods_number, goods_desc, thumb_img', $where);
            $info['thumb_img'] = explode(',', $info['thumb_img']);
            $this->assign('info', $info);
            $this->display('goods_edit');
        } else {
            $data = array();
            if (!$_FILES['fileimg']['error']) { //不为空，则图片修改了
                $res = Lib\image::upimage($_FILES);
                if (!$res['info']) {
                    $this->showMessage($res['msg']);
                }
                $data['thumb_img'] = $data['ori_img'] = implode(',', $res['filename']);
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
            $data['sid'] = $shop->getOne('sid', 'uid='.$_SESSION['userid']);
            $where = 'gid='.$_POST['gid'];
            if (!$goods->update($data, $where)) {
                $this->showMessage($goods->getError());
            } else {
                $this->lists();
            }
        }
    }
    public function add()
    {
        if (empty($_POST)) {
            return $this->display('goods_add');
        }
        $data = array();
        $res = Lib\image::upimage($_FILES);
        if (!$res['info']) {
            $this->showMessage($res['msg']);
        }
        $data['thumb_img'] = $data['ori_img'] = implode(',', $res['filename']);
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
        $data['goods_sn'] = substr(str_shuffle('ABCDEFGHIJKLMNOPKRSTUXWXYZ'), 0, 5).crc32($data['goods_name']);
        $data['sid'] = $shop->getOne('sid', 'uid='.$_SESSION['userid']);
        if (!$goods->add($data)) {
            $this->showMessage($goods->getError());
        } else {
            $this->showMessage('商品添加成功！');
        }
    }

    public function dele()
    {
        $where = 'gid='.$_GET['gid'];
        $goods = M('goods');
        $arr = array();
        $arr['is_delete'] = 1;
        if ($goods->update($arr, $where)) {
            $this->showMessage('删除成功', 'index.php?m=admin&c=goods&a=lists');
        } else {
            $this->showMessage('删除失败', 'index.php?m=admin&c=goods&a=lists');
        }
    }

    public function del()
    {
        $where = 'gid='. $_GET['gid'];
        $goods = M('goods');
        if ($goods->delete($where)) {
            $this->showMessage('删除成功', 'index.php?m=admin&c=goods&a=recycle');
        } else {
            $this->showMessage('删除失败', 'index.php?m=admin&c=goods&a=recycle');
        }
    }

    public function recycle()
    {
        $goods = M('goods');
        $config = C('config');
        $sql=  'select count(*) as total from '.$config["db"]["db_prefix"].'goods a left join '.$config["db"]["db_prefix"].'shop b on a.sid=b.sid where a.is_delete = 0 and b.uid='.$_SESSION['userid'];
        $total = $goods->query($sql);
        $page = new Lib\page($total[0]['total'], 10);
        $limit = $page->limit();
        $sql = 'select gid,name,left(goods_name,7)as gname,goods_name,goods_number,shop_price,activi_price,click_count,left(add_time,10) as addtime from '.$config["db"]["db_prefix"].'goods a left join '.$config["db"]["db_prefix"].'shop b on a.sid=b.sid where a.is_delete = 1 and b.uid='.$_SESSION['userid'].' limit ' . $limit;
        $lists = $goods->query($sql);
        $pagenav = $page->pagenav();
        $this->assign('pagenav', $pagenav);
        $this->assign('lists', $lists);
        $this->display('recycle');
    }
    public function reset()
    {
        $where = 'gid='.$_GET['gid'];
        $goods = M('goods');
        $arr = array();
        $arr['is_delete'] = 0;
        if ($goods->update($arr, $where)) {
            $this->showMessage('还原成功', 'index.php?m=admin&c=goods&a=recycle');
        } else {
            $this->showMessage('还原失败', 'index.php?m=admin&c=goods&a=recycle');
        }
    }
}
