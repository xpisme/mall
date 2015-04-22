<?php 

/**
 * @Author:      xp
 * @DateTime:    2015-04-18 16:37:14
 * @Description: 公用方法
 */


defined('ACC')||exit('ACC Denied');

/*本次运行的sql语句
 * @param string $sql 
 * @return array 
 */
function sqllog($sql=''){
	static $log = array();
	static $i = 1;
	if(!empty($sql)){
		$log['sql'.$i++] = $sql;
		return;
	}else{
		return $log;
	}
}
/*运行轨迹和sql
 * @return array 
 */
function get_trace(){
	ob_start();
	debug_print_backtrace();
	$trace = ob_get_clean();
	$trace = explode('#', trim($trace));
	array_shift($trace);
	array_shift($trace);
	$trace = array_reverse($trace);
	foreach ($trace as $k => $v) {
		$trace[$k] = trim(substr($v, 3));
	}
	$sqllog = sqllog();
	$res = array_merge($trace,$sqllog);
	return $res;
}
/*
*获得语言包的变量
*/
function L($key,$kind=''){
	static $lang = array();
	if(!empty($kind)){
		file_exists(LANG.$kind.'.php') ? require LANG.$kind.'.php' : LANG.'zh_cn.php' ;
		$lang = $_LANG;
		return;
	}
	return $lang[$key];
}

/*获得model的模型
 * @param string $name 
 * @return object
 */
function M($name){
	static $m = array();
	if(!empty($m[$name])) return $m[$name];
	$tmp = new Model\Model();
	$tmp->table($name);
	return $m[$name] = $tmp;
}
