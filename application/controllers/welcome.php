<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('system_model');
		$this->load->model('autoreply/base_reply');
		$this->load->model('autoreply/text_reply');
		$this->load->model('autoreply/news_reply');
		$this->load->library('parser');
		$this->load->helper(array('form', 'url'));
	}

	function index(){
		$header['title'] = '欢迎语';
		$this->load->view('templates/header', $header);

		$data['reply_user'] = '海豚君';
		$data['reply_user_IP'] = '';

		$this->load->view('reply/welcome', $data);
		$this->load->view('templates/footer');

	}

		//设置欢迎语
	public function set_welcome(){
		$replyArray = array(
				'ID'             => 1,
				'autoreply_type' => $_POST['autoreply_type'],
				'news_type'      => 'welcome'
        	);
	    switch ($_POST['autoreply_type']) {
	    	case 'text':
	    		$replyArray['autoreply_content'] = $_POST['autoreply_content'];
	    		break;
			case 'news':  
				$replyArray['articles'] = $_POST['articles'];
				break;
	    	
	    	default:
	    		# code...
	    		break;
	    }
     	//判断类型并设置
		function AdvancedReply($type){
			switch ($type) {
				case 'text':	
					return new Text_reply();
				case 'news':
					return  new News_reply();
				default:
					# code...
					break;
			}
		}
		$advancedReply = AdvancedReply($replyArray['autoreply_type']);
		//欢迎语存入数据库
		$advancedReply -> init($replyArray);
	}
	

	//获取欢迎语
	public function get_welcome(){
		$query = $this->db->get_where('wx_autoreply',array('ID'=>1));
		$result = $query->result_array();
		if($result[0]['autoreply_type']=='text'){
			echo $result[0]['autoreply_content'].'!@#$%^&*';
		}else{
			$news = $this->news_reply->get_news(1,'welcome');
			$data['news'] = $news;
			if($news){
				$result =  $this->parser->parse('reply/get_news',$data,TRUE); 
				$result2 = $this->parser->parse('reply/get_news2',$data,TRUE);
				$result = $result.'!@#$%^&*'.$result2;
			}else{
				$result = '图文已损坏'.'!@#$%^&*';
			}
			echo $result;
		}		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */