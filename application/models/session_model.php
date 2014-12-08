<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	require_once APPPATH.'libraries/common/GlobalFunctions.php';

	class Session_model extends CI_Model
	{
		public function __construct(){		
			parent::__construct();		
	    	$this->load->database();	          	        
		}

		public function init($weixin_array){
			//获取参数
			$message_username        = trim($weixin_array['FromUserName']);
			$session_start_timestamp = trim($weixin_array['CreateTime']);

			if(!($message_username && $session_start_timestamp)){
				return false;
			}

			//如果存在未关闭的会话
			if($session = $this->get_unclosed_session($message_username)){
				$now = getTime();
				if(($now-$session['session_start_timestamp'])>48*3600){
				//会话超时 (48小时)
					
					//关闭旧session
					$array_update  = array(
							'message_username' => $message_username,
							'session_status'   => 1,
							'session_start_timestamp' => $session['session_start_timestamp'],
							'session_end_timestamp'  => $session['session_start_timestamp']+48*3600
						);
					$this->update_session($array_update);

					//创建一个新会话
					$array_new = array(
						'message_username'        => $message_username,
						'session_status'          => 0,
						'session_start_timestamp' => $now
					);
					$this->set_session($array_new);
					return true;
				}else{
				//会话未超时
					return true;
				}				
			}else{
			//不存在，则创建一个新会话session
				$array = array(
						'message_username'        => $message_username,
						'session_status'          => 0,
						'session_start_timestamp' => $session_start_timestamp
					);
				$this->set_session($array);
				return true;
			}
		}

		public function get_sessions($username){
			$this->db->from('wx_session');
			$this->db->where('message_username',$username);
			$query = $this->db->get();
			$result = $query->result();

			if($result){
				return $result;
			}else{
				return NULL;
			}
		}

		//获取该用户正在进行的会话
		public function get_unclosed_session($username){
			$this->db->from('wx_session');
			$this->db->where('message_username',$username);
			$this->db->where('session_status', 0);		
			$query = $this->db->get();
			$result = $query->result_array();

			if($result){
				return $result[0];
			}else{
				return NULL;
			}
		}

		//获取所有正在进行的会话
		public function get_unclosed_sessions(){
			$this->db->from('wx_session');
			//$this->db->where('message_username',$username);
			$this->db->where('session_status', 0);		
			$query = $this->db->get();
			$result = $query->result_array();

			if($result){
				return $result;
			}else{
				return NULL;
			}
		}

		// $array = array(
		// 		'message_username' => $username,
		// 		'session_status'   => $status,
		// 		'session_start_timestamp'  => $start_timestamp,
		// 		'session_end_timestamp'    => $end_timestamp
		// 	);
		public function set_session($array){
			foreach ($array as $key => $value) {
				if ($value){
					$data[$key] = $value;
				}				
			}			
			$this->db->insert('wx_session', $data);
		}

		public function update_session($array){
			foreach ($array as $key => $value) {
				if ($value){
					$data[$key] = $value;
				}				
			}
			$this->db->where('message_username', $data['message_username']);
			$this->db->where('session_start_timestamp', $data['session_start_timestamp']);			
			$this->db->update('wx_session', $data);
		}

		public function delelte_session($username, $start_timestamp){
			$this->db->where('message_username', $username); 
			$this->db->where('session_start_timestamp', $start_timestamp);
			$this->db->delelte('wx_session');
		}

	}
?>