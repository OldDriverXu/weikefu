<div id='selfmenu_content'>	
	<div class="panel panel-default">
		<div class="panel-heading">
			<p>编辑提示</p>
		</div>
	  	<div class="panel-body">
	  		<p>可创建最多3个一级菜单，每个一级菜单下可创建最多5个二级菜单</p>
		</div>
	</div>


	<div id='edit_frame'>
		<div class='frame_left'>
			<div class='left_title'>
				<span>菜单管理</span>
				<button class='btn btn-success btn-sm'>添加</button>
				<button class='btn btn-default btn-sm sort_button'>排序</button>
			</div>
			<div class='left_content'>

			</div>
		</div>
		<div class='frame_right'>
			<div class='right_title'>
				<p>设置动作</p>
			</div>
			<div class='right_content'>
				
			</div>
		</div>
		<div class='clearboth'></div>
	</div>

	<div class="panel panel-default publish">
		<div class="panel-heading">
			<p>发布提示</p>
		</div>
	  	<div class="panel-body">
	  		<p>编辑中的菜单不能直接在用户手机上生效，你需要进行发布，发布后24小时内所有的用户都将更新到新的菜单。</p>
	  		<p>点击删除将删除用户手机上的自定义菜单功能。</p>
		</div>
		<div class="panel-footer">
			<button class="btn btn-success btn-sm btn_submit">发布</button>
			<button class="btn btn-success btn-sm btn_cancle">删除</button>
		</div>
	</div>

</div>

<div id='selfmenu_modal'>
	<!-- Modal -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">添加自定义菜单</h4>
		        <input type="hidden" value='' class='menu_order'>
		        <input type="hidden" value='' class='menu_parent'>
		    </div>
		    <div class="modal-body">

				<div class="form-group">
					<label class="col-sm-2 control-label">菜单名称</label>
					<div class="col-sm-10">
						<input type="text" class="form-control menu_name" value="">
					</div>
				</div>

				<div class="form-group menu_func">
					<label class="col-sm-2 control-label">菜单功能</label>
					<div class="col-sm-10">
						<div class="btn-group">
							<button type="button" class="btn btn-default send">发送信息</button>
							<button type="button" class="btn btn-default jump">跳转到网页</button>
							<input type="hidden" value='' class='add_type'>
						</div>
					</div>
				</div>

				<div class="form-group jump_url display_none">
					<label class="col-sm-2 control-label">跳转网址</label>
					<div class="col-sm-10">
						<input type="text" class="form-control menu_url" value="">
					</div>
				</div>

				<div class="form-group info_content display_none">
					<label class="col-sm-2 control-label">信息内容</label>
					<div class="col-sm-10">
						<div id='semfmenu-pannel-wrap'>
							<div class="reply-pannel">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs" id="myTab">		
									<li class="active"><a href="#text" data-toggle="tab" data-type="text">文本</a></li>
									<li><a href="#music" data-toggle="tab" data-type="music">音乐</a></li>
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
												<button type="submit" class="btn btn-success btn-sm">上传</button>
											</div>	
										</form>
										<input type="text" class="hide" id="thumb_media_id"  name="thumb_media_id" />	
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
													<button type="submit" class="btn btn-success btn-sm">上传</button>
												</div>
											</form>
											<input type="text" class="hide" id="article_pic_url"  name="article_pic_url" /> 						
										</div>	

									</div>
								</div>			
							</div>
						</div>
					</div>
					<div class='clearboth'></div>
				</div>
				
				<div class='clearboth hide' class='sm_id'></div>
		    </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	        <button type="button" class="btn btn-primary sub_button" data-clazz=''>保存</button>
	        <input type="hidden" value='' class='sub_type'>
	        <input type="hidden" id="autoreply_type" name="autoreply_type" value="text"/>
	        <input type="hidden" id='selfmenu_id' value=''>

	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->	
</div>



