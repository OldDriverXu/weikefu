<div id="content">
	<div class="reply-follower col-xs-2" id="reply-follower">

	</div>

	<div class="reply-body col-xs-8">
		<div class="reply-screen" id="reply-content">

		</div>
		<div class="reply-pannel">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" id="myTab">		
				<li class="active"><a href="#text" data-toggle="tab" data-type="text">文本</a></li>
				<li><a href="#image" data-toggle="tab" data-type="image">图片</a></li>
				<li><a href="#music" data-toggle="tab" data-type="music">音乐</a></li>
				<li><a href="#video" data-toggle="tab" data-type="video">视频</a></li>
				<li><a href="#voice" data-toggle="tab" data-type="voice">语音</a></li>
				<li><a href="#news" data-toggle="tab" data-type="news">图文</a></li>
			</ul>

			<!-- <form action="./reply/postform" method="POST" id="replyform"> -->
			
			<!-- Tab panes -->
			<div class="tab-content">

				<div class="tab-pane active" id="text">
					<div class="form-group">
						<textarea class="form-control" rows="4" id="reply_content" name="reply_content">

						</textarea>
					</div>
				</div>

				<div class="tab-pane" id="image">	
					<div class="text-danger" id="pic_error"></div>
					<?php echo form_open_multipart('upload/pic_upload', array('id'=>'pic_upload'));?>				
					    <div class="input-group">
							<label class="input-group-addon">图片(jpg)</label>
							<input type="file" class="form-control" id="pic_media" name="pic_media" />
							<button type="submit" class="btn btn-success">上传</button>
						</div>	
					</form>
					<input type="text" class="hide" id="pic_media_id" name="pic_media_id" />					
				</div>

				<div class="tab-pane" id="music">					
					<div class="input-group">
						<label class="input-group-addon">音乐标题</label>
						<input type="text" class="form-control" id="music_title" name="music_title"/>
					</div>

					<div class="input-group">
						<label class="input-group-addon">音乐简介</label>
						<input type="text" class="form-control" id="music_description"  name="music_description" />
					</div>

					<div class="input-group">
						<label class="input-group-addon">音乐链接</label>
						<input type="text" class="form-control" id="music_url"  name="music_url" />
					</div>

					<div class="input-group">
						<label class="input-group-addon">高品质音乐链接</label>
						<input type="text" class="form-control" id="hqmusic_url"  name="hqmusic_url" />
					</div>

					<div class="text-danger" id="thumb_error"></div>
					<?php echo form_open_multipart('upload/thumb_upload', array('id'=>'thumb_upload'));?>
						<div class="input-group">
							<label class="input-group-addon">封面照片(jpg)</label>
							<input type="file" class="form-control" id="thumb_media" name="thumb_media" />
							<button type="submit" class="btn btn-success">上传</button>
						</div>	
					</form>
					<input type="text" class="hide" id="thumb_media_id"  name="thumb_media_id" />	
				</div>

				<div class="tab-pane" id="video">
					<div class="text-danger" id="video_error"></div>
					<?php echo form_open_multipart('upload/video_upload', array('id'=>'video_upload'));?>
						<div class="input-group">
							<label class="input-group-addon">视频(mp4)</label>
							<input type="file" class="form-control" id="video_media" name="video_media" />
							<button type="submit" class="btn btn-success">上传</button>
						</div>
					</form>
					<input type="text" class="hide" id="video_media_id" name="video_media_id" />

					<div class="input-group">
						<label class="input-group-addon">视频标题</label>
						<input type="text" class="form-control" id="video_title" name="video_title" />
					</div>

					<div class="input-group">
						<label class="input-group-addon">视频简介</label>
						<input type="text" class="form-control" id="video_description" name="video_description" />
					</div>
				</div>

				<div class="tab-pane" id="voice">
					<div class="text-danger" id="voice_error"></div>
					<?php echo form_open_multipart('upload/voice_upload', array('id'=>'voice_upload'));?>
						<div class="input-group">						
							<label class="input-group-addon">语音(mp3/amr)</label>
							<input type="file" class="form-control" id="voice_media"  name="voice_media" />
							<button type="submit" class="btn btn-success">上传</button>
						</div>
					</form>
					<input type="text" class="hide" id="voice_media_id"  name="voice_media_id" />
				</div>

				<div class="tab-pane" id="news">

					<table class="table table-striped table-bordered" id="news_content">
						<tr>
							<th>排序</th>
							<th>图文标题</th>
							<th>图文简介</th>
							<th>图文链接</th>
							<th>图片链接</th>
							<th>编辑</th>
						</tr>
						<!-- <tr id="article1">
							<td class="article_order">1</td>
							<td class="article_title">2</td>
							<td class="article_description">3</td>
							<td class="article_url">4</td>
							<td class="article_pic_url">5</td>
							<td>
								<button type="button" class="btn btn-info edit">修改</button>
								<button type="button" class="btn btn-danger delete">删除</button>
							</td>
						</tr>	 -->			
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
								<button type="submit" class="btn btn-success">上传</button>
							</div>
						</form>
						<input type="text" class="hide" id="article_pic_url"  name="article_pic_url" /> 						
					</div>	

				</div>
			</div>
			
			<input type="text" class="hide" id="reply_to_username" name="reply_to_username" value=""/>
			<input type="text" class="hide" id="reply_user" name="reply_user" value="<?php echo $reply_user;?>"/>
			<input type="text" class="hide" id="reply_user_ip" name="reply_user_ip" value="<?php echo $reply_user_ip;?>" />
			<input type="text" class="hide" id="reply_title" name="reply_title" />
			<input type="text" class="hide" id="reply_excerpt" name="reply_excerpt"/>
			<input type="text" class="hide" id="reply_type" name="reply_type" value="text"/>
			<input type="text" class="hide" id="reply_status" name="reply_status" />
			<input type="text" class="hide" id="reply_parent" name="reply_parent" />			

			<button type="submit" class="btn btn-primary" id="submit">发送</button>


			<!-- </form> -->
		</div>
	</div>

	<div class="reply-setting col-xs-2">

	</div>

	<script type="text/javascript">
		$(document).ready(function() {				
			//上传pic，获得media_id
			$("#pic_upload").ajaxForm({
				dataType: 'json',
				success: function(responseText, statusText, xhr){
					if(responseText.error){
						$("#pic_error").html(responseText.error);
					}else{
						$("#pic_media_id").val(responseText.media_id);
						$("#pic_error").html("");
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
			//上传video，获得media_id
			$("#video_upload").ajaxForm({
				dataType: 'json',
				success: function(responseText, statusText, xhr){
					if(responseText.error){
						$("#video_error").html(responseText.error);
					}else{
						$("#video_media_id").val(responseText.media_id);
						$("#video_error").html("");
						alert('成功上传!');
					}	
				}
			});
			//上传voice，获得media_id
			$("#voice_upload").ajaxForm({
				dataType: 'json',
				success: function(responseText, statusText, xhr){
					if(responseText.error){
						$("#voice_error").html(responseText.error);
					}else{
						$("#voice_media_id").val(responseText.media_id);
						$("#voice_error").html("");
						alert('成功上传!');
					}	
				}
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

			//提交回复
			$("#submit").click(function(){
				post_form();		
			})
		})	

		//回复类型
		$("#myTab li").live("click", function(){
			var type = $("#myTab").find(".active").children("a").attr("data-type");
			$("#reply_type").val(type);
		})		

		
		
		$("#add_article").click(function(){
			add_article();
		});

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

		function add_article(){
			var article_order       = $("#article_order").val();
			var article_title       = $("#article_title").val();
			var article_description = $("#article_description").val();
			var article_url         = $("#article_url").val();
			var article_pic_url     = $("#article_pic_url").val();		
			
			var addDOM ='<tr id="article'+article_order+'" class="article"><td class="article_order">'+article_order+'</td><td class="article_title">'+article_title+'</td><td class="article_description">'+article_description+'</td><td class="article_url">'+article_url+'</td><td class="article_pic_url">'+article_pic_url+'</td><td><button type="button" class="btn btn-info edit">修改</button><button type="button" class="btn btn-danger delete">删除</button></td></tr>';
			$(addDOM).appendTo("#news_content");

			$("#article_order").val("");
			$("#article_title").val("");
			$("#article_description").val("");
			$("#article_url").val("");
			$("#article_pic_url").val("");
			$("#article_pic").val("");	
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
				articles.push(article);
			})	
			return articles;		
		}

		function clear_form(){
			//text
			$("#reply_content").val("");
			//image
			$("#pic_media_id").val("");
			//music
			$("#music_title").val("");
			$("#music_description").val("");
			$("#music_url").val("");
			$("#hqmusic_url").val("");
			$("#thumb_media_id").val("");
			//video
			$("#video_media_id").val("");
			$("#video_title").val("");
			$("#video_description").val("");
			//voice
			$("#voice_media_id").val("");
			//news
			$("#news_content").val("");			
		}

		//发送客服回复	
		function post_form(){
			//common params 
			var reply_to_username= $("#reply_to_username").val();
			var reply_user 		 = $("#reply_user").val();
			var reply_user_IP    = $("#reply_user_IP").val();
			var reply_title      = $("#reply_title").val();
			var reply_excerpt    = $("#reply_excerpt").val();
			var reply_type       = $("#reply_type").val();
			var reply_status     = $("#reply_status").val();
			var reply_parent     = $("#reply_parent").val();

			//text
			var reply_content    = $("#reply_content").val();
			//image
			var pic_media_id     = $("#pic_media_id").val();
			//music
			var music_title      = $("#music_title").val();
			var music_description= $("#music_description").val();
			var music_url        = $("#music_url").val();
			var hqmusic_url      = $("#hqmusic_url").val();
			var thumb_media_id   = $("#thumb_media_id").val();
			//video
			var video_media_id   = $("#video_media_id").val();
			var video_title      = $("#video_title").val();
			var video_description= $("#video_description").val();
			//voice
			var voice_media_id   = $("#voice_media_id").val();
			//news
			var articles = new Array();
			articles = get_articles();
			
			jQuery.ajax({
				url: './reply/postform',
				type: 'POST',
				dataType: 'json',
				data: {
					reply_to_username : reply_to_username,
					reply_user        : reply_user,
					reply_user_IP     : reply_user_IP,
					reply_title       : reply_title,
					reply_excerpt     : reply_excerpt,
					reply_type        : reply_type,
					reply_status      : reply_status,
					reply_parent      : reply_parent,
					//text
					reply_content     : reply_content,
					//image
					pic_media_id      : pic_media_id,
					//music
					music_title       : music_title,
					music_description : music_description,
					music_url         : music_url,
					hqmusic_url       : hqmusic_url,
					thumb_media_id    : thumb_media_id,
					//video
					video_media_id    : video_media_id,
					video_title       : video_title,
					video_description : video_description,
					//voice
					voice_media_id    : voice_media_id,
					//news
					articles          : articles
				},
				complete: function(xhr, textStatus) { //called when complete 
					//清空表单
					clear_form();		                    
		        },
				success: function(response, textStatus, xhr){

				},
				error: function(xhr, textStatus, errorThrown) {
		            //called when there is an error
		            console.log(xhr);
		            console.log(textStatus);
		            console.log(errorThrown);
		        }
			});
		}

		//获取单个会话详情
		function get_session(username, timestamp){
			jQuery.ajax({
				url:'./reply/get_session/'+username+'/'+timestamp,
				type: 'GET',				
				success: function(response, textStatus, xhr){
					//清空对话区域 
					$("#reply-content").empty();
					$('#reply-content').append(response); 
					$('#reply-content').scrollTop(document.getElementById("reply-content").scrollHeight);
				}
			})
		}

		//获取未读所有会话
		function get_unclosed_sessions() {
			jQuery.ajax({
				url: './reply/get_unclosed_sessions',
				type: 'GET',
				success: function(response, textStatus, xhr){
					//清空粉丝新留言区域 
					$("#reply-follower").empty();
					$('#reply-follower').append(response);
				}
			})
		}
		//unread = get_unclosed_sessions();

		var username;
		var timestamp;

		$('.open-session').live('click', function(){
			username = $(this).attr('data-username');
			timestamp = $(this).attr('data-timestamp');
			get_session(username, timestamp);

			$("#reply_to_username").val(username);			
		})

		ud = function update(){			
				get_unclosed_sessions();			
		}
		sh = setInterval( ud, 5000);		

	</script>	
</div>
