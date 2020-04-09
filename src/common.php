<?php
/**
 * Created by PhpStorm.
 * Author: 雷霆科技 <michaelray@vip.qq.com> <http://www.thunderfuture.com>
 * Date: 2020/4/9
 * Time: 13:26
 */

use MichaelRay\ThinkLibrary\SocketLog;

if ( !function_exists('slogStart')) {
	function slogStart ()
	{
		SocketLog::$logs = [];
	}
}

if ( !function_exists('slogEnd')) {
	function slogEnd ()
	{
		SocketLog::sendLog();
	}
}

if ( !function_exists('slogGroup')) {
	function slogGroup ($var)
	{
		return slog($var, 'group');
	}
}

if ( !function_exists('slogGroupEnd')) {
	function slogGroupEnd ()
	{
		return slog('', 'groupEnd');
	}
}

if ( !function_exists('slog')) {
	function slog ($log, $type = 'log', $css = '')
	{
		return SocketLog::slog($log, $type, $css);
	}
}
