<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Off_duty_reply extends CI_Controller{
	
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
		$header['title'] = '下班回复';
		$this->load->view('templates/header', $header);

		$data['reply_user'] = '海豚君';
		$data['reply_user_IP'] = '';

		$this->load->view('reply/off_duty_reply', $data);
		$this->load->view('templates/footer');
	}
	//获取下班自动回复
	public function get_off_duty_reply(){
		$query = $this->db->get_where('wx_autoreply',array('ID'=>2));
		$result = $query->result_array();
		$result_type = $result[0]['autoreply_type'];
		if($result_type=='text'){
			echo $result[0]['autoreply_content'];
		}else if($result_type=='news'){
			$news = $this->news_reply->get_news(2,'auto_reply');
			$data['news'] = $news;
			if($news){
				$result =  $this->parser->parse('reply/get_news',$data,TRUE); 
			}else{
				$result = '图文已损坏';
			}
			echo $result;
		}else if($result_type=='music'){
			$music = $this->music_reply->get_music(2);
			$data['music'][0] = $music;
			if($music){
				$result = $this->parser->parse('reply/get_music', $data,TRUE);
			}else{
				$result = '音乐已损坏';
			}
			echo $result;
		}
	}
	public function set_off_duty_reply(){
		$autoreply_type = $_POST['autoreply_type'];
		$work_status = $_POST['work_status'];
		//设置工作状态
		$this->base_reply->update_online_status($work_status);
		//如果只设置工作状态直接返回 
		if($autoreply_type=='only_set_online'){
			return;
		}
		$replyArray = array(
				'autoreply_type'    => $autoreply_type
			);
		$get_reply_array = array(
				'autoreply_keyword' => 'off_duty_reply'
			);
		$this->base_reply->update_reply($replyArray, 2);
		switch($autoreply_type){
			case 'text':
				$content = (string) trim($_POST['autoreply_content']);
				$this->text_reply->update_text_content(2,$content);
				break;
			case 'music':
				$musicArray = $_POST['music'];
				$result = $this->music_reply->get_music(2);
				//判断数据库是否存在这条数据
				$num = $this->music_reply->is_have_data(2);
				$musicArray['autoreply_id'] = 2;
				if($num){									
					$this->music_reply->update_music($musicArray);
				}else{
					$this->music_reply->set_music($musicArray);
				}
				break;
			case 'news':
				$newsArray = $_POST['articles'];
				//判断数据库是否存在这条数据
				$result = $this->news_reply->get_news(2, 'auto_reply');
				if(count($result)){
					$this->news_reply->delete_article_by_news_id(2);
				}
				$len2=count($newsArray);
				if($len2){
					for($j=0;$j<$len2;$j++){
						$newsArray[$j]['news_id'] = 2;
						//放入wx_article中所需字段
						$newsArray[$j]['news_type'] = 'auto_reply';
						$this->news_reply->set_article($newsArray[$j]);
					}
				}
				break;
			default:
				break;				
		}
	}

	public function get_work_status(){
		$result = $this->base_reply->get_online_status();
		echo $result;
	}
}