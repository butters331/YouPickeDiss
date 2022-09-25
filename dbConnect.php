<?php
$dbServername = "localhost";
$dbUsername = "u268055314_butters331";
$dbPassword = "Youpickediss10$";
$dbName = "u268055314_ypd";

// Create connection
$conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);

// Check connection
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>

