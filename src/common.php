<?php
/**
 * Created by PhpStorm.
 * Author: 雷霆科技 <michaelray@vip.qq.com> <http://www.thunderfuture.com>
 * Date: 2020/4/9
 * Time: 13:26
 */

use MichaelRay\ThinkLibrary\tools\SocketLog;

if ( !function_exists('slog_start')) {
	function slog_start ()
	{
		SocketLog::$logs = [];
	}
}

if ( !function_exists('slog_end')) {
	function slog_end ()
	{
		SocketLog::sendLog();
	}
}

if ( !function_exists('slog_group')) {
	function slog_group ($var)
	{
		return slog($var, 'group');
	}
}

if ( !function_exists('slog_group_end')) {
	function slog_group_end ()
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

if ( !function_exists('slog_big')) {
	function slog_big ($log)
	{
		return SocketLog::big($log);
	}
}
