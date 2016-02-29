<?php
//	error_reporting(E_ALL);
//	ini_set("display_errors", 1);
// var_dump($_GET);

	$root = $_SERVER['DOCUMENT_ROOT']."/";
	
	require_once $root.'backends/admin-backend.php';
	require_once $root.'/'.'views/Layout_View.php';
	
	$option = "links";
	
	$data 	= $backend->loadBackend($option);
	$view 	= new Layout_View($data, 'Links');
	
	echo $view->printHTMLPage($option);
	
	