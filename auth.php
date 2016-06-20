<?php
	
	// $pass = hash("sha256", "");
	
	$result = FALSE;
	
	$result = preg_match("/localhost$/", $_SERVER['HTTP_HOST']) === 1;
	
	
	
	return $result;
	