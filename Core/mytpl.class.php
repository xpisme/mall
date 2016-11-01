<?php
namespace Core;

use Lib;

class mytpl extends Lib\template
{
    public static $ins;
    protected function __construct()
    {
        parent::__construct();
        $config = C('config');
        $this->template_dir = VIEW.$config['default_view_group'].'';
        $this->compile_dir = DATA . 'compiled';
        if (DEBUG) {
            $this->caching = false;
            $this->force_compile = true;
        } else {
            $this->caching = true;
            $this->force_compile = false;
        }
    }
    public static function getins()
    {
        if (self::$ins instanceof self) {
            return self::$ins;
        }
        self::$ins = new self();
        return self::$ins;
    }
}
