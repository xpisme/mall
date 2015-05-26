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
function M($name=''){
	static $m = array();
	static $resource = '';
    if(!empty($m[$name]))   return $m[$name];
    if(empty($resource)){
        $CONFIG = C('config');
        $config = $CONFIG['db'];
        require_once CORE.'db/'.$config['db_type'].'.class.php';
        $db = 'Core\\db\\'.$config['db_type'].'db';
        $resource =  new $db($config);
    }
    $tmp = new Model\Model($resource,$name);
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
function GC($key,$value=array(),$flag=false){
    static $cache = array();
    $filename = DBCACHE.$key.'.php';
    if(empty($value)){
        if(isset($cache[$key]) && !$flag) return $cache[$key];
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

function catetree($cates,$pid=0,$flag=true){
    static $tree = array();
    static $frontkey;
    if($flag) $tree = array();
    foreach($cates as $key => $cate){
        if($cate['pid'] == $pid){
            $level = $cate['level'];
            if($level == 1){
                $cate['pre'] = '&nbsp;&nbsp;';
                $num = count($tree);
                if($num > 0)  $tree[$num-1]['pre'] = str_replace('├','└',$tree[$num-1]['pre']);
            }elseif( ($cha = ($level - $cates[$frontkey]['level'])) == 0){
                $cate['pre'] =  str_repeat("&nbsp;",($level-1)*3).'├─';
                if(count($tree) == (count($cates) -1) )   $cate['pre'] =  str_repeat("&nbsp;",($level-1)*3).'└─';
            }else{
                $cate['pre'] =  str_repeat("&nbsp;",($level-1)*3).'├─';
                $num = count($tree);
                if($cha<0) $tree[$num-1]['pre'] = str_replace('├','└',$tree[$num-1]['pre']);
            }
            $frontkey = $key;
            $cate['url'] = md5($cate['cid']).'bxve'.$cate['cid'];
            $tree[] = $cate;
            if(!empty($cate['childlist'])){
                catetree($cates,$cate['cid'],false);
            }
        }
    }
    return $tree;
}

function get_all_child($arr,$id=0,&$childs){
    if(!is_array($arr)) return false;
    foreach($arr as $k=>$v){

        if($v['pid'] == $id){
            $childs[] = $v['cid'];
            if($v['childlist'] != ''){ // 有子节点
                $array = explode(',',$v['childlist']);
                foreach($array as $tv){
                    $childs[] = $tv;
                    get_all_child($arr,$tv,$childs);
                }
            }
        }
    }
}

/**
 * @param $cid 当前的栏目id
 * @return array 面包屑导航
 */
function get_crumbs($cid){
    getPlist($cid,GC('category'),$plist);
    $parray = explode(',',$plist);
    $cname = array();
    foreach($parray as $v){
        if($v) array_unshift($cname,M('cate')->getRow('cid,cname','cid='.$v));
    }
    $temp['cname'] = M("cate")->getOne("cname",'cid='.$cid);
    $temp['cid'] = $cid;
    array_push($cname,$temp);
    return $cname;
}

/** 格式化goods数组中的images
 * @param $data goods表
 */
function formatgoods($data){
    foreach($data as $k=>$v){
        if(isset($v['thumb_img'])) $data[$k]['thumb_img'] = explode(',',$v['thumb_img']);
        if(isset($v['ori_img']))   $data[$k]['ori_img'] = explode(',',$v['ori_img']);
    }
    return $data;
}
