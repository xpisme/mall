<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link href="<?php echo $this->_var['path']; ?>css/index.css" rel="stylesheet">
    <script src="<?php echo $this->_var['path']; ?>js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo $this->_var['path']; ?>js/index.js"></script>
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
                    <p>
                        <a href="index.php?m=admin&c=goods&a=add"><input type="button" value="发布商品" class="h-r-input" /></a>
                        <input type="button" value="我的关注" class="h-r-input"/>
                    </p>
                <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="nav">
        <div class="nav-inner">
            <ul class="nav-inner-ul" id="nav-inner-ul">
                <a href="index.php"><li>首页</li></a>
                <?php $_from = $this->_var['catetree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cate');if (count($_from)):
    foreach ($_from AS $this->_var['cate']):
?>
                    <?php if ($this->_var['cate']['level'] == 1): ?>
                        <a href="index.php?m=home&c=index&a=gory&z=<?php echo $this->_var['cate']['url']; ?>"><li><?php echo $this->_var['cate']['cname']; ?></li></a>
                    <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
    </div>
    <div class="content">
        <div class="content-inner">
            <div class="c-goods">
                <div class="c-goods-img">
                    
                    <img src="<?php echo $this->_var['goodsinfo']['thumb_img']; ?>">
                    
                </div>
                <div class="c-part1-right">
                    <?php $_from = $this->_var['others']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'other');if (count($_from)):
    foreach ($_from AS $this->_var['other']):
?>
                        <a href="index.php?m=home&c=index&a=goods&sn=<?php echo $this->_var['other']['goods_sn']; ?>"><img src="<?php echo $this->_var['other']['thumb_img']; ?>" alt="<?php echo $this->_var['other']['goods_name']; ?>"></a>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    
                </div>

                <div class="c-part1-main">
                    
                    <form>
                        <p class="c-goods-username">&nbsp;<?php echo $this->_var['goodsinfo']['name']; ?>&nbsp;<span class="c-goods-username-span">发布</span></p>
                        <p class="c-goods-price">￥<?php echo $this->_var['goodsinfo']['shop_price']; ?><span class="c-goods-price-span">元</span></p>
                        <p class="c-goods-goodsName"><?php echo $this->_var['goodsinfo']['goods_name']; ?></p>
                        <div class="c-goods-describe">
                            <?php echo $this->_var['goodsinfo']['goods_desc']; ?>
                        </div>
                        <p class="c-goods-contact">
                            联系：&nbsp;
                            <span><?php echo $this->_var['goodsinfo']['tel']; ?></span>&nbsp;
                        </p>
                        <input type="button" value="关注一下" class="c-goods-focus fl" onclick="careOrder()">
                    </form>
                    
                </div>

            </div>
        </div>
    </div>
</div>
</body>
</html>