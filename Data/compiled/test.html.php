<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>categorytree</title>
</head>
<body>
	<ul>
		<?php $_from = $this->_var['catetree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cate');if (count($_from)):
    foreach ($_from AS $this->_var['cate']):
?>
			<li><?php echo $this->_var['cate']['pre']; ?><?php echo $this->_var['cate']['cname']; ?></li>
	    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
</body>
</html>
<br>
<br>
<br>
<ul>
	<li>图书
		<ul>
			<li>计算机
				<ul>
					<li>php</li>
					<li>java</li>
					<li>.net</li>
				</ul>
			</li>
			<li>历史</li>
		</ul>
	</li>
	<li>服装</li>
	<li>美食</li>
</ul>