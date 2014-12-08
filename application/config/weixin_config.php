<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['token'] = 'philosopher';
$config['access_token_url'] = 'https://api.weixin.qq.com/cgi-bin/token';

// grant_type	 是获取access_token填写client_credential
// appid	 是第三方用户唯一凭证
// secret	 是第三方用户唯一凭证密钥，即appsecret
$config['grant_type'] = 'client_credential';
$config['appid'] = 'wxdbf0c50c75787383';
$config['secret'] = 'bff664700da9e51b10c4111f73e595bd';
?>