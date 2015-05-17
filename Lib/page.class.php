<?php
namespace Lib;

class page{
    protected $total;
    protected $page;
    protected $perpage;

    /**
     * @param $total总条数
     * @param bool $page 当前页
     * @param bool $perpage 每一页显示的条数
     */
    public function __construct($total,$page,$perpage){
        $this->total=$total;
        $this->page=$page;
        $this->perpage=$perpage;
    }

    public function show(){
        $allpages = ceil($this->total/$this->perpage);
        $url='';
        $requri = $_SERVER['REQUEST_URI'];
        if( ($find = stripos($requri,"&page")) !== false ){
            $url =  substr($requri,0,$find)."&page=";
        }else{
            $url = $requri."&page=";
        }

        $pagenav = '';
        $pagenav .='<span>';
        if($this->page != 1)  $pagenav .= '<a href="'.$url.'0">首页</a>&nbsp;&nbsp;';
        for($i=1;$i<=$allpages;$i++){
            if($i == $this->page){
                $pagenav .= '<a style="color:red;" href="'.$url.$i.'">'.$i.'</a>&nbsp;&nbsp;';
            }else{
                $pagenav .= '<a href="'.$url.$i.'">'.$i.'</a>&nbsp;&nbsp;';
            }
        }
        if($this->page != $allpages)  $pagenav .= '<a href="'.$url.$allpages.'">最后一页</a>&nbsp;&nbsp;';
        return $pagenav .= '</span>';

    }

}