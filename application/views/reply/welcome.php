<div id='show_welcome'>
	<p class='title'>当前欢迎语</p>
	<div class='content'></div>
</div>

<div id='set_welcome'>
	<p class='title'>设置欢迎语</p>
	<div class='set_welcome_content'>
		<ul class='nav nav-tabs' id='myTab'>
			<li class='active'><a href='#text' data-toggle='tab' data-type='text'>文本</a></li>
			<li><a href='#news' data-toggle='tab' data-type='news'>图文</a></li>
		</ul>
		<div class='tab-content'>
			<div class='tab-pane active' id='text'>
				<div class='form-group'>
					<textarea class='form-control' name="reply-content" id="reply-content"  rows="4">
						
					</textarea>
				</div>
			</div>
			<div class='tab-pane' id='news'>
				<table class='table table-hover' id='news_content'>
					<tr>
						<th>排序</th><th>图文标题</th><th>图文简介</th>
						<th>图文链接</th><th>图片链接</th><th>编辑</th>
					</tr>				
				</table>

				<div class="article_content">
					<button type="button" class="btn btn-default" id="add_article">添加一条图文</button> <span>(最多10条图文消息)</span>

					<div class="input-group">
						<label class="input-group-addon">排序</label>
						<input type="text" class="form-control" id="article_order" />
					</div>

					<div class="input-group">
						<label class="input-group-addon">图文标题</label>
						<input type="text" class="form-control" id="article_title" />
					</div>

					<div class="input-group">
						<label class="input-group-addon">图文简介</label>
						<input type="text" class="form-control" id="article_description" />
					</div>
				
					<div class="input-group">
						<label class="input-group-addon">图文链接</label>
						<input type="text" class="form-control" id="article_url" />
					</div>

					<div class="text-danger" id="article_error"></div>
					<?php echo form_open_multipart('upload', array('id'=>'article_upload'));?>
						<div class="input-group">						
							<label class="input-group-addon">插图</label>
							<input type="file" class="form-control" name="userfile" id="article_pic"/>
							<button type="submit" class="btn btn-success btn-sm">上传</button>
						</div>
					</form>
					<input type="text" class="hide" id="article_pic_url"  name="article_pic_url" /> 						
				</div>	
			</div>
		</div>
		<div class='text_align_right'>
			<button type="submit" class="btn btn-primary btn-sm" id="submit">发送</button>
		</div>
	</div>

	<input type="text" class="hide" id="autoreply_user" name="autoreply_user" value="<?php echo $reply_user;?>"/>
	<input type="text" class="hide" id="autoreply_title" name="autoreply_title" />
	<input type="text" class="hide" id="autoreply_excerpt" name="autoreply_excerpt"/>
	<input type="text" class="hide" id="autoreply_type" name="autoreply_type" value="text"/>
	<input type="text" class="hide" id="autoreply_status" name="autoreply_status" />

</div>

<script>
	$(document).ready(function(){

		//提交回复
		$('#submit').click(function(){
			set_welcome();
		});
		//添加一条图文
		$("#add_article").click(function(){
			add_article();
		});

		//回复类型
		$("#myTab li").live("click", function(){
			var type = $("#myTab").find(".active").children("a").attr("data-type");
			$("#autoreply_type").val(type);
		});

		//获取欢迎语
		function get_welcome(){
			$.ajax({
				url: './welcome/get_welcome',
				type: 'GET',
				success: function(response, textStatus, xhr){
					var res = response.split('!@#$%^&*');
					$('.content').html(res[0]);
					if(res[1]){
						$("#news_content tr[class='article']").remove();
						$(res[1]).appendTo("#news_content");
					}
				}
			});
		}
		get_welcome();
		//设置欢迎语	
		function set_welcome(){
			//common params 
			var autoreply_user 		 = $("#autoreply_user").val();
			var autoreply_title      = $("#autoreply_title").val();
			var autoreply_excerpt    = $("#autoreply_excerpt").val();
			var autoreply_type       = $("#autoreply_type").val();
			var autoreply_status     = $("#autoreply_status").val();

			//text
			var autoreply_content    = $("#reply-content").val();

			//news
			var articles = new Array();
			articles = get_articles();
			
			jQuery.ajax({
				url: './welcome/set_welcome',
				type: 'POST',
				dataType: 'json',
				data: {
					autoreply_user        : autoreply_user,
					autoreply_title       : autoreply_title,
					autoreply_excerpt     : autoreply_excerpt,
					autoreply_type        : autoreply_type,
					autoreply_status      : autoreply_status,
					//text
					autoreply_content     : autoreply_content,
					//news
					articles         : articles
				},
				complete: function(xhr, textStatus) { //called when complete 
					//清空表单
					clear_form();		                    
		        },
				success: function(response, textStatus, xhr){
					get_welcome();
				},
				error: function(xhr, textStatus, errorThrown) {
		            //called when there is an error
		            console.log(xhr);
		            console.log(textStatus);
		            console.log(errorThrown);
		        }
			});
		}

		function get_articles(){
			var articles = new Array();	
			$(".article").each(function(){
				var article = new Object();
				article.article_order       = $(this).children(".article_order").html();
				article.article_title       = $(this).children(".article_title").html();
				article.article_description = $(this).children(".article_description").html();
				article.article_url         = $(this).children(".article_url").html();
				article.article_pic_url     = $(this).children(".article_pic_url").html();
				article.news_type        = 'welcome';
				articles.push(article);
			});	
			return articles;		
		}

		function clear_form(){
			//text
			$("#reply_content").val("");
			//news
			$("#news_content").val("");			
		}
	

		function add_article(){
			var article_order       = $("#article_order").val();
			var article_title       = $("#article_title").val();
			var article_description = $("#article_description").val();
			var article_url         = $("#article_url").val();
			var article_pic_url     = $("#article_pic_url").val();		
			
			var addDOM ='<tr id="article'+
						article_order+'" class="article"><td class="article_order">'+
						article_order+'</td><td class="article_title">'+
						article_title+'</td><td class="article_description">'+
						article_description+'</td><td class="article_url">'+
						article_url+'</td><td class="article_pic_url">'+
						article_pic_url+'</td><td><button type="button" class="btn btn-info btn-sm edit">修改</button><button type="button" class="btn btn-danger btn-sm delete">删除</button></td></tr>';
			$(addDOM).appendTo("#news_content");

			$("#article_order").val("");
			$("#article_title").val("");
			$("#article_description").val("");
			$("#article_url").val("");
			$("#article_pic_url").val("");
			$("#article_pic").val("");	
		}
		//编辑图文
		$(".edit").live("click", function(){			
			var root = $(this).parent().parent();
			var article_order       = $(root).find(".article_order").html();
			var article_title       = $(root).find(".article_title").html();
			var article_description = $(root).find(".article_description").html();
			var article_url         = $(root).find(".article_url").html();
			var article_pic_url     = $(root).find(".article_pic_url").html();

			$("#article_order").val(article_order); 
			$("#article_title").val(article_title);
			$("#article_description").val(article_description); 
			$("#article_url").val(article_url); 
			$("#article_pic_url").val(article_pic_url); 

			$(root).remove();
		});
		$(".delete").live("click", function(){
			$(this).parent().parent().remove();
		});

		//上传article_pic，获得图片地址
		$("#article_upload").ajaxForm({
			dataType: 'json',
			success: function(responseText, statusText, xhr){
				if(responseText.error){
					$("#article_error").html(responseText.error);
				}else{
					$("#article_pic_url").val(responseText.upload_data.full_path);
					$("#article_error").html("");											
					alert('成功上传!');
				}	
			}
		});
	});
</script>