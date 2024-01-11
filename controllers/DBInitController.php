<?php

namespace controllers;

use models\Task;

class DBInitController extends Cron {
	public function main() {
		$task_dp = new Task();
		$task_dp->generateTasks();
		echo "ok\n";
	}

}
