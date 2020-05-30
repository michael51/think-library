<?php
/**
 * Created by PhpStorm.
 * Author: 雷霆科技 <michaelray@vip.qq.com> <https://www.thunderfuture.com>
 * Date: 2020/5/24
 * Time: 11:41
 */

namespace MichaelRay\ThinkLibrary;

class Service
{
	protected $config = [];

	public function __construct (array $config = [])
	{
		$this->init($config);
	}

	public function init (array $config = [])
	{
		$this->config = array_merge($this->config, array_change_key_case($config));
	}

}
