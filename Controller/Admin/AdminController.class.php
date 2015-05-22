<?php 

/**
 * @Author:      xp
 * @DateTime:    2015-05-22 11:24:03
 * @Description: Description
 */
namespace Controller\Admin;
use Controller;

class AdminController extends Controller\Controller{
    public function __construct(){
        parent::__construct();
        if(empty($_SESSION['username'])) header('location:'.SITE);
        $username = $_SESSION["username"];
        $exshop = M()->query('select count(*) as sum from m_shop s left join m_customer c on s.uid=c.uid where c.uname='."'$username'");
        $sum = current($exshop)['sum'];
        if($sum == 0) header('location:'.SITE);
    }
}