<script>
	$(document).ready(function(){
		$('#selfmenu_content .sort_button').tooltip({
			title : '拖拽菜单名称进行排序',
			placement : 'top',
		});

		//一次性获取菜单数据，并保存起来
		var menu_data = new Array();
		//获取菜单对象
		//根id获取对应数据 id为字符串
		function get_by_id(id){
			for(var i=0,len=menu_data.length; i<len; i++){
				var obj = menu_data[i];
				if(obj.ID == id){
					return obj;
				}
			}
		}

		function get_left_selfmenu(){
			$.ajax({
				url : './selfmenu/get_selfmenu',
				type : 'GET',
				dataType: 'json',
				success : function(response){
					menu_data = response
					var str = '';
					for(var i=0,len=response.length;i<len;i++){
						str += render_left_menu(response[i]);
					}
					str += '</ul>';
					var left_content = $('#selfmenu_content .left_content');
					left_content.html(str);
					//拖动排序
					left_content.find('ul').sortable({
						items: '.second_menu',
						opacity: 0.6,
						revert: true,
						update: function(event, ui){
							var objs = new Array();
							$(this).find('.second_menu').each(function(i){
								var obj = new Object();
								//更新数据库
								obj.id = $(this).data('id');
								obj.order = i + 1;
								objs.push(obj);
							});
							sort_menu(objs);
						}
					});
				}
			});
		}
		//显示左边菜单
		get_left_selfmenu();

		//菜单排序
		function sort_menu(arr){
			$.ajax({
				url : './selfmenu/sort_menu',
				type : 'GET',
				data : {
					menu_data : arr
				},
				success : function(){

				}
			});
		}


		//获取二级菜单
		function get_secondmenu(id){
			var num = 0;
			var second_menu = new Array();
			for(var i=0,len=menu_data.length;i<len;i++){
				if(menu_data[i].menu_parent==id){
					second_menu[num] = menu_data[i];
					num++;
				}
			}
			return second_menu;
		}

		//根据数据渲染左边菜单
		//first_render 用来判断是否是第一次渲染
		var first_render = 0;
		function render_left_menu(obj){
			str = '';
			str_ul = '';
			if(first_render){
				str_ul = '</ul><ul>';
			}else{
				str_ul = '<ul>';
			}
			var menu_parent = obj.menu_parent;
			if(menu_parent == '0'){
				str = str_ul + "<li class='first_menu' data-id="+
						obj.ID+" data-order="+
						obj.menu_order+"><div class='menu_name_wrap'>"+''+
						"<span class='glyphicon glyphicon-chevron-down'></span><span class='menu_name'>"+
						obj.menu_name+"</span></div><div class='edit_icon'>"+''+
						"<span class='glyphicon glyphicon-plus'></span>"+''+
						"<span class='glyphicon glyphicon-pencil'></span>"+''+
						"<span class='glyphicon glyphicon-trash'></span></div><div class='clearboth'></div></li>"
			}else{
				str = "<li class='second_menu' data-id="+
						obj.ID+" data-type="+
						obj.menu_type+" data-order="+
						obj.menu_order+"><div class='menu_name_wrap'>"+''+
						"<span class='menu_name'>"+
						obj.menu_name+"</span></div><div class='edit_icon'>"+''+
						"<span class='glyphicon glyphicon-plus'></span>"+''+
						"<span class='glyphicon glyphicon-pencil'></span>"+''+
						"<span class='glyphicon glyphicon-trash'></span></div><div class='clearboth'></div></li>";
			}
			first_render = 1;
			return str;
		}
		//渲染右边菜单显示
		function render_right_menu(obj){
			var str = '';
			var right_content = $('#selfmenu_content .right_content');
			if(obj.menu_type == 'view'){
				str = "<div class='view_menu'><p>订阅者点击该菜单会跳到以下链接</p><input readonly='readonly' class='' value="+
				obj.menu_url+"></div>";
				right_content.html(str);

			}else if(obj.menu_type == 'click'){
				var key = obj.menu_key;
				$.ajax({
					url : './selfmenu/get_clickmenu?key=' + key,
					type : 'GET',
					success : function(response){
						str = "<div class='click_menu'><p>订阅者点击该菜单会收到以下信息</p><div class='reply_wrap'>"+
						response+"</div></div>";
						right_content.html(str);
					}
				});
			}			
		}
		//添加控件
		function add_tool(){
			$('#selfmenu_content .left_content ul').sortable();
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
				$(addDOM).appendTo("#news_content");

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
		}
		add_tool();

		function blind_event(){
			var left_content = $('#selfmenu_content .left_content');     //左菜单
			var selfmenu_modal = $('#selfmenu_modal .modal');            //模态框
			var menu_type= selfmenu_modal.find('.btn-group .add_type');  //菜单类型 click/view
			var submit = selfmenu_modal.find('.sub_button');             //提交按钮
			var sub_type = selfmenu_modal.find('.sub_type');             //提交类型 add/update

			var menu_name = selfmenu_modal.find('.menu_name');           //菜单名称
			var menu_url = selfmenu_modal.find('.menu_url');
			var menu_order = selfmenu_modal.find('.menu_order');
			var menu_parent = selfmenu_modal.find('.menu_parent');
			var selfmenu_id = $('#selfmenu_modal #selfmenu_id');

			var autoreply_type = $('#selfmenu_modal #autoreply_type');
			var text = selfmenu_modal.find('#reply_content');

			//鼠标旋浮li变色
			left_content.on('mouseover', 'li', function(){
				$(this).addClass('blue_background');
				$(this).find('.edit_icon').show();
			});
			left_content.on('mouseout', 'li', function(){
				$(this).removeClass('blue_background');
				$(this).find('.edit_icon').hide();
			});
			//点击左边菜单，右边显示内容
			left_content.on('click', 'li', function(){
				var obj = get_by_id($(this).data('id'));
				//判断是否有二级菜单
				var second_menu = get_secondmenu(obj.ID);
				var str = '';
				if(second_menu.length){
					str = "<p class='first_has_secondmenu'>已有子菜单，无法设置动作</p>";
					$('#selfmenu_content .right_content').html(str);
				}else{
					str = render_right_menu(obj);
				}
			});

			//点击添加一级菜单按钮
			$('#selfmenu_content .left_title .btn-success').click(function(){
				var ul_count = left_content.find('ul').length;
				if(ul_count>=3){
					alert('一级菜单最多只能有三个');
					return false;
				}

				$('#selfmenu_modal .menu_func').hide();
				selfmenu_modal.modal();
				sub_type.val('add_first');
				menu_order.val(ul_count + 1);
				return false;

			});

			//点击添加二级菜单按钮
			left_content.on('click', 'li .glyphicon-plus', function(event){
				var menu_ul = $(this).parent().parent().parent();
				var second_menu_count = menu_ul.find('li').length;
				//上级菜单id
				menu_parent.val(menu_ul.find('li:eq(0)').data('id'));
				if(second_menu_count >= 6){
					alert('一级菜单下最多能添加5个二级菜单!');
					return false;
				}

				selfmenu_modal.modal();
				//为提交按钮分类  添加一级菜单add_first 添加二级菜单add_second
				sub_type.val('add_second');
				menu_order.val(second_menu_count);
				return false;
			});
			//点击删除按钮
			left_content.on('click', 'li .glyphicon-trash', function(event){
				var menu_li = $(this).parent().parent();
				var menu_level = menu_li.attr('class').split(' ')[0];
				var id = menu_li.data('id');
				var type = menu_li.data('type');
				var choice = true;
				if(menu_level == 'first_menu'){
					choice = confirm('删除该菜单后，子菜单也会被一同删除！');
				}else if(menu_level == 'second_menu'){
					choice = confirm('确认删除该菜单！');
				}
				if(!choice){
						return false;
				}

				$.ajax({
					url : './selfmenu/dele_menu?id='+id+"&menu_level="+menu_level+'&menu_type='+type,
					type : 'GET',
					success : function(){
						location.href = '';
					}
				});
				return false;
			});
			//点击编辑按钮
			left_content.on('click', 'li .glyphicon-pencil', function(event){
				var menu_li = $(this).parent().parent();
				var menu_level = menu_li.attr('class').split(' ')[0];
				var id = menu_li.data('id');
				var obj = get_by_id(id);
				//判断是否有二级菜单
				var second_menu = get_secondmenu(obj.ID);
				var str = '';
				var right_content = $('#selfmenu_content .right_content');
				//在模态框中加入id 方便修改保存
				selfmenu_id.val(id);
				sub_type.val('update');
				menu_order.val(obj.menu_order);
				//有子菜单 只需修改菜单名
				if(second_menu.length){
					$('#selfmenu_modal .menu_func').hide();
					menu_name.val(obj.menu_name);
					selfmenu_modal.modal();
				}else{
					//无子菜单
					if(obj.menu_type == 'view' ||obj.menu_type == ''){
						$('#selfmenu_modal .menu_func').show();
						menu_type.val('view');
						selfmenu_modal.find('.jump_url').show();
						selfmenu_modal.find('.info_content').hide();

						menu_name.val(obj.menu_name);
						menu_url.val(obj.menu_url);
						menu_type.val('view');
						selfmenu_modal.modal();

					}else if(obj.menu_type == 'click'){
						$('#selfmenu_modal .menu_func').show();
						selfmenu_modal.find('.info_content').show();
						
						selfmenu_modal.modal();

						menu_name.val(obj.menu_name);
						menu_type.val('click');

						var key = obj.menu_key;
						$.ajax({
							url : './selfmenu/get_menu_info?key=' + obj.menu_key,
							type : 'GET',
							success : function(response){
								var data = JSON.parse(response);
								var edit_type = data.edit_type;
								//自动回复信息
								var replys = data.replys;
								if(edit_type == 'text'){
									var content = replys.autoreply_content;
									$('#selfmenu_modal #reply_content').val(content);
								}else if(edit_type == 'music'){
									$('#selfmenu_modal #music_title').val(replys.music_title);
									$('#selfmenu_modal #music_description').val(replys.music_description);
									$('#selfmenu_modal #music_url').val(replys.music_url);
									$('#selfmenu_modal #hqmusic_url').val(replys.hqmusic_url);

								}else if(edit_type == 'news'){
									var news = replys.news;
									var addDOM = '';
									for(var i=0,len=news.length; i<len; i++){
										var one_new = news[i];
										addDOM += '<tr id="article'+
												one_new.article_order+'" class="article"><td class="article_order">'+
												one_new.article_order+'</td><td class="article_title">'+
												one_new.article_title+'</td><td class="article_description">'+
												one_new.article_description+'</td><td class="article_url">'+
												one_new.article_url+'</td><td class="article_pic_url">'+
												one_new.article_pic_url+'</td><td><button type="button" class="btn btn-info btn-sm edit">修改</button><button type="button" class="btn btn-danger btn-sm delete">删除</button></td></tr>';
									}
									$(addDOM).appendTo("#selfmenu_modal #news_content");
								}
							},
						});
					}

				}
				return false;		
			});			

			//点击菜单功能选项
			selfmenu_modal.find('.btn-group .send').click(function(){
				menu_type.val('click');
				selfmenu_modal.find('.jump_url').hide();
				selfmenu_modal.find('.info_content').show();
			});
			selfmenu_modal.find('.btn-group .jump').click(function(){
				menu_type.val('view');
				selfmenu_modal.find('.jump_url').show();
				selfmenu_modal.find('.info_content').hide();
			});
			//点击提交按钮
			submit.click(function(){
				var articles = new Array();
				$('.article').each(function(){
					var article = new Object();
					// article.news_id = ID;
					article.news_type = 'auto_reply';
					article.article_order       = $(this).children(".article_order").html();
					article.article_title       = $(this).children(".article_title").html();
					article.article_description = $(this).children(".article_description").html();
					article.article_url         = $(this).children(".article_url").html();
					article.article_pic_url     = $(this).children(".article_pic_url").html();
				 	articles.push(article);
				});
				var music = new Object();
				if(autoreply_type.val() == 'music'){
					music.music_title      = $('#music_title').val();
					music.music_description = $('#music_description').val();
					music.music_url         = $('#music_url').val();
					music.hqmusic_url      = $('#hqmusic_url').val();
				}

				if(sub_type.val() == 'add_first'){
					$.ajax({
						url : './selfmenu/add_firstmenu',
						type : 'GET',
						data : {
							menu_name   : menu_name.val(),
							menu_order  : menu_order.val(),
							menu_parent : 0,
						},
						success : function(){

						}
					});

				}else if(sub_type.val() == 'add_second'){
					$.ajax({
						url : './selfmenu/add_secondmenu',
						type : 'POST',
						data : {
							menu_type      : menu_type.val(),
							menu_name      : menu_name.val(),
							menu_url       : menu_url.val(),
							menu_order     : menu_order.val(),
							menu_parent    : menu_parent.val(),
							autoreply_type : autoreply_type.val(),
							text           : text.val(),
							music          : music,
							news           : articles,
						},
						success : function(){

						}
					});

				}else if(sub_type.val() == 'update'){
					$.ajax({
						url: './selfmenu/update_selfmenu',
						type: 'POST',
						data : {
							sm_id 		   : selfmenu_id.val(),
							menu_type      : menu_type.val(),
							menu_name      : menu_name.val(),
							menu_url       : menu_url.val(),
							menu_order     : menu_order.val(),
							menu_parent    : menu_parent.val(),
							autoreply_type : autoreply_type.val(),
							text           : text.val(),
							music          : music,
							news           : articles,
						},
						success: function(response){

						}
					});
				}
				selfmenu_modal.modal('hide');
				// location.href = '';
			});
			//关闭模态框，刷新页面
			selfmenu_modal.on('hidden.bs.modal', function(e){
				location.href = '';
			});
			//发布自定义菜单
			$('#selfmenu_content .panel-footer .btn_submit').click(function(){
				$.ajax({
					url : './selfmenu/create_selfmenu',
					type : 'GET',
					success : function(){
						alert('发布成功！');
					}
				});
			});
			//删除自定义菜单
			$('#selfmenu_content .panel-footer .btn_cancle').click(function(){
				$.ajax({
					url : './selfmenu/delete_selfmenu',
					type : 'GET',
					success : function(){
						alert('删除成功！');
					}
				});
			});
		}

		blind_event();

	});
</script>
