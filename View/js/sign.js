/**
 * Created by lenovo on 2015/4/25.
 */
//sign up

var warning = document.getElementById('warning');
function sign(){
    var user=new Object();
    user.username = document.getElementById('username').value;
    user.password = document.getElementById('password').value;
    user.pswSure = document.getElementById('pswSure').value;
    user.email = document.getElementById('email').value;
    if(user.username==""|| user.password==""|| user.pswSure==""){
        warning.innerHTML = "请填入完整注册信息!";
        if(event && event.preventDefault){
            event.preventDefault();
        }else{window.event.returnValue = false;}
    }else{
        if(user.password != user.pswSure){
            warning.innerHTML = "密码确认与您设置的密码不符！";
            document.getElementById('password').value ="";
            document.getElementById('pswSure').value = "";
            if(event && event.preventDefault){
                event.preventDefault();
            }else{
                window.event.returnValue = false;
            }
        }else{
            var apos=user.email.indexOf("@");
            var dotpos=user.email.lastIndexOf(".");
            if (apos<1||dotpos-apos<2)
            {
                warning.innerHTML = "邮箱格式不正确";
                if(event && event.preventDefault){
                    event.preventDefault();
                }else{window.event.returnValue = false;}
            }
        }
    }
}

document.getElementById('verifycode').onclick = function(){
    this.src='index.php?m=home&c=user&a=getverify&rand='+Math.random();
}

//Sign in

function signIn(){
    var username = document.getElementById('username');
    var password = document.getElementById('password');
    if(username.value=="" || password.value==""){
        document.getElementById('warning').innerHTML = "请填入完整的登陆信息" ;
        if(event && event.preventDefault){
            event.preventDefault();
        }else{window.event.returnValue = false;}
    }
}