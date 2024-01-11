<?php

namespace models;

use Memcached;

abstract class Model {
	protected $db;
	protected $cache;

	public function __construct()
	{
		global $db;
		$this->db = $db;
		$this->cache = new Memcached();
		$this->cache->addServer('127.0.0.1', 11211);
	}

	/**
	 * @param string $key
	 * @return false|mixed
	 */
	protected function getCached(string $key)
	{
		$result = $this->cache->get($key);
		if ($this->cache->getResultCode() == Memcached::RES_NOTFOUND) {
			return false;
		} else {
			return $result;
		}
	}

	/**
	 * @param string $key
	 * @param $value
	 * @return void
	 */
	protected function setCached(string $key, $value) {
		$this->cache->set($key, $value, 3600);
	}

	/**
	 * Очистка кэша
	 * @return void
	 */
	protected function flushCache() {
		$this->cache->flush();
	}

}
