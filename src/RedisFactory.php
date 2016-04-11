<?php

namespace Tomaj\RedisFactory;

class RedisFactory
{
	private static $instance;

	public static function instance($host, $port)
	{
		if (!self::$instance) {
			self::$instance = self::newInstance($host, $port);
		}
		return self::$instance;
	}

	public static function newInstance($host, $port)
	{
		if (extension_loaded('redis')) {
			$redis = new \Redis($host, $port);
			$redis->connect($host, $port);
			return $redis;
		}

		if (class_exists('Predis\Client')) {
			return new \Predis\Client([
				'host' => $host,
				'port' => $port,
			]);
		}

		throw new \Exception('No redis library loaded (ext-redis or predis)');
	}
}