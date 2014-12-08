<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Add_autoreply extends CI_Controller{
	
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
		$header['title'] = '新增自动回复';
		$this->load->view('templates/header', $header);

		$data['reply_user'] = '海豚君';
		$data['reply_user_IP'] = '';

		$this->load->view('reply/add_autoreply', $data);
		$this->load->view('templates/footer');
	}
    
    public function add_reply(){
		$autoreply_keyword  = $_POST['autoreply_keyword'];
		$autoreply_type     = $_POST['autoreply_type'];
		// $autoreply_content  = $_POST['autoreply_content'];
		// $music 			    = $_POST['music'];
		// $articles           = $_POST['articles'];
		for($i=0,$len=count($autoreply_keyword);$i<$len;$i++){
			$replyArray = array(
				'autoreply_keyword' => $autoreply_keyword[$i],
				'autoreply_type'    => $autoreply_type
				//'attoreply_contnent'=> $_POST['attoreply_contnent'];
				// 'articles'           : $_POST['articles'];
			);
			//插入wx_autoreply
			$id = $this->base_reply->set_reply($replyArray);
			switch($autoreply_type){
				case 'text':
					$content = $_POST['autoreply_content'];
					$this->text_reply->update_text_content($id,$content);
					break;
				case 'music':
					$musicArray = $_POST['music'];
					$musicArray['autoreply_id'] = $id;
					$this->music_reply->set_music($musicArray);
					break;
				case 'news':
					$newsArray = $_POST['articles'];
					for($j=0,$len2=count($newsArray);$j<$len2;$j++){
						$newsArray[$j]['news_id'] = $id;
						//放入wx_article中所需字段
						$newsArray[$j]['news_type'] = 'auto_reply';
						$this->news_reply->set_article($newsArray[$j]);
					}
					break;
				default:
					break;				
			}
		}
    }

}