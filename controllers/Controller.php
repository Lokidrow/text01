<?php

namespace controllers;

abstract class Controller {
	/**
	 * @param string $view
	 * @param array $vars
	 * @return string
	 */
	protected function view(string $view, array $vars): string
	{
		$___filename = ROOT . '/views/' . $view . '.php';
		if (file_exists($___filename)) {
			ob_start();
			extract($vars);
			include $___filename;
			return ob_get_clean();
		}
		return '';
	}

}
