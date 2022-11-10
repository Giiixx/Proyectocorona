<?php
	$server = 'localhost';
	$username = 'root';
	$password = 'root';
	$database = 'ProyectoBiologicos';

    try{
		$conn = new PDO("mysql:host=$server;dbname=$database;",$username, $password);
        echo "se ingreso correctamentegaaaa";
         
	}catch(PDOException $e){
		die('connection failed: '.$e->getMessage());
	}


?>