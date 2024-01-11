<?php

require dirname(__FILE__) . '/includes/config.php';
require ROOT . '/includes/functions.php';
require ROOT . '/vendor/autoload.php';
require ROOT . '/includes/init.php';

$crons = [
	'dbinit' => 'DBInitController',
];

foreach ($crons as $name => $cName) {
	if ($name === $argv[1]) {
		$controllerName = 'controllers\\' . $cName;
		$controller = new $controllerName;
		$result = $controller->main();
		if (!empty($result)) {
			echo $result;
		}
	}
}
