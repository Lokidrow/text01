<?php
namespace controllers;

use models\Task;

class WebController extends Controller {

	const PER_PAGE = 10;

	public function index(): string
	{
		$task_m = new Task();
		$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
		$search = $_GET['s'] ?? '';
		$tasks = $task_m->getTasks(self::PER_PAGE, ($page - 1) * self::PER_PAGE, $search, false);
		return $this->view('index', [
			'tasks' => $tasks,
			'pages' => ceil($task_m->count / self::PER_PAGE),
			'page' => $page,
			'search' => $search,
		]);
	}

}
