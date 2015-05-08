<?php 
/**
 * @Author:      xp
 * @DateTime:    2015-04-18 08:10:57
 * @Description: 数据库基础类
 */
namespace Core\db;
use Core;
defined('ACC')||exit('ACC Denied');

abstract class DB{
	// 数据库配置
	public $db_config;
	// 链接资源
	private $link;
	// 插入的id
	private $insertid;
	// 最后的sql语句
	private $lastSql;
	// 当前数据库
	public $currdb;
	public function __construct(){
		$tmp = C('config');
        $this->db_config = $tmp['db'];
		$this->connect();
	}
	
	/**
	 * 链接数据库
	 * @access public
	 * @return resource
	 */
	public function connect(){}

	/**
	 * 获得所有数据
	 * @access public
	 * @return array
	 */
	public function getAll($field = '*',$where = 1,$group='',$having='',$order='',$limit=''){
	}

	/**
	 * 获得一行数据
	 * @access public
	 * @param where str
	 * @return array
	 */
	public function getRow($where){}

	/**
	 * 获得一个数据
	 * @access public
	 * @param field str
	 * @param where str
	 * @return mix
	 */
	public function getOne($field,$where){}

	/**
	 * 删除数据
	 * @access public
	 * @param where  str
	 * @return bool
	 */
	public function delete($where){}

	/**
	 * 更新数据
	 * @access public
	 * @param where  str
	 * @param arr  array
	 * @return bool
	 */
	public function update($arr,$where){}
	
	/**
	 * 增加数据
	 * @access public
	 * @param arr array
	 * @return int  insertid
	 */
	public function add($arr){}

	/**
	 * 执行sql语句
	 * @access public
	 * @param  sql str
	 * @return array
	 */
	public function query($sql){}

	/**
	 * 分析参数类型
	 * @access public
	 * @param value mix
	 * @return mix
	 */
	public function parseValue($value){
		if(is_string($value)){
			return '\''.$value.'\'';
		}
		return $value;
	}
	
	/**
	 * 获得最新插入的id
	 * @access public
	 * @return int
	 */
	public function insertId(){
		return $this->insertid;
	}
	
	/**
	 * 获得最后的sql语句
	 * @access public
	 * @return int
	 */
	public function lastSql(){
		return $this->lastSql;
	}
	/**
	 * 设置当前数据库
	 * @access public
	 * @return str
	 */
	public function table($table){
		return $this->currdb = $this->db_config['db_name'].'.'. $this->db_config['db_prefix'] .$table;
	}


}

