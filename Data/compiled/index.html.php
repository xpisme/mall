<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>校卖部</title>
    <link href="<?php echo $this->_var['path']; ?>css/index.css" type="text/css" rel="stylesheet">
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
    <p class="lin"></p>
    <div class="content">
        <div class="content-part1">
            <div class="c-part1-inner">
                <div class="c-part1-left">
                    <ul class="c-part1-list"  id="c-part1-list">
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
                <div class="c-part1-right">
                    <?php $_from = $this->_var['images']; if (!is_array($_from) && !is_object($_from)) {
    settype($_from, 'array');
}; $this->push_vars('', 'img'); if (count($_from)):
    foreach ($_from as $this->_var['img']):
?>
                        <a href="index.php?m=home&c=index&a=goods&sn=<?php echo $this->_var['img']['goods_sn']; ?>"><img src="<?php echo $this->_var['img']['thumb_img']['0']; ?>" alt="<?php echo $this->_var['img']['goods_name']; ?>" /></a>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
                <div class="c-part1-main-index">
                    <div id="slider">
                        <ul class="list">
                        <?php  $i=1; ?>
                        <?php $_from = $this->_var['goodsimg']; if (!is_array($_from) && !is_object($_from)) {
    settype($_from, 'array');
}; $this->push_vars('', 'tem'); if (count($_from)):
    foreach ($_from as $this->_var['tem']):
?>
                            <?php  if ($i) {
    ?>
                            <li class="current"><img src="<?php echo $this->_var['tem']['thumb_img']['0']; ?>" alt="<?php echo $this->_var['tem']['goods_name']; ?>" /></li>
                            <?php 
} else {
    ?>
                            <li><img src="<?php echo $this->_var['tem']['thumb_img']['0']; ?>" alt="<?php echo $this->_var['tem']['goods_name']; ?>" /></li>
                            <?php 
} $i=0; ?>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-part2">
            <div class="c-part2-inner">
                <p class="part-title">新单速递<span>.&nbsp;.&nbsp;.</span></p>
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
    <div class="footer"></div>
</div>
<script src="<?php echo $this->_var['path']; ?>js/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
//slider事件
    var slider = document.getElementById('slider');
    var sliderLi = slider.getElementsByTagName('li');
    var timer = pl= null;
    var index = 1;
    function autoPlay(){
        pl= setInterval(function(){
            index >= sliderLi.length && (index = 0);
            show(index);
            index++;
        },4000);
    }
    autoPlay();
    

function show(index){
    var alpha = 0;
    for(var i=0;i<sliderLi.length;i++){
        sliderLi[i].style.opacity = 0;
        sliderLi[i].filter ="alpha(opacity=0)";
    }

    timer = setInterval(function(){
        alpha += 2;
        alpha > 100 && (alpha = 0);
        sliderLi[index].style.opacity = alpha/100;
        sliderLi[index].style.filter = "alpha(opacity="+ alpha+")";
        alpha == 100 && (clearInterval(timer));
    },20);
}
var cList = document.getElementById('c-part1-list').getElementsByTagName('li');
for(var i=0;i<cList.length;i++){
    cList[i].onclick = function(){
        var x = this.innerHTML;
        window.location = '/book_search' + x;
    }
}
</script>
<script src="<?php echo $this->_var['path']; ?>js/index.js"></script>
<script>
  

    // //ajax
    // window.onload = function(){
    //     var xhr;
    //     if (window.XMLHttpRequest) {
    //         xhr = new XMLHttpRequest();
    //     } else {
    //         xhr = new ActiveXObject();
    //     }
    //     xhr.open('get', '/idx_ajx', true);
    //     xhr.send();
    //     xhr.onreadystatechange = function(){
    //         if(xhr.readyState == 4 &&  xhr.status == 200){
    //             var str="";
    //             var resJson = xhr.responseText;
    //             var res = eval("("+resJson+")");
    //             for(var i=0;i<res.length;i++){
    //                str =str+ "<li id='order_show' onclick='order_show('"+res[i]._id+"')'><p id='hide_id' class='hidden'>"+res[i]._id+"</p>"
    //                 +"<img src='images/show1.png' class='c-part2-new-ul-img'>"
    //                 +"<div class='c-part2-new-ul-img-price fr'>￥"+res[i].price
    //                 +"</div><div class='c-part2-detail'><p class='c-part2-detail-goodsName'>"
    //                 +res[i].goodsName+"</p><p class='c-part2-detail-describe'>"+res[i].describe
    //                 +"<p class='c-part2-detail-more'><span>"+res[i].goodsCode
    //                 +"</span>&nbsp;<span>"+res[i].classes
    //                 +"</span>&nbsp;<span>"+res[i].grade
    //                 +"</span></p></p></div></li>"
    //             }
    //             document.getElementById('c-part2-new-ul').innerHTML = str;
    //             var e=event || window.event;

    //             if (e && e.stopPropagation){
    //                 e.stopPropagation();
    //             }
    //             else{
    //                 e.cancelBubble=true;
    //             }
    //             /*var id = document.getElementById('hide_id').innerHTML;
    //             document.getElementById('order_show').onclick = order_show(id);*/
    //         }
    //     };
    // };
</script>
</body>

</html>