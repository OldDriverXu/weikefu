<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	require_once APPPATH.'models/advanced/advanced_base_reply.php';

	//客服图文回复接口
	class Advanced_news_reply extends Advanced_base_reply	
	{
		private $article_count;   // 图文消息个数，限制为10条以内
		private $article_title;  		   // 图文消息的标题
		private $article_description;      // 图文消息的描述
		private $article_pic_url;          // 图片链接，支持JPG、PNG格式，较好的效果为大图640*320，小图80*80，限制图片链接的域名需要与开发者填写的基本资料中的Url一致  
		private $article_url;              // 点击图文消息跳转链接
		private $news_array;

		public function __construct(){		
			parent::__construct();
		}

		public function init($array){
			//获取共有参数
			$this->to_username = (string) trim($array['reply_to_username']);  
			$this->rly_type    = (string) trim($array['reply_type']);

			//私有参数
			$this->news_array  = (string) trim($array['articles']);

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
			
			// $array['articles'] = array(
			// 	'0' => array(
			//			'article_order' => '1',
			// 			'article_title' => "xxxx",
			// 			'article_description' => "xxxx",
			// 			'article_url' => 'xxxxx',
			// 			'article_pic_url' => 'xxxxx'
 			//  	),
			// 	'1' =>array(
			//			'article_order' => '2',
			//          'article_title' => "xxxx",
			// 			'article_description' => "xxxx",
			// 			'article_url' => 'xxxxx',
			// 			'article_pic_url' => 'xxxxx'
			// 		)
			// );
			$article_count = count($array['articles']);
			$data_subfix = $array['articles'];
			//数组中插入news_id
			for ( $i=0; $i<$article_count; $i++) {
				$data_subfix[$i]['news_id'] = $reply_id;								
			}
			//遍历数组，设置单篇图文
			for ( $i=0; $i<$article_count; $i++) {
				$this->set_article($data_subfix[$i]);								
			}				
			$this->get_news($reply_id);			
			return true;
		}

		public function post_json(){
			$data = array(
					'touser'  => $this->to_username,
					'msgtype' => $this->rly_type,
					'news'    => array(
					'articles' => $this->news_array
						)	
				);
			return urldecode(json_encode($data));
		}

		public function get_news($news_id, $new_type){
			$this->db->from('wx_article');
			$this->db->where('news_id', $news_id);
			$this->db->where('news_type', $news_type);
			$this->db->order_by('article_order', 'asc');
			$query = $this->db->get();
			$result = $query->result_array();			

			if($result){
				for ($i=0; $i<count($result);$i++) {
					$data[$i]['title']       = urlencode($result[$i]['article_title']);
					$data[$i]['description'] = urlencode($result[$i]['article_description']);
					$data[$i]['url']         = urlencode($result[$i]['article_url']);
					$data[$i]['picurl']      = urlencode($result[$i]['article_pic_url']);
				}
				$this->news_array = $data;
			}else{
				$this->news_array = NULL;
			}
			return $this->news_array;
		}

		public function get_article($article_id){
			$this->db->from('wx_article');
			$this->db->where('article_id', $article_id);
			$this->db->where('news_type', 'reply');
			$query = $this->db->get();
			$result = $query->result;

			if($result){
				return $result;
			}else{
				return NULL;
			}
		}

		/* $array = array(
		|       'news_type'				 => $news_type,
		| 		'news_id'       		 => $news_id,
		| 		'article_order'          => $article_order,
		| 		'article_title'          => $article_title,
		|		'article_description'    => $article_description,
		|		'article_pic_url'        => $article_pic_url,
		| 		'article_url'            => $article_url 		
		| 	);
		*/
		public function set_article($array){
			$data['news_type'] = 'reply';
			foreach ($array as $key => $value) {
				if ($value){
					$data[$key] = $value;
				}				
			}			
			$this->db->insert('wx_article', $data);
		}

		/* $array = array(
		|		'article_id'			 => $article_id,
		|       'news_type'				 => $news_type,
		| 		'news_id'       		 => $news_id,
		| 		'article_order'          => $article_order,
		| 		'article_title'          => $article_title,
		|		'article_description'    => $article_description,
		|		'article_pic_url'        => $article_pic_url,
		| 		'article_url'            => $article_url 		
		| 	);
		*/
		public function update_article($array){
			foreach ($array as $key => $value) {
				if ($value){
					$data[$key] = $value;
					//$this->db->set($key, $value);					
				}				
			}
			$this->db->where('article_id', $data['article_id']);
			$this->db->where('news_type', 'reply');
			$this->db->update('wx_article', $data);
		}

		public function delete_article($article_id){
			$this->db->where('article_id', $article_id);
			$this->db->where('news_type', 'reply');
			$this->db->delete('wx_article');
		}
	}
?>