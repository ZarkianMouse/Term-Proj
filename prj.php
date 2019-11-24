<html>

<head>
	<title>Hello World</title>
	<h1> Hello</h1>
</head>

<body>
<?php
$myuser = $_POST["username"];
$mypass = $_POST["password"];
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
}	


//Create an Insert prepared statement and run it
$score = 0;
if ($stmt = mysqli_prepare($conn, "INSERT INTO Users (Username,Passwd, Score) VALUES (?, ?, ?)")) {
mysqli_stmt_bind_param($stmt, 'ssd', $myuser, $mypass, $score);
mysqli_stmt_execute($stmt);
printf("Insert: Affected %d rows\n", mysqli_stmt_affected_rows($stmt));
printf("\n");
mysqli_stmt_close($stmt);
}	

	
//Run the Select query
printf("Reading data from table: \n");
$res = mysqli_query($conn, 'SELECT * FROM Users');
echo "<table><tr><th colspan=\"2\">MyUsers</th></tr>";
echo "<tr><td>Username</td><td>Score</td></tr>";
while ($row = mysqli_fetch_assoc($res)) {
echo "<tr><td>" . $row['Username'] . "</td><td>" . $row['Score'] . "</td></tr>";
}
echo "</table>";

if (!$res) {
    print "Error - the query could not be executed";
    $error = mysqli_error();
    print "<p>" . $error . "</p>";
    exit;
}		
	
	
//Close the connection
mysqli_close($conn);
?>
	
		

</body>
</html>
