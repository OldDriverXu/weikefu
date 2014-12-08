<div id='followers_info'>
	<div id='title'>
		<span>粉丝信息</span><button id='update_followers' class='btn btn-info btn-sm'>更新粉丝信息</button>
	</div>
	<div id='content'>
		<!-- <div class='follower'>
			<div class='icon_info'>
				<img src="../download/1390878042779.jpeg" alt="">
			</div>
			<div class='text_info'>
				<div class='first_line'>
					<span class='user_name'>张波</span><span class='user_sex'>性别:</span><span class='sex_info'>男</span>
					<span calss='telephon'>手机:</span><span class='telephon_info'>15629111879</span>
				</div>
				<div class='second_line'>
					<span class='group'>分组:</span><span class='group_info'>去酒吧找他</span><button class='group_edit'>修改分组</button>
				</div>
			</div>
			<div class='clearboth'></div>
		</div> -->
	</div>
	<div id='bottom'>
		<span id='firstspan' class='pagination'><<</span><span id='page_num'>11</span><span class='pagination'>>></span><input class='jump form-control'><button class='btn btn-success btn-sm'>跳转</button>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var followers_data = new Array();
		function get_followers_info(page_num){
			$.ajax({
				url : './follower/get_all_followers',
				type : 'GET',
				success : function(response){
					followers_data = eval(response);
					pagination(1);
				}
			});
		}
		get_followers_info()

		//分页
		function pagination(page_num){
			var page_size = 6;                 //每页记录数
			var rows = followers_data.length;            //总记录数
			var max_page = Math.ceil(rows/page_size);        //总页数
			if(page_num < 1){
				page_num = 1;
			}else if(page_num > max_page){
				page_num = max_page;
			}
			var start_row_num = (page_num-1) * page_size;   //起始记录数
			var end_row_num = page_num * page_size;         //终止记录数
			// if(end_row_num>rows){
			// 	end_row_num = rows;
			// }
			var data = followers_data.slice(start_row_num, end_row_num);

			var str = '';
			var follower_sex = 1;
			for(var i=0,len=data.length;i<len;i++){
				follower_sex = data[i]['follower_sex'];
				if(follower_sex==1){
					follower_sex = '男';
				}else if(follower_sex==0){
					follower_sex = '女';
				}else if(follower_sex==2){
					follower_sex = '未知';
				}
				str += "<div class='follower'><div class='icon_info'><img src="+
				                data[i]['follower_headimgurl']+" alt=''></div><div class='text_info'><div class='first_line'><span class='user_name'>"+
				                data[i]['follower_nickname']+"</span><span class='user_sex'>性别:</span><span class='sex_info'>"+
				                follower_sex+"</span><span calss='telephon'>城市:</span><span class='telephon_info'>"+
				                data[i]['follower_city']+"</span></div><div class='second_line'><span class='group'>分组:</span><span class='group_info'>"+
				                data[i]['follower_group']+"</span><button class='group_edit btn btn-info btn-sm'>修改分组</button></div></div><div class='clearboth'></div></div>";
				
			}
			var display_page_num = page_num + '/' + max_page;
		    $('#content .follower').remove();         
			$('#content').append(str);;
			$('#page_num').html(display_page_num);
		}
		//点击前后页
		$('#bottom span.pagination').click(function(){
			var page_num = parseInt($('#page_num').html());
			if(this.id=='firstspan'){
				page_num--;
			}else{
				page_num++;
			}
			pagination(page_num);
		});
		//点击跳转
		$('#bottom button').click(function(){
			var jump = $.trim($('#bottom .jump').val());
			if(!isNaN(jump)){
				pagination(jump);
			}
		});
		//input中点击回车
		$('#bottom .jump').keyup(function(){
			var jump = $.trim($(this).val());
			if((event.keyCode==13)&&(!isNaN(jump))){
				pagination(jump);
			}
		});

		$('#title #update_followers').click(function(){
			$.ajax({
				url : './follower/update',
				type : 'GET',
				success : function(response){
					alert('更新成功');
				}
			});
		});
	});
</script>