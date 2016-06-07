

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
	color:#272928;
	background:white;
}
</style>




</head>
<body style="all:initial;">
<div style="padding=8px;margin:8px;">

	<div id="wrapper">
<h1 style="color:#272928;	background:white;">Get_URL Project</h1>
<h2>Get URLs Convert to Static HTML Pages</h2>
<p>Description: The project is designed to capture webpages convert them into Base64 Data and store the data in a MySQL Database. After the pages are converted to base64 data and stored it may be retrieved by id and viewed as a decoded webpage. The webpages also may be converted to a static html page with your choice of name. Example: MyStoredPage.html</p>

<p>objective: I have an online notebook. The notes kept in the notebook are searchable. I wanted the pages / articles created to exist as a static html webpage. I also have some very productive search queries that would be nice to exist as a static webpage. This project will sucessfully accomplish that taskdo that.</p> 

<p>Future Plans: Currently the project does not capture any CSS except for that that is inline. Since it is primarily designed to work with my notebook, that is not important because the pages all use to local CSS file and look good. Get-URL will also capture off-site or non-local domain webpages. The off-sites webpages have no CSS  other than What was used inline. The project's use will expand tremendously if it can also capture the CSS of an off-site webpage.</p> 
<div id="center-column">
			<div id="post">
				<hr>
				<center>
					<h2>To GET and Store a URL</h2>
					<h4>Copy and Paste a URL and give it keywords</h4>
				</center>
				<br />
				<center><form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;URL:&nbsp;&nbsp;<textarea style="width: 60%;height: 2.5em;"
							cols="70" rows="1" name="origpage" value=""></textarea></span><br />
					<br />
					Keywords:&nbsp;&nbsp;<textarea style="width: 60%;height: 2.5em;"
							cols="70" rows="1" name="origkeywords" value="text"></textarea></span><br />
					<br /> <span style="float: right; margin-right: 50%; color: red;"><input
						type="submit" name="submit" value="Enter" /></span><br />
					<br /><br />
					<hr>
					<hr>
				</form></center>
				<br />

				<center>
					<h2>To Convert Stored Data to HTML</h2>
					<h4>Enter ID number and a PageName (do not enter the extension)</h4>
				</center>
				<br />
				<center><form action="" method="post">
					Enter ID -:<input style="margin-right:20%;width: 10%;height: 2.5em;"type="text" name="data" />
					<br /><br /> Save as PageName:&nbsp;&nbsp;
					<textarea style="width: 60%;height: 2.5em;"cols="50" rows="2" name="pagename" value="text"></textarea>
					<br />
					<br /> <span color: red;"><input type="submit" name="makeit" value="Enter" /></span>
				</form></center>
				<br /><br /><br />
				<hr>
				<hr><br />
				
				<center><h2>View a Stored Page by ID</h2>
				<form action="" method="post">
					View by Id:&nbsp;&nbsp;
					<textarea style="width: 60%;height: 2.5em;"cols="50" rows="2" name="origid" value="text"></textarea>
					<br />
					<br /> <input type="submit" name="submit2" value="Enter" />
				</form></center>
				<br />
<hr>
				<hr><br />
				
				<center><h2>Delete a Stored Page by ID</h2>
				<form action="" method="post">
					Delete Sql by Id:&nbsp;&nbsp;
					<textarea style="width: 60%;height: 2.5em;"cols="50" rows="2" name="delid" value="text"></textarea>
					<br />
					<br /> <input type="submit" name="deleteit" value="Enter" />
				</form></center>
				<br /><hr /><hr />
<center><h2>"CLICKABLE" List of html Generated Pages</h2><br />
<?php
settype($thelist, "string"); 
if ($handle = opendir('.')) {
    while (false !== ($file = readdir($handle)))
    {
        if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'html')
        {
            $thelist .= '<li><a href="'.$file.'">'.$file.'</a></li>';
        }
    }
echo $thelist;
    closedir($handle);
}
?></center><hr />				
<center>
<h2>View and Delete Files</h2>
<h4>Select file to view then view or delete</h4>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<input type="file" name="filename" value="" />
<input type="submit" name="submit" value="VIEW" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="delete" value="DELETE" style="color:red;" />
<br />
</form>

<?php
if (isset ( $_POST ['submit'] ) ) {
$view = file_get_contents ($_POST ['filename']  );
echo $view;
  } ;
?>

<?php

if (isset ( $_POST ['delete'] ) && ! empty ($_POST ['filename'] )) {
$filename = $_POST ['filename'];
unlink($filename);
$filename = NULL; 
}
?>
</center>
<br /><br />		
<hr style="height:5px;background-color:gray;" >
<hr style="height:5px;background-color:gray;" >			
<br /><br />				
<?php
//connection to the database
$hostname = "localhost";
$username = "root";
$password = "";
$database = "geturl";
$dbhandle = mysql_connect($hostname, $username, $password)
or die("Unable to connect to MySQL");

//select a database to work with
$selected = mysql_select_db($database,$dbhandle)
or die("Could not select geturl");
?>

executed an SQL query and return the last 3 records
<?php $result = mysql_query("SELECT * FROM `urls`" . "ORDER BY `ID` DESC LIMIT 3"); ?>
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
// executed the SQL query and return 1 record
if (isset ( $_POST ["submit2"] ) && ! empty ( $_POST ["origid"] )) {
	?>
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
</div>



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
	header ( "Location: index.php" );
	?>
<?php

	header ( 'Content-Type: text/html; charset=UTF-8' );
	?>

<?php
	// execute the SQL query and return 5 records
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
 
}
?>

<?php
// execute the SQL query and return 1 record
if (isset ( $_POST ["makeit"] ) && ! empty ( $_POST ["pagename"] )) {
	$data = $_POST ['data'];
	$pagename = $_POST ['pagename'];
	$min_length = 5;
	if (strlen ( $pagename ) >= $min_length) {
		$result = mysql_query ( "SELECT * FROM urls WHERE id= '$data'" );
		// fetch the data from the database
		?>
		</div>
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





 <?php
if(isset($_POST['deleteit']))
{
$con = mysql_connect($hostname, $username, $password);
if(! $con )
{
  die('Could not connect: ' . mysql_error());
}
//$id = $_POST['id'];
$sql = "DELETE FROM urls WHERE ID={$_POST['delid']} LIMIT 1";
//$sql = "DELETE comments ".
//       "WHERE id = $id" ;
mysql_select_db($database);
$retval = mysql_query( $sql, $con );
if(! $retval )
{
  die('Could not delete data: ' . mysql_error());
}
echo "Deleted data successfully\n";
mysql_close($con);
}
?>
</div>
</div>
</div>
</div></div>
</body>
</html>
