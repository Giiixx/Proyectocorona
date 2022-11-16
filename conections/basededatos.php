<?php
	$server = 'sql10.freesqldatabase.com';
	$username = 'sql10574032';
	$password = 'AXUSHCNL1B';
	$database = 'sql10574032';

    try{
		$conn = new PDO("mysql:host=$server;dbname=$database;",$username, $password);
        
	}catch(PDOException $e){
		die('connection failed: '.$e->getMessage());
	}


?>