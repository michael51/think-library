<?php
/**
 * Created by PhpStorm.
 * Author: 雷霆科技 <michaelray@vip.qq.com> <https://www.thunderfuture.com>
 * Date: 2020/5/8
 * Time: 9:33
 */
namespace MichaelRay\ThinkLibrary;

use think\facade\Hook;
use think\facade\Response;

class ThunderController extends \think\Controller
{
	public function __construct (\think\App $app = null)
	{
		parent::__construct($app);
	}

	protected function fetch($template = '', $vars = [], $config = [])
	{
		//变量注入到模板，可以把this的变量注入到模板，比较方便。
		$arr = ['string','integer','array'];
		foreach ($this as $key => $info) {
			if(in_array(gettype($info),$arr)) {
				if ($key !== 'beforeActionList' && $key !== 'middleware') {
					$this->view->$key = $info;
				}
			}
		}

		return Response::create($template, 'view')->assign($vars)->config($config);
	}
}
