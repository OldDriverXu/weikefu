<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	require_once APPPATH.'models/advanced/advanced_base_reply.php';
	
	//客服文本接口
	class Advanced_text_reply extends Advanced_base_reply
	{	
		private $content;      // 文本消息内容

		public function __construct(){		
			parent::__construct();			
		}

		public function init($array){
			//获取共有参数
			$this->to_username = (string) trim($array['reply_to_username']);  
			$this->rly_type    = (string) trim($array['reply_type']);

			//私有参数
			$this->content = (string) trim($array['reply_content']);

			
			if(!($this->to_username && $this->rly_type)){
				return false;
			}
			
			//信息入库
			$data = array(
				'reply_to_username'      => $array['reply_to_username'],
				'reply_date'             => date('Y-m-d H:i:s', $array['reply_date_timestamp']),
				'reply_date_timestamp'   => $array['reply_date_timestamp'],
				'reply_user'             => $array['reply_user'],
				'reply_user_IP'          => $array['reply_user_ip'],
				'reply_content'          => $this->content,
				'reply_title'            => $array['reply_title'],
				'reply_excerpt'          => $array['reply_excerpt'],
				'reply_type'             => $this->rly_type,
				'reply_status'           => $array['reply_status'],
				'reply_parent'           => $array['reply_parent']
				);
			$this->set_reply($data);
			return true;
		}

		public function post_json(){
			$data = array(
					'touser'  => $this->to_username,
					'msgtype' => $this->rly_type,
					'text'    => array(
							'content' => urlencode($this->content)
						)	
				);
			return urldecode(json_encode($data));
		}

		public function get_reply_content(){
			return $this->content;
		}
		
		public function set_reply_content($text){
			$this->content = $text;
		}
		
		
	}
?>