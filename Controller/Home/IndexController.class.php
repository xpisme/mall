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
		$this->display('index');
	}
}



