<?php
	$server = 'localhost';
	$username = 'root';
	$password = 'Skatertlvsk8';
	$database = 'ProyectoBiologicos';

    try{
		$conn = new PDO("mysql:host=$server;dbname=$database;",$username, $password);
        
	}catch(PDOException $e){
		die('connection failed: '.$e->getMessage());
	}


?>