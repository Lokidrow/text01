<?php
namespace controllers;

use models\Task;

class TaskController extends Controller {

	/**
	 * АПИ получения списка задач
	 * @return array
	 */
	public function getTasks(): array
	{
		$task_m = new Task();
		return $task_m->getTasks();
	}

	/**
	 * АПИ получения одной задачи
	 * @param int $id
	 * @return array
	 */
	public function getTask(int $id): array
	{
		$task_m = new Task();
		return $task_m->findById($id);
	}

}
