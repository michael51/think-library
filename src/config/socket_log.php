<?php
/**
 * Created by PhpStorm.
 * Author: 雷霆科技 <michaelray@vip.qq.com> <http://www.thunderfuture.com>
 * Date: 2020/4/9
 * Time: 13:20
 */

return [
	'enable'              => true, //是否记录日志的开关
	'host'                => 'localhost',
	//是否显示利于优化的参数，如果允许时间，消耗内存等
	'optimize'            => true,
	'show_included_files' => false,
	'error_handler'       => false,
	//日志强制记录到配置的client_id
	'force_client_id'     => '',
	//限制允许读取日志的client_id
	'allow_client_ids'    => []
];
