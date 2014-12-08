
<form id="upload" action="http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=<?php echo $access_token;?>&type=<?php echo $type;?>" method="POST" enctype="multipart/form-data" >
	<input type="file" data-type="file" name="media" / >
	<input type="submit" class="submit" id="submit" value="提交">
</form>


<script type="text/javascript">
	$(document).ready(function() {
		var options = { 		     
		    success:    showResponse,
		    dataType: 'jsonp',
		    type: 'post'
		}; 




		
			$("#upload").ajaxForm(options);
		
	})

	function showResponse(responseText)  { 
    // for normal html responses, the first argument to the success callback 
    // is the XMLHttpRequest object's responseText property 
 
    // if the ajaxForm method was passed an Options Object with the dataType 
    // property set to 'xml' then the first argument to the success callback 
    // is the XMLHttpRequest object's responseXML property 
 
    // if the ajaxForm method was passed an Options Object with the dataType 
    // property set to 'json' then the first argument to the success callback 
    // is the json data object returned by the server 
 
    alert('status: ' + responseText ); 
} 



	</script>

