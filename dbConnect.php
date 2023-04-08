<?php
$dbServername = "localhost";
$dbUsername = "u268055314_butters331";
$dbPassword = "Youpickediss10$";
$dbName = "u268055314_ypd";

$stripeKey = "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";

// Create connection
$conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);

// Check connection
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>

