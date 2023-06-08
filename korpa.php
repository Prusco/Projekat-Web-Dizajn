<?php

require_once 'veza.php';


$sql_cart = "SELECT * FROM korpa";
$all_cart = $conn->query($sql_cart);
$ukupno = 0;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="korpa.css">
    <title>Korpa</title>
    <script src="https://kit.fontawesome.com/1f39a77455.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <div class="sadrzaj">
    <h1><?php echo mysqli_num_rows($all_cart) ?> proizvoda u korpi</h1>
    
    <hr>
    </div>
    <?php
        while($row_cart = mysqli_fetch_assoc($all_cart)){
            $sql = "SELECT * FROM proizvodi WHERE proizvod_id =".$row_cart["proizvod_id"];
            $kolicina = $row_cart["kolicina"];
            $svi_proizvodi = $conn->query($sql);
            while($row = mysqli_fetch_assoc($svi_proizvodi)){
                $ukupno = ($ukupno + $row["cijena"])*$kolicina;
    ?>
    <div class="card">
        <div class="slika">
            <img src="<?php echo $row["slika"] ?>" alt="">
        </div>

        <div class="caption">
            <p class="rate">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </p>
            <div class="kolicina">
                <button type="button" class="minus" data-id="<?php echo $row["proizvod_id"]; ?>">-</button>
                <input type="text" class="koli" id="vrijednost" value="<?php echo $kolicina ?>" readonly>
                
                <button type="button" class="plus" data-id="<?php echo $row["proizvod_id"]; ?>">+</button>
            </div>
            <p class="naziv_proizvoda"><?php echo $row["naziv_proizvoda"] ?></p>
            <p class="cijena"><?php echo $row["cijena"] ?>KM</p>
            
            <button class="ukloni" data-id="<?php echo $row["proizvod_id"]; ?>" >Ukloni iz korpe</button>
            
        </div>
    </div>
    
    <?php
        }
    }
    ?>

    <div class="cijenakutija">
        <h5><b>Detalji cijene</b></h5>
        <h5>-------------------------------------</h5>
        <div class="cijena">
            <?php
                if(mysqli_num_rows($all_cart)>0){
                    $broj = mysqli_num_rows($all_cart);
                    echo "<h5>Cijena ($broj proizvoda)</h5>"; 
                }else{
                    echo "<h5>Cijena (0 proizvoda)</h5>";
                }
            ?>
            <h5>-------------------------------------</h5>
            <h5>Cijena proizvoda: <?php echo $ukupno; ?>KM </h5>
            <h5>Cijena dostave: 0KM</h5>
            <h5>-------------------------------------</h5>
            <h5>Ukupno: <?php echo $ukupno; ?>KM</h5>
        </div>
    </div>

    <script>
        var ukloni = document.getElementsByClassName("ukloni");
        for(var i=0; i<ukloni.length; i++){
            ukloni[i].addEventListener("click", function(event){
                var target = event.target;
                var cart_id = target.getAttribute("data-id");
                var xml = new XMLHttpRequest();
                xml.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        target.innerHTML = this.responseText;
                        target.style.opacity = .3;
                    }
                }

                xml.open("GET", "veza.php?cart_id="+cart_id, true);
                xml.send();
            })
        }

        var umanji = document.getElementsByClassName("minus");
        for(var i=0; i<umanji.length; i++){
            umanji[i].addEventListener("click", function(event){
                var target = event.target;
                var dugmem_id = target.getAttribute("data-id");
                var xml = new XMLHttpRequest();
                xml.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        target.innerHTML = this.responseText;
                    }
                }

                xml.open("GET", "veza.php?dugmem_id="+dugmem_id, true);
                xml.send();
            })
        }

        var uvecaj = document.getElementsByClassName("plus");
        for(var i=0; i<uvecaj.length; i++){
            uvecaj[i].addEventListener("click", function(event){
                var target = event.target;
                var dugmep_id = target.getAttribute("data-id");
                var xml = new XMLHttpRequest();
                xml.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        target.innerHTML = this.responseText;
                    }
                }

                xml.open("GET", "veza.php?dugmep_id="+dugmep_id, true);
                xml.send();
            })
        }

    </script>

</body>
</html>