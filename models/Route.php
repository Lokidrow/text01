<?php

namespace models;

class Route {

	static $paths = [];

	/**
	 * Получить контролер по url
	 * @return array
	 */
	public static function getController(): array
	{
		$url = $_SERVER['REQUEST_URI'];
		$pos = strpos($url, '?');
		if ($pos !== false) {
			$url = mb_substr($url, 0, $pos);
		}
		if (empty(self::$paths))
		{
			self::$paths = explode('/', trim($url, '/'));
		}
		require ROOT . '/includes/routes.php';
		foreach ($routes as $route) {
			$controller = self::parseRoute($route);
			if (!empty($controller)) {
				return $controller;
			}
		}
		return [];
	}

	/**
	 * Парсинг адресной строки и определяем подходит ли указанный route под неё
	 * @param array $route
	 * @return array|false
	 */
	private static function parseRoute(array $route)
	{
		$path = explode('/', trim($route['url'], '/'));
		$select = true;
		$vars = [];
		if (count(self::$paths) === count($path))
		{
			for ($i = 0, $c = sizeof($path); $i < $c; $i++)
			{
				preg_match('/^\{([a-zA-Z]+?)\}$/', $path[$i], $m);
				if (!empty($m[1])) {
					$vars[$m[1]] = self::$paths[$i];
				} elseif (self::$paths[$i] !== $path[$i])
				{
					$select = false;
					break;
				}
			}
			if ($select)
			{
				$route['vars'] = $vars;
				return $route;
			}
		}
		return false;
	}

}
