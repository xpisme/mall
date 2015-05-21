
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
                校书包
            </div>
            <div class="h-right">
                <p id="personName" class="h-r-userName"><%= personName %></p>
                <p>
                    <a href="index.php?m=Admin&c=goods&a=list"><input type="button" value="发布商品" class="h-r-input"/></a>
                    <input type="button" value="我的关注" class="h-r-input"/>
                </p>
            </div>
        </div>
    </div>
    <p class="lin"></p>
    <div class="content">
        <div class="content-part1">
            <div class="c-part1-inner">
                <div class="c-part1-left">
                    <ul class="c-part1-list">
                        
                        <li onclick="book_search('书籍')">图书</li>
                        <li onclick="book_search('女装')">女装</li>
                        <li onclick="book_search('男装')">男装</li>
                        <li onclick="book_search('鞋')">男/女鞋</li>
                        <li onclick="book_search('配饰礼物')">配饰/礼物</li>
                        <li onclick="book_search('学习用品')">学习用品</li>
                        <li onclick="book_search('生活用品')">生活用品</li>
                        <li onclick="book_search('运动娱乐')">运动/娱乐</li>
                    </ul>
                </div>
                <div class="c-part1-right">
                    <img src="<?php echo $this->_var['path']; ?>images/paart1-1.jpg">
                    <img src="<?php echo $this->_var['path']; ?>images/paart1-7.jpg" class="fr">
                    <img src="<?php echo $this->_var['path']; ?>images/paart1-2.jpg">
                    <img src="<?php echo $this->_var['path']; ?>images/paart1-6.jpg" class="fr">
                    <img src="<?php echo $this->_var['path']; ?>images/paart1-5.jpg">
                    <img src="<?php echo $this->_var['path']; ?>images/paart1-4.jpg" class="fr">
                </div>
                <div class="c-part1-main"></div>
            </div>
        </div>
        <div class="content-part2">
            <div class="c-part2-inner">
                <p class="part-title">新单速递<span>.&nbsp;.&nbsp;.</span></p>
                <div class="c-part2-new">
                    <ul class="c-part2-new-ul" id="c-part2-new-ul">
                        <% rows.forEach(function(row){%>
                            <li onclick="order_show('<%= row.id%>')">
                                <img src="<?php echo $this->_var['path']; ?>images/show1.png" class="c-part2-new-ul-img">
                                <div class="c-part2-new-ul-img-price fr">￥<%= row.price%></div>
                                <div class="c-part2-detail">
                                    <p class="c-part2-detail-goodsName"><%= row.goodsName%></p>
                                    <p class="c-part2-detail-describe">
                                        <%= row.describe%>
                                    </p>
                                </div>
                            </li>
                        <%})%>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer"></div>
</div>
<script src="<?php echo $this->_var['path']; ?>js/index.js"></script>
<script>
    //ajax
    /*window.onload = function(){
     var xhr;
     if (window.XMLHttpRequest) {
     xhr = new XMLHttpRequest();
     } else {
     xhr = new ActiveXObject();
     }
     xhr.open('get', '', true);
     xhr.send();
     xhr.onreadystatechange = function(){
     if(xhr.readyState == 4 &&  xhr.status == 200){
     var str="";
     var resJson = xhr.responseText;
     var res = eval("("+resJson+")");
     for(var i=0;i<res.length;i++){
     str =str+ "<li id='order_show' onclick='order_show('"+res[i]._id+"')'><p id='hide_id' class='hidden'>"+res[i]._id+"</p>"
     +"<img src='images/show1.png' class='c-part2-new-ul-img'>"
     +"<div class='c-part2-new-ul-img-price fr'>￥"+res[i].price
     +"</div><div class='c-part2-detail'><p class='c-part2-detail-goodsName'>"
     +res[i].goodsName+"</p><p class='c-part2-detail-describe'>"+res[i].describe
     +"<p class='c-part2-detail-more'><span>"+res[i].goodsCode
     +"</span>&nbsp;<span>"+res[i].classes
     +"</span>&nbsp;<span>"+res[i].grade
     +"</span></p></p></div></li>"
     }
     document.getElementById('c-part2-new-ul').innerHTML = str;
     var e=event || window.event;
     if (e && e.stopPropagation){
     e.stopPropagation();
     }
     else{
     e.cancelBubble=true;
     }
     *//*var id = document.getElementById('hide_id').innerHTML;
     document.getElementById('order_show').onclick = order_show(id);*//*
     }
     };
     };*/
</script>
</body>

</html>