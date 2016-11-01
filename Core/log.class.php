<?php 

/**
 * @Author:      xp
 * @DateTime:    2015-04-18 20:05:33
 * @Description: 日志类
 */
namespace Core;

defined('ACC')||exit('ACC Denied');

final class log
{
    const LOGFILE = 'curr.log'; // 文件名称
    public static $newline = "\r\n";     // 换行符
    public static $size = 1048576;     // 1M
    /** 写日志
     *  @access public static
     *  @param string $str
     */
    public static function write($str)
    {
        $str = '['.date('Y-m-d H:i:s', time()).']  '.$str;
        $str .= self::$newline;
        $filename = DATA.'dblog/'.self::LOGFILE;
        if (file_exists($filename) && (filesize($filename) > self::$size)) {
            self::bak($filename);
        }
        $fp = fopen($filename, 'ab'); // 没有该文件会自动创建
        fwrite($fp, $str);
        fclose($fp);
    }
    /**
     * 备份文件
     * *@access public static
     * @param $oldname string
     */
    public static function bak($oldname)
    {
        try {
            try {
                rename($oldname, DATA.'dblog/'.date('Y-m-d H:i:s', time()).'.log');
            } catch (Exception $e) {
                echo '文件重命名失败'.$e->getMessage();
            }
            touch(DATA.'dblog/'.self::LOGFILE);
        } catch (Exception $e) {
            echo '文件创建失败：'.$e->getMessage();
        }
    }
}
