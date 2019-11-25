<?php 
	header("Access-Control-Allow-Credentials: true");
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
	header('Access-Control-Allow-Headers: Accept, X-Access-Token, X-Application-Name, X-Request-Sent-Time');

	$host = 'nrb-term.mysql.database.azure.com';
	$username = 'nrbadmin@nrb-term';
	$password = 'M4W1srtA0l9';
	$db_name = 'term_proj';
	
	// Strings must be escaped to prevent SQL injection attack. 
    $name = $_POST["namePost"];
    $score = $_POST["scorePost"]; 
    $hash = $_POST["hashPost"];
	
	$conn = mysqli_init();
	mysqli_ssl_set($conn,NULL,NULL, "BaltimoreCyberTrustRoot.crt.pem", NULL, NULL) ; 
	mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL);
	if (mysqli_connect_errno($conn)) {
		die('Failed to connect to MySQL: '.mysqli_connect_error());
	}	
  
	$secretKey="insertsecretcodehere";
  
	$real_hash = md5($name . $score . $secretKey); 
    if($real_hash == $hash) { 
        // Send variables for the MySQL database class. 
		if ($stmt = mysqli_prepare($conn, "UPDATE Users SET Score = ? WHERE Username = ?")) {
				mysqli_stmt_bind_param($stmt, 'ds', $score, $name);
				mysqli_stmt_execute($stmt);
				//Close the connection
				mysqli_stmt_close($stmt);
				//printf("<p>User $name: Congrats! You have achieved a new high score</p>");
		}
				
	}
  
  //Check Connection
  if(!$conn){
    die("Connection Failed. ". mysqli_connect_error());
  }
?>

<!--<?php> //Run the Update statement

		$host = 'nrb-term.mysql.database.azure.com';
		$username = 'nrbadmin@nrb-term';
		$password = 'M4W1srtA0l9';
		$db_name = 'term_proj';
		$conn = mysqli_init();
		mysqli_ssl_set($conn,NULL,NULL, "BaltimoreCyberTrustRoot.crt.pem", NULL, NULL) ; 
		mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL);
		if (mysqli_connect_errno($conn)) {
			die('Failed to connect to MySQL: '.mysqli_connect_error());
		}	
 
        // Strings must be escaped to prevent SQL injection attack. 
        $name = mysql_real_escape_string($_GET['name'], $db); 
        $score = mysql_real_escape_string($_GET['score'], $db); 
        $hash = $_GET['hash']; 
        $secretKey="mySecretKey"; # Change this value to match the value stored in the client javascript below 

        $real_hash = md5($name . $score . $secretKey); 
        if($real_hash == $hash) { 
            // Send variables for the MySQL database class. 
			if ($stmt = mysqli_prepare($conn, "UPDATE Users SET Score = ? WHERE Username = ?")) {
					mysqli_stmt_bind_param($stmt, 'ds', $score, $name);
					mysqli_stmt_execute($stmt);
					//Close the connection
					mysqli_stmt_close($stmt);
					//printf("<p>User $name: Congrats! You have achieved a new high score</p>");
			}
				
        } 
				
?>-->