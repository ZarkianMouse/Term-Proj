<html>

<head>
	<title>Update Score</title>
	<link rel="stylesheet" type="text/css" href="./php_style.css">
</head>
<body>

<?php 

	$host = 'nrb-term.mysql.database.azure.com';
	$username = 'nrbadmin@nrb-term';
	$password = 'M4W1srtA0l9';
	$db_name = 'term_proj';
	
	// Strings must be escaped to prevent SQL injection attack. 
    $name = $_POST["username"];
	$pass = $_POST["password"];
    $score = $_POST["score"]; 
	
	if ($name == "" || $pass == "")
	{
		printf("<div class=\"error\">Cannot proceed with query: All form fields must be filled in\n
				<form action=\"ind.html\" target=\"_self\"><input type=\"submit\" value=\"Return to Game\"></form></div>");
	}
	else
	{
		$conn = mysqli_init();
		mysqli_ssl_set($conn,NULL,NULL, "BaltimoreCyberTrustRoot.crt.pem", NULL, NULL) ; 
		mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL);
		if (mysqli_connect_errno($conn)) {
			die('Failed to connect to MySQL: '.mysqli_connect_error());
		}	
		$query = "SELECT Score FROM Users WHERE Username LIKE '%{$name}%' && Passwd LIKE '%{$pass}%'";
		$res = mysqli_query($conn,$query);
		if (mysqli_fetch_array($res) == "")
		{
			printf("<div class=\"error\"><p>Error: Could not find user <strong>$name</strong> <br/> Perhaps you entered the wrong password or username?</p>
				<form action=\"index.html\" target=\"_self\"><input type=\"submit\" value=\"Return\"></form></div>");
		}
		
		else
		{
			$row= mysqli_fetch_assoc($res);
			$current_score = htmlspecialchars($row["Score"]);
			//current_score = $row["Score"];
			echo $current_score;
			if ($current_score < $score)
			{
			// Send variables for the MySQL database class. 
				if ($stmt = mysqli_prepare($conn, "UPDATE Users SET Score = ? WHERE Username = ?")) {
					mysqli_stmt_bind_param($stmt, 'ds', $score, $name);
					mysqli_stmt_execute($stmt);
					//Close the connection
					mysqli_stmt_close($stmt);
					printf("<div class=\"welcome\"><p>User <strong>$name</strong>: Congrats! You have achieved a new high score</p>");
				}
				
			}
			printf("<div class=\"nav\"><form action=\"prj_accessAccount.php\" target=\"_self\" method=\"post\"><table hidden><tr>
				<td><input type=\"text\" name=\"username\" value=\"$name\" hidden></td>
				</tr>
				<tr>
					<td><input type=\"password\" name=\"password\" value=\"$pass\" hidden></td>
				</tr></table><p><input type=\"submit\" value=\"Return to Home\"></p></form></div></div>");
		}
	}

?>
</body>
</html>