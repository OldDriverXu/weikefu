<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	require_once APPPATH.'models/advanced/advanced_base_reply.php';

	//客服视频接口
	class Advanced_music_reply extends Advanced_base_reply
	{	
		private $music_title;      
		private $music_description;
		private $music_url;
		private $hqmusic_url;     //可为空
		private $thumb_media_id;

		public function __construct(){		
			parent::__construct();
		}

		public function init($array){
			//获取共有参数
			$this->to_username = (string) trim($array['reply_to_username']);  
			$this->rly_type    = (string) trim($array['reply_type']);

			//私有参数
			$this->music_title       = (string) trim($array['music_title']);
			$this->music_description = (string) trim($array['music_description']);
			$this->music_url         = (string) trim($array['music_url']);
			$this->hqmusic_url       = (string) trim($array['hqmusic_url']);
			$this->thumb_media_id    = (string) trim($array['thumb_media_id']);


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
			$data_subfix = array(
					'reply_id'           => $reply_id,
					'music_title'        => $this->music_title,
					'music_description'  => $this->music_description,
					'music_url'          => $this->music_url,
					'hqmusic_url'        => $this->hqmusic_url,
					'thumb_media_id'     => $this->thumb_media_id
				);
			$this->set_music($data_subfix);
			return true;
		}

		public function post_json(){
			$data = array(
					'touser'  => $this->to_username,
					'msgtype' => $this->rly_type,
					'music'    => array(
							'title'          => urlencode($this->music_title),
							'description'    => urlencode($this->music_description),
							'musicurl'	     => urlencode($this->music_url),
							'hqmusicurl'     => urlencode($this->hqmusic_url),
							'thumb_media_id' => urlencode($this->thumb_media_id)
						)	
				);
			return urldecode(json_encode($data));
		}

		public function get_music($reply_id){
			$this->_get_music_title($reply_id);
			$this->_get_music_description($reply_id);
			$this->_get_music_url($reply_id);
			$this->_get_hqmusic_url($reply_id);
			$data = array(
					'music_title'        => $this->music_title,
					'music_description'  => $this->music_description,
					'music_url'          => $this->music_url,
					'hqmusic_url'        => $this->hqmusic_url
				);
			return $data;
		}

		public function set_music($array){
			$reply_id                 = $array['reply_id'];
			$this->music_title        = $array['music_title'];
			$this->music_description  = $array['music_description'];
			$this->music_url          = $array['music_url'];
			$this->hqmusic_url        = $array['hqmusic_url'];

			$this->_set_music_title($reply_id, $this->music_title);
			$this->_set_music_description($reply_id, $this->music_description);
			$this->_set_music_url($reply_id, $this->music_url);
			$this->_set_hqmusic_url($reply_id, $this->hqmusic_url);
		}

		private function _get_music_title($reply_id){
			$this->db->from('wx_replymeta');
			$this->db->where('reply_id', $reply_id);
			$this->db->where('meta_key', 'music_title');
			$this->db->select('meta_value');
			$query=$this->db->get();
			$result = $query->result_array();

			if($result){
				$this->music_title = $result[0]['meta_value'];
			}
			return $this->music_title;
		}

		private function _set_music_title($reply_id, $text){
			$data = array(
					'reply_id' => $reply_id,
					'meta_key'   => 'music_title',
					'meta_value' => $text
				);
			$this->db->insert('wx_replymeta', $data);

			$this->music_title = $text;
		}

		private function _get_music_description($reply_id){
			$this->db->from('wx_replymeta');
			$this->db->where('reply_id', $reply_id);
			$this->db->where('meta_key', 'music_description');
			$this->db->select('meta_value');
			$query=$this->db->get();
			$result = $query->result_array();

			if($result){
				$this->music_description = $result[0]['meta_value'];
			}
			return $this->music_description;
		}

		private function _set_music_description($reply_id, $text){
			$data = array(
					'reply_id' => $reply_id,
					'meta_key'   => 'music_description',
					'meta_value' => $text
				);
			$this->db->insert('wx_replymeta', $data);

			$this->music_description = $text;
		}

		private function _get_music_url($reply_id){
			$this->db->from('wx_replymeta');
			$this->db->where('reply_id', $reply_id);
			$this->db->where('meta_key', 'music_url');
			$this->db->select('meta_value');
			$query=$this->db->get();
			$result = $query->result_array();

			if($result){
				$this->music_url = $result[0]['meta_value'];
			}
			return $this->music_url;
		}

		private function _set_music_url($reply_id, $text){
			$data = array(
					'reply_id' => $reply_id,
					'meta_key'   => 'music_url',
					'meta_value' => $text
				);
			$this->db->insert('wx_replymeta', $data);

			$this->music_url = $text;
		}

		private function _get_hqmusic_url($reply_id){
			$this->db->from('wx_replymeta');
			$this->db->where('reply_id', $reply_id);
			$this->db->where('meta_key', 'hqmusic_url');
			$this->db->select('meta_value');
			$query=$this->db->get();
			$result = $query->result_array();

			if($result){
				$this->hqmusic_url = $result[0]['meta_value'];
			}
			return $this->hqmusic_url;
		}

		private function _set_hqmusic_url($reply_id, $text){
			$data = array(
					'reply_id' => $reply_id,
					'meta_key'   => 'hqmusic_url',
					'meta_value' => $text
				);
			$this->db->insert('wx_replymeta', $data);

			$this->hqmusic_url = $text;
		}
	}
?>
