<?php
require_once 'veza.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $naziv_proizvoda = $_POST['naziv_proizvoda'];
    $cijena = $_POST['cijena'];
    $slika = $_FILES['slika']['name'];
    $slika_tmp = $_FILES['slika']['tmp_name'];

    // Specify the destination directory to store the uploaded image
    $destination = 'slike-video/' . $slika;

    // Check if the file has a valid extension
    $file_extension = strtolower(pathinfo($slika, PATHINFO_EXTENSION));
    if ($file_extension !== 'jpg') {
        echo "Dozvoljeni su samo JPG formati slika.";
        exit;
    }
    
    if (file_exists($destination)) {
        echo "Datoteka s istim imenom već postoji.";
        exit;
    }

    // Check if the connection is successful
    if ($conn) {
        // Move the uploaded image to the destination directory
        if (move_uploaded_file($slika_tmp, $destination)) {
            // Insert the new product into the database, storing the image path
            $sql = "INSERT INTO proizvodi (naziv_proizvoda, cijena, slika) VALUES ('$naziv_proizvoda', '$cijena', '$destination')";

            if ($conn->query($sql) === true) {
                echo "Proizvod je uspješno dodan u bazu podataka.";
            } else {
                echo "Greška prilikom dodavanja proizvoda: " . $conn->error;
            }
        } else {
            echo "Greška prilikom prebacivanja datoteke.";
        }
    } else {
        echo "Greška prilikom uspostavljanja veze s bazom podataka.";
    }
}
?>
