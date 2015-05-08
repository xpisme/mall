/**
 * Created by lenovo on 2015/4/6.
 */
function order_onlode(){
    // document.getElementById('date').value =new Date().toJSON().slice(0,10);
}
//发布商品
function Add(){
    var goodsName = document.getElementById('goodsName').value;
    var num = document.getElementById('num').value;
    var price = document.getElementById('price').value;
    var grade = document.getElementById('grade').value;
    var tel = document.getElementById('tel').value;
    var email = document.getElementById('email').value;
    var date = document.getElementById('date').value;
    var goodsCode = document.getElementById('goodsCode').value;
    var classes = document.getElementById('classes').value;
    if(goodsName =="" || num=="" || price=="" || grade=="" || tel=="" || goodsCode=="" || classes=="" ||date=="" || email==""){
        document.getElementById('warning').innerHTML ="请填入完整信息，不要遗漏";
        if(event && event.preventDefault()){
            event.preventDefault();
        }else{
            window.event.returnValue = false;
        }
    }

}
//添加分类

var exit = document.getElementById('exit');
var addClass =document.getElementById('addClass');
var hidLayer = document.getElementsByClassName('hidLayer')[0];
var reset = document.getElementsByClassName('reset')[0];
var submit = document.getElementsByClassName('submit')[0];
var layerInput = document.getElementsByClassName('layerInput')[0];
var layerSelect = document.getElementsByClassName('layerSelect')[0];
var layerTextarea = document.getElementsByClassName('layerTextarea')[0];
var errMsg  = document.getElementsByClassName('errMsg')[0];
addClass.onclick = function(){
    hidLayer.style.display = "block";
};
exit.onclick = function(){
    empt();
    hidLayer.style.display = "none";
};
reset.onclick = function(){
    empt();
};
function empt(){
    layerInput.value = "";
    layerSelect.value = "";
    layerTextarea.value = "";
    errMsg.innerHTML = "";
}

/*correct  */
function correct(){
    var goodsName = document.getElementById('goodsName').value;
    var num = document.getElementById('num').value;
    var price = document.getElementById('price').value;
    var grade = document.getElementById('grade').value;
    var tel = document.getElementById('tel').value;
    var email = document.getElementById('email').value;
    var date = document.getElementById('date').value;
    var goodsCode = document.getElementById('goodsCode').value;
    var classes = document.getElementById('classes').value;
    if(goodsName =="" || num=="" || price=="" || grade=="" || tel=="" || goodsCode=="" || classes=="" ||date=="" || email==""){
        document.getElementById('warning').innerHTML ="请填入完整信息，不要遗漏";
        if(event && event.preventDefault()){
            event.preventDefault();
        }else{
            window.event.returnValue = false;
        }
    }

}

function correct_back(){
    var onName = document.getElementById('onName').value;
    document.getElementById('id').value = "";
    document.getElementById('goodsName').value = "";
    document.getElementById('num').value = "";
    document.getElementById('price').value = "";
    document.getElementById('grade').value = "";
    document.getElementById('tel').value = "";
    document.getElementById('email').value = "";
    document.getElementById('date').value = "";
    document.getElementById('goodsCode').value = "";
    document.getElementById('classes').value = "";
    window.location = '/back' + onName;
    document.getElementById('onName').value = "";
}