<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');	

	class My_auth {
		
		private $logged_in;
		private $CI;

		function check_login(){
			$this->CI = & get_instance();
	    	$this->CI->load->library('session');
	    	$this->CI->load->helper('url');

	    	$this->logged_in = $this->CI->session->userdata('logged_in');
	    	if ($this->logged_in === TRUE){
	    		//登陆状态
	    	}else{
	    		//未登录，不在登陆页则跳转到登陆页
	    		if (preg_match("/login.*/i", uri_string()) || preg_match("/database.*/i", uri_string()) || preg_match("/echo_server.*/i", uri_string()) ){
	    		}else{
	    			redirect('login');
	    		}
	    	}
		}
	}	
	
?>