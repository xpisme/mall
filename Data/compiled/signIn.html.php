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
                <form id="zcForm" action="" method="post">
                    用户名：<input type="text" id="username" name="username" required="required" class="signText-input"><br/>
                    密 码 ：<input type="password" id="password" name="password" required="required" class="signText-input"><br/>
                    <div class="CodeBox">
                        <div class="verCode-p fl">
                            验证码：<input type="text" name="verifynum" id="verCode" required="required">
                        </div>
                        <div class="Code fr">
                            <img src="index.php?m=home&c=user&a=getverify" id="verifycode" title="看不清换一张" alt="看不清换一张"/>
                        </div>
                    </div>
                    <button type="submit" onclick="signIn()" class="signBtn">Sign in</button>
                    <a href="index.php?m=home&c=user&a=signup"><p class="toSignIn"> >> to Sign up</p></a>
                    <p id="warning"></p>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $this->_var['path']; ?>js/sign.js"></script>
</body>
</html>
