<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Glavni admin Menu</title>

    <script>

        const urlParams = new URLSearchParams(window.location.search);
        const username = urlParams.get('username');

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('username').textContent = username;
        });
    </script>
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
    
    <div class="sadrzaj">
        <div class="poruka"> 
            <h1>Dobro Došli , <span id="username"></span> (Glavni Admin)</h1><br>
            <h1>Ovdje možete izabrati da li želite Admin prikaz ili User prikaz</h1>
        </div>
        <div class="dugmad">
            <div class="dugme">
                <button id="dugme1" onclick="window.location.href='testadmin.php?username=' + encodeURIComponent(username)"><img src="slike-video/author-01.png" alt="logo"><br> Admin</button>
            </div>  
            <div class="dugme">
                <button id="dugme1" onclick="window.location.href='mainv2.php?username=' + encodeURIComponent(username)"><img src="slike-video/author-01.png" alt="logo"><br> User</button>
            </div>
            <div class="dugme">
                <button id="dugme2" onclick="pokazikomentare()"><img src="slike-video/plus.jpg" alt="logo"><br> Postavi Admina</button>
            </div>
        </div>  

        <div class="korisnici">
        <script>
            function redirectToUserPage() {
                const username = document.getElementById('username').textContent;
                const url = 'mainv2.php?username=' + encodeURIComponent(username);
                window.location.href = url;
            }
        </script>
        <?php 
        
        $conn = new mysqli("localhost","root","","online_naručivanje_deluxe_food");

        
        if($conn->connect_error){
            die("Failed to connect : " .$conn->connect_error);
        }else{
            $sql1= "SELECT * FROM registracija WHERE id_rolovi = 2 or id_rolovi = 3";
            $svi_korisnici = $conn -> query($sql1);

        }
        ?>
        
        <?php
        while($row = mysqli_fetch_assoc($svi_korisnici)){
        ?>
            <div class="card">
                <p class="ime">Ime:<?php echo $row["Ime"] ?></p>
                <p class="username">Username:<?php echo $row["username"] ?></p>
                <p class="password">Password:<?php echo $row["password"] ?></p>
                <p class="datum">Datum rođenja:<?php echo $row["datumrod"] ?></p>
                <p class="rol">Rol:<b><?php if($row["id_rolovi"] == 2){
                        echo "Admin";
                    }else{
                        echo "User";
                    } ?>
                    </b>
                </p>
                <div class="dug">
                <?php if($row["id_rolovi"] == 3): ?>
                    <button class="add postavi" type="button" style="display: none;" data-id="<?php echo $row["ID"]; ?>" >Postavi Admina</button>
                <?php else: ?>
                    <button class="add skini" type="button" style="display: none;" data-id="<?php echo $row["ID"]; ?>">Skini Admina</button>
                <?php endif; ?>

                <button class="ukloni" type="button" data-id="<?php echo $row["ID"]; ?>">Ukloni</button>
            </div>
            </div>
        <?php    
        }
        ?>

    </div>

    </div>
    
    <script>

        var postavii = document.getElementsByClassName("add postavi");
        for (var i = 0; i < postavii.length; i++) {
            postavii[i].addEventListener("click", function(event) {
                var target = event.target;
                var dugmem_id = target.getAttribute("data-id");
                var xml = new XMLHttpRequest();
                xml.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        target.innerHTML = this.responseText;
                        location.reload(); // Reload the current page
                    }
                }

                xml.open("GET", "veza.php?postavi_id=" + dugmem_id, true);
                xml.send();
            })
        }


        var skinii = document.getElementsByClassName("add skini");
        for (var i = 0; i < skinii.length; i++) {
            skinii[i].addEventListener("click", function(event) {
                var target = event.target;
                var dugmem_id = target.getAttribute("data-id");
                var xml = new XMLHttpRequest();
                xml.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        target.innerHTML = this.responseText;
                        location.reload(); // Reload the current page
                    }
                }

                xml.open("GET", "veza.php?skini_id=" + dugmem_id, true);
                xml.send();
            })
        }

        var ukloni = document.getElementsByClassName("ukloni");
        for(var i=0; i<ukloni.length; i++){
            ukloni[i].addEventListener("click", function(event){
                var target = event.target;
                var user_id = target.getAttribute("data-id");
                var xml = new XMLHttpRequest();
                xml.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        target.innerHTML = this.responseText;
                        target.style.opacity = .3;
                    }
                }

                xml.open("GET", "veza.php?user_id="+user_id, true);
                xml.send();
            })
        }

        var postavi = document.getElementsByClassName("add");
        for(var i=0; i<postavi.length; i++){
            ukloni[i].addEventListener("click", function(event){
                var target = event.target;
                var user_rol = target.getAttribute("data-id");
                var xml = new XMLHttpRequest();
                xml.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        target.innerHTML = this.responseText;
                        target.style.opacity = .5;
                    }
                }

                xml.open("GET", "veza.php?user_rol="+user_rol, true);
                xml.send();
            })
        }
            function setUserAsAdmin(userId) {
                window.location.href = "set_as_admin.php?user_id=" + userId;
            }

        
    </script>


    <div class="footer">
        <p class="dno"> &#169; SI 2023</p>
    </div>
    </div>

</body>
</html>

<script>

        function pokazikomentare() {
            var dugmeukloni = document.querySelectorAll('.ukloni');
            var dugmedodaj = document.querySelectorAll('.add');

            for (var i = 0; i < dugmeukloni.length; i++) {
                if (dugmedodaj[i].style.display === "none") {
                    dugmedodaj[i].style.display = "inline";
                    dugmeukloni[i].style.display = "none";
                }else {
                    dugmedodaj[i].style.display = "none";
                    dugmeukloni[i].style.display = "inline";
                }
            }
        }


</script>
