<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	header("Content-Type: text/html; charset=utf-8");

	class Reply extends CI_Controller
	{

		public function __construct(){
			parent::__construct();
			$this->load->model('system_model');
			$this->load->model('advanced/advanced_base_reply');
			$this->load->model('advanced/advanced_text_reply'); 
			$this->load->model('advanced/advanced_image_reply'); 
			$this->load->model('advanced/advanced_music_reply'); 
			$this->load->model('advanced/advanced_news_reply'); 
			$this->load->model('advanced/advanced_voice_reply'); 
			$this->load->model('advanced/advanced_video_reply');
			$this->load->model('advanced/advanced_media');

			$this->load->model('message/base_message');
			$this->load->model('message/text_message');
			$this->load->model('message/image_message');
			$this->load->model('message/link_message');
			$this->load->model('message/location_message');
			$this->load->model('message/video_message');
			$this->load->model('message/voice_message');

			$this->load->model('personnel/user_model');
			$this->load->model('personnel/follower_model');

			$this->load->model('session_model');

			$this->load->library('parser');
			$this->load->helper(array('form', 'url'));
		}

		public function index(){

			$header['title'] = "客服回复";
			$this->load->view('templates/header', $header);	

			$data['reply_user'] ="海豚君";
			$data['reply_user_IP'] ="";	
			//$sessions = $this->session_model->get_unclosed_sessions();
			
			$this->load->view('reply/index',$data);
			$this->load->view('templates/footer');
 
		}

		//发送客服回复
		public function postform(){
			$access_token = $this->system_model->get_access_token();

            $replyArray = array(
            		'reply_to_username'      => $_POST['reply_to_username'],
            		'reply_date_timestamp'   => getTime(),
            		'reply_user'             => $_POST['reply_user'],
            		'reply_user_IP'          => $_POST['reply_user_ip'],			
					'reply_title'            => $_POST['reply_title'],
					'reply_excerpt'          => $_POST['reply_excerpt'],
					'reply_type'             => $_POST['reply_type'],
					'reply_status'           => $_POST['reply_status'],
					'reply_parent'           => $_POST['reply_parent']
            	);

            switch ($_POST['reply_type']) {
            	case 'text':
            		$replyArray['reply_content']     = $_POST['reply_content'];
            		break;

            	case 'image':
            		$replyArray['pic_media_id']      = $_POST['pic_media_id'];
            		         		
            		break;

            	case 'music':
            		$replyArray['music_title']       = $_POST['music_title'];
            		$replyArray['music_description'] = $_POST['music_description'];
            		$replyArray['music_url']         = $_POST['music_url'];
            		$replyArray['hqmusic_url']       = $_POST['hqmusic_url'];
            		$replyArray['thumb_media_id']    = $_POST['thumb_media_id'];
            		break;

            	case 'video':
            		$replyArray['video_media_id']    = $_POST['video_media_id'];
            		$replyArray['video_title']       = $_POST['video_title'];
            		$replyArray['video_description'] = $_POST['video_description'];
            		break;

        		case 'voice':
        			$replyArray['voice_media_id']    = $_POST['voice_media_id'];
        			break;

        		case 'news':  
        			$replyArray['articles'] = $_POST['articles'];
        			break;
            	
            	default:
            		# code...
            		break;
            }            
            

         	//客服回复
			function AdvancedReply($type){
				switch ($type) {
					case 'text':
						return new Advanced_text_reply();
					case 'image':
						return new Advanced_image_reply();
					case 'music':
						return new Advanced_music_reply();
					case 'video':
						return new Advanced_video_reply();
					case 'news':
						return new Advanced_news_reply();
					case 'voice':
						return new Advanced_voice_reply();
					
					default:
						# code...
						break;
				}
			}			
			$advancedReply = AdvancedReply($replyArray['reply_type']);
			//客服回复初始化、入库
			$advancedReply->init($replyArray);
			//将客服回复发给微信服务器
			$access_token = $this->system_model->get_access_token();
			$postJson = $advancedReply->post_json();
			// var_dump($access_token);
			// var_dump($postJson);
		
			$replyJson = $advancedReply->post_to_weixin($access_token,$postJson);
			//var_dump($replyJson);
		}


		//获取粉丝来言
		private function _get_message($username, $timestamp){
			// $access_token = $this->system_model->get_access_token();

			//获取粉丝昵称和头像
			$follower = $this->follower_model->get_follower($username);
			$nickname = $follower['follower_nickname'];
			$headimg  = $follower['follower_headimgurl'];

			//获取粉丝message
			$input = array('message_username' => $username, 'message_date_timestamp >=' =>$timestamp);			
			$base_message = $this->base_message->get_message($input);

			if($base_message){
				$i=0;
				foreach ($base_message as $message) {
					//将该条消息设置为已读
					$update = array('ID' => $message['ID'], 'message_status' =>'read');
					$this->base_message->update_message($update);

					//缓存数组清空
					$temp = array();

					$temp['type'] = 'message';
					$temp['nickname'] = $nickname;
					$temp['headimg'] = $headimg;
					$temp['date'] = $message['message_date'];
					$temp['date_timestamp']	= $message['message_date_timestamp'];

					switch ($message['message_type']) {
					 	case 'text':
					 		# code...
					 		$temp['content'] = $message['message_content'];
					 		break;

					 	case 'image':
					 	    $image = $this->image_message->get_pic($message['ID']);	
					 	    $temp['content'] = '<a href="'.$image['pic_url'].'" target="_blank"><img src="'.$image['pic_url'].'"></a>' ;		 		
					 		break;

					 	case 'link':
					 		$link = $this->link_message->get_link($message['ID']);
					 		$temp['content'] = '<a href="'.$link['link_url'].'" target="_blank">'.$link['link_title'].'</a>'.'<span>'.$link['link_description'].'</span>';
					 		break;

					 	case 'location':
					 		$location = $this->location_message->get_location($message['ID']);
					 		$temp['content'] = '地理位置信息:'.$location['label'];
					 		break;

					 	case 'video':
					 		$video = $this->video_message->get_video($message['ID']);
					 		$temp['content'] = '视频ID:'.$video['video_media_id'];
					 		break;

					 	case 'voice':
					 		$voice = $this->voice_message->get_voice($message['ID']);
					 		//$voice_file = $this->advanced_media->get($access_token, $voice['voice_media_id']);
					 		$temp['content'] = '语音ID:'.$voice['voice_media_id'];
					 		break;
					 	
					 	default:				 		
					 		return NULL;
					}				  
					$result[$i++]= $temp;
				}
			}
			return $result;			
			// $data=array('message' => $result);
			// $string = $this->parser->parse('reply/get_message', $data);  //返回给ajax请求
		}

		//获取客服回复
		private function _get_reply($reply_to_username, $timestamp){	

			//获取客服昵称和头像
			//$user     = $this->user_model->get_user($username);
			$nickname = '海豚君';
			$headimg  = 'http://cn.dolphin.com';

			//获取客服reply
			$input = array('reply_to_username' => $reply_to_username, 'reply_date_timestamp >=' => $timestamp);
			$base_reply = $this->advanced_base_reply->get_reply($input);
			if($base_reply){
				$i=0;
				foreach ($base_reply as $reply) {
					//将该条回复设置为已读
					$update = array('ID' => $reply['ID'], 'reply_status' =>'read');
					$this->advanced_base_reply->update_reply($update);

					//缓存数组清空
					$temp = array();

					$temp['type'] = 'reply';
					$temp['nickname'] = $nickname;
					$temp['headimg'] = $headimg;
					$temp['date'] = $reply['reply_date'];
					$temp['date_timestamp']	= $reply['reply_date_timestamp'];

					switch ($reply['reply_type']) {
					 	case 'text':					 		
					 		$temp['content'] = $reply['reply_content'];
					 		break;

					 	case 'image':
					 	    $image = $this->advanced_image_reply->get_pic($reply['ID']);
					 	    $temp['content'] = '图片ID：'.$image;	
					 		break;

					 	case 'music':
					 		$music = $this->advanced_music_reply->get_music($reply['ID']);
					 		$temp['content'] = '<a href="'.$music['music_url'].'" target="_blank">'.$music['music_title'].'</a>'.'<span>'.$music['music_description'].'</span>';
					 		break;

					 	case 'video':
					 		$video = $this->advanced_video_reply->get_video($reply['ID']);
					 		$temp['content'] = $video['video_title'].'<br/>'.$video['video_description'].'<br/>'.'视频ID：'.$video['video_media_id'];

					 	case 'voice':
					 		$voice = $this->advanced_voice_reply->get_voice($reply['ID']);
					 		$temp['content'] = '语音ID:'.$voice['voice_media_id'];
					 		break;

					 	case 'news':
					 		$news = $this->advanced_news_reply->get_news($reply['ID'],'reply');
					 		if($news){
					 			for($i=0; $i<count($news); $i++){
					 				$news[$i]['title']       = urldecode($news[$i]['title']);
					 				$news[$i]['description'] = urldecode($news[$i]['description']);
					 				$news[$i]['url']         = urldecode($news[$i]['url']);
					 				$news[$i]['picurl']      = urldecode($news[$i]['picurl']);
					 			}
					 		}
					 		$data['news'] = $news;	
					 		if($news){
								$temp['content'] = $this->parser->parse('reply/get_news', $data, TRUE);
							}else{
								$temp['content'] = "图文已损坏";
							}
					 		break;			 	
					 	
					 	default:				 		
					 		return NULL;
					}				  
					$result[$i++]= $temp;
				}
			}			
			return $result;

			//$data=array('reply' => $result);
			//$string = $this->parser->parse('reply/get_reply', $data);  //返回给ajax请求		
		}

		//获取正在进行的会话
		public function get_unclosed_sessions(){
			$sessions = $this->session_model->get_unclosed_sessions();

			if($sessions){
				for ($i=0; $i<count($sessions); $i++) { 
					$follower = $this->follower_model->get_follower($sessions[$i]['message_username']);

					//获取未读message
					$unread = array('message_username' => $sessions[$i]['message_username'], 'message_date_timestamp >=' =>$sessions[$i]['session_start_timestamp'], 'message_status'=>'unread');
					$unread_message = $this->base_message->get_message($unread);
					$unread_num = count($unread_message);

					$data['sessions'][$i] = array(
							'message_username' => $sessions[$i]['message_username'],
							'nickname'    => $follower['follower_nickname'],
							'headimg'     => $follower['follower_headimgurl'],
							'session_start_timestamp' => $sessions[$i]['session_start_timestamp'],
							'unread'      => $unread_num
						);					
				}
			}
			if($data){
				$string = $this->parser->parse('reply/get_follower', $data); //返回给ajax
			}else{
				echo "暂时没有新留言";
			}
			
		}

		public function get_session($username, $timestamp){			
			$con1 = $this->_get_message($username, $timestamp);
			$con2 = $this->_get_reply($username, $timestamp);			
			//conversation：message 和 reply 合并
			if (is_array($con1)&&is_array($con2)){
				$con = array_merge($con1,$con2);
			}else{
				if($con1){
					$con =$con1;
				}elseif ($con2) {
					$con =$con2;
				}				
			}

			//二维数组按照key值排序
			function _multi_array_sort($multi_array, $sort_key, $sort = SORT_ASC) {
				if (is_array($multi_array)) {
					foreach ($multi_array as $row_array) {		
						if (is_array($row_array)) {
							$key_array[] = $row_array[$sort_key];
						} else {
							return FALSE;
						}
					}
				} else {
					return FALSE;
				}
				array_multisort($key_array, $sort, $multi_array);
				return $multi_array;
			}

			//conversation按照时间排序
			if($con){
				$data['sessions'] = _multi_array_sort($con, 'date_timestamp');
			}
			if($data){
				$string = $this->parser->parse('reply/get_session', $data); //返回给ajax
			}			
		}


	}
?>
