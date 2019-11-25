<html>

<head>
	<title>Deleting Account</title>
	<link rel="stylesheet" type="text/css" href="./php_style.css">
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
				<form action=\"index.html\" target=\"_self\"><input type=\"submit\" value=\"Return\"></form></div>");
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
	

		$query = "SELECT Passwd FROM Users WHERE Username LIKE '%{$myuser}%' && Passwd LIKE '%{$mypass}%'";
		$res = mysqli_query($conn,$query);
		if (mysqli_fetch_array($res) == "")
		{
			printf("<div class=\"error\"><p>Error: Could not find user <strong>$name</strong> <br/> Perhaps you entered the wrong password or username?</p>
				<form action=\"index.html\" target=\"_self\"><input type=\"submit\" value=\"Return to Main\"></form></div>");
		}
		else
		{
			

				//Run the Delete statement
				if ($stmt = mysqli_prepare($conn, "DELETE FROM Users WHERE Username = ?")) {
					mysqli_stmt_bind_param($stmt, 's', $myuser);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_close($stmt);
				}
				
				printf("<div class=\"welcome\"<p>Hello <strong>$myuser</strong></p>
					<div class=\"error\"><p>Your account was deleted successfully</p></div>
					<div class=\"nav\"><form action=\"index.html\" target=\"_self\"><input type=\"submit\" value=\"Return\"></form></div></div>"
					);
		
			
    
		}	
}
?>
</body>
</html>