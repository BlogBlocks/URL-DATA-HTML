
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Jack Northrup" />
<title>GET URL</title>
<link rel="stylesheet" href="reset.css" />
<style>
p {
	font-size: 1.5em;
}
</style>
</head>
<body>
	<div id="wrapper">
<?php include('get-header.php'); ?>
<div id="center-column">
			<div id="post">
				<hr>
				<center>
					<h2>To GET and Store a URL</h2>
					<h4>Copy and Paste a URL and give it keywords</h4>
				</center>
				<br />
				<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
					<span style="float: right; margin-right: 20px;">URL:&nbsp;&nbsp;<textarea
							cols="70" rows="1" name="origpage" value=""></textarea></span><br />
					<br />
					<span style="float: right; margin-right: 20px;">Keywords:&nbsp;&nbsp;<textarea
							cols="70" rows="1" name="origkeywords" value="text"></textarea></span><br />
					<br /> <span style="float: right; margin-right: 50%; color: red;"><input
						type="submit" name="submit" value="Enter" /></span><br />
					<br />
					<hr>
					<hr>
				</form>
				<br />

				<center>
					<h2>To Convert Stored Data to HTML</h2>
					<h4>Enter ID number and a PageName (do not enter the extension)</h4>
				</center>
				<br />
				<form action="" method="post">
					Enter ID -:<input type="text" name="data" /><br />
					<br /> Save as PageName:&nbsp;&nbsp;
					<textarea cols="50" rows="2" name="pagename" value="text"></textarea>
					<br />
					<br /> <input type="submit" name="makeit" value="Enter" />
				</form>
				<br />
				<hr>
				<hr>
				<h2>View a Stored Page by ID</h2>
				<form action="" method="post">
					View by Id:&nbsp;&nbsp;
					<textarea cols="70" rows="3" name="origid" value="text"></textarea>
					<br />
					<br /> <input type="submit" name="submit2" value="Enter" />
				</form>
				<br />
				
				<h2>View a Stored Page by ID</h2>
				<form action="" method="post">
					View by Id:&nbsp;&nbsp;
					<textarea cols="70" rows="3" name="origid" value="text"></textarea>
					<br />
					<br /> <input type="submit" name="submit2" value="Enter" />
				</form>
				<br />



<?php
// execute the SQL query and return records
if (isset ( $_POST ["submit2"] ) && ! empty ( $_POST ["origid"] )) {
	?>
<?php include('get-url-connect.php'); ?>
<?php

	$id = $_POST ["origid"];
	$result = mysql_query ( "SELECT * FROM urls WHERE id=" . ( int ) $id . " LIMIT 1" );
	// fetch the data from the database
	?>
<?php

	while ( $row = mysql_fetch_array ( $result ) ) {
		echo "ID -" . $row ['id'] . "&nbsp;&nbsp;&nbsp;Date:" . $row ['date'] . "<br />"; 
$page = base64_decode($row['page'])."<br />";
$keywords = $row['keywords'];
echo $keywords."<br />";
echo $page."<br /><br /><hr>";
echo  "Here is your Page";

}
}
?>








<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<?php include('get-url-connect.php'); ?>
//execute an SQL query and return the last 5 records
<?php $result = mysql_query("SELECT * FROM `urls`" . "ORDER BY `ID` DESC LIMIT 5"); ?>
<div class="boxit">
<?php 
// fetch the data from the database
while ( $row = mysql_fetch_array ( $result ) ) {
	echo "ID -" . $row ['id'] . "&nbsp;&nbsp;&nbsp;Date:" . $row ['date'] . "<br />";
	$page = base64_decode ( $row ['page'] ) . "<br />";
	$keywords = $row ['keywords'];
	// display the keywords and the WebPage
	echo $keywords . "<br />";
	echo $page . "<br /><br /><hr>";
}
?>


<?php
if (isset ( $_POST ['submit'] )) {
	header ( 'Content-Type: text/html; charset=UTF-8' );
	$con = mysqli_connect ( "localhost", "root", "", "geturl" );
	// Check connection
	if (mysqli_connect_error ()) {
		echo "Failed to connect to MySQL SERVER: " . mysqli_connect_error ();
	}
	$keywords = $_POST [origkeywords];
	$page1 = file_get_contents ( $_POST [origpage] );
	$page = base64_encode ( $page1 );
	$sql = "INSERT INTO urls (keywords, page)
VALUES
('$keywords','$page')";
	if (! mysqli_query ( $con, $sql )) {
		die ( 'Error - Failed to post: ' . mysqli_error ( $con ) );
	}
	mysqli_close ( $con );
	header ( "Location: get-url.php" );
	?>
<?php

	header ( 'Content-Type: text/html; charset=UTF-8' );
	?>
<?php include('get-connect.php'); ?>
<?php
	// execute the SQL query and return records
	$result = mysql_query ( "SELECT * FROM `urls`" . " ORDER BY `ID` DESC LIMIT 5 " );
	// fetch the data from the database
	?>
<div class="boxit">
<?php
	while ( $row = mysql_fetch_array ( $result ) ) {
		echo "ID -" . $row ['id'] . "&nbsp;&nbsp;&nbsp;Date:" . $row ['date'] . "<br />";
		$page = base64_decode ( $row ['page'] ) . "<br />";
		$keywords = $row ['keywords'];
		echo $keywords . "<br />";
		echo $page . "<br /><br /><hr>";
	}
} else {
	echo "Huston, We have a problem";
}
?>
<?php include('get-url-connect.php'); ?>
<?php
// execute the SQL query and return records
if (isset ( $_POST ["makeit"] ) && ! empty ( $_POST ["pagename"] )) {
	$data = $_POST ['data'];
	$pagename = $_POST ['pagename'];
	$min_length = 10;
	if (strlen ( $pagename ) >= $min_length) {
		$result = mysql_query ( "SELECT * FROM urls WHERE id= '$data'" );
		// fetch the data from the database
		?>
<div class="boxit">
<?php
		while ( $row = mysql_fetch_array ( $result ) ) {
			echo "ID -" . $row ['id'] . "&nbsp;&nbsp;&nbsp;Date:" . $row ['date'] . "<br />";
			$page = base64_decode ( $row ['page'] ) . "<br />";
			$keywords = $row ['keywords'];
			echo $keywords . "<br />";
			echo $page . "<br /><br /><hr>";
			$file = $pagename . '.html';
			file_put_contents ( $file, $page );
		}
		?>
<?php Echo "<h2>CLICK RED FILENAME TO VIEW HTML:<a style='color:red;' href=$file>$pagename</a></h2>"?>
<?php
	}
}
?>


</body>
</html>

