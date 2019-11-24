<html>

<head>
	<title>Hello World</title>
	<h1> Hello</h1>
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
}

//Create an Insert prepared statement and run it
$username = 'BrandNewProduct';
$passwd = 'Blue';
$score = 15;
if ($stmt = mysqli_prepare($conn, "INSERT INTO User (Username, Passwd, Score) VALUES (?, ?, ?)")) {
mysqli_stmt_bind_param($stmt, 'ssd', $username, $passwd, $score);
mysqli_stmt_execute($stmt);
printf("Insert: Affected %d rows\n", mysqli_stmt_affected_rows($stmt));
mysqli_stmt_close($stmt);
}

//Create an Insert prepared statement and run it
$product_name = 'BrandNewProduct';
$product_color = 'Blue';
$product_price = 15.5;
if ($stmt = mysqli_prepare($conn, "INSERT INTO Products (ProductName, Color, Price) VALUES (?, ?, ?)")) {
mysqli_stmt_bind_param($stmt, 'ssd', $product_name, $product_color, $product_price);
mysqli_stmt_execute($stmt);
printf("Insert: Affected %d rows\n", mysqli_stmt_affected_rows($stmt));
mysqli_stmt_close($stmt);
}

//Close the connection
mysqli_close($conn);
?>
</body>
</html>
