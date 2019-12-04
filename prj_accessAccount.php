<html>

<head>
	<link rel="stylesheet" type="text/css" href="./php_style.css">
	<title>User Home</title>
</head>

<body>

<?php
    
// Get input data
$myuser = $_POST["username"];
$mypass = $_POST["password"];
$host = 'nrb-term.mysql.database.azure.com';
$username = 'nrbadmin@nrb-term';
$password = 'M4W1srtA0l9';
$db_name = 'term_proj';

if ($myuser == "" || $mypass == "")
{
	printf("<div class=\"error\">Cannot proceed with query: All form fields must be filled in\n
				<form action=\"index.html\" target=\"_self\"><input type=\"submit\" value=\"Return to Main\"></form></div>");
}
else
{
	//Establishes the connection
	$conn = mysqli_init();
	mysqli_ssl_set($conn,NULL,NULL, "BaltimoreCyberTrustRoot.crt.pem", NULL, NULL) ; 
	mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL);
	if (mysqli_connect_errno($conn)) {
		die('Failed to connect to MySQL: '.mysqli_connect_error());
	}	

		$query = "SELECT Passwd, Score FROM Users WHERE Username LIKE '%{$myuser}%'";//&& Passwd LIKE '%{$mypass}%'";
		$res = mysqli_query($conn,$query);
		$user_row = mysqli_fetch_assoc($res);
		
		
		if ($user_row == "" || $user_row["Passwd"] != $mypass)
		{
			printf("<div class=\"error\"><p>Error: Could not find user <strong>$myuser</strong> <br/> Perhaps you entered the wrong password or username?</p>
					<form action=\"index.html\" target=\"_self\"><input type=\"submit\" value=\"Return\"></form>");
		}
		else
		{
		
			$myscore = $user_row["Score"];
			
			printf("<div class=\"welcome\"><span>Welcome <strong>$myuser</strong></span>
					<div class=\"nav\"><button onclick=\"window.location.href = 'index.html';\">Logout</button>
					<button onclick=\"window.location.href = 'prj_deleteAccount.html';\">Delete Account</button>
					<button onclick=\"window.location.href = 'ind.html';\">Go to Game</button></div>
					<div style=\"font-size: 20; margin-top: 20;\"><em>Your High Score: <strong>$myscore</strong></em></div></div>");
    
			// Final Display of All Entries
			$query = "SELECT Username, Score FROM Users ORDER BY Score DESC,Username LIMIT 0,5";
			$result = mysqli_query($conn,$query);
			$num_rows = mysqli_num_rows($result);
			
			$row = mysqli_fetch_array($result);
			$num_fields = mysqli_num_fields($result);
			$keys = array_keys($row);
			print "<table><caption>Leaderboard</caption>";
			print "<tr align = 'center'>";
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
					print "<td>" . $value . "</td> ";
    			}
   		 		print "</tr>";
    			$row = mysqli_fetch_array($result);
			}
			print "</table>";
		}	
	
}
?>
</body>
</html>
