<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class User_model extends CI_Model
	{
		public function __construct(){		
			parent::__construct();			
	    	$this->load->database();	          	        
		}

		public function get_user($username){
			$this->db->from('wx_users');
			$this->db->where('user_login', $username);
			$query = $this->db->get();
			$result = $query->result();					

			if($result){
				return $result;
			}else{
				return NULL;
			}
		}

		/* $array = array(
		| 		'user_login'                   => $username,
		| 		'user_pass'                    => $password,
		| 		'user_nickname'                => $user_nickname,
		| 		'user_email'                   => $user_email,
		| 		'user_headimgurl'              => $user_headimgurl,	
		|       'user_registered'              => $datetime,
		| 		'user_registered_timestamp'    => $timstamp,
		|		'user_group'     			   => $user_group,
		| 		'user_status'                  => $user_status
		| 	);
		*/
		public function set_user($array){
			foreach ($array as $key => $value) {
				if ($value){
					$data[$key] = $value;
				}				
			}
			$this->db->insert('wx_users', $data);
		}

		public function update_user($array){
			foreach ($array as $key => $value) {
				if ($value){
					$data[$key] = $value;								
				}				
			}
			$this->db->where('user_login', $data['user_login']);
			$this->db->update('wx_users', $data);
		}

		public function delete_user($username){
			$this->db->where('user_login', $username);
			$this->db->delete('wx_users');
		}
	}
?>