<?php
Class FileDataProcessing implements DataProcessing {
	public $path = "";
	public $dbSize = "";
	public $pageSize = "";
	public $currentPage = "";

	public function __construct ($path) {
		$this->path = $path;
	}
	
	/**
	*Сохраняет полученные данные в файл
	*@param array
	*/
	public function saveData () {
		$content = "\n";
		$numargs = func_num_args();
		
		$arg_list = func_get_args();
		for ($i = 0; $i < $numargs; $i++) {
			$content .= (str_replace(";", "",$arg_list[$i])).';';
		}
	
		if (file_exists($this->path)) {
			$file = fopen($this->path, 'a+');
			fwrite($file, $content);
			fclose($file);
		}
		
		
		setcookie("GuestBookName", $arg_list[0], mktime(0, 0, 0, date("n"), date("j"), date("Y")+1));
		setcookie("GuestBookEmail", $arg_list[1], mktime(0, 0, 0, date("n"), date("j"), date("Y")+1));
			
		$url = $_SERVER['PHP_SELF'];
		header('Location: '.$url);
		exit;
	}
	
	
	/**
	*Возвращает данные из файла
	*@param 
	*@return string
	*/
	public function getData () {
		$this->pageSize = (isset($_GET['size'])) ? $_GET['size'] : 15;
		$this->currentPage = (isset($_GET['page'])) ? $_GET['page'] : 1;
		$db = file($this->path);
		$this->dbsize = count($db);
		$pageNum = $this->dbsize/$this->pageSize;
		$pageNum = ((int)$pageNum == $pageNum) ? $pageNum : (int)ceil($pageNum);
		
		$db = array_reverse($db);
		$startIndex = ($this->currentPage - 1)*$this->pageSize;
		$pageItems = array_slice($db, $startIndex, $this->pageSize);
		
		for ($i=0; $i < count($pageItems) ; $i++) { 
			$tmp = explode(';', $pageItems[$i]);
			$rand = rand(1,7);
			$html .= "<li><div><span>$tmp[0]</span><span class='date'>$tmp[3]</span><span class='avatar'><img src='images/$rand.png' width='60' height='60'></span></div><p>$tmp[2]</p></li>";
		}
		unset($tmp);
		return $html;
	}
}

