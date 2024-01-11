<?php

use models\Route;

require dirname(__FILE__, 2) . '/includes/config.php';
require ROOT . '/includes/functions.php';
require ROOT . '/vendor/autoload.php';
require ROOT . '/includes/init.php';

$route = Route::getController();
if (!empty($route)) {
	$controllerName = 'controllers\\' . $route['controller'];
	$controller = new $controllerName;
	$functionName = $route['function'];
	$args = [];
	if (!empty($route['vars'])) {
		try
		{
			$method = new ReflectionMethod($controller, $functionName);
			$params = $method->getParameters();
		} catch (ReflectionException $e)
		{
			$params = [];
		}
		foreach ($params as $param) {
			foreach ($route['vars'] as $var_id => $var_val) {
				if ($var_id === $param->name) {
					$args[$var_id] = $var_val;
				}
			}
		}
	}
	$result = call_user_func_array([$controller, $functionName], $args);
	if (is_array($result)) {
		header('Content-type: application/json');
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	} elseif (is_string($result)) {
		echo $result;
	}
} else {
	header('HTTP/1.0 404 Not Found');
}
