<?php
function pr($s) {
	echo '<pre>';
	print_r($s);
	echo '</pre>';
}

function getUrl(int $page, string $search = ''): string
{
	$params = '';
	if ($page > 1) {
		$params = 'p=' . $page;
	}
	if ($search) {
		if ($params) {
			$params .= '&';
		}
		$params .= 's=' . $search;
	}
	return '/' . ($params ? '?' . $params : '');
}
