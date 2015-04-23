/**
 * Created by lenovo on 2015/4/6.
 */
function order_onlode(){
    document.getElementById('date').value =new Date().toJSON().slice(0,10);
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
//搜索
function order_search(){
    var personName = document.getElementById('personName').innerText;
    window.location = "/person_search"+personName;
}
//返回首页
function rt_index(){
    var personName = document.getElementById('personName').innerText;
    window.location = "/rt_index" + personName;
}

/*order_search  */

function order_index(){
    var personName = document.getElementById('personName').innerHTML;
    window.location = "/order"+personName;
}

function order_correct(id){
    window.location ="/correct"+id;
}

function order_delete(id){
    window.location ="/delete"+id
}

/*correct  */
function correct_onlode(){
    document.getElementById('date').value =new Date().toJSON().slice(0,10);
}
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