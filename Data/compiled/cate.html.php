<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8" CONTENT="TEXT/HTML">
    <title>分类管理</title>
    <link rel="stylesheet" href="<?php echo $this->_var['path']; ?>css/order.css">
</head>
<body>
<div id="box">
    <div class="head">
        <div class="head-inner">
            <div class="h-r-left">
                校卖部
            </div>
            <div class="h-right">
                <p id="personName" class="h-r-userName">
                <?php if ($this->_var['username'] == ''): ?>
                <a href="index.php?m=home&c=user&a=signin">登录</a>|<a href="index.php?m=home&c=user&a=signup">注册</a>
                <?php else: ?>
                    欢迎 <?php echo $this->_var['username']; ?><a href="index.php?m=home&c=user&a=logout"><span class="exit fr">退出登录</span></a>
                <?php endif; ?>
                </p>
                <p><a href="index.php?m=admin&c=goods&a=add"><input type="button" value="发布商品" class="h-r-input" /></a>
                    <input type="button" value="我的关注" class="h-r-input"/>
                </p>
            </div>
        </div>
    </div>
    <p class="lin"></p>
    <div class="content">
        <div class="c-left">
            <ul class="c-l-ul">
                <a href="index.php"><li>首&nbsp;页</li></a>
                <a href="index.php?m=admin&c=goods&a=lists"><li>在线商品</li></a>
                <a href="index.php?m=admin&c=goods&a=add"><li>发布商品</li></a>
                <a href="index.php?m=admin&c=cate&a=lists"><li>分类列表</li></a>
                <li>我的关注</li>
            </ul>
        </div>
        <div class="c-right">
            <h1 class="c-r-h1">分类列表</h1>
            <table class="c-r-clsList-table" id="c-r-tb">
                <tr>
                    <th class="c-r-clsList-table-th">序号</th>
                    <th class="c-r-clsList-table-th" style="width: 500px;">分类名称</th>
                    <th class="c-r-clsList-table-th">添加</th>
                    <th class="c-r-clsList-table-th">修改</th>
                    <th class="c-r-clsList-table-th">删除</th>
                </tr>
                <?php $_from = $this->_var['catetree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cate');if (count($_from)):
    foreach ($_from AS $this->_var['cate']):
?>
                <tr>
                    <td><?php echo $this->_var['cate']['cid']; ?></td>
                    <td style="width: 500px;text-align: left;"><?php echo $this->_var['cate']['pre']; ?><?php echo $this->_var['cate']['cname']; ?></td>
                    <td class="edit addClass" style="width: 85px;">添加子菜单</td>
                    <td class="edit addClass" cid="<?php echo $this->_var['cate']['cid']; ?>">修改</td>
                    <td class="edit delClass" cid="<?php echo $this->_var['cate']['cid']; ?>">删除</td>
                </tr>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </table>
        </div>
    </div>
    <div class="hidLayer">
        <div class="layer">
            <div class="layer-inner">
                <form action="" id="categorylist" method="post" onsubmit="return false;">
                    <p>分类名称：<input type="text" id="layerInput" class="layerInput" name="className" ></p>
                    <p class="layer-inner-Pselect">
                        上级分类：
                        <select class="layerSelect" id="layerSelect" name="selectName">
                            <option value="0">顶级分类</option>
                            <?php $_from = $this->_var['catetree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cate');if (count($_from)):
    foreach ($_from AS $this->_var['cate']):
?>
                            <option value="<?php echo $this->_var['cate']['cid']; ?>"><?php echo $this->_var['cate']['pre']; ?><?php echo $this->_var['cate']['cname']; ?></option>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </select>
                    </p>
                    <p class="layerTextp">
                        <span class="layerTextspan">分类描述：</span><br/>
                        <textarea class="layerTextarea" id="layerTextarea" name="" ></textarea>
                    </p>
                    <p class="layerBtn">
                        <input type="button" id="exit" class="fr layerBtn-input" value="退出">
                        <input type="reset" class="fr layerBtn-input reset" value="重置">
                        <input type="submit" id="dosubmit" class="fr layerBtn-input submit" value="确定">
                        <span class="errMsg fr"></span>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $this->_var['path']; ?>js/jquery-1.11.3.min.js"></script>
<script src="<?php echo $this->_var['path']; ?>js/order.js"></script>
<script>    
window.onload=loading;
    //隔行变色
    function loading (argument) {
        var tabbg=document.getElementById('c-r-tb');
        for(var i=0;i<tabbg.rows.length;i++){
            if(tabbg.rows[i].rowIndex%2==0) {
                tabbg.rows[i].style.backgroundColor = "#e8edf1"
            }else{
                tabbg.rows[i].style.backgroundColor = ""
            }
        }
    }
</script>
</body>
</html>