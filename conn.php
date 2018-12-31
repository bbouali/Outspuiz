<?php

$URL = $_SERVER[HTTP_HOST];
if (strpos($URL, 'localhost') === FALSE) { // If URL does not have localhost in it (is on a server)
  // not needed for this project
} else { // If URL has localhost in it (is on local machine)
  $dbhost = '127.0.0.1';  //server settings may vary - this is from an IIS instance
  $dbuser = 'root'; //replace w/ your local MySQL db username (default is 'root')
  $dbpass = 'your_pw'; //replace w/ your local MySQL db password
  $dbname = 'test';
}

$conn = ($GLOBALS["___mysqli_ston"] = mysqli_connect($dbhost, $dbuser, $dbpass)) or die("Problem occur in connection");
$db = ((bool)mysqli_query($conn, "USE " . $dbname));
?>
