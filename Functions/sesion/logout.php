<?php 
	session_start();
	
	session_unset();
	
	session_destroy();
	
	header('Location:/public_html/templates/index.php');
?>