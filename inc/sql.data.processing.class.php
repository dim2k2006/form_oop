<?php
Class SqlDataProcessing implements DataProcessing {
	public $dbSize = "";
	public $pageSize = "";
	public $currentPage = "";

	private $dbPrefix = "";
	private $dbName = "";
	private $dbUser = "";
	private $dbPassword = "";
	private $dbHost = "";
	private $dbCharset = "";
	
	private $dbConnection = "";
	
	public function __construct ($dbPrefix, $dbName, $dbUser, $dbPassword, $dbHost, $dbCharset) {
		$this->dbPrefix = $dbPrefix;
		$this->dbName = $dbName;
		$this->dbUser = $dbUser;
		$this->dbPassword = $dbPassword;
		$this->dbHost = $dbHost;
		$this->dbCharset = $dbCharset;
		
		try {
			$this->dbConnection = new PDO('mysql:host='.$this->dbHost.';dbname='.$this->dbPrefix.'_'.$this->dbName, $this->dbUser, $this->dbPassword);
		} catch (Exception $ex) {
			exit('Проблема с подключением к БД: '.$ex->getMessage());
		}
	}
	
	/**
	*Сохраняет полученные данные в базу данных sql
	*@param array
	*/
	public function saveData () {
		$arg_list = func_get_args();
		$statement = $this->dbConnection->prepare("INSERT INTO ".$this->dbPrefix."_comments (id, name, email, message, date, ip, browser) values (:id, :name, :email, :message, :date, :ip, :browser)");
		$rowsCount = $statement->execute(array('id' => '', 'name' => $arg_list[0], 'email' => $arg_list[1], 'message' => $arg_list[2], 'date' => $arg_list[3], 'ip' => $arg_list[4], 'browser' => $arg_list[5]));
		if($rowsCount == 0) {
			echo 'Ошибка вставки данных: '.print_r($statement->errorInfo(), true);
		}
		
		setcookie("GuestBookName", $arg_list[0], mktime(0, 0, 0, date("n"), date("j"), date("Y")+1));
		setcookie("GuestBookEmail", $arg_list[1], mktime(0, 0, 0, date("n"), date("j"), date("Y")+1));
			
		$url = $_SERVER['PHP_SELF'];
		header('Location: '.$url);
		exit;
	}
	
	
	/**
	*Возвращает данные из базы данных sql
	*@param 
	*@return string
	*/
	public function getData () {
		$this->pageSize = (isset($_GET['size'])) ? $_GET['size'] : 15;
		$this->currentPage = (isset($_GET['page'])) ? $_GET['page'] : 1;
		$statement = $this->dbConnection->prepare("SELECT * FROM ".$this->dbPrefix."_comments");
		$statement ->setFetchMode(PDO::FETCH_NUM);
		$statement->execute();
		$db = $statement->fetchAll();
		$this->dbsize = count($db);
		$pageNum = $this->dbsize/$this->pageSize;
		$pageNum = ((int)$pageNum == $pageNum) ? $pageNum : (int)ceil($pageNum);
		
		$db = array_reverse($db);
		$startIndex = ($this->currentPage - 1)*$this->pageSize;
		$pageItems = array_slice($db, $startIndex, $this->pageSize);
		
		$count = count($pageItems);
		
		for ($i=0; $i < $count ; $i++) { 
			$rand = rand(1,7);
			$name = $pageItems[$i][1];
			$date = $pageItems[$i][4];
			$message = $pageItems[$i][3];
			$html .= "<li><div><span>$name</span><span class='date'>$date</span><span class='avatar'><img src='images/$rand.png' width='60' height='60'></span></div><p>$message</p></li>";
		}
		
		unset($tmp);
		return $html;
	}
}

