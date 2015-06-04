/**
 * Created by lenovo on 2015/4/6.
 */

// common function
function str_repeat(str,num){
    return new Array(num+1).join(str);
}

function is_num(str){
    var re = /^(\d+)$|^(\d+[.]?\d{0,2})$/;//匹配是否为数字或小数
    return str.match(re);
}

//验证 商品 
$("#goods_number,#shop_price,#activi_price").keyup(function(){
    if(!is_num($(this).val())) $(this).val('');
});
function validata(){
    var goods_name,goods_number,shop_price,activi_price ,goodsCode ,fulAvatar;
    goods_name = $("#goods_name").val();
    goods_number = $("#goods_number").val();
    shop_price = $("#shop_price").val();
    activi_price = $("#activi_price").val();
    fulAvatar = $("#fulAvatar").val();
    if (goods_name == '' || goods_number == '' || shop_price == '' || activi_price == '' || fulAvatar == '') {
        $("#warning").val("信息请输入完整");
        return false;
    }
}
//添加分类

var exit = document.getElementById('exit');
var addClass =$(".addClass");
var hidLayer = document.getElementsByClassName('hidLayer')[0];
var reset = document.getElementsByClassName('reset')[0];
var submit = document.getElementsByClassName('submit')[0];
var layerInput = document.getElementsByClassName('layerInput')[0];
var layerSelect = document.getElementsByClassName('layerSelect')[0];
var layerTextarea = document.getElementsByClassName('layerTextarea')[0];
var errMsg  = document.getElementsByClassName('errMsg')[0];

$("#c-r-tb").on('click',".addClass",function(){
    var id = $(this).parent().children().first().html();
    var attr = $(this).attr("cid");
    if(attr !== undefined){
        $.post('index.php?m=admin&c=cate&a=getinfo', {id: id}, function(res) {
               if(!res.status){
                   alert(res.info);
               }else{
                    $("#layerSelect").val(res.data.res.pid);
                    $("#layerInput").val(res.data.res.cname);
                    $("#layerTextarea").val(res.data.res.info);
                    $('<input type="hidden" name="cateid" value="'+id+'" />').prependTo("#categorylist");
                    $("input[type=submit]").val("修改");
                    $("input[type=submit]").attr('id', 'doeditsubmit');
               }
        },'json');
    }else{
        $("#layerSelect").val(id);        
    }

    hidLayer.style.display = "block";
});
exit.onclick = function(){
    empt();
    hidLayer.style.display = "none";
    $("input[type=submit]").attr('id', 'dosubmit');
    $("input[type=submit]").val("确认");
    $("input[type=hidden]").remove();
};
reset.onclick = function(){
    empt();
};
function empt(){
    layerInput.value = "";
    layerSelect.value = 0;
    layerTextarea.value = "";
    errMsg.innerHTML = "";
}

$("#categorylist").on('click',"#dosubmit",function(e){
            e.preventDefault;
            cname = layerInput.value;
            pid = layerSelect.value;
            info = layerTextarea.value;
            if(cname == "" || pid == ""|| info == ""){
                errMsg.innerHTML = "请填入完整信息！";
            }else{
                $.ajax({
                    type:"post",
                    url:"index.php?m=admin&c=cate&a=add",
                    dataType:'json',
                    data: {cname:cname,pid:pid,info:info},
                    success:function(res){
                       if(!res.status){
                           alert(res.info);
                       }else{
                            var result = '';
                            var show = '';
                            var cates = res.data.category;
                            result += '<option value="0">顶级分类</option>';
                            for (var i = 0; i < cates.length; i++) {
                                result += '<option value="'+cates[i].cid+'">'+cates[i].pre+cates[i].cname+'</option>';
                                show += '<tr> <td>'+cates[i].cid+'</td> <td style="width: 500px;text-align: left; text-indent:27px;" >'+cates[i].pre+cates[i].cname+'</td> <td class="edit addClass" style="width: 85px;">添加子菜单</td> <td class="edit addClass" cid="'+cates[i].cid+'">修改</td> <td class="edit delClass" cid="'+cates[i].cid+'">删除</td>  </tr>';
                            };
                            $("#goodsCode").html(result);
                            $("#layerSelect").html(result);
                            $("#c-r-tb tr:gt(0)").remove();
                            $(show).appendTo($("#c-r-tb"));
                            loading();
                            $("#exit").trigger('click');
                       }
                    }
                });
            }
});
$("#categorylist").on('click',"#doeditsubmit",function(e){
            e.preventDefault;
            cname = layerInput.value;
            pid = layerSelect.value;
            info = layerTextarea.value;
            id = $("input[type=hidden]").val();
            if(cname == "" || pid == ""|| info == "" || id == ""){
                errMsg.innerHTML = "请填入完整信息！";
            }else{
                $.ajax({
                    type:"post",
                    url:"index.php?m=admin&c=cate&a=edit",
                    dataType:'json',
                    data: {cname:cname,pid:pid,info:info,id:id},
                    success:function(res){
                       if(!res.status){
                           alert(res.info);
                       }else{
                            var result = '';
                            var show = '';
                            var cates = res.data.category;
                            result += '<option value="0">顶级分类</option>';
                            for (var i = 0; i < cates.length; i++) {
                                result += '<option value="'+cates[i].cid+'">'+cates[i].pre+cates[i].cname+'</option>';
                                show += '<tr> <td>'+cates[i].cid+'</td> <td style="width: 500px;text-align: left; text-indent:27px;" >'+cates[i].pre+cates[i].cname+'</td> <td class="edit addClass" style="width: 85px;">添加子菜单</td> <td class="edit addClass" cid="'+cates[i].cid+'">修改</td> <td class="edit delClass" cid="'+cates[i].cid+'">删除</td> </tr>';
                            };
                            $("#goodsCode").html(result);
                            $("#layerSelect").html(result);
                            $("#c-r-tb tr:gt(0)").remove();
                            $(show).appendTo($("#c-r-tb"));
                            loading();
                            $("#exit").trigger('click');
                       }
                    }
                });
            }
});

$("#c-r-tb").on('click', '.delClass', function(event) {
    event.preventDefault();
    var id = $(this).attr('cid');
    $.post('index.php?m=admin&c=cate&a=dele', {id: id}, function(res) {
        if(!res.status){
               alert(res.info);
           }else{
                var result = '';
                var show = '';
                var cates = res.data.category;
                console.log(cates);
                result += '<option value="0">顶级分类</option>';
                for (var i = 0; i < cates.length; i++) {
                    result += '<option value="'+cates[i].cid+'">'+cates[i].pre+cates[i].cname+'</option>';
                    show += '<tr> <td>'+cates[i].cid+'</td> <td style="width: 500px;text-align: left; text-indent:27px;" >'+cates[i].pre+cates[i].cname+'</td> <td class="edit addClass" style="width: 85px;">添加子菜单</td> <td class="edit addClass" cid="'+cates[i].cid+'">修改</td> <td class="edit delClass" cid="'+cates[i].cid+'">删除</td> </tr>';
                };
                $("#goodsCode").html(result);
                $("#layerSelect").html(result);
                $("#c-r-tb tr:gt(0)").remove();
                $(show).appendTo($("#c-r-tb"));
                loading();
           }
    },"json");
});

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

// 图片在线预览
$("input[type=file]").change(function(e){
    $(".c-r-img").html('');
    var files = e.target.files; 
    for (var i = 0,file; file = files[i]; i++) {
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(e){
            $('<img src="'+e.target.result+'">').prependTo($(".c-r-img"));
            $(".c-r-img").show();
        }
    };
})

