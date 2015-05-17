<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8" CONTENT="TEXT/HTML">
    <meta name="viewport" content="width=device-width">
    <title>商品管理</title>
    <link href="<?php echo $this->_var['path']; ?>css/order.css" rel="stylesheet">
</head>
<body>
<div id="box">
    <div class="head">
        <div class="head-inner">
            <div class="h-r-left">
                校卖部
            </div>
            <div class="h-right">
                <p id="personName" class="h-r-userName"><?php echo $this->_var['username']; ?></p>
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
                <li id="addClass">添加分类</li>
                <li>我的关注</li>
            </ul>
        </div>
        <div class="c-right">
            <h1>商品信息表</h1>

            <form id="orderForm" action="" method="post" enctype="multipart/form-data" onsubmit="validata();">
                <p class="c-r-from-p">
                    商品名称：<input type="text" name="goods_name" id="goods_name" required="required" value="<?php echo $this->_var['abc']; ?>">&nbsp;
                    商品数量：<input type="text" name="goods_number" id="goods_number" class="textRight" required="required">&nbsp;
                    商品单价：<input type="text" name="shop_price" id="shop_price" class="textRight"  required="required"><br/>
                </p>
                <p class="c-r-from-p">
                    促销单价：<input type="text" name="activi_price" id="activi_price" class="textRight"  required="required">&nbsp;
                    商品分类：
                    <select class="c-r-select" id="goodsCode" name="catid"  required="required">
                        <?php $_from = $this->_var['catetree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cate');if (count($_from)):
    foreach ($_from AS $this->_var['cate']):
?>
                        <option value="<?php echo $this->_var['cate']['cid']; ?>"><?php echo $this->_var['cate']['pre']; ?><?php echo $this->_var['cate']['cname']; ?></option>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </select>&nbsp;
                </p>
                <p class="c-r-from-p">
                    上传图片：
                    <input id="fulAvatar" name="fileimg" type="file" class="form-control" accept="image/*" required="required"/><br/>
                </p>
                <p class="c-r-from-p">商品描述：</p>
                <textarea class="c-r-txt" name="describe"  required="required"></textarea>
                <span id="warning"></span>
                <input type="submit" value="发布商品" class="btn">
                </p>
            </form>
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
</body>
</html>