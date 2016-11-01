<?php 

/**
 * @Author:      xp
 * @DateTime:    2015-04-27 17:35:54
 * @Description: Description
 */
namespace Controller\Admin;

use Controller;

defined('ACC') or exit('ACC Denied');


class CateController extends AdminController
{
    public function add()
    {
        if (empty($_POST)) {
            $this->showMessage('not value');
        }
        $data = array();
        $ajaxdata = array();
        $data['cname'] = $_POST['cname'];
        $data['info'] = $_POST['info'];
        $data['pid'] = $_POST['pid'];
        $data['level'] = 1;
        $cate = M('cate');
        $cate->validata = array(
            array('cname','require','分类名不能为空'),
            array('cname','unique','已存在'),
            array('pid','require','不能为空')
        );
        if ($data['pid'] != 0) {
            $data['level'] = $cate->getOne('level', 'cid='.$data['pid']) + 1;
        }
        $category = $cate->getAll('cid,pid');
        getPlist($data['pid'], $category, $list);
        $data['pidlist'] = empty($list) ? $data['pid'] : $data['pid'].','.$list ;
        $cate->query('set autocommit=0');
        $cate->query('begin');
        if (!$cate->add($data)) {
            $cate->query('rollback');
            $this->ajaxReturn($ajaxdata, '添加失败', 0);
        } else {
            // 更新上一级的childlist
            $where = 'cid='.$data['pid'];
            $childlist = $cate->getOne('childlist', $where);
            if (strlen($childlist > 0)) {
                $childlist = $childlist.',';
            }
            $insertid = $cate->insertId();
            $tmpdata = array();
            $tmpdata['childlist'] = $childlist.$insertid;
            $cate->validata = array();

            if (!$cate->update($tmpdata, $where)) {
                $cate->query('roolback');
            }
            $cate->query('commit');
            $ajaxdata['category'] = catetree($this->getNew());
            $this->ajaxReturn($ajaxdata, 'success', 1);
        }
    }

    public function lists()
    {
        $this->display('cate');
    }
    public function getinfo()
    {
        if (empty($_POST)) {
            $this->showMessage('not found');
        }
        $data = array();
        $cate = M('cate');
        $res = $cate->getRow('cname,pid,info', 'cid='.$_POST['id']);
        if (!$res) {
            $this->ajaxReturn($data, '没找到', 0);
        } else {
            $data['res'] = $res;
            $this->ajaxReturn($data, '', 1);
        }
    }

    public function getNew()
    {
        CacheController::category();
        return GC('category', '', true);
    }

    public function edit()
    {
        if (empty($_POST)) {
            $this->showMessage('not value');
        }
        $data = array();
        $ajaxdata = array();
        $data['cname'] = $_POST['cname'];
        $data['info'] = $_POST['info'];
        $data['pid'] = $_POST['pid'];
        $data['level'] = 1;
        $cate = M('cate');
        $cate->validata = array(
            array('cname','require','分类名不能为空'),
            array('pid','require','不能为空')
        );
        if ($data['pid'] != 0) {
            $data['level'] = $cate->getOne('level', 'cid='.$data['pid']) + 1;
        }
        $category = $cate->getAll('cid,pid,childlist,pidlist');
        getPlist($data['pid'], $category, $pidlist);
        $data['pidlist'] = empty($pidlist) ? $data['pid'] : $data['pid'].','.$pidlist ;
        $where = 'cid='.$_POST['id'];
        $oldwhere = 'cid='. $cate->getOne('pid', 'cid='.$_POST['id']);
        $oldchildlist = $cate->getOne('childlist', $oldwhere);
        $cate->query('set autocommit=0');
        $cate->query('begin');
        if (!$cate->update($data, $where)) {
            $cate->query('roolback');
            $this->ajaxReturn($ajaxdata, $cate->getError(), 0);
        } else {
            // 更新旧上一级的childlist
            $tmpdata = array();
            $childlist = str_replace($_POST['id'], '', $oldchildlist);
            $arr = explode(',', $childlist);
            $tmpdata['childlist'] = implode(',', array_filter($arr));
            $cate->validata = array();

            if (!$cate->update($tmpdata, $oldwhere)) {
                $cate->query('roolback');
            }

            // 更新新上一级的childlist
            $where = 'cid='.$data['pid'];
            $childlist = $cate->getOne('childlist', $where);
            if (strlen($childlist > 0)) {
                $childlist = $childlist.',';
            }
            $currid = $_POST['id'];
            $tmpdata = array();
            $tmpdata['childlist'] = $childlist.$currid;
            $cate->validata = array(); //设置需要检测的变量
            if (!$cate->update($tmpdata, $where)) {
                $cate->query('roolback');
            }

            // 更新所有的pidlist
            get_all_child($category, $_POST['id'], $childarray);
            if (!empty($childarray)) {
                $pidlist2 = $cate->getOne('pidlist', 'cid='.$_POST['id']);
                foreach ($childarray as $childvalue) {
                    $tmp = array();
                    $sourcepidlist = '';
                    foreach ($category as $catevalue) {
                        if ($catevalue['cid'] == $childvalue) {
                            $sourcepidlist = $catevalue['pidlist'];
                        }
                    }
                    $tmpres = $cate->query('select level from m_cate where cid in (select pid from m_cate where cid='.$childvalue.')');
                    $tmp['level'] = current($tmpres)['level'] + 1;
                    $tmp['pidlist'] = substr($sourcepidlist, 0, stripos($sourcepidlist, $_POST["id"])).$_POST["id"].','.$pidlist2;
                    if (!$cate->update($tmp, 'cid='.$childvalue)) {
                        $cate->query('roolback');
                    }
                }
            }
            $cate->query('commit');
            $ajaxdata['category'] = catetree($this->getNew());
            $this->ajaxReturn($ajaxdata, 'success', 1);
        }
    }

    public function dele()
    {
        if (empty($_POST)) {
            $this->showMessage('not value');
        }
        $ajaxdata = array();
        $id = $_POST['id'];
        $category = GC('category');
        get_all_child($category, $id, $childarray);
        if (empty($childarray)) {
            $str = $id;
        } else {
            $str =  $id.','. implode(',', $childarray);
        }
        $where = 'cid in ('.$str .')';
        $goodswhere = 'cat_id in ('.$str.') and is_delete = 0 and is_on_sale = 1' ;
        $goods = M('goods');
//        $this->ajaxReturn($goods->getOne('gid',$goodswhere),'该目录下有商品',0);
        if (!empty($goods->getOne('gid', $goodswhere))) {
            $this->ajaxReturn($ajaxdata, '该目录下有商品', 0);
        }
        $cate = M('cate');
        $oldwhere = 'cid='. $cate->getOne('pid', 'cid='.$id);
        $oldchildlist = $cate->getOne('childlist', $oldwhere);
        $cate->query('set autocommit=0');
        $cate->query('begin');
        if ($cate->delete($where)) {
            $tmpdata = array();
            $childlist = str_replace($id, '', $oldchildlist);
            $arr = explode(',', $childlist);
            $tmpdata['childlist'] = implode(',', array_filter($arr));
            $cate->validata = array();

            if (!$cate->update($tmpdata, $oldwhere)) {
                $cate->query('roolback');
            }
            $cate->query('commit');
            $ajaxdata['category'] = catetree($this->getNew());
            $this->ajaxReturn($ajaxdata, '', 1);
        } else {
            $cate->query('roolback');
            $this->ajaxReturn($ajaxdata, '删除失败', 0);
        }
    }
}
