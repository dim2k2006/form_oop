<?php
Class Paginator {
	public function get_db () {
		return file('data/db.txt');
	}
	
	public function get_page_num ($db, $pageSizeContent) {
		$dbSize = count($db);
		$pageNum = $dbSize/$pageSizeContent;
		return ((int)$pageNum == $pageNum) ? $pageNum : (int)ceil($pageNum);
	}
	
	public function page_num_checker ($pageNum) {
		if (isset($_GET['page'])) $page = $_GET['page'];
		if (isset($_GET['size'])) $size = $_GET['size'];
		if ($pageNum < $page) {
			echo "<meta http-equiv='refresh' content='0;?page=$pageNum&size=$size#text'>";
		}
	}
	
	public function page_get_content ($db, $pageSizeContent) {
		isset($_GET['page']) ? $page = $_GET['page'] : $page = 1;
		$db = array_reverse($db);
		$startIndex = ($page - 1)*$pageSizeContent;
		$pageItems = array_slice($db, $startIndex, $pageSizeContent);
		$html = "";
		for ($i=0; $i < count($pageItems) ; $i++) { 
			$tmp = explode(';', $pageItems[$i]);
			$rand = rand(1,7);
			$html .= "<li><div><span>$tmp[0]</span><span class='date'>$tmp[3]</span><span class='avatar'><img src='images/$rand.png' width='60' height='60'></span></div><p>$tmp[2]</p></li>";
		}
		unset($tmp);
		return $html;
	}
	
	public function get_paginator ($pageNum) {
		isset($_GET['page']) ? $page = $_GET['page'] : $page = 1;
		isset($_GET['size']) ? $pageSize = $_GET['size'] : $pageSize = 15;
		switch ($pageSize) {
			case 15:
				$active15 = 'class="activeNum"';
				break;
			case 30:
				$active30 = 'class="activeNum"';
				break;
			case 45:
				$active45 = 'class="activeNum"';
				break;
		}
		$html = "";
	
		for ($i=1; $i <= $pageNum; $i++) { 
			$html .= ($i == $page) ? "<a class='pItem active' href=\"?page=$i&size=$pageSize#text\">$i</a>" : "<a class='pItem' href=\"?page=$i&size=$pageSize#text\">$i</a>";
		}
		$html .= "<span>Кол-во записей:<a $active15 href=\"?page=$page&size=15#text\">15</a><a $active30 href=\"?page=$page&size=30#text\">30</a><a $active45 href=\"?page=$page&size=45#text\">45</a></span>";
	
		return $html;
	}
}

$paginator = new Paginator ();