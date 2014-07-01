<?php
	//получаем базу данных
	$db = $paginator -> get_db ();

	//получаем кол-во страниц
	$pageNum = $paginator -> get_page_num ($db, $pageSizeContent);

	//проверяем текущую страницу
	$paginator -> page_num_checker ($pageNum);

	//выводим содержимое текущей страницы
	$content = $paginator -> page_get_content ($db, $pageSizeContent);
	$html .= "<a id='text'></a><ul>$content</ul>";
?>