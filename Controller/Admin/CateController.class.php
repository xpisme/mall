<?php 

/**
 * @Author:      xp
 * @DateTime:    2015-04-27 17:35:54
 * @Description: Description
 */
namespace Controller\Admin;
use Controller;
defined('ACC') or exit('ACC Denied');


class CateController extends Controller\Controller{
	public function add(){
        $data = array();
        $ajaxdata = array();
        $data['cname'] = $_POST['cname'];
        $data['info'] = $_POST['info'];
        $data['pid'] = $_POST['pid'];
        $data['level'] = 1;
        $cate = M('cate');
        if($data['pid'] != 0){
            $res = $cate->getOne('level','cid='.$data['pid']);
            $data['level'] = $res['level'] + 1;
        }
        $category = $cate->getAll('cid,pid');
        getPlist($data['pid'],$category,$list);
        $data['pidlist'] = $data['pid'].','.$list;
        if(!$cate->add($data)){
            $this->ajaxReturn($ajaxdata,'添加失败',0);
        }else{
            // 更新上一级的childlist
            $where = 'cid='.$data['pid'];
            $childlist = $cate->getOne('childlist',$where);
            $childlist = $childlist['childlist'];
            if(strlen($childlist > 0)) $childlist = $childlist.',';
            $insertid = $cate->insertId();
            $tmpdata = array();
            $tmpdata['childlist'] = $childlist.$insertid;
            $cate->update($tmpdata,$where);
            $ajaxdata['category'] = $this->getNew();
            $this->ajaxReturn($ajaxdata,'success',1);
        }
    }

    public function getNew(){
        CacheController::category();
        return GC('category');
    }
}

 ?>