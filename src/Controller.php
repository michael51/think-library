<?php
/**
 * Created by PhpStorm.
 * Author: MichaelRay <michaelray@vip.qq.com> <http://www.michaelray.cn>
 * Date: 2020/4/7
 * Time: 20:45
 * 修复原有的QueryHelper，不支持关联联合查询的BUG。
 */

namespace MichaelRay\ThinkLibrary;

use MichaelRay\ThinkLibrary\helper\QueryHelper;

class Controller extends \library\Controller
{
	protected function _query($dbQuery)
	{
		return QueryHelper::instance()->init($dbQuery);
	}
}
