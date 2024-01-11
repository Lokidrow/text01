<?php

namespace models;

use DateInterval;
use DateTime;
use PDO;

class Task extends Model {
	public $count = 0;

	/**
	 * Получить список задач
	 * @param int $limit
	 * @param int $offset
	 * @param string $search
	 * @param bool $cached
	 * @return array
	 */
	public function getTasks(int $limit = 1000, int $offset = 0, string $search = '', bool $cached = true): array
	{
		if ($cached)
		{
			$rows = $this->getCached("tasks");
			if ($rows !== false)
			{
				return $rows;
			}
		}
		if ($search) {
			$res = $this->db->prepare("SELECT SQL_CALC_FOUND_ROWS * from tasks WHERE `title` LIKE :s ORDER BY id LIMIT $offset, $limit");
			$res->execute([
				's' => $search,
			]);
		} else {
			$res = $this->db->query("SELECT SQL_CALC_FOUND_ROWS * from tasks ORDER BY id LIMIT $offset, $limit");
		}
		$res2 = $this->db->query('SELECT FOUND_ROWS()');
		$row = $res2->fetch(PDO::FETCH_NUM);
		$this->count = $row[0] ?? 0;
		$rows = $res->fetchAll(PDO::FETCH_ASSOC);
		if ($cached)
		{
			$this->setCached('tasks', $rows);
		}
		return $rows ?: [];
	}

	/**
	 * Создать новую задачу
	 * @param array $task
	 * @return int
	 */
	public function newTask(array $task): int
	{
		$stat = $this->db->prepare('INSERT INTO tasks (title, `date`, author, `status`, description)
			VALUES (:title, :date, :author, :status, :description)');
		$stat->execute([
			'title' => $task['title'] ?? '',
			'date' => $task['date']->format('Y-m-d H:i:s'),
			'author' => $task['author'] ?? '',
			'status' => $task['status'] ?? '',
			'description' => $task['description'] ?? '',
		]);
		return $this->db->lastInsertId();
	}

	/**
	 * Генерация таблицы задач
	 * @return void
	 */
	public function generateTasks()
	{
		$this->flushCache();
		$this->db->query('CREATE TABLE IF NOT EXISTS `tasks` (
  				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  				`title` varchar(64) NOT NULL DEFAULT "0",
  				`date` timestamp NULL DEFAULT NULL,
  				`author` varchar(64) NOT NULL,
  				`status` varchar(64) NOT NULL,
  				`description` varchar(64) NOT NULL,
  			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;');
		$date = new DateTime();
		for ($i = 0; $i < 1000; $i++) {
			$n = $i + 1;
			$date->add(new DateInterval('PT1H'));
			$this->newTask([
				'title' => 'Задача ' . $n,
				'date' => $date,
				'author' => 'Автор ' . $n,
				'status' => 'Статус ' . $n,
				'description' => 'Описание ' . $n,
			]);
		}
	}

	/**
	 * Получить одну задачу
	 * @param int $id
	 * @return array
	 */
	public function findById(int $id): array
	{
		$stat = $this->db->query('SELECT * FROm tasks WHERE id=' . $id . ' LIMIT 1');
		$row = $stat->fetch(PDO::FETCH_ASSOC);
		return $row ?: [];
	}

}
