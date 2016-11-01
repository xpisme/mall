<?php 
/**
 * @Author:      xp
 * @DateTime:    2015-04-18 11:53:34
 * @Description: Mysql 类
 */
namespace Core\db;

use Core;

defined('ACC')||exit('ACC Denied');

class mysqldb extends DB
{
    /**
     * 链接数据库
     * @access public
     * @return resource
     */
    public function connect()
    {
        $this->link = mysql_connect($this->db_config['db_host'], $this->db_config['db_user'], $this->db_config['db_pass']) or die('链接失败');
        if (!$this->query("set names ".$this->db_config['db_char']) || !$this->query("use ".$this->db_config['db_name'])) {
            exit('编码或数据库设置失败');
        }
    }

    /**
     * 获得所有数据
     * @access public
     * @return array
     */
    public function getAll($table, $field = '*', $where = 1, $group='', $having='', $order='', $limit='')
    {
        $table = $this->jointable($table);
        $sql = 'select ';
        $where = $where == 1 ? '' : ' where '.$where;
        $group = $group == '' ? '' : ' group by '.$group ;
        $having = $having == '' ? '' : ' having '.$having;
        $order = $order == '' ? '' : ' order by '.$order ;
        $limit = $limit == '' ? '' : ' limit '.$limit;
        $sql = $sql . $field . ' from '.$table.$where.$group.$having.$order.$limit;
        return $this->query($sql);
    }

    /**
     * 获得一行数据
     * @access public
     * @param where str
     * @return array
     */
    public function getRow($table, $filed='*', $where)
    {
        $table = $this->jointable($table);
        $sql = "select ".$filed." from ".$table." where ".$where." limit 1";
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
    public function getOne($table, $field, $where)
    {
        $table = $this->jointable($table);
        $sql = "select ".$field." from ".$table." where ".$where;
        $res = $this->query($sql);
        return empty($res) ? false : $res[0] ;
    }

    /**
     * 删除数据
     * @access public
     * @param where  str
     * @return bool
     */
    public function delete($table, $where)
    {
        $table = $this->jointable($table);
        $sql = 'delete from '.$table.' where '.$where;
        return $this->query($sql);
    }

    /**
     * 更新数据
     * @access public
     * @param where  str
     * @param arr  array
     * @return bool
     */
    public function update($table, $arr, $where)
    {
        $table = $this->jointable($table);
        if (empty($where)) {
            exit();
        }
        $sql = "update ".$table." set ";
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
    public function add($table, $arr)
    {
        $table = $this->jointable($table);
        $sql = '';
        $sql .= 'insert into '.$table.' ';
        foreach ($arr as $key => $value) {
            $values[]=$this->parseValue($value);
        }
        $sql .= '('. implode(',', array_keys($arr)).') values (' .implode(',', $values).')';
        $this->query($sql);

        return $this->insertid = mysql_insert_id();
    }

    /**
     * 执行sql语句
     * @access public
     * @param  sql str
     * @return array
     */
    public function query($sql)
    {
        sqllog($sql);
        $this->lastSql = $sql;
        if ($res = mysql_query($sql, $this->link)) {
            if (is_bool($res)) {
                return true;
            } elseif (is_resource($res)) {
                return $this->fetch($res);
            }
        } else {
            Core\log::write($sql);
            return false;
        }
    }

    

    /**
     * 获得最新插入的id
     * @access public
     * @return int
     */
    public function insertId()
    {
        return $this->insertid;
    }
    
    /**
     * 获得最后的sql语句
     * @access public
     * @return int
     */
    public function lastSql()
    {
        return $this->lastSql;
    }

    /**
     * 根据资源得出数组
     * @access public
     * @param resource
     * @return int
     */
    public function fetch($res)
    {
        $arr = array();
        while ($row = mysql_fetch_assoc($res)) {
            $arr[]=$row;
        }
        return $arr;
    }
}
