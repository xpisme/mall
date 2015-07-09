/**
 * Created by lenovo on 2015/6/11.
 */
$(document).ready(function(){
    var socket;
    var userName = $('.h-r-userName').text().trim();
    var tbxMsg = $('#tbxMsg');
    var seller = $('.c-goods-username');
    $('#btnLogout,#box').on('click',function(){
        $('.chat-box').animate({position:'fixed',right:'-270px'},1000);
    });
    $('.chat-switch').on('click',function(){
        $('.chat-box').animate({position:'fixed',right:'10px'},1000);
        socket = io.connect('http://localhost:8080');
        socket.on('connect',function(){
            addMsg("<p class='gray'>您可以和对方聊天啦</p>");
            socket.emit('new user',userName);
            document.onkeydown = function(ev){
              var ev = ev || window.event;
                if(ev.keyCode == 13){
                    var msg= tbxMsg.val();
                    var to = seller.text();
                    if(msg !== ""){
                        socket.emit('chat',userName,to,msg);
                        addMsg("<p class='chat-p'><span><span class='mColor-green'>您 ：</span>"+msg+"</span></p>");
                        tbxMsg.val('');
                        ev.preventDefault();
                        console.log('send');
                    }
                }
            };
            /*$('#btnSend').on('click',function(){
                var msg= tbxMsg.val();
                var to = seller.text();
                socket.emit('chat',userName,to,msg);
                addMsg("<p class='chat-p'><span><span class='mColor-green'>您 ：</span>"+msg+"</span></p>");
                tbxMsg.val('');
                console.log('send');
            });*/

            socket.on('to'+userName,function(data){
                console.log('to'+userName);
                addMsg("<p class='chat-p'><span><span class='mColor-green'>"+data.username+"：</span>"+data.msg+"</span></p>")
            });

            socket.on('exit',function(person){
                addMsg("<p class='gray'>"+ person + "已经退出聊天<br/></p>");
            });
            socket.on('disconnect',function(){
                addMsg("<p class='gray'>与服务器链接已断开--disconnect</p>");
            });



            $('#btnLogout').on('click',function(){
                console.log('ok');
                var to = seller.text();
                socket.emit('exit',userName,to);
                socket.disconnect();
                console.log('已经断开socket连接');
                $('.chat-switch').on('click',function(){
                    addMsg("<p style='color: red;'>请重新刷新页面，建立对话链接</p>")
                })
            });

        });

    });
    function addMsg(msg){
        document.getElementById('chat').innerHTML+=msg;
    }
    $(window).unload(function(){
        var to = seller.text();
        socket.emit('exit',userName,to);
        socket.disconnect();
        console.log('close');
    });
    /*function exit(){
        console.log('ok');
        var to = seller.text();
        socket.emit('exit',userName,to);
        socket.disconnect();
    }*/
});