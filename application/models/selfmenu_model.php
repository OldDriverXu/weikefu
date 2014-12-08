<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	/**
	* 
	*/
	class Selfmenu_model extends CI_Model
	{
		public $ID;
		public $menu_type;
		public $menu_key;
		public $menu_url;
		public $menu_parent;
		
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
	    	require_once APPPATH.'libraries/common/GlobalFunctions.php';	         	        
		}

		//创建自定义菜单
		public function post_to_weixin($access_token){
			if($access_token == ''){
				return false;
			}
			$post_url = 'https://api.weixin.qq.com/cgi-bin/menu/create';
			$curl_url = $post_url.'?access_token='.$access_token;
			$json = $this->post_json();
			$curl_result = doCurlPostRequest($curl_url, $json);
			echo($curl_result);
			return $curl_result;
		}
		//删除自定义菜单
		public function delete_to_weixin($access_token){
			if($access_token == ''){
				return false;
			}
			$post_url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$access_token;

			$curl_result = doCurlGetRequest($post_url);
			echo($curl_result);
			return $curl_result;
		}
		public function iterator_data($item){

			switch ($item['menu_type']) {
						case 'click':
							$json_array = array(
								'type' => 'click',
								'name' => urlencode($item['menu_name']),
								'key' => $item['menu_key']
							);
							break;
						case 'view':
							$json_array = array(
								'type' => 'view',
								'name' => urlencode($item['menu_name']),
								'url' => $item['menu_url']
							);
							break;					
						default:
							# code...
							break;
			}
			return $json_array;
		}
		//传给微信json格式
		public function post_json(){
			$json_array =  array();
			$json_array['button'] = array();
			//获取一级菜单
			$result = $this->get_sub_button(0);
			$result_count = count($result);

			//遍历一级菜单
			for ($i=0; $i < $result_count && $i < 3; $i++) {
				$item = $result[$i];
				$id = $item['ID'];
				$sub_button = $this->get_sub_button($id);
				$sub_button_array = array();
				$sub_button_count = count($sub_button);
				//如果有子菜单
				if($sub_button_count){        
					for ($j=0; $j < $sub_button_count && $j < 5; $j++) { 
						$sub_button_array[$j] = $this->iterator_data($sub_button[$j]);
					}
					$json_array['button'][$i] = array(
						'name' => urlencode($item['menu_name']),
						'sub_button' => $sub_button_array
					);
				}else{
					$json_array['button'][$i] = $this->iterator_data($item);
				}
			}
			// $result = array(
			// 		'button' => array(
			// 			        0 => array(
			// 						'name' => urlencode('菜单'),
			// 						'sub_button' => array(
			// 							0 => array(	
			// 								'type' => 'click',
			// 								'name' => urlencode('今日歌曲'),
			// 								'key' =>'abcdefg'
			// 							),
			// 							1 => array(
			// 								'type' => 'click',
			// 								'name' => urlencode('今日歌曲'),
			// 								'key' =>'abcdefg'
			// 							)
			// 						)
			// 					)
			// 		)
			// );
			header("Content-type:text/html;charset=utf-8"); 
			$data = urldecode(json_encode($json_array));
			return $data;
		}

		public function get_all_selfmenu(){
			$query = $this->db->get('wx_selfmenu');
			$result = $query->result_array();
			return $result;
		}
		//根据id获取录
		public function get_by_id($id){
			$this->db->where('ID' , $id);
			$query = $this->db->get("wx_selfmenu");
			$result = $query->result_array();
			return $result[0];
		}
		//根据menu_parent 获取一、二级菜单
		public function get_sub_button($id){
			$this->db->where('menu_parent',$id);
			$this->db->order_by('menu_order', 'asc');
			$query = $this->db->get('wx_selfmenu');
			$result = $query->result_array();
			return $result;
		}

		//添加新的自定义菜单
		public function set_selfmenu($obj){
			$new_obj = array();
			foreach ($obj as $key => $value) {
				if($value){
					$new_obj[$key] = $value;
				}
			}
			$this->db->insert('wx_selfmenu', $new_obj);
			return $this->db->insert_id();
		}
		//删除自定义菜单
		public function dele_menu_by_id($id){
			$this->db->where('ID', $id);
			$this->db->delete('wx_selfmenu');
		}
		//找到最大的id
		public function get_max_id(){
			$str = 'select max(ID) from wx_selfmenu';
			$query = $this->db->query($str);
			$result = $query->result_array();
			$max_id = $result[0]['max(ID)'];
			return $max_id;
		}
		//更新
		public function update_menu($id, $data){
			$new_data = array();
			foreach ($data as $key => $value) {
				if($value){
					$new_data[$key] = $value;
				}
			}
			$this->db->where('ID', $id);
			$this->db->update('wx_selfmenu', $new_data);
		}
		//selfmenu自动排序
		//一级菜单
		public function exec_fist_order(){
			$first_menu = $this->get_sub_button(0);
			$len=count($first_menu);
			if($len){
				for($i=0,$len=count($first_menu); $i<$len; $i++){
					$id = $first_menu[$i]['ID'];
					$order = $i+1;
					$this->update_menu($id, array('menu_order'=>$order));
					$this->exec_second_order($id);
				}
			}
		}

		//二级菜单
		public function exec_second_order($id){
			$second_menu = $this->get_sub_button($id);
			$len=count($second_menu);
			if($len){
				for($i=0,$len=count($second_menu); $i<$len; $i++){
					$id = $second_menu[$i]['ID'];
					$order = $i+1;
					$this->update_menu($id, array('menu_order'=>$order));
				}
			}
		}
	}