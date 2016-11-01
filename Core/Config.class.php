<?php 

/**
 * @Author:      xp
 * @DateTime:    2015-05-01 17:57:27
 * @Description: 配置文件读取类
 */

namespace Core;

defined('ACC') or exit('ACC Denied');

class Config implements \ArrayAccess
{
    protected static $configs = array();

    public function offsetSet($key, $value)
    {
        throw new \Exception("Can not write config file", 1);
    }

    public function offsetUnset($key)
    {
    }

    public function offsetGet($key)
    {
        if (empty(self::$configs[$key])) {
            $config = require CONF . $key . '.php';
            self::$configs[$key] = $config;
        }
        return self::$configs[$key];
    }

    public function offsetExists($key)
    {
        return isset(self::$configs[$key]);
    }
}
