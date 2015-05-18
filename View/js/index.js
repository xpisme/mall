/**
 * Created by lenovo on 2015/4/4.
 */

  $(window).scroll(function(){
    　　var scrollTop = $(this).scrollTop();
    　　var scrollHeight = $(document).height();
    　　var windowHeight = $(this).height();
    　　if(scrollTop + windowHeight == scrollHeight){
    　　　var len = $("#c-part2-new-ul li").length;
          $.post('index.php?m=home&c=index&a=getgoods', {len:len}, function(res) {
                if(!res.status){
                   alert(res.info);
                }else{
                    var data = res.data.res;
                    for (var i = data.length - 1; i >= 0; i--) {
                        var str = '<li> <img src="'+data[i].thumb_img+'" class="c-part2-new-ul-img"> <div class="c-part2-new-ul-img-price fr">￥'+data[i].shop_price+'</div> <div class="c-part2-detail"> <p class="c-part2-detail-goodsName">'+data[i].goods_name+'</p> <p class="c-part2-detail-describe"> '+data[i].goods_desc+' </p> </div> </li>';
                        $(str).appendTo('#c-part2-new-ul');
                    }
                }
          },'json');
    　　}
    });