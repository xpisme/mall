<?php 

/**
 * @Author:      xp
 * @DateTime:    2015-04-18 08:06:49
 * @Description: 模型的基础类
 */


namespace Model;

use Core\db;

defined('ACC')||exit('ACC Denied');

final class Model
{
    protected $db = '';
    protected $table;
    protected $errormsg;
    public $validata = array();
    protected static $ins='';
    // validata array(field,rule,message,condition)
    public function _validata($data)
    {
        foreach ($this->validata as $value) {
            switch ($value[1]) {
                case 'require':
                    if ($data[$value[0]] == 0) {
                        continue ;
                    }
                    if (empty($data[$value[0]])) {
                        return $this->errormsg = $value[0].':'.$value[2];
                    }
                    break;
                case 'unique':
                    $where = $value[0].'="'.$data[$value[0]].'"';
                    $res = $this->getRow('*', $where);
                    if (!empty($res)) {
                        return $this->errormsg = $value[0].':'.$value[2];
                    }
                    break;
                case 'number':
                    $reg = '/^\d+$|^(\d+[.]?\d{0,2})$/';
                    if (preg_match($reg, $data[$value[0]]) === 0) {
                        return $this->errormsg = $value[0].':'.$value[2];
                    } elseif (!empty($value[3])) {
                        if (strlen($data[$value[0]]) !== $value[3]) {
                            return $this->errormsg = $value[0].':'.$value[2];
                        }
                    }
                    break;
                case 'qq':
                    $reg = '/^\d{6,12}$/';
                    if (preg_match($reg, $data[$value[0]]) === 0) {
                        return $this->errormsg = $value[0].':'.$value[2];
                    } elseif (!empty($value[3])) {
                        if (strlen($data[$value[0]]) !== $value[3]) {
                            return $this->errormsg = $value[0].':'.$value[2];
                        }
                    }
                    break;
                case 'tel':
                    $reg = '/^1[3587]{1}\d{9}$/';
                    if (preg_match($reg, $data[$value[0]]) === 0) {
                        return $this->errormsg = $value[0].':'.$value[2];
                    } elseif (!empty($value[3])) {
                        if (strlen($data[$value[0]]) !== $value[3]) {
                            return $this->errormsg = $value[0].':'.$value[2];
                        }
                    }
                    break;

                case 'email':
                    $reg = '/^[\da-z._]+@[\da-z._]+$/i';
                    if (preg_match($reg, $data[$value[0]]) === 0) {
                        return    $this->errormsg = $value[0].':'.$value[2];
                    }
                            
                    break;
                case 'url':
                    $reg = '#^http[s]?://[\w./]+$#i';
                    if (preg_match($reg, $data[$value[0]]) === 0) {
                        return    $this->errormsg = $value[0].':'.$value[2];
                    }
                            
                    break;
                case 'ip':
                    $reg = '/^((\d{1,2}|1\d{2}|2[0-4]\d|25[0-5])([.]?)){4}$/';
                    if (preg_match($reg, $data[$value[0]]) === 0) {
                        return    $this->errormsg = $value[0].':'.$value[2];
                    }
                            
                    break;
                case 'min':
                    if (mb_strlen($data[$value[0]], 'utf-8') > $value[3]) {
                        return    $this->errormsg = $value[0].':'.$value[2];
                    }
                            
                    break;
                case 'max':
                    if (mb_strlen($data[$value[0]], 'utf-8') < $value[3]) {
                        return    $this->errormsg = $value[0].':'.$value[2];
                    }
                            
                    break;
                case 'in':
                    $tmparr = explode(',', trim($value[3]));
                    if (!in_array($data[$value[0]], $tmparr)) {
                        return    $this->errormsg = $value[0].':'.$value[2];
                    }
                            
                    break;
                case 'between':
                    $objlen = mb_strlen($data[$value[0]], 'utf-8');
                    $tmparr = explode(',', $value[3]);
                    if (($objlen < $tmparr[0]) || ($objlen > $tmparr[1])) {
                        return    $this->errormsg = $value[0].':'.$value[2];
                    }
                            
                    break;
                default:
                    break;
            }
        }
    }

    /** 读取文件，选择数据库，创建链接
     */
    public function __construct($resource, $table)
    {
        $this->db = $resource;
        return $this->table = $table;
    }

    public function gettable()
    {
        return $this->table;
    }

    public function getAll($field = '*', $where = 1, $group='', $having='', $order='', $limit='')
    {
        return $this->db->getAll($this->table, $field, $where, $group, $having, $order, $limit);
    }

    public function getRow($field, $where)
    {
        return $this->db->getRow($this->table, $field, $where);
    }

    public function getOne($field, $where)
    {
        $res = $this->db->getOne($this->table, $field, $where);
        if (is_bool($res)) {
            return $res;
        }
        return current($res);
    }

    public function delete($where)
    {
        return $this->db->delete($this->table, $where);
    }

    public function update($arr, $where)
    {
        $this->_validata($arr);
        if (!empty($this->getError())) {
            return false;
        }
        return $this->db->update($this->table, $arr, $where);
    }

    public function add($arr)
    {
        $this->_validata($arr);
        if (!empty($this->getError())) {
            return false;
        }
        return $this->db->add($this->table, $arr);
    }

    public function query($sql)
    {
        return $this->db->query($sql);
    }

    public function insertId()
    {
        return $this->db->insertId();
    }

    public function lastSql()
    {
        return $this->db->lastSql;
    }
    public function getError()
    {
        return $this->errormsg;
    }
}
