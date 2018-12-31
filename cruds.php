<?php

session_start();
$userId = $_SESSION["userId"];
$userGroup = $_SESSION["userGroup"];

include 'conn.php';

$Users = 'users';

date_default_timezone_set('America/Phoenix');

if (isset($_GET['getUsers'])) {
if ($_GET['getUsers'] == '1') {

header('Content-type: Application/JSON');

$query = "SELECT * FROM $Users";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);

$UsersArray = [];

while($row = mysqli_fetch_assoc($result))  {
$UserID = $row['id'];
$Name = $row['name'];
$Age = $row['age'];
$Email = $row['email'];

$UserArray = array('id'=>$UserID, 'name'=>$Name, 'age'=>$Age, 'email'=>$Email);
array_push($UsersArray,$UserArray);
}

print_r(json_encode($UsersArray,JSON_PRETTY_PRINT));

	@mysqli_close($conn);

}
}

if (isset($_POST['addUser'])) {
if ($_POST['addUser'] == '1') {

$Name = $_POST['name'];
$Age = $_POST['age'];
$Email = $_POST['email'];

$MyQuery = "INSERT INTO $Users (name,age,email) VALUES ('".$Name."','".$Age."','".$Email."')";

		$q=@mysqli_query($GLOBALS["___mysqli_ston"], $MyQuery);

		if($q) {
			print_r('success');
		} else {
			print_r('fail');
		}

		@mysqli_close($conn);

}
}

if (isset($_GET['deleteUser'])) {
if ($_GET['deleteUser'] == '1') {

	$UserID = $_GET['user_id'];

	$MyQuery = "DELETE FROM $Users WHERE id=".$UserID;
			$q = @mysqli_query($conn, $MyQuery);

	@mysqli_close($conn);

}
}
?>
