<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Advanced_media extends CI_Model
	{

		public function __construct(){		
			parent::__construct();
			require_once APPPATH.'libraries/common/GlobalFunctions.php';
		}

		public function get($access_token, $media_id){
			if($access_token == "" || $media_id == "" ){
				return false;
			}

			$get_url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$access_token.'&media_id='.$media_id;
			// $result = doCurlGetRequest($get_url);
			// return $result;

			$ch = curl_init($get_url);
	        curl_setopt($ch, CURLOPT_HEADER, 0);    
	        curl_setopt($ch, CURLOPT_NOBODY, 0);    //对body进行输出。
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        $package = curl_exec($ch);
	        $httpinfo = curl_getinfo($ch);			

			curl_close($ch);
        	$media = array_merge(array('mediaBody' => $package), $httpinfo);

        	//求出文件格式
	        preg_match('/\w\/(\w+)/i', $media["content_type"], $extmatches);
	        $fileExt = $extmatches[1];
	        $filename = time().rand(100,999).".{$fileExt}";
	        $time = getCurrentDate();
	        $dirname = "./download/".$time;
	        if(!file_exists($dirname)){
	            mkdir($dirname,0777,true);
	        }
	        file_put_contents($dirname.$filename,$media['mediaBody']);
	        return $dirname.$filename;			
		}

		public function set($access_token, $type, $file){
			if($access_token == "" || $type =="" || $file == "" ){
				return false;
			}

			$post_url = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token='.$access_token.'&type='.$type;
			$fields['media'] = '@'.$file;						
			//$result = doCurlPostRequest($post_url, $fields);

			$ch = curl_init($post_url) ;		       
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        $result = curl_exec($ch) ;
	        curl_close($ch);
			return $result;
		}
	}

?>