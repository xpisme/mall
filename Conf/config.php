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
    'db_name' => 'mall',
    'db_char' => 'utf8',
    'db_type' => 'mysqli', // mysql mysqli pdo
    'db_prefix'=> 'm_', // 数据表前缀
);

$CONFIG['lang'] = 'zh_cn';
$CONFIG['default_view_group'] = 'home';
$CONFIG['view_groups'] = 'home,admin';
$CONFIG['upload_max_size'] = 1048576;// 1M
$CONFIG['image_type'] = 'image/png,image/jpg,image/jpeg,image/gif';

return $CONFIG;
