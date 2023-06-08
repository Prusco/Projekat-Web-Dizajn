<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="testadmin.css">
    <script>

        const urlParams = new URLSearchParams(window.location.search);
        const username = urlParams.get('username');

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('username').textContent = username;
        });
    </script>
    <script src="https://kit.fontawesome.com/1f39a77455.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="pozadina">

        <video autoplay loop muted class="video">
            <source src="slike-video/video.mp4" type="video/mp4">
        </video>

        <header class="main-header">
            <div class="logo">
                <h1 class="naslov"><em>DELUXE</em> FOOD</h1>
            </div>
            
        </header>
        <div class="poruka"> 
                <h1>Dobrodošao, <span id="username" style="color : antiquewhite;"></span> (Admin)</h1>
        </div>
        <div class="sadrzaj">
            
            
            <div class="dugme">
                <button id="dugme1" onclick="redirectToUserPage()"><img src="slike-video/author-01.png" alt="logo"><br> User</button>
            </div>  
            <div class="dugme">
                <button id="dugme1" onclick="pokazikomentare()"><img src="slike-video/korpa.png" alt="logo"><br> Dodaj novi proizvod</button>
            </div>  
        </div>
        
        <div class="proizvodi">
            <?php 
            
            $conn = new mysqli("localhost","root","","online_naručivanje_deluxe_food");

            
            if($conn->connect_error){
                die("Failed to connect : " .$conn->connect_error);
            }else{
                $sql1= "SELECT * FROM proizvodi";
                $svi_proizvodi = $conn -> query($sql1);

            }
            ?>
            
            <?php
            while($row = mysqli_fetch_assoc($svi_proizvodi)){
            ?>
                <div class="card">
                    <div class="image">
                        <img src="<?php echo $row["slika"]; ?>" alt="">
                    </div>
                    <p class="naziv_proizvoda">Naziv proizvoda:<?php echo $row["naziv_proizvoda"] ?></p>
                    <p class="cijena">Cijena: <b><?php echo $row["cijena"]; ?> KM</b></p>

                    <div class="dug">
                        <button class="ukloni" type="button" data-id="<?php echo $row["proizvod_id"]; ?>">Ukloni</button>
                    </div>
                </div>
            <?php    
            }
            ?>
        </div>

        <script>
            var ukloni = document.getElementsByClassName("ukloni");
            for(var i=0; i<ukloni.length; i++){
                ukloni[i].addEventListener("click", function(event){
                    var target = event.target;
                    var proizvod_id = target.getAttribute("data-id");
                    var xml = new XMLHttpRequest();
                    xml.onreadystatechange = function(){
                        if(this.readyState == 4 && this.status == 200){
                            target.innerHTML = this.responseText;
                            target.style.opacity = .3;
                        }
                    }

                    xml.open("GET", "veza.php?proizvod_id="+proizvod_id, true);
                    xml.send();
                })
            }

        </script>

        <div class="kontakt" enctype="multipart/form-data" style="display : none;">
            <form id="kontakti" action="dodaj.php" method="post" enctype="multipart/form-data">
                <h3>Dodavanje novog proizvoda</h3>
                <input type="text" name="naziv_proizvoda" placeholder="Naziv proizvoda" required>
                <input type="text" name="cijena" placeholder="Cijena" required>
                <input type="file" name="slika" required>
                <input type="submit" value="Dodaj proizvod" name="submit" >
            </form>            
        </div>

        <div class="footer">
            <p class="dno"> &#169; SI 2023</p>
        </div>
    </div>

    

    <script>
        function redirectToUserPage() {
            const username = document.getElementById('username').textContent;
            const url = 'mainv2.php?username=' + encodeURIComponent(username);
            window.location.href = url;
        }

        function pokazikomentare() {
            var divkontakt = document.querySelector('.kontakt');
            var proizvodi = document.querySelector('.proizvodi');

            
            if (divkontakt.style.display === "none") {
                proizvodi.style.display = "none";
                divkontakt.style.display = "flex";
                
                
            }else {
                proizvodi.style.display = "flex";
                proizvodi.style.flexDirection = "row";
                proizvodi.style.flexWrap = "wrap";
                divkontakt.style.display = "none";
            }
        }

    </script>
</body>
</html>
