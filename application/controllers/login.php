<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	header("Content-Type: text/html; charset=utf-8");

	class Login extends CI_Controller{

		private $_username;
    	private $_password;
    	const warning_icon = "<span class='glyphicon glyphicon-exclamation-sign username_error'></span>";

		public function __construct() {
			parent::__construct();
			$this->load->helper( array ('form','url' ) );			
			$this->load->library('form_validation');			
			$this->load->model('personnel/account_model');
		}

		public function index() {
			$this->load->view('account/login');
		}

		public function in() {
			//设置错误定界符
            // $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

            //用户名,密码
            $this->_username = $this->input->post('username');  
            $this->_password = $this->input->post('password');

            //重写required验证信息
			$this->form_validation->set_message('required', self::warning_icon.'请填写%s!');
			//表单验证规则
			$this->form_validation->set_rules('username', '用户名', 'trim|required|xss_clean|callback_username_check');  
        	$this->form_validation->set_rules('password', '密码', 'trim|required|xss_clean|callback_password_check' );  

        	if ($this->form_validation->run()) {
        		//注册session,设定登录状态
        		$this->account_model->login($this->_username);
        		redirect('welcome');
        	}else{
        		$this->load->view('account/login');
        	}  
		}

		/* 检查用户名是不存在的登录
        * @param string $username
        * @return bool 
        */
		public function username_check($username){
			if ($this->account_model->get_by_username($username)){
				return TRUE;
			}else{
				$this->form_validation->set_message('username_check', self::warning_icon.'用户名'.$username.'不存在!');
				return FALSE;
			}			
		}
		/*
        * 检查用户的密码正确性
        */
		public function password_check($password){
			if($this->account_model->password_check($this->_username, $password)){
				return TRUE;
			}else{
				$this->form_validation->set_message('password_check', self::warning_icon.'用户名或密码不正确!');
				return FALSE;
			}		
		}
	}
?>