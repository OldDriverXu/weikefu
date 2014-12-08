<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Advanced_base_reply extends CI_Model
	{
		public $to_username;     // 普通用户openid
		public $rly_type;        // 消息类型，text

		public function __construct(){		
			parent::__construct();		
	    	$this->load->database();
	    	require_once APPPATH.'libraries/common/GlobalFunctions.php';	         	        
		}

		//发送给微信服务器
		public function post_to_weixin($access_token,$json){
			if($access_token == "" || $json == "" ){
				return false;
			}
			$post_url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send';
			$curl_url = $post_url.'?access_token='.$access_token;
			$curl_result =doCurlPostRequest($curl_url, $json);	
			
			return $curl_result;
		}
		public function set_to_username($username){
			$this->to_username = $username;
		}		
		public function get_rly_type(){
			return $this->rly_type;
		}
		public function set_rly_type($type){
			$this->rly_type = $type;
		}

		/* $array = array(
		| 		'reply_to_username'      => $reply_to_username,
		| 		'reply_date'             => date('Y-m-d H:i:s', $reply_timestamp),
		| 		'reply_date_timestamp'   => $reply_timestamp,
		|		'reply_user'             => $reply_user,
		|		'reply_user_IP'          => $reply_user_ip,
		| 		'reply_content'          => $reply_content,
		| 		'reply_title'            => $reply_title,
		| 		'reply_excerpt'          => $reply_excerpt,
		| 		'reply_type'             => $reply_type,
		| 		'reply_status'           => $reply_status,
		| 		'reply_parent'           => $reply_parent
		| 	);
		*/
		public function get_reply($array){
			foreach ($array as $key => $value) {
				if ($value){
					$data[$key] = $value;
				}				
			}			 
			$this->db->from('wx_reply');
			$this->db->where($data);
			$query = $this->db->get();
			$query = $query->result_array();			
			return $query;
		}

		/* $array = array(
		| 		'reply_to_username'      => $reply_to_username,
		| 		'reply_date'             => date('Y-m-d H:i:s', $reply_timestamp),
		| 		'reply_date_timestamp'   => $reply_timestamp,
		|		'reply_user'             => $reply_user,
		|		'reply_user_IP'          => $reply_user_ip,
		| 		'reply_content'          => $reply_content,
		| 		'reply_title'            => $reply_title,
		| 		'reply_excerpt'          => $reply_excerpt,
		| 		'reply_type'             => $reply_type,
		| 		'reply_status'           => $reply_status,
		| 		'reply_parent'           => $reply_parent
		| 	);
		*/
		public function set_reply($array){
			foreach ($array as $key => $value) {
				if ($value){
					$data[$key] = $value;
				}				
			}			
			$this->db->insert('wx_reply', $data); 
			return $this->db->insert_id();
		}

		public function update_reply($array){
			foreach ($array as $key => $value) {
				if ($value){
					$data[$key] = $value;
				}				
			}			
			$this->db->where('ID', $data['ID']);
			$this->db->update('wx_reply', $data); 
		}
	}
?>