<?php
	//выводим пагинатор
	$paginator = $paginator -> get_paginator ($pageNum);
	$html .= "<div class='paginator'>$paginator</div>";
?>
