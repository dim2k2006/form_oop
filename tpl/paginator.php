<?php
$pg = new Pagination();
  
   
$pg->setNumberOfPages($sdp->dbsize,$sdp->pageSize); 
$url = $_SERVER['PHP_SELF'];
$pg->draw($sdp->currentPage,$url,$sdp->pageSize);

switch($sdp->pageSize) {
	case 15:
		$active15 = "class=activeNum";
		break;
	case 30:
		$active30 = "class=activeNum";
		break;
	case 45:
		$active45 = "class=activeNum";
		break;
}

$html .= '<div class="paginator">';
$html .= $pg->pagination;
$html .= "<span>Кол-во записей:<a $active15 href=\"?page=1&size=15\">15</a><a $active30 href=\"?page=1&size=30\">30</a><a $active45 href=\"?page=1&size=45\">45</a></span>";
$html .= "<div class='cb'></div>";
$html .= '</div>';
