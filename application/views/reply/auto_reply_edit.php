{replys}
		<form action="" class='form-horixontal' role='form'>
			<div class='form-group'>
				<label class="col-sm-2 control-label">序号</label>
				<div class='col-sm-10'>
					<input type="text" class='form-control' value='{ID}' id='ID' >
				</div>
			</div>
			<div class='form-group'>
				<label class="col-sm-2 control-label">关键词</label>
				<div class='col-sm-10'>
					<input type="text" class='form-control' value='{autoreply_keyword}' id='autoreply_keyword'>
				</div>
			</div>
			<div class='form-group'>
				<label class="col-sm-2 control-label">回复类型</label>
				<div class='col-sm-10'>
					<input type="text" class='form-control' value='{autoreply_type}' id='autoreply_type'/>
				</div>
			</div>
			<div class='form-group'>
				<label class="col-sm-2 control-label">回复内容</label>
				<div class='col-sm-10'>
					<input type="text" class='form-control' value='{autoreply_content}' id='autoreply_content'>
				</div>
			</div>
		</form>
		<p>&nbsp;</p>
		
		<div class="auto_reply_edit">
			<ul class='nav nav-tabs' id='myTab'>
				<li class='active'><a href='#text' data-toggle='tab' data-type='text'>文本</a></li>
				<li><a href="#music" data-toggle="tab" data-type="music">音乐</a></li>
				<li><a href='#news' data-toggle='tab' data-type='news'>图文</a></li>
			</ul>
			<div class='tab-content'>
				<div class='tab-pane active' id='text'>
					<div class='form-group'>
						<textarea class='form-control' name="reply-content" id="reply-content"  rows="4">
						</textarea>
					</div>
				</div>

				<div class="tab-pane" id="music">				
						<div class="input-group">
							<label class="input-group-addon">音乐标题</label>
							<input type="text" class="form-control" id="music_title" name="music_title"
							value='{music_title}'/>
						</div>

						<div class="input-group">
							<label class="input-group-addon">音乐简介</label>
							<input type="text" class="form-control" id="music_description"  name="music_description"
							value='{music_description}'/>
						</div>

						<div class="input-group">
							<label class="input-group-addon">音乐链接</label>
							<input type="text" class="form-control" id="music_url"  name="music_url"
							value='{music_url}'/>
						</div>

						<div class="input-group">
							<label class="input-group-addon">高品质音乐链接</label>
							<input type="text" class="form-control" id="hqmusic_url"  name="hqmusic_url"
							value='{hqmusic_url}'/>
						</div>

						<div class="text-danger" id="thumb_error"></div>
						<input type="text" class="hide" id="thumb_media_id"  name="thumb_media_id" />
				</div>
				<div class='tab-pane' id='news'>
					<table class='table table-striped table-bordered' id='news_content_table'>
						<tr>
							<th>排序</th><th>图文标题</th><th>图文简介</th>
							<th>图文链接</th><th>图片链接</th><th>编辑</th>
						</tr>
						{news}
							<tr id="article{article_order}" class="article">
								<td class="article_order">{article_order}</td>
								<td class="article_title">{article_title}</td>
								<td class="article_description">{article_description}</td>
								<td class="article_url">{article_url}</td>
								<td class="article_pic_url">{article_pic_url}</td>
								<td><button type="button" class="btn btn-info btn-sm edit">修改</button>
									<button type="button" class="btn btn-danger btn-sm delete">删除</button>
								</td>
							</tr>
						{/news}				
					</table>

					<div id='news_content'>
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

						<input type="text" class="hide" id="autoreply_user" name="autoreply_user" value="<?php echo $reply_user;?>"/>
						<input type="text" class="hide" id="autoreply_title" name="autoreply_title" />
						<input type="text" class="hide" id="autoreply_excerpt" name="autoreply_excerpt"/>
						<input type="text" class="hide" id="autoreply_type" name="autoreply_type" value="text"/>
						<input type="text" class="hide" id="autoreply_status" name="autoreply_status" />
					</div>
				</div>
			</div>
		</div>

	<script>
		//去掉'news'
		if('{edit_type}'!='news'){
			var article_order = $('tr[id="article{article_order}"]');
			article_order.remove();
			var news = document.getElementById('news');
			news.removeChild(news.firstChild);
		}
		if('{edit_type}'!='music'){
			$('#music_title').val('');
			$('#music_description').val('');
			$('#music_url').val('');
			$('#hqmusic_url').val('');
		}
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
		//上传thumb，获得media_id
		$("#thumb_upload").ajaxForm({
			dataType: 'json',
			success: function(responseText, statusText, xhr){
				if(responseText.error){
					$("#thumb_error").html(responseText.error);
				}else{
					$("#thumb_media_id").val(responseText.media_id);
					$("#thumb_error").html("");
					alert('成功上传!');
				}	
			}
		});
		//回复类型
		$("#myTab li").live("click", function(){
			var type = $("#myTab").find(".active").children("a").attr("data-type");
			$("#autoreply_type").val(type);
		})
		//添加一条新图文
		$('#add_article').click(function(){
			var article_order       = $("#article_order").val();
			var article_title       = $("#article_title").val();
			var article_description = $("#article_description").val();
			var article_url         = $("#article_url").val();
			var article_pic_url     = $("#article_pic_url").val();		
			
			var addDOM ='<tr id="article'+article_order+'" class="article"><td class="article_order">'+article_order+'</td><td class="article_title">'+article_title+'</td><td class="article_description">'+article_description+'</td><td class="article_url">'+article_url+'</td><td class="article_pic_url">'+article_pic_url+'</td><td><button type="button" class="btn btn-info edit">修改</button><button type="button" class="btn btn-danger delete">删除</button></td></tr>';
			$(addDOM).appendTo("#news_content_table");

			$("#article_order").val("");
			$("#article_title").val("");
			$("#article_description").val("");
			$("#article_url").val("");
			$("#article_pic_url").val("");
			$("#article_pic").val("");	
		});
		//删除一条图文
		$('.delete_one').live('click', function(){
			$(this).parent().remove();
		});
		//编辑图文
		$(".article").on("click",'.btn-info', function(){			
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

		//修改、提交图文
		$('button.btn-primary').click(function(){
			var ID = $('#ID').val();
			var autoreply_keyword = $('#autoreply_keyword').val();
			var autoreply_type = $('#autoreply_type').val();
			var autoreply_content = $('#reply-content').val();
			var articles = new Array();
			$('.article').each(function(){
				var article = new Object();
				article.news_id = ID;
				article.news_type = 'auto_reply';
				article.article_order       = $(this).children(".article_order").html();
				article.article_title       = $(this).children(".article_title").html();
				article.article_description = $(this).children(".article_description").html();
				article.article_url         = $(this).children(".article_url").html();
				article.article_pic_url     = $(this).children(".article_pic_url").html();
			 	articles.push(article);
			});
			var music = new Object();
			if(autoreply_type=='music'){
				music.music_title = $('#music_title').val();
				music.music_description = $('#music_description').val();
				music.music_url = $('#music_url').val();
				music.hqmusic_url = $('#hqmusic_url').val();
			}
			$.ajax({
				url: './auto_reply/update_reply',
				type: 'POST',
				data: {
					ID                 : ID,
					autoreply_keyword  : autoreply_keyword,
					autoreply_type     : autoreply_type,
					autoreply_content  : autoreply_content,
					music 			   : music,
					articles           : articles
				},
				dataType: 'json',
				success: function(response){
					$('#myModal').modal('hide');
					location.href = '';
				},
				error: function(xhr, textStatus,errorThrown){
					console.log(xhr);
					console.log(textStatus);
					console.log(errorThrown);
				}
			});
		});
	</script>
{/replys}