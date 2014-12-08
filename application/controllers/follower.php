<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	header("Content-Type: text/html; charset=utf-8");

	class Follower extends CI_Controller
	{
		private $access_token;

		public function __construct(){
			parent::__construct();	
			$this->load->model('system_model');
			$this->load->model('personnel/follower_model');
			$this->access_token = $this->system_model->get_access_token();
		}

		public function index(){

			$header['title'] = "粉丝管理";
			$this->load->view('templates/header', $header);
			$this->load->view('followers_manage');
			$this->load->view('templates/footer');
		}

		//更新粉丝信息并入库
		public function update(){				
			$list = $this->follower_model->get_followers_list($this->access_token);
			foreach ($list as $value) {			
				$data = $this->follower_model->get_follower_info($this->access_token, $value);
				if($data){
					if ($this->follower_model->get_follower($value)){
						//用户存在，更新当前信息
						$this->follower_model->update_follower($data);
					}else{
						//用户不存在，创建一条信息
						$this->follower_model->set_follower($data);
					}
				}
			}
		}
		//获取所有粉丝信息
		public function get_all_followers(){
			$result = $this->follower_model->get_all_followers();
			echo json_encode($result);
		}
	}
?>