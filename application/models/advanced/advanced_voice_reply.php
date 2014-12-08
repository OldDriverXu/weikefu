<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	require_once APPPATH.'models/advanced/advanced_base_reply.php';

	//客服语音接口
	class Advanced_voice_reply extends Advanced_base_reply
	{	
		private $voice_media_id;      // 通过上传多媒体文件，得到的id

		public function __construct(){		
			parent::__construct();
		}

		public function init($array){
			//获取共有参数
			$this->to_username = (string) trim($array['reply_to_username']); 
			$this->rly_type    = (string) trim($array['reply_type']);

			//私有参数
			$this->voice_media_id       = (string) trim($array['voice_media_id']);
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
					'reply_content'          => $array['reply_content'],
					'reply_title'            => $this->rly_type,
					'reply_excerpt'          => $array['reply_excerpt'],
					'reply_type'             => $array['reply_type'],
					'reply_status'           => $array['reply_status'],
					'reply_parent'           => $array['reply_parent']
				);
			$reply_id = $this->set_reply($data);		
			$this->set_voice($reply_id, $this->voice_media_id);
			return true;
		}

		public function post_json(){
			$data = array(
					'touser'  => $this->to_username,
					'msgtype' => $this->rly_type,
					'voice'    => array(
							'media_id' => urlencode($this->voice_media_id)
						)	
				);
			return urldecode(json_encode($data));
		}
		
		public function get_voice($reply_id){
			$this->db->from('wx_replymeta');
			$this->db->where('reply_id', $reply_id);
			$this->db->where('meta_key', 'voice_media_id');
			$this->db->select('meta_value');
			$query=$this->db->get();
			$result = $query->result_array();

			if($result){
				$this->voice_media_id = $result[0]['meta_value'];
			}
			return $this->voice_media_id;
		}

		public function set_voice($reply_id, $media_id){
			$data = array(
					'reply_id' => $reply_id,
					'meta_key'   => 'voice_media_id',
					'meta_value' => $media_id
				);
			$this->db->insert('wx_replymeta', $data);

			$this->voice_media_id = $media_id;
		}
	}
?>