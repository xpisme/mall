<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8" CONTENT="TEXT/HTML">
    <meta name="viewport" content="width=device-width">
    <title>商品管理</title>
    <link href="<?php echo $this->_var['path']; ?>css/index.css" rel="stylesheet">
</head>
<body>
<div id="box">
    <div class="head">
        <div class="head-inner">
            <div class="h-r-left">
                校卖部
            </div>
        </div>
    </div>
    <p class="lin"></p>
    <div class="content errContent">
        <p class="errContent-p"><?php echo $this->_var['msg']; ?></p>
    </div>
</div>
<script type="text/javascript">
function go(){
    var href = window.location.href;
    window.location.replace(href);
}
setTimeout("go()",1500);
</script>
</body>
</html>