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

// Check if form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get form data
  $ime = $_POST['Ime'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $datumrod = $_POST['datumrod'];
  $password = $_POST['password'];

  // Insert data into table
  $sql = "INSERT INTO registracija (ime, email, username, datumrod, password) 
          VALUES ('$ime', '$email', '$username', '$datumrod', '$password')";

if ($conn->query($sql) === TRUE) {
  // Redirect user to login page after successful insert
  header("Location: login.html");
  exit();
} else {
  echo "Error inserting record: " . $conn->error;
}

}

// Close connection
$conn->close();
?>
