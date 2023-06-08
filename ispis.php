<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_naručivanje_deluxe_food";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

  $sql1 = "SELECT * FROM proizvodi";

  $svi_proizvodi = $conn -> query($sql1)

?>