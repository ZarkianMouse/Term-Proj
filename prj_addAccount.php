<html>

<head>
	<title>Adding Account</title>
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
	
    $score = 0;
	$query = "SELECT Username FROM Users WHERE Username LIKE '%{$myuser}%'";
	$res = mysqli_query($conn,$query);
	if (mysqli_fetch_array($res) == "")
	{
		if ($stmt = mysqli_prepare($conn, "INSERT INTO Users (Username,Passwd, Score) VALUES (?, ?, ?)")) {
			mysqli_stmt_bind_param($stmt, 'ssd', $myuser, $mypass, $score);
			mysqli_stmt_execute($stmt);
			printf("<div class=\"welcome\"><p>User $myuser added successfully :)</p>");
			mysqli_stmt_close($stmt);
		}
	}
		
	else {
		printf("<div class=\"error\"><p>Error: User already exists</p>");
			
	}
	printf("<form action=\"index.html\" target=\"_self\"><input type=\"submit\" value=\"Return\"></form></div>");
		
}
?>
</body>
</html>