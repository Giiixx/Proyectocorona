<?php
	$server = 'localhost';
	$username = 'root';
	$password = 'Skatertlvsk8';
	$database = 'proyectoBiologicos';

    try{
		$conn = new PDO("mysql:host=$server;dbname=$database;",$username, $password);
        echo "se ingreso correctamentegaaaa";
         
	}catch(PDOException $e){
		die('connection failed: '.$e->getMessage());
	}


?>