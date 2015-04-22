<?php 

/**
 * @Author:      xp
 * @DateTime:    2015-04-18 10:06:44
 * @Description: 系统配置文件
 */

/*数据库配置*/
namespace Conf;
defined('ACC')||exit('ACC Denied');

$CONFIG['db'] = array(
	'db_host' => 'localhost',
	'db_user' => 'root',
	'db_pass' => '',
	'db_name' => 'test',
	'db_char' => 'utf8',
	'db_type' => 'pdo' // mysql mysqli pdo
);

$CONFIG['lang'] = 'zh_cn';

 ?>