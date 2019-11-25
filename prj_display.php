<html>

<head>
	<title>Update Score</title>
	<h1> Updating your score</h1>
</head>
<body>
<?php
	$host = 'nrb-term.mysql.database.azure.com';
	$username = 'nrbadmin@nrb-term';
	$password = 'M4W1srtA0l9';
	$db_name = 'term_proj';
	
    //Establishes the connection
	$conn = mysqli_init();
	mysqli_ssl_set($conn,NULL,NULL, "BaltimoreCyberTrustRoot.crt.pem", NULL, NULL) ; 
	mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL);
	if (mysqli_connect_errno($conn)) {
		die('Failed to connect to MySQL: '.mysqli_connect_error());
 
    // Final Display of All Entries
			$query = "SELECT Username, Score FROM Users ORDER BY Score DESC,Username LIMIT 0,5";
			$result = mysqli_query($conn,$query);
			$num_rows = mysqli_num_rows($result);
			print "<table><caption>High Scores</caption>";
			print "<tr align = 'center'>";
			$row = mysqli_fetch_array($result);
			$num_fields = mysqli_num_fields($result);
			$keys = array_keys($row);
			for ($index = 0; $index < $num_fields; $index++)
			{
				print "<th>" . $keys[2 * $index + 1] . "</th>";
			}
    
			print "</tr>";
    
			// Output the values of the fields in the rows
			for ($row_num = 0; $row_num < $num_rows; $row_num++) {
    			print "<tr align = 'center'>";
    			$values = array_values($row);
    			for ($index = 0; $index < $num_fields; $index++){
					$value = htmlspecialchars($values[2 * $index + 1]);
					print "<th>" . $value . "</th> ";
    			}
   		 		print "</tr>";
    			$row = mysqli_fetch_array($result);
			}
			print "</table>";
?>
</body>
</html>