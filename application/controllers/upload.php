<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	require_once APPPATH.'libraries/common/GlobalFunctions.php';

	class Upload extends CI_Controller
	{

		public function __construct(){
			parent::__construct();
			$this->load->model('system_model');
			$this->load->model('advanced/advanced_media');
			$this->load->helper(array('form', 'url'));
		}

		public function index(){
			$time = getCurrentDate();
			$dirname = "./upload/".$time;
			if(!file_exists($dirname)){
	            mkdir($dirname,0777,true);
	        }

	        $config['upload_path'] = $dirname;
			$config['allowed_types'] = 'gif|jpg|png|mpg4|mpg|mpeg|mp4|mp3|amr';
			$config['file_name'] = time();
			$config['max_size'] = '0';
			$config['max_width']  = '0';
			$config['max_height']  = '0';

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload()){
				$error = array('error' => $this->upload->display_errors());
				$result = json_encode($error);
				echo $result;
			}else{
				$data = array('upload_data' =>$this->upload->data());
				$file_path = base_url().$dirname.'/'.$data['upload_data']['file_name'];
				$data['upload_data']['full_path'] = $file_path;
				$result = json_encode($data);
				echo $result;
			}
		}

		public function pic_upload(){
			$time = getCurrentDate();
			$dirname = "./upload/".$time;
			if(!file_exists($dirname)){
	            mkdir($dirname,0777,true);
	        }

			$config['upload_path'] = $dirname;
			$config['allowed_types'] = 'jpg';
			$config['file_name'] = time();
			$config['max_size'] = '128';
			$config['max_width']  = '0';
			$config['max_height']  = '0';

			$this->load->library('upload', $config);

			$field_name = "pic_media";
			if ( ! $this->upload->do_upload($field_name)){
				$error = array('error' => $this->upload->display_errors());
				$result = json_encode($error);
				echo $result;
			}else{
				$data = array('upload_data' => $this->upload->data());

				$access_token = $this->system_model->get_access_token();
				$file = $data['upload_data']['full_path'];
				$type = "image";

				//上传至微信服务器，获得media_id				
				$result = $this->advanced_media->set($access_token, $type, $file);
				$output_array = json_decode($result,true);

				if( !$output_array || $output_array['errcode']){	
					return false;
				}
				echo $result;
			}
		}

		public function thumb_upload(){
			$time = getCurrentDate();
			$dirname = "./upload/".$time;
			if(!file_exists($dirname)){
	            mkdir($dirname,0777,true);
	        }

			$config['upload_path'] = $dirname;
			$config['allowed_types'] = 'jpg';
			$config['file_name'] = time();
			$config['max_size'] = '64';
			$config['max_width']  = '0';
			$config['max_height']  = '0';

			$this->load->library('upload', $config);

			$field_name = "thumb_media";
			if ( ! $this->upload->do_upload($field_name)){
				$error = array('error' => $this->upload->display_errors());
				$result = json_encode($error);
				echo $result;
			}else{
				$data = array('upload_data' => $this->upload->data());

				$access_token = $this->system_model->get_access_token();
				$file = $data['upload_data']['full_path'];
				$type = "image";

				//上传至微信服务器，获得media_id				
				$result = $this->advanced_media->set($access_token, $type, $file);
				$output_array = json_decode($result,true);

				if( !$output_array || $output_array['errcode']){	
					return false;
				}
				echo $result;
			}
		}

		public function video_upload(){
			$time = getCurrentDate();
			$dirname = "./upload/".$time;
			if(!file_exists($dirname)){
	            mkdir($dirname,0777,true);
	        }

			$config['upload_path'] = $dirname;			
			$config['allowed_types'] = 'mpg4|mpg|mpeg|mp4';
			$config['file_name'] = time();
			$config['max_size'] = '1024';
			$config['max_width']  = '0';
			$config['max_height']  = '0';

			$this->load->library('upload', $config);

			$field_name = "video_media";
			if ( ! $this->upload->do_upload($field_name)){
				$error = array('error' => $this->upload->display_errors());
				$result = json_encode($error);
				echo $result;
			}else{
				$data = array('upload_data' => $this->upload->data());

				$access_token = $this->system_model->get_access_token();
				$file = $data['upload_data']['full_path'];
				$type = "video";

				//上传至微信服务器，获得media_id				
				$result = $this->advanced_media->set($access_token, $type, $file);
				$output_array = json_decode($result,true);

				if( !$output_array || $output_array['errcode']){	
					return false;
				}
				echo $result;
			}
		}

		public function voice_upload(){
			$time = getCurrentDate();
			$dirname = "./upload/".$time;
			if(!file_exists($dirname)){
	            mkdir($dirname,0777,true);
	        }

			$config['upload_path'] = $dirname;			
			$config['allowed_types'] = 'mp3|amr';
			$config['file_name'] = time();
			$config['max_size'] = '256';
			$config['max_width']  = '0';
			$config['max_height']  = '0';

			$this->load->library('upload', $config);

			$field_name = "voice_media";
			if ( ! $this->upload->do_upload($field_name)){
				$error = array('error' => $this->upload->display_errors());
				$result = json_encode($error);
				echo $result;
			}else{
				$data = array('upload_data' => $this->upload->data());

				$access_token = $this->system_model->get_access_token();
				$file = $data['upload_data']['full_path'];
				$type = "voice";

				//上传至微信服务器，获得media_id				
				$result = $this->advanced_media->set($access_token, $type, $file);
				$output_array = json_decode($result,true);

				if( !$output_array || $output_array['errcode']){	
					return false;
				}
				echo $result;
			}
		}
	}

?>