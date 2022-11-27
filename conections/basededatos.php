<?php
	$server = 'localhost';
	$username = 'root';
	$password = 'root';
	$database = 'ProyectoBiologico';

    try{
		$conn = new PDO("mysql:host=$server;dbname=$database;",$username, $password);
        
	}catch(PDOException $e){
		die('connection failed: '.$e->getMessage());
	}


?>