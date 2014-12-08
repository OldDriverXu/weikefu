<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class System_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->load->helper('url');
			$this->load->database();
			$this->config->load('weixin_config',TRUE);	
			require_once APPPATH.'libraries/common/GlobalFunctions.php';		
		}	

		public function check_signature($signature, $timestamp, $nonce){
			$token  = $this->config->item('token', 'weixin_config');
			$tmpArr = array($token, $timestamp, $nonce);
			sort($tmpArr);
			$tmpStr = implode( $tmpArr );
			$tmpStr = sha1( $tmpStr );
			
			if( $tmpStr == $signature ){
				return true;
			}else{
				return false;
			}
		}

		public function get_access_token(){
			$expire_timestamp = $this->get_expires();
			$token = $this->get_token();
			$now_timestamp = getTime();			

			if ($now_timestamp < $expire_timestamp){
				//未超时				
				return $token;			
			}else{
				//超时
				$grant_type = $this->config->item('grant_type', 'weixin_config');
				$appid      = $this->config->item('appid', 'weixin_config');
				$secret     = $this->config->item('secret', 'weixin_config');

				$post_url   = $this->config->item('access_token_url', 'weixin_config');
				$post_string   = "grant_type=".$grant_type."&appid=".$appid."&secret=".$secret;		
				$curl_result = doCurlPostRequest($post_url, $post_string);
		
				$output_array = json_decode($curl_result,true);

				if(!$output_array || $output_array['errcode']){
					interface_log(ERROR, EC_OTHER, 'request wx to get token error');
					return false;
				}
				//从返回的数据中获得access_token和它的过期时间
				$token   = $output_array['access_token'];
				$expires = $output_array['expires_in'] +$now_timestamp-30; //$output_array['expires_in'] = 7200; 正常情况下access_token有效期为7200秒
				$this->update_token($token);
				$this->update_expires($expires);			

				return $token;



			}
		}		

		private function get_token(){
			$this->db->from('wx_options');
			$this->db->where('option_name', 'access_token');
			$this->db->select('option_value');			
			$query = $this->db->get();
			$result = $query->result_array();

			if($result){
				return $result[0]['option_value'];
			}else{
				return NULL;
			}
		}

		private function update_token($token){
			$array = array(
					'option_name' => 'access_token',
					'option_value' => $token
				);			
			$this->db->where('option_name', 'access_token');
			$this->db->update('wx_options', $array);
		}

		private function get_expires(){
			$this->db->from('wx_options');
			$this->db->where('option_name', 'expires');
			$this->db->select('option_value');
			$query = $this->db->get();
			$result = $query->result_array();

			if($result){
				return $result[0]['option_value'];
			}else{
				return NULL;
			}
		}

		private function update_expires($expires){
			$array = array(
					'option_name' => 'expires',
					'option_value' => $expires
				);			
			$this->db->where('option_name', 'expires');
			$this->db->update('wx_options', $array);
		}
	}
?>