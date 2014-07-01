<?php
isset($_GET['size']) ? $pageSizeContent = $_GET['size'] : $pageSizeContent = 15;
require_once 'form.class.php';
require_once 'paginator.class.php';