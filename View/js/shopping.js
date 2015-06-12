/**
 * Created by lenovo on 2015/6/8.
 */
$(document).ready(function(){
    //初始各金额计算,及初始全选
    var shopLi = $('.spC-list-ul').children('li');
    for(var i= 0;i<shopLi.length;i++){
        var n = $(shopLi[i]).find('.spcNumber').text();
        var p = $(shopLi[i]).find('.spC-list-subtotal-p').text();
        var price;
        price = parseInt(n)*parseFloat(p);
        $(shopLi[i]).find('.money').text(price);
        $(shopLi[i]).find('input').prop('checked',true);
        $(shopLi[i]).css('background','#eeeeee');
        $('.spC-finally').find('input').prop('checked',true);
    }
    allPrice();
    // check();
    //点击数量减少
    $('.subtract').delegate($(this),'click',function(e){
        var currli = $(this).parents('li');
        var n=$(this).parent().children('.spcNumber').text();
        var p= $(this).parents('li').find('.spC-list-subtotal-p').html();
        var m = $(this).parents('li').find('.money');
        var sn = $(this).parents('li').find('.goodsn').attr('sn');
        var spcNumber = $(this).parent().children('.spcNumber');
        var num,price;
        if(parseInt(n) == 0){
            num=0;
        }else{
            num = parseInt(n)-1;
        }
        $.get('index.php?m=home&c=cart&a=decr',{sn:sn},function (msg){
            if(!msg.status){
                alert(msg.info);
            }else{
                spcNumber.text(num);
                price = parseFloat(p)*num;
                m.text(price);
                if(num == 0) $(currli).remove();
                check();
                allPrice();
            }
        },'json');
        
    });
    //点击数量增加
    $('.add').delegate($(this),'click',function(){
        var n =$(this).parent().children('.spcNumber').text();
        var p= $(this).parents('li').find('.spC-list-subtotal-p').html();
        var m = $(this).parents('li').find('.money');
        var sn = $(this).parents('li').find('.goodsn').attr('sn');
        var spcNumber = $(this).parent().children('.spcNumber');
        var num = parseInt(n)+1;
        $.get('index.php?m=home&c=cart&a=incr',{sn:sn},function (msg){
            if(!msg.status){
                alert(msg.info);
            }else{
                spcNumber.text(num);
                price = parseFloat(p)*num;
                m.text(price);
                allPrice();
            }
        },'json');
    });
    // 删除商品
    $('.doMore-delete').delegate($(this),'click',function(){
        var currli = $(this).parents('li');
        var sn = $(this).parents('li').find('.goodsn').attr('sn');
        var num = 0;
        $.get('index.php?m=home&c=cart&a=delitem',{sn:sn},function (msg){
            if(!msg.status){
                alert(msg.info);
            }else{
                $(currli).remove();
                allPrice();
            }
        },'json');
    });
    //全选
    $('.spC-finally-checkAll').on('click',function(){
        if($(this).attr("checked")){
            $('.spC-list-ul').find('li').css('background','white').find('input').prop('checked',false);
            $(this).removeAttr("checked");
            check();
            allPrice()
        }else{
            $('.spC-list-ul').find('li').css('background','#eeeeee').find('input').prop('checked',true);
            $(this).attr("checked",'true');
            check();
            allPrice()
        }
    });

    shopLi.find('input').on('click',function(){
        check();
        allPrice();
    });
    //总金额计数函数
    function allPrice(){
        var shopLi = $('.spC-list-ul').children('li');
        var Total=0,money =[];
        for(var i=0; i<shopLi.length;i++){
            if($(shopLi[i]).find('input').prop('checked')){
                var m = $(shopLi[i]).find('.money').text();
                money.push(parseFloat(m));
            }
        }
        for(var n=0 ;n<money.length;n++){
            Total += money[n]
        }
        $('.spC-finally .PriceNum').text(Total);
    }
    //判断被选商品的数量
    function check(){
        var shopLi = $('.spC-list-ul').children('li');
        for(var i= 0,n=0;i<shopLi.length;i++){
            if($(shopLi[i]).find('input').prop('checked')){
                $(shopLi[i]).css('background','#eeeeee');
                n++;
            }else{
                $(shopLi[i]).css('background','white');
            }
        }
        if(n == $(shopLi).length){
            $('.spC-finally-checkAll').prop('checked',true);
        }else{
            $('.spC-finally-checkAll').prop('checked',false);
        }
        $('.spC-finally-right-count').text(n);
    }
    // 移动到我的关注
    $(".myfocus").click(function(){
      var sn = $(this).attr('sn');
      var tthis = $(this);
      $.post('index.php?m=home&c=index&a=focus', {sn: sn}, function(msg) {
        if(!msg.status){
          alert(msg.info);
        }else{
          $(tthis).html(msg.info);
        }
      },'json');
    });
    // 页面加载后触发
    $('.spC-finally-checkAll').trigger('click');
    // 删除选中商品
    $("#deledgoods").click(function(event) {
        var goods = $(".spC-list-goods").find('input:checked');
        var delgoods = new Array();
        $(goods).each(function(index, el) {
            delgoods[index] = $(el).attr('sn');
        });
        $.post('index.php?m=home&c=cart&a=delitems', {sn:delgoods}, function(msg) {
            if(!msg.status){
              alert(msg.info);
            }else{
              $(goods).each(function(index, el) {
                    $(el).parents('li').remove();
                    check();
                    allPrice();
                });
            }
        },'json');
    });
});
