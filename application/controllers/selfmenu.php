<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); 

	header("Content-Type: text/html; charset=utf-8");

	class Selfmenu extends CI_controller{
		public function __construct(){
			parent::__construct();
			$this->load->model('system_model');
			$this->load->model('selfmenu_model');
			$this->load->model('autoreply/base_reply');
			$this->load->model('autoreply/music_reply');
			$this->load->model('autoreply/news_reply');
			$this->load->model('autoreply/text_reply');

			$this->load->library('parser');
			$this->load->helper(array('form', 'url'));
		}
		public function index(){
			$header['title'] = "自定义菜单";
			$this->load->view('templates/header', $header);
			$this->load->view('selfmenu_manage');
			$this->load->view('templates/footer');			
		}
		//创建自定义菜单
		public function create_selfmenu(){
			$access_token = $this->system_model->get_access_token();
			$postJson = $this->selfmenu_model->post_to_weixin($access_token);
		}
		//删除自定义菜单
		public function delete_selfmenu(){
			$access_token = $this->system_model->get_access_token();
			$postJson = $this->selfmenu_model->delete_to_weixin($access_token);
		}

		public function get_selfmenu(){
			$selfmenu = array();
			//一级菜单
			$firstmenu = $this->selfmenu_model->get_sub_button(0);
			$allmenu = $this->selfmenu_model->get_all_selfmenu();

			$num = 0;
			//遍历一级菜单
			for ($i=0;$i<count($firstmenu) && $i<3;$i++){
				$selfmenu[$num] = $firstmenu[$i];
				$num++;
				$ID = $firstmenu[$i]['ID'];
				//获取子菜单
				$secondmenu = $this->selfmenu_model->get_sub_button($ID);
				$second_count = count($secondmenu);
				if($second_count){
					for($j=0; $j<$second_count && $j<5; $j++){
						$selfmenu[$num] = $secondmenu[$j];
						$num++;
					}
				}
			}
			echo json_encode($selfmenu);
		}

		public function get_clickmenu(){
			$key = $_GET['key'];
			$obj = $this->base_reply->get_autoreply_by_key($key);
			$type = $obj['autoreply_type'];
			$id = $obj['ID'];
			$result = '';
			if($type == 'text'){
				$result = $obj['autoreply_content'];
			}else if($type == 'news'){
				$news = $this->news_reply->get_news($id, 'auto_reply');
				$data['news'] = $news;
				if($news){
					$result = $this->parser->parse('reply/get_news', $data,TRUE);
				}else{
					$result = '图文已损坏';
				}
			}else if($type == 'music'){
				$music = $this->music_reply->get_music($id);
				$data['music'][0] = $music;
				if($music){
					$result = $this->parser->parse('reply/get_music', $data,TRUE);
				}else{
					$result = '音乐已损坏';
				}
			}
			echo $result;
		}

		//添加一级自定义菜单
		public function add_firstmenu(){
			$menu_name      = trim($_GET['menu_name']);
			$menu_order     = $_GET['menu_order'];
			$menu_parent    = $_GET['menu_parent'];

			$add_selfmenu = array(
				'menu_name'   => $menu_name,
				'menu_order'  => $menu_order,
				'menu_parent' => $menu_parent,
			);
			$this->selfmenu_model->set_selfmenu($add_selfmenu);
			//selfmenu自动排序
			$this->selfmenu_model->exec_fist_order();
		}

		//添加二级自定义菜单
		public function add_secondmenu(){
			$menu_type      = $_POST['menu_type'];
			$menu_name      = trim($_POST['menu_name']);
			$menu_url       = $_POST['menu_url'];
			$menu_order     = $_POST['menu_order'];
			$menu_parent    = $_POST['menu_parent'];
			$autoreply_type = $_POST['autoreply_type'];
			$text           = trim($_POST['text']);
			$music          = $_POST['music'];
			$news           = $_POST['news'];

			$add_selfmenu = array(
				'menu_type'   => $menu_type,
				'menu_name'   => $menu_name,
				'menu_order'  => $menu_order,
				'menu_parent' => $menu_parent,
			);
			if($menu_type == 'click'){
				$insert_id = $this->selfmenu_model->set_selfmenu($add_selfmenu);
				$menu_key = 'selfmenu-'.$insert_id;

				$insert_array = array('menu_key' => $menu_key);
				$this->selfmenu_model->update_menu($insert_id, $insert_array);

				$add_autoreply = array(
					'autoreply_keyword' => $menu_key,
					'autoreply_type'    => $autoreply_type
				);

				//插入wx_autoreply
				$id = $this->base_reply->set_reply($add_autoreply);					
				if($autoreply_type == 'text'){
					$this->text_reply->update_text_content($id, $text);
				}else if($autoreply_type == 'music'){
					$music_array = $music;
					$music_array['autoreply_id'] = $id;
					$this->music_reply->set_music($music_array);
				}else if($autoreply_type == 'news'){
					$news_array = $news;
					for($i=0,$len=count($news_array); $i<$len; $i++){
						$news_array[$i]['news_id'] = $id;
						//放入wx_article中所需字段
						$news_array[$i]['news_type'] ='auto_reply';
						$this->news_reply->set_article($news_array[$i]);
					}
				}
			}else if($menu_type == 'view'){
				$add_selfmenu['menu_url'] = $menu_url;
			    $this->selfmenu_model->set_selfmenu($add_selfmenu);
			}
			//selfmenu自动排序
			$this->selfmenu_model->exec_fist_order();
		}
		//删除数据库自定义菜单
		public function dele_menu(){
			$id = $_GET['id'];
			$menu_level = $_GET['menu_level'];
			$menu_type =$_GET['menu_type'];     //click/view

			if($menu_level == 'first_menu'){
				//从wx_selfmenu删除
				$this->selfmenu_model->dele_menu_by_id($id);

				$second_menu = $this->selfmenu_model->get_sub_button($id);
				$len = count($second_menu);
				if($len){
					for($i=0; $i<$len; $i++){
						$this->dele_one_menu($second_menu[$i]);
					}
				}
			}else if($menu_level == 'second_menu'){
				$obj = $this->selfmenu_model->get_by_id($id);
				$this->dele_one_menu($obj);
			}
			//selfmenu自动排序
			$this->selfmenu_model->exec_fist_order();
		}
		//删除数据库单个菜单
		public function dele_one_menu($obj){
			//从wx_selfmenu删除
			$this->selfmenu_model->dele_menu_by_id($obj['ID']);

			$type = $obj['menu_type'];
			if($type == 'click'){
				$keyword = $obj['menu_key'];
				$reply_obj = $this->base_reply->get_autoreply_by_key($keyword);

				$this->base_reply->dele_reply($reply_obj['ID']);
			}else if($type == 'view'){

			}
		}
		//点击修改获取菜单回复信息
		public function get_menu_info(){
			$key = $_GET['key'];
			$obj = $this->base_reply->get_autoreply_by_key($key);
			$type = $obj['autoreply_type'];
			$id = $obj['ID'];

			$query = $this->db->get_where('wx_autoreply',array('ID'=>$id, 'autoreply_type'=>$type));
			$result = $query->result_array();
			$data['replys'] = $result[0];
			if($type == 'text'){
				$data['edit_type'] = 'text';
			}else if($type == 'news'){
				$query_news = $this->db->get_where('wx_article',array('news_type'=>'auto_reply','news_id'=>$id));
				$data['replys']['news'] = $query_news->result_array();
				$data['edit_type'] = 'news';
			}else if($type =='music'){
				$query_music = $this->db->get_where('wx_autoreplymeta',array('autoreply_id'=>$id));
				$music_data = $query_music->result_array();
				$data['replys']['music_title'] = $music_data[0]['meta_value'];
				$data['replys']['music_description'] = $music_data[1]['meta_value'];
				$data['replys']['music_url'] = $music_data[2]['meta_value'];
				$data['replys']['hqmusic_url'] = $music_data[3]['meta_value'];
				$data['edit_type'] = 'music';
			}
			echo json_encode($data);
		}
		//更新数据库自定义菜单信息
		public function update_selfmenu(){
			$id             = $_POST['sm_id'];
			$menu_type      = $_POST['menu_type'];
			$menu_name      = trim($_POST['menu_name']);
			$menu_url       = $_POST['menu_url'];
			$menu_order     = $_POST['menu_order'];
			$menu_parent    = $_POST['menu_parent'];
			$autoreply_type = $_POST['autoreply_type'];
			$text           = trim($_POST['text']);
			$music          = $_POST['music'];
			$news           = $_POST['news'];

			$update_array = array(
				'menu_type'   => $menu_type,
				'menu_name'   => $menu_name,
				'menu_order'  => $menu_order,
				'menu_parent' => $menu_parent,
			);
			if($menu_type == 'click'){
				//更新wx_selfmenu
				$this->selfmenu_model->update_menu($id, $update_array);
				
				//更新wx_autoreply
				$update_autoreply = array(
					'autoreply_type'    => $autoreply_type
				);
				//获取semfmenu对象
				$sm_obj = $this->selfmenu_model->get_by_id($id);
				//获取autoreply对象
				$ar_obj = $this->base_reply->get_reply(array('autoreply_keyword'=>$sm_obj['menu_key']));
				$ar_id = $ar_obj[0]['ID'];
				$this->base_reply->update_reply($update_autoreply, $ar_id);

				if($autoreply_type == 'text'){
					$this->text_reply->update_text_content($ar_id, $text);
				}else if($autoreply_type == 'music'){
					$music_array = $music;
					$music_array['autoreply_id'] = $ar_id;
					$this->music_reply->update_music($music_array);
				}else if($autoreply_type == 'news'){
					$news_array = $news;
					//清空图文
					$delete_array = array(
							'news_id' => $ar_id,
							'news_type' => 'auto_reply'
					);
		 	        $this->db->delete('wx_article', $delete_array);

					for($i=0,$len=count($news_array); $i<$len; $i++){
						$news_array[$i]['news_id'] = $ar_id;
						//放入wx_article中所需字段
						$news_array[$i]['news_type'] ='auto_reply';
						$this->news_reply->set_article($news_array[$i]);
					}
				}
			}else if($menu_type == 'view'){
				$update_array['menu_url'] = $menu_url;
			    $this->selfmenu_model->update_menu($id, $update_array);
			}
		}
		//拖拽菜单排序
		public function sort_menu(){
			$menu_data = $_GET['menu_data'];
			for($i=0,$len=count($menu_data); $i<$len; $i++){
				$obj = $menu_data[$i];
				$data = array(
					'menu_order' => $obj['order']
				);
				$this->selfmenu_model->update_menu($obj['id'], $data);
			}
		}
	}
