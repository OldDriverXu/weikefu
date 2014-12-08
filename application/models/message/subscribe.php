<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	require_once APPPATH.'models/message/base_message.php';

	//自动回复消息
	class Subscribe extends Base_message
	{	
		private $content;    // 事件类型  

		public function __construct(){
			parent::__construct();
			$this->load->model('system_model');
			$this->load->model('autoreply/base_reply');
			$this->load->model('autoreply/text_reply'); 
			$this->load->model('autoreply/music_reply'); 
			$this->load->model('autoreply/news_reply');
			$this->load->model('personnel/follower_model');

			$this->load->library('parser');
			$this->load->helper(array('form', 'url'));
			$this->access_token = $this->system_model->get_access_token();			        	        
		}

		public function init($weixin_array){
			// 获取共有参数
			$this->from_username = (string) trim($weixin_array['FromUserName']);
			$this->to_username   = (string) trim($weixin_array['ToUserName']);
			$this->create_time   = (int)    trim($weixin_array['CreateTime']);
			$this->msg_type      = (string) trim($weixin_array['MsgType']);

			// 私有参数
			$this->content       = (string) trim($weixin_array['Event']);
			if(!($this->from_username && $this->to_username && $this->msg_type)){
				return false;
			}
			// 消息入库
			$array = array(
					'message_username'       => $this->from_username,
					'message_date'		     => date('Y-m-d H:i:s', $this->create_time),
					'message_date_timestamp' => $this->create_time,
					'message_content'        => $this->content,
					'message_type'           => $this->msg_type,
					'message_status'         => 'unread'
				);
			$this->set_message($array);
			//自动回复欢迎语
			$array_subscribe = array(
				'autoreply_to_username' => $this->from_username, 
				'autoreply_from_username' => $this->to_username	
			);
			$this->reply_welcome($array_subscribe);

			$follower_model = $this->follower_model;
			$result = $follower_model->get_follower_info($this->access_token,$this->from_username);
			// var_dump($result);
			$follower_model->set_follower($result);
			die;
		}

		public function get_text_content(){
			return $this->content;
		}
		
		public function set_text_content($text){
			$this->content = $text;
		}

		// $array = array(
		// 		'autoreply_to_username' =>,
		// 		'autoreply_from_username' =>,
		// 		'autoreply_type'=>,
		// 		'autoreply_content' =>
		// 	)
		public function reply_welcome($array){
			$query = $this->db->get_where('wx_autoreply',array('ID'=>1));
			$result = $query->result_array();
			$type = $result[0]['autoreply_type'];
			$array['autoreply_type'] = $type;			
			$xml ='';
			switch ($type) {
				case 'text':
					$array['autoreply_content'] = $result[0]['autoreply_content'];
					$xml = $this->text_reply->create_xml($array);
					break;
				case 'news':
					$news = $this->news_reply->get_news(1,'welcome');
					$array['autoreply_content'] = $news;
					$xml = $this->news_reply->create_xml($array);
					break;
				default:
					# code...
					break;
			}		
			//echo $xml;
			var_dump($xml);
			interface_log(INFO, EC_OK, "***********************************");
			interface_log(INFO, EC_OK, "***** subscribe output start *****");
			interface_log(INFO, EC_OK, 'output:' . var_export($xml, true));
		}
		public function reply_welcome2($array){
			$result = reply_type()->create_xml($array);
			return $result;
		}
	}
?>