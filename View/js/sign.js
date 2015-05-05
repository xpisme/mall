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
    if(user.username==""|| user.password==""|| user.pswSure=="" || user.email==""){
        warning.innerHTML = "请填入完整注册信息!";
        if(event && event.preventDefault){
            event.preventDefault();
        }else{window.event.returnValue = false;}
    }else{
        if(user.password != user.pswSure){
            warning.innerHTML = "密码确认与设置的密码不符！";
            document.getElementById('password').value ="";
            document.getElementById('pswSure').value = "";
            if(event && event.preventDefault){
                event.preventDefault();
            }else{window.event.returnValue = false;}
        }
    }
}

//Sign in


function signIn(){
    var username = document.getElementById('username');
    var password = document.getElementById('password');
    if(username.value=="" || password.value==""){
        document.getElementById('warning').innerHTML = "请填入完整的登陆信息" ;
        if(event && event.preventDefault()){
            event.preventDefault();
        }else{
            window.event.returnValue = false;
        }
    }
}