<?php
/**
 * Created by PhpStorm.
 * Author: MichaelRay <michaelray@vip.qq.com> <http://www.michaelray.cn>
 * Date: 2020/4/7
 * Time: 18:01
 */

namespace helper;

use library\helper\QueryHelper as LibraryQueryHelper;
use library\helper\PageHelper;

class QueryHelper extends LibraryQueryHelper
{
	/**
	 * 设置Like查询条件
	 * @param string|array $fields 查询字段
	 * @param string $input 输入类型 get|post
	 * @param string $alias 别名分割符
	 * @return $this
	 */
	public function like($fields, $input = 'request', $alias = '.')
	{
		$data = $this->app->request->$input();
		foreach (is_array($fields) ? $fields : explode(',', $fields) as $field) {
			list($dk, $qk) = [$field, $field];
			$alias_mode = false;
			if (stripos($field, $alias) !== false) {
				list($dk, $qk) = explode($alias, $field);
				$alias_mode = true;
			}
			if (isset($data[$qk]) && $data[$qk] !== '') {
				if($alias_mode) {
					$this->query->whereLike("{$dk}.{$qk}", "%{$data[$qk]}%");
				} else {
					$this->query->whereLike($dk, "%{$data[$qk]}%");
				}
			}
		}
		return $this;
	}

	/**
	 * 设置Equal查询条件
	 * @param string|array $fields 查询字段
	 * @param string $input 输入类型 get|post
	 * @param string $alias 别名分割符
	 * @return $this
	 */
	public function equal($fields, $input = 'request', $alias = '.')
	{
		$data = $this->app->request->$input();
		foreach (is_array($fields) ? $fields : explode(',', $fields) as $field) {
			list($dk, $qk) = [$field, $field];
			//michael 修复BUG
			$alias_mode = false;
//            slogGroup('equal');
//			slog('$dk：'.$dk);
//			slog('$qk：'.$qk);
//
//            slogGroup('判断是否使用别名');
			if (stripos($field, $alias) !== false) {
//				slog('yes');
				list($dk, $qk) = explode($alias, $field);
//				slog('$dk：'.$dk);
//				slog('$qk：'.$qk);
				$alias_mode = true;
			} else {
//				slog('没有使用');
			}
//			slogGroupEnd();
//			slogGroup('判断data中是否有qk同时qk不能为空字符串');
//			slog($data);
			if (isset($data[$qk]) && $data[$qk] !== '') {
//				slog('true，追加查询条件:'.$data[$qk]);
				if($alias_mode) {
					$this->query->where("{$dk}.{$qk}", "{$data[$qk]}");
				} else {
					$this->query->where($qk, "{$data[$qk]}");
				}
			} else {
//				slog('false');
			}
//			slogGroupEnd();
//
//			slogGroupEnd();
		}
		return $this;
	}

	/**
	 * 设置IN区间查询
	 * @param string $fields 查询字段
	 * @param string $split 输入分隔符
	 * @param string $input 输入类型 get|post
	 * @param string $alias 别名分割符
	 * @return $this
	 */
	public function in($fields, $split = ',', $input = 'request', $alias = '.')
	{
		$data = $this->app->request->$input();
		foreach (is_array($fields) ? $fields : explode(',', $fields) as $field) {
			list($dk, $qk) = [$field, $field];
			$alias_mode = false;
			if (stripos($field, $alias) !== false) {
				list($dk, $qk) = explode($alias, $field);
				$alias_mode = true;
			}
			if (isset($data[$qk]) && $data[$qk] !== '') {
				if($alias_mode) {
					$field = "{$dk}.{$qk}";
				} else {
					$field = $dk;
				}
				$this->query->whereIn($field, explode($split, $data[$qk]));
			}
		}
		return $this;
	}

	/**
	 * 设置内容区间查询
	 * @param string|array $fields 查询字段
	 * @param string $split 输入分隔符
	 * @param string $input 输入类型 get|post
	 * @param string $alias 别名分割符
	 * @return $this
	 */
	public function valueBetween($fields, $split = ' ', $input = 'request', $alias = '.')
	{
		return $this->setBetweenWhere($fields, $split, $input, $alias);
	}

	/**
	 * 设置日期时间区间查询
	 * @param string|array $fields 查询字段
	 * @param string $split 输入分隔符
	 * @param string $input 输入类型
	 * @param string $alias 别名分割符
	 * @return $this
	 */
	public function dateBetween($fields, $split = ' - ', $input = 'request', $alias = '.')
	{
		return $this->setBetweenWhere($fields, $split, $input, $alias, function ($value, $type) {
			if ($type === 'after') {
				return "{$value} 23:59:59";
			} else {
				return "{$value} 00:00:00";
			}
		});
	}

	/**
	 * 设置时间戳区间查询
	 * @param string|array $fields 查询字段
	 * @param string $split 输入分隔符
	 * @param string $input 输入类型
	 * @param string $alias 别名分割符
	 * @return $this
	 */
	public function timeBetween($fields, $split = ' - ', $input = 'request', $alias = '.')
	{
		return $this->setBetweenWhere($fields, $split, $input, $alias, function ($value, $type) {
			if ($type === 'after') {
				return strtotime("{$value} 23:59:59");
			} else {
				return strtotime("{$value} 00:00:00");
			}
		});
	}

	/**
	 * 设置区域查询条件
	 * @param string|array $fields 查询字段
	 * @param string $split 输入分隔符
	 * @param string $input 输入类型
	 * @param string $alias 别名分割符
	 * @param callable $callback
	 * @return $this
	 */
	private function setBetweenWhere($fields, $split = ' ', $input = 'request', $alias = '.', $callback = null)
	{
		$data = $this->app->request->$input();
		foreach (is_array($fields) ? $fields : explode(',', $fields) as $field) {
			list($dk, $qk) = [$field, $field];
			$alias_mode = false;
			if (stripos($field, $alias) !== false) {
				list($dk, $qk) = explode($alias, $field);
				$alias_mode = true;
			}
			if (isset($data[$qk]) && $data[$qk] !== '') {
				list($begin, $after) = explode($split, $data[$qk]);
				if (is_callable($callback)) {
					$after = call_user_func($callback, $after, 'after');
					$begin = call_user_func($callback, $begin, 'begin');
				}
				if($alias_mode) {
					$field = "{$dk}.{$qk}";
				} else {
					$field = $dk;
				}

				$this->query->whereBetween($field, [$begin, $after]);
			}
		}
		return $this;
	}

	/**
	 * 实例化分页管理器
	 * @param boolean $page 是否启用分页
	 * @param boolean $display 是否渲染模板
	 * @param boolean $total 集合分页记录数
	 * @param integer $limit 集合每页记录数
	 * @return mixed
	 * @throws \think\Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 * @throws \think\exception\PDOException
	 */
	public function page($page = true, $display = true, $total = false, $limit = 0)
	{
		return PageHelper::instance()->init($this->query, $page, $display, $total, $limit);
	}
}
