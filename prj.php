<html>

<head>
	<title>Hello World</title>
	<h1> Hello</h1>
</head>

<body>
<?php
    
// Get input data
$myuser = $_POST["username"];
$mypass = $_POST["password"];
$action = $_POST["action"];
$host = 'nrb-term.mysql.database.azure.com';
$username = 'nrbadmin@nrb-term';
$password = 'M4W1srtA0l9';
$db_name = 'term_proj';
if ($myuser == "" || $mypass == "")
	echo "Cannot proceed with query\n";
else
{
	//Establishes the connection
	$conn = mysqli_init();
	mysqli_ssl_set($conn,NULL,NULL, "BaltimoreCyberTrustRoot.crt.pem", NULL, NULL) ; 
	mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL);
	if (mysqli_connect_errno($conn)) {
		die('Failed to connect to MySQL: '.mysqli_connect_error());
	}	
	
    $score = 0;
	if($action == "insert")
	{
		$query = "insert into Users values($myuser,$mypass, $score)";
		if ($stmt = mysqli_prepare($conn, "INSERT INTO Users (Username,Passwd, Score) VALUES (?, ?, ?)")) {
			mysqli_stmt_bind_param($stmt, 'ssd', $myuser, $mypass, $score);
			mysqli_stmt_execute($stmt);
			printf("\n");
			mysqli_stmt_close($stmt);
		}	
	}
	else
	{
		$myrows = 0;
		$query = "SELECT Username FROM Users WHERE Username LIKE '%{$myuser}%'";
		$res = mysqli_query($conn,$query);
		
		if (!my_sqli_fetch_array($res))
		{
			echo "Could not find user: $myuser";
		}
		else
		{
			printf("Welcome $myuser");
			if($action == "display")
    				$query = "";
			else if ($action == "update")
			{
				//Run the Update statement
				$new_score = 100;
				if ($stmt = mysqli_prepare($conn, "UPDATE Users SET Score = ? WHERE Username = ?")) {
					mysqli_stmt_bind_param($stmt, 'ds', $new_score, $myuser);
					mysqli_stmt_execute($stmt);
					printf("Update: Affected %d rows\n", mysqli_stmt_affected_rows($stmt));

					//Close the connection
					mysqli_stmt_close($stmt);
				}
			}
			else if ($action == "delete")
			{
				//Run the Delete statement
				if ($stmt = mysqli_prepare($conn, "DELETE FROM Users WHERE Username = ?")) {
					mysqli_stmt_bind_param($stmt, 's', $myuser);
					mysqli_stmt_execute($stmt);
					printf("Delete: Affected %d rows\n", mysqli_stmt_affected_rows($stmt));
					mysqli_stmt_close($stmt);
				}
		
			}

    
			// Final Display of All Entries
			$query = "SELECT Username, Score FROM Users ORDER BY Score DESC,Username LIMIT 0,5";
			$result = mysqli_query($conn,$query);

			// Get the number of rows in the result, as well as the first row
			//  and the number of fields in the rows
			$num_rows = mysqli_num_rows($result);
			//print "Number of rows = $num_rows <br />";

			print "<table><caption> <h2> Users ($num_rows) </h2> </caption>";
			print "<tr align = 'center'>";

			$row = mysqli_fetch_array($result);
			$num_fields = mysqli_num_fields($result);

			// Produce the column labels
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
		}	
	}
}
?>
</body>
</html>
