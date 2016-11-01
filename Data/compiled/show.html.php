<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>校卖部</title>
    <link href="<?php echo $this->_var['path']; ?>css/index.css" rel="stylesheet">
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
                <?php elseif ($this->_var['exshop'] == 0): ?>
                    欢迎 <?php echo $this->_var['username']; ?><a href="index.php?m=home&c=user&a=logout"><span class="exit fr">退出登录</span></a>
                    <p>
                        <a href="index.php?m=home&c=shop&a=add"><input type="button" value="开店" class="h-r-input" /></a>
                        <input type="button" value="我的关注" class="h-r-input"/>
                    </p>
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
            <ul class="nav-inner-ul">
                <a href="index.php"><li>首页</li></a>
                <?php $_from = $this->_var['catetree']; if (!is_array($_from) && !is_object($_from)) {
    settype($_from, 'array');
}; $this->push_vars('', 'cate'); if (count($_from)):
    foreach ($_from as $this->_var['cate']):
?>
                    <?php if ($this->_var['cate']['level'] == 1): ?>
                        <a href="index.php?m=home&c=index&a=gory&z=<?php echo $this->_var['cate']['url']; ?>"><li><?php echo $this->_var['cate']['cname']; ?></li></a>
                    <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
    </div>
    <div class="filter-box">
        <div class="filter">
            <div class="filter-path">
                <a href="index.php?m=home&c=index&a=gory&z=<?php echo md5(rand()).'bxve'?>0" class="filter-path-a" style="margin-left: 40px;">全部</a>
                <?php $_from = $this->_var['crumbs']; if (!is_array($_from) && !is_object($_from)) {
    settype($_from, 'array');
}; $this->push_vars('', 'mb'); if (count($_from)):
    foreach ($_from as $this->_var['mb']):
?>
                <span> > </span>
                <a href="index.php?m=home&c=index&a=gory&z=<?php echo md5(rand()).'bxve'?><?php echo $this->_var['mb']['cid']; ?>" class="filter-path-a"><?php echo $this->_var['mb']['cname']; ?></a>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <div class="filter-content">
                <div class="filter-c-class">
                    <div class="filter-c-class-title fl">
                        分类 :
                    </div>
                    <div class="filter-c-class-list fr" id="filter-c-class-list" style="border-bottom: 1px solid lightgray">
                        <?php $_from = $this->_var['childs']; if (!is_array($_from) && !is_object($_from)) {
    settype($_from, 'array');
}; $this->push_vars('', 'child'); if (count($_from)):
    foreach ($_from as $this->_var['child']):
?>
                        <a href="index.php?m=home&c=index&a=gory&z=<?php echo md5(rand()).'bxve'?><?php echo $this->_var['child']['cid']; ?>" class="filter-c-class-a"><span><?php echo $this->_var['child']['cname']; ?></span></a>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        <!-- <span class="filter-c-class-a showMore">更多...</span> -->
                    </div>
                </div>
                <div class="filter-c-price">
                    <div class="filter-c-class-title fl">
                        价格 ：
                    </div>
                    <div class="filter-c-class-list fr">
                        <a href="index.php?m=home&c=index&a=gory&z=<?php echo md5(rand()).'bxve'?><?php echo $this->_var['cid']; ?>" class="filter-c-class-a"><span>全部</span></a>
                        <a href="index.php?m=home&c=index&a=gory&z=<?php echo md5(rand()).'bxve'?><?php echo $this->_var['cid']; ?>&price=0,50" class="filter-c-class-a"><span>0 - 50</span></a>
                        <a href="index.php?m=home&c=index&a=gory&z=<?php echo md5(rand()).'bxve'?><?php echo $this->_var['cid']; ?>&price=50,100" class="filter-c-class-a"><span>50 - 100</span></a>
                        <a href="index.php?m=home&c=index&a=gory&z=<?php echo md5(rand()).'bxve'?><?php echo $this->_var['cid']; ?>&price=100,500" class="filter-c-class-a"><span>100 - 500</span></a>
                        <a href="index.php?m=home&c=index&a=gory&z=<?php echo md5(rand()).'bxve'?><?php echo $this->_var['cid']; ?>&price=500,1000" class="filter-c-class-a"><span>500 - 1000</span></a>
                        <a href="index.php?m=home&c=index&a=gory&z=<?php echo md5(rand()).'bxve'?><?php echo $this->_var['cid']; ?>&price=1000,*" class="filter-c-class-a"><span>1000元以上</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="content-inner">
            <div class="content-part2">
                <div class="c-part2-inner">
                    <div class="c-part2-new">
                        <ul class="c-part2-new-ul" id="c-part2-new-ul">
                            <?php $_from = $this->_var['goods']; if (!is_array($_from) && !is_object($_from)) {
    settype($_from, 'array');
}; $this->push_vars('', 'good'); if (count($_from)):
    foreach ($_from as $this->_var['good']):
?>
                             <li>
                                <a href="index.php?m=home&c=index&a=goods&sn=<?php echo $this->_var['good']['goods_sn']; ?>"><img src="<?php echo $this->_var['good']['thumb_img']['0']; ?>" class="c-part2-new-ul-img"></a>
                                <div class="c-part2-new-ul-img-price fr">￥<?php echo $this->_var['good']['shop_price']; ?></div>
                                <div class="c-part2-detail">
                                    <p class="c-part2-detail-goodsName"><?php echo $this->_var['good']['goods_name']; ?></p>
                                    <p class="c-part2-detail-describe">
                                        <?php echo $this->_var['good']['goods_desc']; ?>
                                    </p>
                                </div>
                             </li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $this->_var['path']; ?>js/jquery-1.11.3.min.js"></script>
<script src="<?php echo $this->_var['path']; ?>js/index.js"></script>
<script>
    $(function(){
        var element = $('#filter-c-class-list>a:gt(8)');
        element.hide();
        $('.showMore').click(function(){
            if(element.is(":visible")){
                element.hide(100);
                $('.showMore').text('更多...');
                $('.filter-c-class').height('70px');
            }else{
                element.show(100);
                $('.showMore').text('收 起');
                $('.filter-c-class').height('120px');
            }
        });
    });

</script>
</body>
</html>