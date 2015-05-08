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

/*过滤字符串
 * @param array $arr 
 * @return array
 */
function _addslashes($arr){
	foreach ($arr as $key => $value) {
		if(is_array($value)){
			_addslashes($value);
		}else{
			$arr[$key] = trim(addslashes($value));
		}
	}
	return $arr;
}
/**
 *读取配置信息
 */
function C($key){
    static $config;
    if(!isset($config)) {
        $config = new \Core\Config();
    }
    return $config->offsetGet($key);
}

/** 获取缓存信息  get cache GC
 * @param $key
 * @param $value
 */
function GC($key,$value=array()){
    static $cache = array();
    $filename = DBCACHE.$key.'.php';
    if(empty($value)){
        if(isset($cache[$key])) return $cache[$key];
        $value = include $filename;
        $cache[$key] = unserialize($value);
        return $cache[$key];
    }
    file_put_contents($filename,"<?php return '".serialize($value)."';");
}

/**
 * @param $currid  当前id
 * @param $data   总数据
 * @param $list  引用传值 返回string
 */
function getPlist($currid,$data,&$list){
    if(empty($data)) return;
    if($currid == 0) {
        $list = substr($list,0,-1);
        return;
    }
    foreach($data as $curr){
        if($curr['cid'] == $currid){
            $list .= $curr['pid'].',';
            getPlist($curr['pid'],$data,$list);
        }
    }
}

/**
 * @param $currid 当前id
 * @param $data  所有的数据
 * @param $list   返回的的子元素
 */
function getChildlist($currid,$data,&$list){
    if(empty($data)) return;
    foreach($data as $curr){
        if($curr['pid'] == $currid){
            $list .= $curr['cid'].',';
        }
    }
    $list = substr($list,0,-1);
}

function catetree($cates,$pid=0){
    static $tree = array();
    foreach($cates as $cate){
        if($cate['pid'] == $pid){
            $cate['pre'] = str_repeat("&nbsp;",($cate['level']-1)*2);
            $tree[] = $cate;
            if(!empty($cate['childlist'])){
                catetree($cates,$cate['cid']);
            }
        }
    }
    return $tree;
}

