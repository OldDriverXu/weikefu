<div id='reply_content'>
	<table  id='reply_his' class='table table-hover'>
		<thead>
			<tr id='form_title'>
				<th>序号<input type='checkbox' class='check' id='select_all'></th>
				<th>关键词</th>
				<th>回复类型</th>
				<th>回复内容</th>
				<th>编辑</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
	<div class='last'>
		<input type='button' value='删除' id='dele' class='btn btn-warning btn-sm'>
		<span id='firstspan' class='pagination'><<</span>
		<span id='page_num'>111</span>
		<span class='pagination'>>></span>
		<input class='jump form-control'>
		<button class='btn btn-success btn-sm'>跳转</button>
	</div>
</div>

<div id='autoreply_modal'>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">修改自动回复</h4>
	      </div>
	      <div class="modal-body">
	        ...
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	        <button type="button" class="btn btn-primary">保存修改</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>

<script>
	$(document).ready(function(){
		var auto_reply_his_data = new Array();             //存储数据
		var first_display = 0;
		function get_auto_reply(page_num){
			$.ajax({
				url: './auto_reply/get_min_auto_reply',
				type: 'GET',
				success: function(response){
					auto_reply_his_data = eval(response);	
					pagination(page_num);				
				}
			});
		}
		get_auto_reply(1);
		//分页
		function pagination(page_num){
			var page_size = 10;                 //每页记录数
			var rows = auto_reply_his_data.length;            //总记录数
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
			var data = auto_reply_his_data.slice(start_row_num, end_row_num);

			var str = '';
			for(var i=0,len=data.length;i<len;i++){
				str += "<tr data-order="+data[i]['ID']+"><td><span>"+
						data[i]['ID']+"</span><input type='checkbox' class='check'></td><td calss='keyword'>"+
						data[i]['autoreply_keyword']+"</td><td class='reply_type'>"+
						data[i]['autoreply_type']+"</td><td><div class='reply_content hide'>"+
						data[i]['autoreply_content']+"</div><input type='button' value='查看' class='show_content btn btn-info'></td><td>"+
						"<input type='button' value='修改' class='edit btn btn-info'></td></tr>"
			}
			var display_page_num = page_num + '/' + max_page;
		    $('#reply_his tbody tr').remove();         
			$('#reply_his tbody').append(str);
			$('#page_num').html(display_page_num);
		}
		//点击前后页
		$('#reply_content').on('click', '.last .pagination', function(){
			var page_num = parseInt($('#page_num').html());
			if(this.id=='firstspan'){
				page_num--;
			}else{
				page_num++;
			}
			pagination(page_num);
		});
		//点击跳转
		$('#reply_content').on('click', '.last button', function(){
			var jump = $.trim($('tr.last .jump').val());
			if(!isNaN(jump)){
				pagination(jump);
			}
		});
		//input中点击回车
		$('#reply_content').on('keyup', '.last .jump', function(){
			var jump = $.trim($('tr.last .jump').val());
			if((event.keyCode==13)&&(!isNaN(jump))){
				pagination(jump);
			}
		});

		//全选
		$('#select_all').click(function(){
			if($(this).attr('checked') == 'checked'){
				$('input.check').attr('checked','checked');
			}else{
				$('input.check').removeAttr('checked');
			}
		});
		//点击查看
		$("#reply_his").on('click','.show_content',function(){
			var type = $(this).parent().prev().html();
			$('#autoreply_modal #myModal').modal();
			var id = $(this).parent().parent().data('order');
			if(type=='text'){
				$('.modal-body').html($(this).prev().html());
			}else if(type=='news'){
				$.ajax({
					url : './auto_reply/get_news?ID='+id,
					type : 'GET',
					success : function(response){
						$('.modal-body').html(response);
					}
				});
			}else if(type=='music'){
				$.ajax({
					url : './auto_reply/get_music?ID='+id,
					type : 'GET',
					success : function(response){
						$('.modal-body').html(response);
					}
				});
			}
			$('button.btn-primary').hide();
			$('#autoreply_modal #myModalLabel').html('查看自动回复');
 		});
		//删除
		$('#reply_content').on('click','#dele',function(){
			if(!confirm('确认删除信息')){
				return;
			}
			var selected = new Array();
			var count = 0
			$('input.check').not($('#select_all')).each(function(i){
				if($(this).attr('checked')=='checked'){
					selected[count] = $(this).parent().parent().data('order');
					count++;
				}
			});
			if(count){
				var selected_url = selected.join(',');
				$.ajax({
					url: './auto_reply/delete_reply?ids='+selected_url,
					type: 'GET',
					success: function(response){
						var page_num = parseInt($('#page_num').html());
						get_auto_reply(page_num);
					}
				});
			}
		});
		//修改
		$('#reply_his').on('click','input.edit',function(){
			var tr = $(this).parent().parent();
			var id = tr.find('span:first').html();
			var keyword = tr.find('keyword').html();
			var type = tr.find('.reply_type').html();
			$.ajax({
				url: './auto_reply/get_message?type='+type+'&id='+id,
				type: 'GET',
				success: function(response){
					$('#autoreply_modal #myModal').modal();
					$('.modal-body').html(response);
					$('button.btn-primary').show();
					$('#autoreply_modal #myModalLabel').html('修改自动回复');
				}
			});
		});


	});
</script>