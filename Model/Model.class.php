<?php 

/**
 * @Author:      xp
 * @DateTime:    2015-04-18 08:06:49
 * @Description: 模型的基础类
 */


namespace Model;
use Core;

defined('ACC')||exit('ACC Denied');

class Model{
	protected $db;
	public $validata = array(); 
	// validata array(field,rule,message,condition)
	public function _validata($data){
		foreach ($this->validata as $value) {
			switch ($value[1]) {
				case 'require':
					if (empty($data[$value[0]])) {
							exit($value[0].' : '. $value[2]);
						}
					break;
				case 'unique':
					$res = $this->getAll($value[0]);
					if(in_array($data[$value[0]], $res[0])){
						exit($value[0].' : '. $value[2]);
					}
					break;
				case 'number':
					$reg = '/^\d+$/';
					if(preg_match($reg, $data[$value[0]]) === 0){
						exit($value[0].' : '. $value[2]);	
					}elseif(!empty($value[3])){
						if(strlen($data[$value[0]]) !== $value[3]) exit($value[0].' : '. $value[2]);
					}
					break;
				case 'email':
					$reg = '/^[\da-z._]+@[\da-z._]$/i';
					if(preg_match($reg, $data[$value[0]]) === 0) exit($value[0].' : '. $value[2]);
					break;
				case 'url': 
					$reg = '#^http[s]?://[\w./]+$#i';
					if(preg_match($reg, $data[$value[0]]) === 0) exit($value[0].' : '. $value[2]);
					break;
				case 'ip': 
					$reg = '/^((\d{1,2}|1\d{2}|2[0-4]\d|25[0-5])([.]?)){4}$/';
					if(preg_match($reg, $data[$value[0]]) === 0) exit($value[0].' : '. $value[2]);
					break;
				case 'min':
					if(mb_strlen($data[$value[0]],'utf-8') > $value[3]) exit($value[0].' : '. $value[2]);
					break;
				case 'max':
					if(mb_strlen($data[$value[0]],'utf-8') < $value[3]) exit($value[0].' : '. $value[2]);
					break;
				case 'in':
					$tmparr = explode(',', trim($value[3]));
					if(!in_array($data[$value[0]], $tmparr)) exit($value[0].' : '. $value[2]);
					break;
				case 'between':
					$objlen = mb_strlen($data[$value[0]],'utf-8');
					$tmparr = explode(',', $value[3]);
					if(($objlen < $tmparr[0]) || ($objlen > $tmparr[1])) exit($value[0].' : '. $value[2]);
					break;
				default:
					break;
			}
		}
	}

	/** 读取文件，选择数据库，创建链接
	 */
	public function __construct(){
		$CONFIG = Core\App::$_config['db'];
		require CORE.'db/DB.class.php';
		require CORE.'db/'.$CONFIG['db_type'].'.class.php';
		$db = 'Core\\db\\'.$CONFIG['db_type'].'db';
		$this->db =  new $db($CONFIG);
	}
	public function table($table){
		return $this->db->table($table);
	}
	public function getAll($field = '*',$where = 1,$group='',$having='',$order='',$limit=''){
		return $this->db->getAll($field,$where,$group,$having,$order,$limit);
	}

	public function getRow($where){
		return $this->db->getRow($where);
	}

	public function getOne($field,$where){
		return $this->db->getOne($field,$where);
	}

	public function delete($where){
		return $this->db->delete($where);
	}

	public function update($arr,$where){
		return $this->db->update($arr,$where);
	}

	public function add($arr){
		$this->_validata($arr);
		return $this->db->add($arr);
	}

	public function query($sql){
		return $this->db->query($sql);
	}

	public function insertId(){
		return $this->db->insertId();
	}

	public function lastSql(){
		return $this->db->lastSql;
	}

}




 ?>