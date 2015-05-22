<?php 

/**
 * @Author:      xp
 * @DateTime:    2015-04-18 09:00:56
 * @Description: 控制器基类
 */
namespace Controller;
use Core;
defined('ACC')||exit('ACC Denied');

class Controller{
    protected $view;

    public function  __construct(){
        $this->view = Core\mytpl::getins();
        $this->assign("path",FRONT);
        // 加载全局的信息变量
        $cate = M('cate');
        $category =$cate->getAll('cid,cname,pid,childlist,pidlist,level');
        $catetree = catetree($category);
        $username = empty($_SESSION['username']) ? '' : $_SESSION['username'];
        $exshop = 0;
        if(!empty($username)){
            $exshop = M()->query('select count(*) as sum from m_shop s left join m_customer c on s.uid=c.uid where c.uname='."'$username'");
            $exshop = current($exshop)['sum'];
        }
        $this->assign('exshop',$exshop);
        $this->assign('username',$username);
        $this->assign('catetree',$catetree);
    }

	public function display($file){
        $file = $file.'.html';
		$this->view->display($file);
	}
    public  function assign($var,$value=''){
        $this->view->assign($var,$value);
    }
	/*
	*展示信息
	*/
	public function showMessage($mes){
        $this->assign('msg',$mes);
        exit ($this->display('err'));
	}
	/*
	* 默认
	*/
	public function index(){
		$this->display('index');
	}

    /**返回客户端
     * @param $data 数据
     * @param string $info 信息
     * @param int $status 状态 0为失败，1为成功
     * @param string $type 类型
     */
    protected function ajaxReturn($data,$info='',$status=1,$type='json') {
        $result  =  array();
        $result['status']  =  $status;
        $result['info'] =  $info;
        $result['data'] = $data;
        if(strtolower($type)=='json') {
            header('Content-Type:text/html; charset=utf-8');
            exit(json_encode($result));
        }elseif(strtolower($type)=='xml'){
            header('Content-Type:text/xml; charset=utf-8');
            exit(xml_encode($result));
        }elseif(strtolower($type)=='html'){
            header('Content-Type:text/html; charset=utf-8');
            exit($data);
        }else{
            // .........
        }
    }
}


