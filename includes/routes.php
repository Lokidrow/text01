<?php
$routes = [
	[
		'url' => '/api/v1/task',
		'controller' => 'TaskController',
		'function' => 'getTasks',
		'name' => 'gettasks',
	], [
		'url' => '/api/v1/task/{id}',
		'controller' => 'TaskController',
		'function' => 'getTask',
		'name' => 'gettask',
	], [
		'url' => '/',
		'controller' => 'WebController',
		'function' => 'index',
		'name' => 'index',
	],
];
