<?php 
/**
 * @Author:      xp
 * @DateTime:    2015-04-18 17:35:08
 * @Description: mysqli类
 */
namespace Core\db;
use Core;
defined('ACC')||exit('ACC Denied');
class mysqlidb extends DB{
	/**
	 * 链接数据库
	 * @access public
	 * @return resource
	 */
	public function connect(){

		$this->link = mysqli_connect($this->db_config['db_host'],$this->db_config['db_user'],$this->db_config['db_pass'],$this->db_config['db_name']) or die('链接失败');

		if(!$this->query("set names ".$this->db_config['db_char'])){
			exit('编码设置失败');
		}
	}

	/**
	 * 获得所有数据
	 * @access public
	 * @return array
	 */
	public function getAll($field = '*',$where = 1,$group='',$having='',$order='',$limit=''){
		$sql = 'select ';
		$where = $where == 1 ? '' : ' where '.$where;
		$group = $group == '' ? '' : ' group by '.$group ;
		$having = $having == '' ? '' : ' having '.$having;
		$order = $order == '' ? '' : ' order by '.$order ;
		$limit = $limit == '' ? '' : ' limit '.$limit;
		$sql = $sql . $field . ' from '.$this->currdb.$where.$group.$having.$order.$limit;
		return $this->query($sql);
	}

	/**
	 * 获得一行数据
	 * @access public
	 * @param where str
	 * @return array
	 */
    public function getRow($filed='*',$where){
        $sql = "select ".$filed." from ".$this->currdb." where ".$where." limit 1";
        $res = $this->query($sql);
        return empty($res) ? false : $res[0] ;
    }

	/**
	 * 获得一个数据
	 * @access public
	 * @param field str
	 * @param where str
	 * @return mix
	 */
	public function getOne($field,$where){
		$sql = "select ".$field." from ".$this->currdb." where ".$where;
        $res = $this->query($sql);
        return empty($res) ? false : $res[0] ;
	}

	/**
	 * 删除数据
	 * @access public
	 * @param where  str
	 * @return bool
	 */
	public function delete($where){
        if(empty($where)) exit();
		$sql = 'delete from '.$this->currdb.' where '.$where;
		return $this->query($sql);
	}

	/**
	 * 更新数据
	 * @access public
	 * @param where  str
	 * @param arr  array
	 * @return bool
	 */
	public function update($arr,$where){
		if(empty($where)) exit();
		$sql = "update ".$this->currdb." set ";
		foreach ($arr as $key => $value) {
			$value = $this->parseValue($value);
            $set[]    = $key.'='.$value;
		}
		$sql .= implode(',', $set);
		$where = " where ".$where;
		$sql .= $where;
		return $this->query($sql);
	}
	
	/**
	 * 增加数据
	 * @access public
	 * @param arr array
	 * @return int  insertid
	 */
	public function add($arr){

		$sql = '';
		$sql .= 'insert into '.$this->currdb.' ';
		foreach ($arr as $key => $value) {
			$values[]=$this->parseValue($value);
		}
		$sql .= '('. implode(',', array_keys($arr)).') values (' .implode(',', $values).')';
		$this->query($sql);

		return $this->insertid = mysqli_insert_id($this->link);
	}

	/**
	 * 执行sql语句
	 * @access public
	 * @param  sql str
	 * @return array
	 */
	public function query($sql){
		require_once CORE.'log.class.php';
		sqllog($sql);
//        Core\log::write(implode("\r\n",get_trace()));
//        Core\log::write($sql);
		$this->lastSql = $sql;
		if($res = mysqli_query($this->link,$sql))
		{
			if(is_bool($res)){
				return true;
			}elseif(is_object($res)){
				return $this->fetch($res);
			}
		}else{
			Core\log::write($sql);
			return false;
		}
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
	 * 根据资源得出数组
	 * @access public
	 * @param resource
	 * @return int
	 */
	public function fetch($res){
		$arr = array();
		while ($row = mysqli_fetch_assoc($res)) {
			$arr[]=$row;
		}
		return $arr;
	}
}

 ?>