<?php
namespace Controller\Admin;

use Controller;

class CacheController extends Controller\Controller{
    public static function category(){
        $cate = M('cate');
        $category = $cate->getAll('cid,cname,pid,childlist,pidlist,level');
        GC('category',$category);
    }
}