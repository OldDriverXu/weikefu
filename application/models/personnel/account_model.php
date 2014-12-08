<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  // 后台用户的登陆、退出
  class Account_model extends CI_Model
  {
    public function __construct(){    
      parent::__construct(); 
      $this->load->database(); 
      $this->load->library('session');                           
    }

    /*
    * 添加用户session数据,设置用户在线状态
    * @param string $username
    */
    function login($username){
      $data = array('user_login'=>$username, 'logged_in'=>TRUE);
       //添加session数据
      $this->session->set_userdata($data); 
    }

    /**
    * 注销用户
    * @return boolean
    */
    function logout(){
      if($this->session->userdata('logged_in') === TRUE){        
        //销毁所有session的数据
        $this->session->sess_destroy();
        return TRUE;
      }
      return FALSE;
    }

    /*
    * 通过用户名获得用户记录
    * @param string $username
    */
    function get_by_username($username){
      $data = $this->db->get_where('wx_users', array('user_login' => $username));
      if($data->num_rows()>0){
        return $data->row_array();
      }else{
        return FALSE;
      }        
    }
   
    /*
    * 用户名不存在时,返回false
    * 用户名存在时，验证密码是否正确
    */
    function password_check($username, $password){                
      if($this->get_by_username($username)){
        $data = $this->db->get_where('wx_users', array('user_login'=> $username, 'user_pass' => $password));
        if($data->num_rows()>0){
          return TRUE;
        }else{
          return FALSE;   //密码错误
        }
      }else{
        return FALSE;     //用户名不存在
      }   
    }
  } 
?>