<?php

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "online_naručivanje_deluxe_food";

$conn = new mysqli($servername, $username, $password, $db_name);

if(isset($_GET["id"])){
    $product_id = $_GET["id"];
    $sql = "SELECT * FROM korpa WHERE proizvod_id = $product_id";
    $result = $conn->query($sql);
    $total_cart = "SELECT * FROM korpa";
    $total_cart_result = $conn->query($total_cart);
    $cart_num = mysqli_num_rows($total_cart_result);

    if(mysqli_num_rows($result) > 0){
        $in_cart = "već je u korpi";

        echo json_encode(["num_cart"=>$cart_num,"in_cart"=>$in_cart]);
    }else{
        $insert = "INSERT INTO korpa(proizvod_id) VALUES($product_id)";
        if($conn->query($insert) === true){
            $in_cart = "dodano u korpu";
            echo json_encode(["num_cart"=>$cart_num,"in_cart"=>$in_cart]);

        }else{
            echo "<script>alert(Nije ubačeno u korpu)</script>";
        }
    }
}

if(isset($_GET["cart_id"])){
    $product_id = $_GET["cart_id"];
    $sql = "DELETE FROM korpa WHERE proizvod_id = ".$product_id;

    if($conn->query($sql) === true){
        echo "Uklonjen iz baze";
    }
}

if(isset($_GET["user_id"])){
    $user_id = $_GET["user_id"];
    $sql = "DELETE FROM registracija WHERE ID = ".$user_id;

    if($conn->query($sql) === true){
        echo "Uklonjen iz baze";
    }
}

if(isset($_GET["user_rol"])){
    $user_rol = $_GET["user_rol"];
    $sql = "UPDATE registracija SET id_rolovi = 2 WHERE id_rolovi = ".$user_rol;

    if($conn->query($sql) === true){
        echo "Admin postavljen";
    }
}

if(isset($_GET["proizvod_id"])){
    $product_id = $_GET["proizvod_id"];
    $sql = "DELETE FROM proizvodi WHERE proizvod_id = ".$product_id;

    if($conn->query($sql) === true){
        echo "Proizvod obrisan";
    }
}

// brisanje komentara u komentari.php

if(isset($_GET["komentar_id"])){
    $komentar_id = $_GET["komentar_id"];
    $sql2 = "DELETE FROM komentari WHERE id_komentara =".$komentar_id;

    if($conn->query($sql2) === true){
        echo "Komentar obrisan";
    }
}


if(isset($_GET["dugmep_id"])){
    $product_id = $_GET["dugmep_id"];
    $sql1 = "UPDATE korpa SET kolicina = kolicina + 1 WHERE proizvod_id = ".$product_id;
    
    if($conn->query($sql1) === true){
        echo "<meta http-equiv='refresh' content='0'>";
    }else{
        echo "Greska";
    }
}

if(isset($_GET["dugmem_id"])){
    $product_id = $_GET["dugmem_id"];
    $sql1 = "UPDATE korpa SET kolicina = kolicina - 1 WHERE proizvod_id = ".$product_id;
    
    $sql111 = "SELECT kolicina FROM korpa WHERE proizvod_id = ". $product_id;
    $result = $conn->query($sql111);
    
    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        $kolicina = $row["kolicina"];
        if($kolicina > 1){
            if($conn->query($sql1) === true){
                echo "<meta http-equiv='refresh' content='0'>";
            }else{
                echo "Greska";
            }
        }else{
            $sql11111 = "DELETE FROM korpa WHERE proizvod_id = ".$product_id;
            if($conn->query($sql11111) === true){
                echo "<meta http-equiv='refresh' content='0'>";
            }else{
                echo "Greska";
            }
        }
    }else{
        echo "Greska";
    }
}


if(isset($_GET["postavi_id"])){
    $product_id = $_GET["postavi_id"];
    $sql1 = "UPDATE registracija SET id_rolovi = 2 WHERE ID = ".$product_id;
    
    if($conn->query($sql1) === true){
        echo "<meta http-equiv='refresh' content='0'>";
    }else{
        echo "Greska";
    }
}

if(isset($_GET["skini_id"])){
    $product_id = $_GET["skini_id"];
    $sql1 = "UPDATE registracija SET id_rolovi = 3 WHERE ID = ".$product_id;
    
    if($conn->query($sql1) === true){
        echo "<meta http-equiv='refresh' content='0'>";
    }else{
        echo "Greska";
    }
}


//     // Provjera da li je slika uspješno poslana
//     if ($slika["error"] === UPLOAD_ERR_OK) {
//       $nazivDatoteke = $slika['slika']['name'];
//       $privremenaPutanja = $slika['slika']['tmp_name'];
//       $novaPutanja = "slike-video/" . $nazivDatoteke;
  
//       // Premještanje slike na odredišnu putanju
//       if (move_uploaded_file($privremenaPutanja, $novaPutanja)) {
//         echo "Slika je uspješno prenesena i spremljena na: " . $novaPutanja;
//       } else {
//         echo "Došlo je do problema prilikom spremanja slike.";
//         }
//         } else {
//         echo "Došlo je do problema prilikom prijenosa slike.";
//         }

//         // Insert data into table
//         $sql1 = "INSERT INTO proizvodi (naziv_proizvoda, cijena, slika) 
//         VALUES ('$naziv_proizvoda', '$cijena', '$putanja')";

//         if ($conn->query($sql1) === TRUE) {
//         echo "Artikal dodan";
//         } else {
//         echo "Error pri dodavanju proizvoda: " . $conn->error;
//         }


?>