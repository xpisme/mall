<?php 
/**
 * @Author:      xp
 * @DateTime:    2015-04-27 17:32:43
 * @Description: Description
 */
namespace Controller\Admin;
use Controller;
defined('ACC')||exit('ACC Denied');

class GoodsController extends Controller\Controller{
	/*
	* 添加商品
	*/
	public function manage(){
        
        $this->display('goods_manage');
	}
}



 ?>