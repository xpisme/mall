<?php 
/**
 * @Author:      xp
 * @DateTime:    2015-04-18 10:13:43
 * @Description: 框架驱动类
 */
namespace Core;

defined('ACC')||exit('ACC Denied');


final class App {
	public static $_config;
	public static function init(){
		spl_autoload_register(array('Core\App','my_autoload'));
		$config = config::offsetGet('config');
		self::$_config = $config;
		require CORE.'functions.php';
		L('',$config['lang']);
		error_reporting(0);
		if(DEBUG){
			error_reporting(-1);
		}
		ini_set('error_log',DATA.'errorlog/my_error.log');
		$_GET = _addslashes($_GET);
		$_POST = _addslashes($_POST);
		$_REQUEST = _addslashes($_REQUEST);
	}

	public static function run(){
		self::init();
		self::router();
	}

	/*
	 *自动加载类
	 */
	public static function my_autoload($name){
		$str = str_replace('\\', '/', $name);
		if(file_exists(ROOT.$str.'.class.php'))
		require_once ROOT.$str.'.class.php';
	}
	/*
	 * 路由 分发控制器
	 */
	public static function router(){
		$url = parse_url($_SERVER['REQUEST_URI']);
		$query = isset($url['query']) ? $url['query'] : '' ;
		if(!empty($query)){
			$res = explode('&', $query);
			foreach ($res as $v) {
				$tmp = explode('=', $v);
				if(strtolower($tmp[0]) == 'c'){
					$controller = ucfirst($tmp[1]); //哪个控制器
				}elseif (strtolower($tmp[0] == 'a')) {
					$action = $tmp[1]; //哪个方法
				}
			}
		}else{
			$controller = 'index';
			$action = 'index';
		}
		if(isset($controller)){
			$ctrl = 'Controller\\'.$controller.'Controller';
			$temp = new $ctrl();
			if(!isset($action) || !method_exists($temp, $action)){
				$action = 'index';
			}
			$temp->$action();
		}else{
			exit(L('controller_method_does_not_exist'));
		}
	}
}


