<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Database extends CI_Controller
	{
		public function __construct(){
			parent::__construct();	        
	        $this->load->dbforge();	        	        
		}

		public function index(){
			
			//wx_message
			$fields1 = array(
					'ID'=> array(
							'type' => 'BIGINT',
							'auto_increment' => TRUE
						),
					'message_username' => array(
							'type' =>'LONGTEXT'
						),
					'message_date' => array(
							'type' => 'DATETIME'
						),
					'message_date_timestamp' => array(
							'type' => 'INT',
							'constraint'=> '8'
						),
					'message_content' => array(
							'type' => 'LONGTEXT'
						),
					'message_title' => array(
							'type' => 'TEXT'
						),
					'message_excerpt' => array(
							'type' => 'TEXT'
						),
					'message_type' => array(
							'type' => 'VARCHAR',
							'constraint' => '8',
							'default' => 'text'
						),
					'message_status' => array(
							'type' => 'VARCHAR',
							'constraint' => '16',
							'default' => '0'
						),
					'reply_id' => array(
							'type' => 'BIGINT'							
						) 
				);
			$this->dbforge->add_field($fields1);
			$this->dbforge->add_key('ID', TRUE);
			$this->dbforge->create_table('wx_message', TRUE);

			//wx_messagemeta
			$fields2 = array(
					'meta_id' => array(
							'type' => 'BIGINT',
							'auto_increment' => TRUE
						),
					'message_id' => array(
							'type' => 'BIGINT'
						),
					'meta_key' => array(
							'type' => 'VARCHAR',
							'constraint' => '255'
						),
					'meta_value' => array(
							'type' => 'LONGTEXT'							
						)
				);
			$this->dbforge->add_field($fields2);
			$this->dbforge->add_key('meta_id', TRUE);
			$this->dbforge->create_table('wx_messagemeta', TRUE);

			//wx_reply		
			$fields3 = array(
					'ID'=> array(
							'type' => 'BIGINT',
							'auto_increment' => TRUE
						),
					'reply_to_username' => array(
							'type' =>'LONGTEXT'
						),
					'reply_date' => array(
							'type' => 'DATETIME'
						),
					'reply_date_timestamp' => array(
							'type' => 'INT',
							'constraint'=> '8'
						),
					'reply_user' => array(
							'type' => 'TEXT'
						),
					'reply_user_IP' => array(
							'type' => 'VARCHAR',
							'constraint'=> '16'
						),
					'reply_content' => array(
							'type' => 'LONGTEXT'
						),
					'reply_title' => array(
							'type' => 'TEXT'
						),
					'reply_excerpt' => array(
							'type' => 'TEXT'
						),
					'reply_type' => array(
							'type' => 'VARCHAR',
							'constraint' => '8',
							'default' => 'text'
						),
					'reply_status' => array(
							'type' => 'VARCHAR',
							'constraint' => '16',
							'default' => '0'
						),
					'reply_parent' => array(
							'type' => 'BIGINT'							
						) 
				);
			$this->dbforge->add_field($fields3);
			$this->dbforge->add_key('ID', TRUE);
			$this->dbforge->create_table('wx_reply', TRUE);

			//wx_replymeta
			$fields4 = array(
					'meta_id' => array(
							'type' => 'BIGINT',
							'auto_increment' => TRUE
						),
					'reply_id' => array(
							'type' => 'BIGINT'
						),
					'meta_key' => array(
							'type' => 'VARCHAR',
							'constraint' => '255'
						),
					'meta_value' => array(
							'type' => 'LONGTEXT'							
						)
				);
			$this->dbforge->add_field($fields4);
			$this->dbforge->add_key('meta_id', TRUE);
			$this->dbforge->create_table('wx_replymeta', TRUE);

			//wx_article		
			$fields5 = array(
					'article_id'=> array(
							'type' => 'BIGINT',
							'auto_increment' => TRUE
						),
					'news_type'=>array(
							'type'=> 'VARCHAR',
							'constraint'=> '15'
						),
					'news_id' => array(
							'type' =>'BIGINT'
						),	
					'article_order' => array(
							'type' => 'INT',
							'constraint'=> '8'
						),					
					'article_title' => array(
							'type' => 'TEXT'
						),
					'article_description' => array(
							'type' => 'TEXT'
						),
					'article_pic_url' => array(
							'type' => 'TEXT'							
						),
					'article_url' => array(
							'type' => 'TEXT'
						)					
				);
			$this->dbforge->add_field($fields5);
			$this->dbforge->add_key('article_id', TRUE);
			$this->dbforge->create_table('wx_article', TRUE);

			//wx_session 
			$fields6= array(
					'session_id' => array(
							'type' => 'BIGINT',
							'auto_increment' => TRUE
						),
					'message_username' => array(
							'type'=> 'TEXT'
						),
					'session_status' => array(
							'type'=>'VARCHAR',
							'constraint'=> '16'

						),
					'session_start_timestamp' => array(
							'type' => 'INT',
							'constraint'=> '8'
						),
					'session_end_timestamp' => array(
							'type' => 'INT',
							'constraint'=> '8'
						)
				);
			$this->dbforge->add_field($fields6);
			$this->dbforge->add_key('session_id', TRUE);
			$this->dbforge->create_table('wx_session', TRUE);

			//wx_users
			$fields7 = array(
					'ID' => array(
							'type' => 'BIGINT',
							'auto_increment' => TRUE
						),
					'user_login' => array(
							'type'=> 'VARCHAR',
							'constraint' => '60'
						),
					'user_pass' => array(
							'type'=> 'VARCHAR',
							'constraint' => '64'
						),
					'user_nickname' => array(
							'type'=> 'VARCHAR',
							'constraint' => '50'
						),
					'user_email' => array(
							'type'=> 'VARCHAR',
							'constraint' => '100'
						),
					'user_headimgurl' => array(
							'type' => 'TEXT'
						),
					'user_registered' => array(
							'type' => 'DATETIME'
						),
					'user_registered_timestamp' => array(
							'type' => 'INT',
							'constraint'=> '8'
						),
					'user_group' => array(
							'type' => 'text'
						),
					'user_status' => array(
							'type' => 'INT',
							'constraint' => '11'
						)
				);
			$this->dbforge->add_field($fields7);
			$this->dbforge->add_key('ID', TRUE);
			$this->dbforge->create_table('wx_users', TRUE);

			//wx_usermeta
			$fields8 = array(
					'meta_id' => array(
							'type' => 'BIGINT',
							'auto_increment' => TRUE
						),
					'user_id' => array(
							'type' => 'BIGINT'
						),
					'meta_key' => array(
							'type' => 'VARCHAR',
							'constraint' => '255'
						),
					'meta_value' => array(
							'type' => 'LONGTEXT'							
						)
				);
			$this->dbforge->add_field($fields8);
			$this->dbforge->add_key('meta_id', TRUE);
			$this->dbforge->create_table('wx_usermeta', TRUE);

			//wx_followers
			$fields9 = array(
					'ID' => array(
							'type' => 'BIGINT',
							'auto_increment' => TRUE
						),
					'follower_username' => array(
							'type'=> 'LONGTEXT'							
						),
					'follower_subscribe' => array(
							'type'=> 'INT',
							'constraint' => '8'
						),
					'follower_subscribe_timestamp' => array(
							'type' => 'INT',
							'constraint'=> '8'
						),
					'follower_nickname' => array(
							'type'=> 'VARCHAR',
							'constraint' => '50'
						),
					'follower_headimgurl' => array(
							'type' => 'LONGTEXT'
						),
					'follower_sex' => array(
							'type'=> 'INT',
							'constraint' => '8'
						),
					'follower_province' => array(
							'type' => 'text'
						),
					'follower_city' => array(
							'type' => 'text'
						),
					'follower_country' => array(
							'type' => 'text'
						),
					'follower_group' => array(
							'type' => 'text'
						),
					'follower_status' => array(
							'type' => 'INT',
							'constraint' => '11'
						)
				);
			$this->dbforge->add_field($fields9);
			$this->dbforge->add_key('ID', TRUE);
			$this->dbforge->create_table('wx_followers', TRUE);

			//wx_followermeta
			$fields10 = array(
					'meta_id' => array(
							'type' => 'BIGINT',
							'auto_increment' => TRUE
						),
					'follower_id' => array(
							'type' => 'BIGINT'
						),
					'meta_key' => array(
							'type' => 'VARCHAR',
							'constraint' => '255'
						),
					'meta_value' => array(
							'type' => 'LONGTEXT'							
						)
				);
			$this->dbforge->add_field($fields10);
			$this->dbforge->add_key('meta_id', TRUE);
			$this->dbforge->create_table('wx_followermeta', TRUE);

			//wx_options
			$fields11 = array(
					'option_id' => array(
							'type' => 'BIGINT',
							'auto_increment' => TRUE
						),					
					'option_name' => array(
							'type' => 'VARCHAR',
							'constraint' => '64'
						),
					'option_value' => array(
							'type' => 'LONGTEXT'							
						)
				);
			$this->dbforge->add_field($fields11);
			$this->dbforge->add_key('option_id', TRUE);
			$this->dbforge->create_table('wx_options', TRUE);
			$fields11_params = array(
					array(
							'option_name' => 'access_token',
							'option_value'  => ''
						),
					array(
							'option_name' => 'expires',
							'option_value' => ''
						),
					array(
							'option_name' => 'work_status',
							'option_value' => 'online'
						)
				);
			$this->db->insert_batch('wx_options',$fields11_params);

			//wx_autoreply
			$fields12 = array(
					'ID' => array(
							'type' => 'BIGINT',
							'auto_increment' => TRUE
						),
					'autoreply_keyword' => array(
							'type' => 'TEXT'
						),
					'autoreply_content' => array(
							'type' => 'LONGTEXT'
						),
					'autoreply_title' => array(
							'type' => 'TEXT'
						),
					'autoreply_excerpt' => array(
							'type' => 'TEXT'
						),
					'autoreply_type' => array(
							'type' => 'VARCHAR',
							'constraint' => '8'
						),
					'autoreply_status' => array(
							'type' => 'VARCHAR',
							'constraint' => '16'
						)
				);
			$this->dbforge->add_field($fields12);
			$this->dbforge->add_key('ID', TRUE);
			$this->dbforge->create_table('wx_autoreply', TRUE);
			$fields12_params = array(
					array(	
							'autoreply_keyword' => 'welcome_reply',
							'autoreply_content' => '你好，欢迎关注！',
							'autoreply_type'  => 'text'
						),
					array(
							'autoreply_keyword' => 'off_duty_reply',
							'autoreply_content' => '你好，我不在电脑前。',
							'autoreply_type'  => 'text'
						)
				);
			$this->db->insert_batch('wx_autoreply',$fields12_params);

			//wx_autoreplymeta
			$fields13 = array(
					'meta_id' => array(
							'type' => 'BIGINT',
							'auto_increment' => TRUE
						),
					'autoreply_id'=> array(
							'type' => 'BIGINT'
						),
					'meta_key' => array(
							'type' => 'VARCHAR',
							'constraint' => '255'
						),
					'meta_value' => array(
							'type' => 'LONGTEXT'
						)
				);
			$this->dbforge->add_field($fields13);
			$this->dbforge->add_key('meta_id', TRUE);
			$this->dbforge->create_table('wx_autoreplymeta', TRUE);

			//wx_selfmenu
			$fields14 = array(
				'ID' => array(
						'type' => 'TINYINT',
						'auto_increment' => TRUE
						),
				'menu_type' => array(
						'type' => 'VARCHAR',
						'constraint' => '10'
						),
				'menu_name' => array(
						'type' => 'VARCHAR',
						'constraint' => '8'
					),
				'menu_key' => array(
						'type' => 'VARCHAR',
						'constraint' => '255',
						),
				'menu_url' => array(
						'type' => 'VARCHAR',
						'constraint' => '255',
						),
				'menu_parent' => array(
						'type' => 'TINYINT',
						),
				'menu_order' => array(
						'type' => 'TINYINT',
						)

			);
			$this->dbforge->add_field($fields14);
			$this->dbforge->add_key('ID', TRUE);
			$this->dbforge->create_table('wx_selfmenu', TRUE);			
		}
	}
?>