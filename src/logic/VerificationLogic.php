<?php
/**
 * Created by PhpStorm.
 * User: MichaelRay
 * Date: 2019/10/9
 * Time: 12:55
 */

namespace MichaelRay\ThinkLibrary\logic;

use MichaelRay\ThinkLibrary\tools\Jwt;

class VerificationLogic
{
	/**
	 * 验证token是否合法
	 * @param $token [需要验证的token]
	 * @param $timestamp [时间戳]
	 * @return array
	 * demo:$verification_token = VerificationLogic::verificationToken($token, $timestamp);
	 */

	static public function verificationToken ($token, $timestamp)
	{
		$timestamp = (int) $timestamp;
		$this_token = self::generateToken($timestamp);

		if ($this_token !== $token) {
			return ['code' => 400, 'msg' => '令牌非法'];
		} else {
			if (self::isExpire($timestamp)) {
				return ['code' => 401, 'msg' => '令牌过期'];
			} else {
				return ['code' => 0];
			}
		}
	}

	//验证时间戳是否过期（超过600秒为过期）
	//DEMO:$expire = VerificationLogic::isExpire(1564460866);
	static public function isExpire ($timestamp)
	{
		$now = time();
		if ($now - $timestamp > 600) {
			return true;
		} else {
			return false;
		}
	}

	//生成时间搓
	static function generateToken ($timestamp)
	{
		$payload = array(
			'timestamp' => $timestamp
		);
		$jwt = new Jwt();
		$token = $jwt->getToken($payload);

		return $token;
	}
}
