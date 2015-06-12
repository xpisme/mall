/**
 * Created by lenovo on 2015/6/9.
 */
$(document).ready(function(){
    $('.add-address').click(function(){
        $('.layer-box').fadeIn(200);
    });
    $('.layer-close').click(function(){
        $('.layer-box').fadeOut(200);
    });


    var userList = $('.userList');
    for(var j=0;j<userList.length;j++){
        $(userList[j]).on('click',function(){
            userList.css('background','white').find('.userName').css({'color':'#01a57f','border':'1px solid #01a57f'});
            $(this).css('background','#e8edf1').find('.userName').css({'color':' #ef735f','border':'1px solid  #ef735f'});
        })
    }


    var weySpan = $('.wey-inner > span');
    for(var i= 0;i<weySpan.length;i++){
        $(weySpan[i]).on('click',function(){
            weySpan.css({'color':'#01a57f','border':'1px solid #01a57f','background':'white'});
            $(this).css({'color':' #ef735f','border':'1px solid  #ef735f','background':'#e8edf1'});
        });
    }

    // ajax 保存 收货人地址
    $("#firstsubmit").click(function(event) {
        var name = $("#gname").val();
        var provice = $("#provice").val();
        var city = $("#city").val();
        var country = $("#country").val();
        var address = $("#user-address").val();
        var phone = $("#user-phone").val();
        if (name == '' || provice == '' || city == '' || address == '' || phone == '' ){
            return false;
        }
        $.post('index.php?m=home&c=cart&a=address', {name:name,provice:provice,city:city,country:country,address:address,phone:phone}, function(msg) {
            console.log(msg);
        },'json');
    });
});