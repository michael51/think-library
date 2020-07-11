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

if ( !function_exists('slog_warn')) {
	function slog_warn($log)
	{
		return SocketLog::slogWarn($log);
	}
}
if ( !function_exists('slog_error')) {
	function slog_error($log)
	{
		return SocketLog::slogError($log);
	}
}

if ( !function_exists('slog_success')) {
	function slog_success($log)
	{
		return SocketLog::slogSuccess($log);
	}
}
if ( !function_exists('slog_success_big')) {
	function slog_success_big($log)
	{
		return SocketLog::slogSuccessBig($log);
	}
}

if ( !function_exists('slog_handle')) {
	function slog_handle($log)
	{
		return SocketLog::slogHandle($log);
	}
}

if ( !function_exists('slog_handle_big')) {
	function slog_handle_big($log)
	{
		return SocketLog::slogHandleBig($log);
	}
}


function get_this_url ()
{
	return $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
}


function get_site_root ()
{
	return $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["SERVER_NAME"] ;
}


function get_module_statics ($file)
{
	$path = \Env::get('root_path') . '/public/static/' . $file;
	return '/static/' . $file . "?tid=" . filemtime($path);
}


function get_dist_js_path ($file)
{
	$jsPath = config('app.dist_js_path');
	$path = \Env::get('root_path') . '/public/static/dist/'.$jsPath.'/' . $file;

	return '/static/dist/'. $jsPath.'/'. $file . "?v=" . filemtime($path);
}

function get_file_time($path){
	return filemtime(\Env::get('root_path') . '/public/'.$path);
}

