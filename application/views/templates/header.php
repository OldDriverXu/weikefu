<!doctype html>
<html lang="en">
<head>
	<?php $this->load->helper('url'); ?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title><?php echo $title;?> - 微信客服系统</title>
	<script src="<?php echo base_url();?>js/jquery-1.8.2.min.js"></script>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.tagsinput.css">

</head>
<body>
	<div class='head' id='header'>
		<div class='head_box'>
			<div class='head_left'>				
			</div>
			<div class='head_right'>
				<a href="#" class='dol_browser'>百纳海豚浏览器</a>
				<span class='glyphicon glyphicon-comment'></span>
				<a href="./logout">退出</a>
			</div>
			<div class='clearboth'></div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-xs-2">
				<ul class="left_nav">				
					<li><span class="glyphicon glyphicon-cog"></span> 设置</li>
					<li><a href='./welcome'>欢迎语</a></li>
					<li><a href='./selfmenu'>自定义菜单</a></li>
					<li><a href="./off_duty_reply">下班回复</a></li>
					<li><a>系统设置</a></li>
					<li><span class="glyphicon glyphicon-earphone"></span> 会话管理</li>
					<li><a href="./reply">客服回复</a></li>
					<li><a>会话查询</a></li>
					<li><span class="glyphicon glyphicon-star-empty"></span> 粉丝管理</li>
					<li><a href='./follower'>粉丝管理</a></li>
					<li><span class="glyphicon glyphicon-user"></span> 客服管理</li>
					<li><a>客服管理</a></li>
					<li><span class="glyphicon glyphicon-globe"></span> 自动回复</li>
					<li><a href="./auto_reply">历史自动回复</a></li>
					<li><a href="./add_autoreply">新增自动回复</a></li>
				</ul>

			</div>
			<div class="col-xs-10">
				<h3><?php echo $title;?></h3>



	
