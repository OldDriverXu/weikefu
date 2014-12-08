<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	require_once APPPATH.'models/advanced/advanced_base_reply.php';

	//客服视频接口
	class Advanced_video_reply extends Advanced_base_reply
	{	
		private $video_media_id;      // 通过上传多媒体文件，得到的id
		private $video_title;
		private $video_description;

		public function __construct(){		
			parent::__construct();
		}

		public function init($array){
			//获取共有参数
			$this->to_username = (string) trim($array['reply_to_username']);  
			$this->rly_type    = (string) trim($array['reply_type']);

			//私有参数
			$this->video_media_id    = (string) trim($array['video_media_id']);
			$this->video_title       = (string) trim($array['video_title']);
			$this->video_description = (string) trim($array['video_description']);

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
					'reply_title'            => $array['reply_title'],
					'reply_excerpt'          => $array['reply_excerpt'],
					'reply_type'             => $this->rly_type,
					'reply_status'           => $array['reply_status'],
					'reply_parent'           => $array['reply_parent']
				);
			$reply_id = $this->set_reply($data);
			$data_subfix = array(
					'reply_id'          => $reply_id,
					'video_media_id'    => $this->video_media_id,
					'video_title'       => $this->video_title,
					'video_description' => $this->video_description					
				);
			$this->set_video($data_subfix);
			return true;
		}

		public function post_json(){
			$data = array(
					'touser'  => $this->to_username,
					'msgtype' => $this->rly_type,
					'video'    => array(
							'media_id'    => urlencode($this->video_media_id),
							'title'       => urlencode($this->video_title),
							'description' => urlencode($this->video_description),
						)	
				);
			return urldecode(json_encode($data));
		}

		public function get_video($reply_id){
			$this->_get_video_media_id($reply_id);
			$this->_get_video_title($reply_id);
			$this->_get_video_description($reply_id);
			$data = array(
					'video_media_id'    => $this->video_media_id,
					'video_title'       => $this->video_title,
					'video_description' => $this->video_description
				);
			return $data;
		}

		public function set_video($array){
			$reply_id                = $array['reply_id'];
			$this->video_media_id    = $array['video_media_id'];
			$this->video_title       = $array['video_title'];
			$this->video_description = $array['video_description'];

			$this->_set_video_media_id($reply_id, $this->video_media_id);
			$this->_set_video_title($reply_id, $this->video_title);
			$this->_set_video_description($reply_id, $this->video_description);
		}
		
		private function _get_video_media_id($reply_id){
			$this->db->from('wx_replymeta');
			$this->db->where('reply_id', $reply_id);
			$this->db->where('meta_key', 'video_media_id');
			$this->db->select('meta_value');
			$query=$this->db->get();
			$result = $query->result_array();

			if($result){
				$this->video_media_id = $result[0]['meta_value'];
			}
			return $this->video_media_id;
		}

		private function _set_video_media_id($reply_id, $media_id){
			$data = array(
					'reply_id' => $reply_id,
					'meta_key'   => 'video_media_id',
					'meta_value' => $media_id
				);
			$this->db->insert('wx_replymeta', $data);

			$this->video_media_id = $media_id;
		}

		private function _get_video_title($reply_id){
			$this->db->from('wx_replymeta');
			$this->db->where('reply_id', $reply_id);
			$this->db->where('meta_key', 'video_title');
			$this->db->select('meta_value');
			$query=$this->db->get();
			$result = $query->result_array();

			if($result){
				$this->video_title = $result[0]['meta_value'];
			}
			return $this->video_title;
		}

		private function _set_video_title($reply_id, $text){
			$data = array(
					'reply_id' => $reply_id,
					'meta_key'   => 'video_title',
					'meta_value' => $text
				);
			$this->db->insert('wx_replymeta', $data);

			$this->video_title = $text;
		}

		private function _get_video_description($reply_id){
			$this->db->from('wx_replymeta');
			$this->db->where('reply_id', $reply_id);
			$this->db->where('meta_key', 'video_description');
			$this->db->select('meta_value');
			$query=$this->db->get();
			$result = $query->result_array();

			if($result){
				$this->video_description = $result[0]['meta_value'];
			}
			return $this->video_description;
		}

		private function _set_video_description($reply_id, $text){
			$data = array(
					'reply_id' => $reply_id,
					'meta_key'   => 'video_description',
					'meta_value' => $text
				);
			$this->db->insert('wx_replymeta', $data);

			$this->video_description = $text;
		}
	}
?>