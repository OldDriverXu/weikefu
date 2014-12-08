<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<title>微信客服系统</title>
		<script src="<?php echo base_url();?>js/jquery-1.8.2.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css">
	</head>
	<?php echo form_open('login/in'); ?>
	<div class='head' id='login_header'>
		<div class='head_box'>
			<div class='head_left'>				
			</div>
			<!-- <div class='head_right'>
				<a href="#" class='dol_browser'>百纳海豚浏览器</a>
				<span class='glyphicon glyphicon-comment'></span>
				<a href="./logout">退出</a>
			</div> -->
			<div class='clearboth'></div>
		</div>
	</div>
	<div id='banner'>
		<div id='login_wrap'>
			<div id='login_form'>
				<h2 class='microsoft_yahei'>登录</h2>

				<div class='error_info'>
					<?php echo validation_errors();?>
				</div>
				<div class='display_none'>
					<span class='glyphicon glyphicon-warning-sign username_error'></span><span class='username_error'><?php echo form_error('username');?></span><br>
					<span class='glyphicon glyphicon-warning-sign password_error'></span><span class='password_error'><?php echo form_error('password');?></span>
				</div>
				<div class="input-group input-group-lg">
					<span class="input-group-addon glyphicon glyphicon-user"></span>
					<input type="text" class="form-control" placeholder="Username" name="username">
				</div>
				<div class="input-group input-group-lg">
					<span class="input-group-addon glyphicon glyphicon-lock"></span>
					<input type="password" class="form-control" placeholder="Password" name="password" >
				</div>
				<input type="checkbox" name="savepwd"  value="savepwd" class='savepwd'><span>记住密码</span><br>
				<input type="submit" name="submit" value="login" class='btn btn-success'>
			</div>
			<div id='qr_code'>
				<img src="../css/images/qrcode.jpg" alt=""><br>
				<span>扫描并关注海豚浏览器</span>
			</div>
			<div class='clearboth'></div>
		</div>
	</div>

	<div class='login_footer'>
		<span>
		    <a target="_blank" href="http://cn.dolphin.com">关于海豚</a>&nbsp;|&nbsp;		    
		    <a target="_blank" href="http://kf.qq.com/product/weixinmp.html">客服中心</a>&nbsp;|&nbsp;
		    <a href="http://crm2.qq.com/page/portalpage/wpa.php?uin=40012345&amp;f=1&amp;ty=1&amp;ap=000011:400792:|m:12|f:400792:m:12" target="_blank">在线客服</a>&nbsp;|&nbsp;
		</span>
		<span>Copyright&nbsp;© 2012-2014 Dolphin. All Rights Reserved.</span>
	</div>
	<?php echo form_close() ?>
	<script>
		$(document).ready(function(){
			$('#login_form').click(function(){
				if($('.username_error:eq(1)').html()){
					$('.username_error').show();
				}
				if($('.password_error:eq(1)').html()){
					$('.password_error').show();
				}
			});
		});
	</script>
</html>