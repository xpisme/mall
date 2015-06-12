/**
* Created by lenovo on 2015/4/4.
*/




function careOrder(){
  var sn = $("#goodsn").val();
  $.post('index.php?m=home&c=index&a=focus', {sn: sn}, function(msg) {
    if(!msg.status){
      alert(msg.info);
    }else{
      $(".c-goods-focus, .fl").val(msg.info);
    }
  },'json');
}