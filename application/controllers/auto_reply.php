<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auto_reply extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('system_model');
		$this->load->model('autoreply/base_reply');
		$this->load->model('autoreply/text_reply');
		$this->load->model('autoreply/music_reply');
		$this->load->model('autoreply/news_reply');
		$this->load->library('parser');
		$this->load->helper(array('form', 'url'));
	}

	function index(){
		$header['title'] = '历史自动回复';
		$this->load->view('templates/header', $header);

		$data['reply_user'] = '海豚君';
		$data['reply_user_IP'] = '';

		$this->load->view('reply/auto_reply', $data);
		$this->load->view('templates/footer');
	}
	function add_autoreply(){
		$header['title'] = '新增自动回复';
		$this->load->view('templates/header', $header);

		$data['reply_user'] = '海豚君';
		$data['reply_user_IP'] = '';

		$this->load->view('reply/add_autoreply', $data);
		$this->load->view('templates/footer');
	}

	//获取全部历史自动回复
	public function get_auto_reply(){
		$query = $this->db->get('wx_autoreply');
		$result = $query->result_array();
		echo json_encode($result);	
	}
	//获取自动回复，去掉欢迎语、下班回复、自定义菜单
	public function get_min_auto_reply(){		
		$result = $this->base_reply->get_min_auto_reply();
		echo json_encode($result);
	}

	//删除自动回复
	public function delete_reply(){
		$ids = explode(',', $_GET['ids']);
		if(count(ids)){
			$this->db->where_in('ID', $ids);
			$this->db->delete('wx_autoreply');

			$this->db->where_in('autoreply_id', $ids);
			$this->db->delete('wx_autoreplymeta');

			$this->db->where('news_type', 'auto_reply');
			$this->db->where_in('news_id', $ids);
			$this->db->delete('wx_article');
		}
	}
	//点击修改获取回复信息
	public function get_message(){
		$type = $_GET['type'];
		$id = $_GET['id'];
		$query = $this->db->get_where('wx_autoreply',array('ID'=>$id, 'autoreply_type'=>$type));
		$result = $query->result_array();
		$data['replys'] = $result;
		if($type == 'text'){
			$data['edit_type'] = 'text';
		}else if($type == 'news'){
			$query_news = $this->db->get_where('wx_article',array('news_type'=>'auto_reply','news_id'=>$id));
			$data['replys'][0]['news'] = $query_news->result_array();
			$data['edit_type'] = 'new';
		}else if($type =='music'){
			$query_music = $this->db->get_where('wx_autoreplymeta',array('autoreply_id'=>$id));
			$music_data = $query_music->result_array();
			$data['replys'][0]['music_title'] = $music_data[0]['meta_value'];
			$data['replys'][0]['music_description'] = $music_data[1]['meta_value'];
			$data['replys'][0]['music_url'] = $music_data[2]['meta_value'];
			$data['replys'][0]['hqmusic_url'] = $music_data[3]['meta_value'];
			$data['edit_type'] = 'music';
		}
		$result = $this->parser->parse('reply/auto_reply_edit',$data,TRUE);
		echo $result;

	}
	//修改信息保存
	public function update_reply(){
		$ID = $_POST['ID'];
		$autoreply_keyword = $_POST['autoreply_keyword'];
		$autoreply_type = $_POST['autoreply_type'];
		$replyArray = array(
			'ID'                => $ID,
			'autoreply_keyword' => $autoreply_keyword,
			'autoreply_type'    => $autoreply_type
			//'attoreply_contnent'=> $_POST['attoreply_contnent'];
			// 'articles'           : $_POST['articles'];
			);
		switch ($autoreply_type){
			case 'text':
				$replyArray['autoreply_content'] = $_POST['autoreply_content'];
				break;
			case 'music':
				$replyArray['music'] = $_POST['music'];
			case 'news':
				$replyArray['articles'] = $_POST['articles'];
				//放入wx_article中所需字段
				$replyArray['news_type'] = 'auto_reply';
			default:

				break;
		}
		//判断类型并设置
		function AdvancedReply($type){
			switch ($type) {
				case 'text':	
					return new Text_reply();
				case 'music':
					return new Music_reply();
				case 'news':
					return  new News_reply();
				default:
					# code...
					break;
			}
		}
		$advancedReply = AdvancedReply($autoreply_type);
		//存入数据库
		$advancedReply -> init($replyArray);


	}
	public function get_news(){
		$ID = $_GET['ID'];
		$news = $this->news_reply->get_news($ID, 'auto_reply');
		$data['news'] = $news;
		if($news){
			$result = $this->parser->parse('reply/get_news', $data,TRUE);
		}else{
			$result = '图文已损坏';
		}
		echo $result;
	}

	public function get_music(){
		$ID = $_GET['ID'];
		$music = $this->music_reply->get_music($ID);
		$data['music'][0] = $music;
		if($music){
			$result = $this->parser->parse('reply/get_music', $data,TRUE);
		}else{
			$result = '音乐已损坏';
		}
		echo $result;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */