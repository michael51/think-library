<?php
/**
 * Created by PhpStorm.
 * Author: 雷霆科技 <michaelray@vip.qq.com> <http://www.thunderfuture.com>
 * Date: 2020/4/7
 * Time: 21:18
 */
namespace thunder_library\tools;

class Tools
{
	public static function  exeUrl($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		$output = curl_exec($ch);
		curl_close($ch);

		return json_decode($output, true);
	}

	public static function getUUID ()
	{
		$char_id = self::getHash();

		return $char_id;
	}

	public static function removeValueByArrValue (&$arr, $value)
	{
		foreach ($arr as $key=> $v)
		{
			if ($v == $value){
				unset($arr[$key]);
			}
		}
	}

	public static function handleLocalDomainForUrl ($url)
	{
		if(strpos($url,'http')!==false) {
			return $url;
		} else {
			return self::getHostUrl().$url;
		}
	}

	public static function getHostUrl ()
	{
		if (self::isHttps()) {
			return 'https://' . $_SERVER['HTTP_HOST'] . '/';
		} else {
			return 'http://' . $_SERVER['HTTP_HOST'] . '/';
		}
	}

	/**
	 * PHP判断当前协议是否为HTTPS
	 */
	private static function isHttps() {
		if ( !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
			return true;
		} elseif ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
			return true;
		} elseif ( !empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
			return true;
		}
		return false;
	}

	public static function isWechat(){
		if ( strpos($_SERVER['HTTP_USER_AGENT'],
				'MicroMessenger') !== false ) {
			return true;
		}
		return false;
	}

	public static function isMobile (){
		$agent      = strtolower($_SERVER['HTTP_USER_AGENT']);
		$is_pc      = (strpos($agent, 'windows nt')) ? true : false;
		$is_mac     = (strpos($agent, 'mac os')) ? true : false;
		$is_iphone  = (strpos($agent, 'iphone')) ? true : false;
		$is_android = (strpos($agent, 'android')) ? true : false;
		$is_ipad    = (strpos($agent, 'ipad')) ? true : false;
		if ($is_pc) {
			return false;
		}
		if ($is_mac) {
			return true;
		}
		if ($is_iphone) {
			return true;
		}
		if ($is_android) {
			return true;
		}
		if ($is_ipad) {
			return true;
		}
	}


	/**
	 * 生成唯一编码
	 * Author: MichaelRay
	 * Date: 2020/3/27
	 * Time: 17:56
	 * @param $length
	 * @return string
	 */
	public static function generateUniquelyNumberCode($length){
		$time = time() . '';
		if ($length < 10) $length = 10;
		$string = ($time[0] + $time[2]) . substr($time, 2) . rand(0, 9);
		while (strlen($string) < $length) $string .= rand(0, 9);
		return $string;
	}

	/**
	 * 生成唯一32位hash
	 * Author: MichaelRay
	 * Date: 2020/3/28
	 * Time: 17:24
	 * @return string
	 */
	public static function getHash(){
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()+-';
		$random = $chars[mt_rand(0,73)].$chars[mt_rand(0,73)].$chars[mt_rand(0,73)].$chars[mt_rand(0,73)].$chars[mt_rand(0,73)];//Random 5 times
		$content = uniqid().$random;  // 类似 5443e09c27bf4aB4uT
		return md5($content);
	}

	public static function getHashId(){
		return uniqid(mt_rand(1, 9));
	}
}
