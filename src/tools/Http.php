<?php
/**
 * Created by PhpStorm.
 * User: MichaelRay
 * Date: 2019/10/17
 * Time: 15:25
 */

namespace MichaelRay\ThinkLibrary\tools;

class Http
{
	//发送get情况
	public static function get ($url,$authorization, $params)
	{
		$defaultAuthorization = [
			'token'     => '',
			'timestamp' => '',
		];
		$authorization = array_merge($defaultAuthorization, $authorization);

		$url = "{$url}?" . http_build_query($params);
		if (is_array($params)) {
			$params = json_encode($params);
		}

		$ch  = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json; charset=utf-8',
			'Content-Length:' . strlen($params),
			'Cache-Control: no-cache',
			'Pragma: no-cache',
			"Token: {$authorization['token']}", //发送后可以在服务端 通过$_SERVER['HTTP_TOKEN']获取
			"Timestamp: {$authorization['timestamp']}", //发送后可以在服务端 通过$_SERVER['HTTP_TOKEN']获取

		]);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}

	public static function post ($url,$authorization, $params)
	{
		$defaultAuthorization = [
			'token'     => '',
			'timestamp' => '',
		];
		$authorization = array_merge($defaultAuthorization, $authorization);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		if (is_array($params)) {
			$params = json_encode($params);
		}
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json; charset=utf-8',
			'Content-Length:' . strlen($params),
			'Cache-Control: no-cache',
			'Pragma: no-cache',
			"Token: {$authorization['token']}", //发送后可以在服务端 通过$_SERVER['HTTP_TOKEN']获取
			"Timestamp: {$authorization['timestamp']}", //发送后可以在服务端 通过$_SERVER['HTTP_TOKEN']获取
		]);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}
}
