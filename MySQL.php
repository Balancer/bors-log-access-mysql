<?php

namespace B2\Log\Access;

class MySQL
{
	static function sum_time()
	{
		$dbh = new \driver_mysql(\B2\Cfg::get('bors_host_db', 'BORS_HOST'));

		if($is_bot)
			$sum_time = $dbh->select('bors_access_log', 'SUM(operation_time)', array(
				'is_bot' => bors()->client()->is_bot(),
				'access_time>' => time() - 600,
			));
		else
		{
			$sum_time = $dbh->select('bors_access_log', 'SUM(operation_time)', array(
				'user_ip' => @$_SERVER['REMOTE_ADDR'],
				'access_time>' => time() - 600,
			));
		}

		return $sum_time;
	}

	static function register($params)
	{
		extract($params);

		$is_bot = bors()->client()->is_bot();
		$is_crawler = bors()->client()->is_crawler();

		$data = [
			'user_ip' => $_SERVER['REMOTE_ADDR'],
			'user_id' => bors()->user_id(),
			'server_uri' => $uri,
			'referrer' => empty($_SERVER['HTTP_REFERER']) ? NULL : $_SERVER['HTTP_REFERER'],
			'access_time' => round($GLOBALS['stat']['start_microtime']),
			'operation_time' =>  str_replace(',', '.', $operation_time),
			'user_agent' => @$_SERVER['HTTP_USER_AGENT'],
			'is_bot' => $is_bot ? $is_bot : NULL,
			'is_crawler' => $is_crawler,
		];

		if(empty($object) || !is_object($object))
		{
			$data['object_class_name'] = $_SERVER['REQUEST_URI'];
			$data['access_url'] = $uri;
		}
		else
		{
			$data['object_class_name'] = $object->class_name();
			$data['object_id'] = $object->id();
			$data['has_bors'] = 1;
			$data['has_bors_url'] = 1;
			$data['access_url'] = ($u=$object->url()) ? $u : $uri;
		}

		bors_new('bors_access_log', $data);
	}
}
