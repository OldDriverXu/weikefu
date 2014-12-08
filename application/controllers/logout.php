<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	header("Content-Type: text/html; charset=utf-8");

	class Logout extends CI_Controller{

		public function __construct() {
			parent::__construct();
			$this->load->helper( array ('form','url' ) );			
			$this->load->library('form_validation');	
			$this->load->model('personnel/account_model');
		}

		/*
        * 用户退出
        * 已经登录则退出，否者转到details
        */
        function index(){
        	if ($this->account_model->logout() == TRUE){
        		$this->load->view('account/login');
        	}else{
        		
        	}
        }
	}
?>