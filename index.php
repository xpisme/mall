<?php 
/**
 * @Author:      xp
 * @DateTime:    2015-04-17 20:07:17
 * @Description: Description
 */

//  设置好路径

defined('ROOT') or define('ROOT', str_replace('\\', '/', dirname(__FILE__)).'/');
defined('CORE') or define('CORE', ROOT.'Core/');
defined('CONF') or define('CONF', ROOT.'Conf/');
defined('CONTROLLER') or define('CONTROLLER', ROOT.'Controller/');
defined('LIB') or define('LIB', ROOT.'Lib/');
defined('MODEL') or define('MODEL', ROOT.'Model/');
defined('VIEW') or define('VIEW', ROOT.'View/');
defined('DATA') or define('DATA', ROOT.'Data/');
defined('LANG') or define('LANG', ROOT.'Lang/');
defined('SITE') or define('SITE', 'http://www.xphp.com');
define('DEBUG', true);
define('ACC',true); // 设置标志

require CONF.'system.php';
require CORE.'App.class.php';

Core\App::run($CONFIG);

