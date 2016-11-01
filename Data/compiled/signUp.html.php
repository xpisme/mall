<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>sign up</title>
    <link href="<?php echo $this->_var['path']; ?>css/sign.css" rel="stylesheet">
</head>
<body>
<div class="signBox">
    <img src="<?php echo $this->_var['path']; ?>images/bg.jpg">
    <div class="signBox-inner">
        <div class="sign">
            <div class="signTitle">
                <h1><a href="index.php">校卖部</a></h1>
            </div>
            <div class="signText">
                <form id="signForm" action="" method="post">
                    用 户 名：<input type="text" id="username" name="username" class="signText-input"><br/>
                    用户邮箱：<input type="email" id="email" name="email" class="signText-input"><br/>
                    密码设置：<input type="password" id="password" name="password" class="signText-input"><br/>
                    重复密码：<input type="password" id="pswSure" class="signText-input"><br/>
                    <button type="submit" onclick="sign()" class="signBtn">Sign up</button>
                    <a href="index.php?m=home&c=user&a=signin"><p class="toSignIn" id="toSignIn">>> to Sign in</p></a>
                    <p id="warning"></p>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $this->_var['path']; ?>js/sign.js"></script>
</body>
</html>