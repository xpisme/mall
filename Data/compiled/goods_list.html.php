<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8" CONTENT="TEXT/HTML">
    <title>订单查询页</title>
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
            <h1 class="c-r-h1">商品信息</h1>
            <table id="c-r-tb">
                <tr class="c-r-table">
                    <th class="c-r-td-addLength">商品名称</th>
                    <th>数量</th>
                    <th>单价</th>
                    <th>促销价格</th>
                    <th>浏览</th>
                    <th class="c-r-td-addLength">出售商家</th>
                    <th class="c-r-td-addLength">发布时间</th>
                    <th>修改</th>
                    <th>删除</th>
                </tr>
                <?php $_from = $this->_var['lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                <tr>
                    <td class="c-r-td-addLength" title="<?php echo $this->_var['list']['goods_name']; ?>"><?php echo $this->_var['list']['gname']; ?></td>
                    <td><?php echo $this->_var['list']['goods_number']; ?></td>
                    <td><?php echo $this->_var['list']['shop_price']; ?>元</td>
                    <td><?php echo $this->_var['list']['activi_price']; ?>元</td>
                    <td><?php echo $this->_var['list']['click_count']; ?></td>
                    <td class="c-r-td-addLength"><?php echo $this->_var['list']['name']; ?></td>
                    <td class="c-r-td-addLength"><?php echo $this->_var['list']['addtime']; ?></td>
                    <td class="edit"><a href="index.php?m=admin&c=goods&a=edit&gid=<?php echo $this->_var['list']['gid']; ?>">修改</a></td>
                    <td class="edit"><a href="index.php?m=admin&c=goods&a=dele&gid=<?php echo $this->_var['list']['gid']; ?>">删除</a></td>
                </tr>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </table>
            <p><?php echo $this->_var['pagenav']; ?></p>
        </div>
    </div>
    <div class="hidLayer">
        <div class="layer">
            <div class="layer-inner">
                <form action="afs" method="post" onsubmit="return false;">
                    <p>分类名称：<input type="text" class="layerInput" name="className" ></p>
                    <p class="layer-inner-Pselect">
                        上级分类：
                        <select class="layerSelect" id="layerSelect" name="selectName">
                            <option value="0">顶级分类</option>
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
                        <textarea class="layerTextarea" name="" ></textarea>
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
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="<?php echo $this->_var['path']; ?>js/order.js"></script>
<script>
    //隔行变色
    var tabbg=document.getElementById('c-r-tb');
    for(var i=1;i<tabbg.rows.length;i++){
        if(tabbg.rows[i].rowIndex%2==0) {
            tabbg.rows[i].style.backgroundColor = "#e8edf1"
        }else{
            tabbg.rows[i].style.backgroundColor = ""
        }
    }
</script>
</body>
</html>
