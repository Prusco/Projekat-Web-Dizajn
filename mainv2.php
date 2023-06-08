<?php

require_once 'veza.php';

$sql_cart = "SELECT * FROM korpa";
$all_cart = $conn->query($sql_cart);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deluxe Food-Glavna stranica</title>
    <link rel="stylesheet" href="mainv2.css">

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
        
        $svi_proizvodi = $conn -> query($sql1);

    ?>


</head>
<script src="https://kit.fontawesome.com/1f39a77455.js" crossorigin="anonymous"></script>
<style>
      form#kontakti{
        background: #3c3c3c;
        display: flex;
        flex-direction: column;
        padding: 2vw 4vw;
        width: 90%;
        max-width: 600px;
        border-radius: 10px;
        justify-content: center;
      }
      form h3{
        color: #f5a425;
        font-weight: 800;
        margin-bottom: 20px;
      }
      form input, form textarea{
        border: 0;
        margin: 10px 0;
        padding: 20px;
        outline: none;
        background: black;
        font-size: 16px;
      }
      form button{
        padding: 15px;
        background: rgb(0, 102, 136);
        color: #f5a425;
        font-size: 18px;
        border:0;
        outline: none;
        cursor: pointer;
        width: 150px;
        margin: 20 auto 0;
        border-radius: 30px;
      }

      /*Dodao sam ovaj kod za promjenu Komentara tj da se razlikuje od Dodaj u Korpi */
      .card button.cover {
        background-color: red;
        color: white;
      }
</style>
<body>

    <video autoplay loop muted class="video">
        <source src="slike-video/video.mp4" type="video/mp4">
    </video>
    <header class="glavni-header" role="header">   
        <div class="logo">
            <h1><em>DELUXE</em> FOOD</h1>
        </div>
        
        <div class="profil">
        <a href="korpa.php" class="korpa"><img src="slike-video/korpa.png" width="40px" height="40px" style="background-color : white; margin-right:10px; border-radius:8px;" alt="Author 1" id="slika"><span id="badge"><?php echo mysqli_num_rows($all_cart) ?></span></a>
        <?php
            $username = isset($_GET['username']) ? $_GET['username'] : '';

            $sql1 = "SELECT id FROM registracija WHERE username = '$username'";
            $result = $conn->query($sql1);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id = $row['id'];
            } else {
                echo "No results found.";
            }
            ?>
            <h3 id="ime"><?php echo htmlspecialchars($username); ?></h3>  
            <a href="" class="profilIme"><img src="slike-video/author-01.png" alt="Author 1" id="slika"></a>
            
        </div>
    </header>
  
    <div class="kontenjer">
        <div class="navigacija">
            <!-- <h6>Pjesma: Jana - Robinja</h6>
            <audio controls autoplay>
                <source src="slike-video/nez.mp3">      
            </audio> -->
            <!-- <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
            <div class="elfsight-app-96d0efea-7851-42e5-a778-99a99c3ec970"></div> -->

            <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
            <div class="elfsight-app-9957f785-9fd9-4f99-b9f1-db5ec12c5274"></div>
            <button onclick="vartinazad()">Povratak na prijavu</button>
            <button onclick="pokazimapu()">Lokacija</button>
            <button onclick="pokazionama()">O nama</button>
            <button onclick="pokazikontakt()">Kontakti</button>
            <button onclick="pokazikomentare()">Komentari</button>
        </div>
       
        <div class="sadrzaj" style="display: flex;">
        <?php
            while($row = mysqli_fetch_assoc($svi_proizvodi)){
        ?>
            <div class="card">
                    <div class="image">
                        <img src="<?php echo $row["slika"]; ?>" alt="">
                    </div>
                    <div class="caption">
                        <p class="rate">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </p>
                        <p class="product_name"><?php echo $row["naziv_proizvoda"]; ?></p>
                        <p class="cijena"><b><?php echo $row["cijena"]; ?> KM</b></p>
                    </div>
                    <!-- Dodao sam ovaj dio koda samo ova 134 linija koda -->
                    <button class="cover" type="button" style="display: none;" onclick="window.location.href='komentari.php?proizvod=<?php echo $row["naziv_proizvoda"]; ?>&id=<?php echo $id; ?>'">Komentari</button>
                    <button class="add" type="button" data-id="<?php echo $row["proizvod_id"]; ?>">Dodaj u korpu</button>
            </div>
            <?php
                }
            ?>
            
        </div>
    </div>
    <script>
        var product_id = document.getElementsByClassName("add");
        for(var i=0; i<product_id.length; i++){
            product_id[i].addEventListener("click", function(event){
                var target = event.target;
                var id = target.getAttribute("data-id");
                var xml = new XMLHttpRequest();
                xml.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        var data = JSON.parse(this.responseText);
                        target.innerHTML = data.in_cart;
                        document.getElementById("badge").innerHTML = data.num_cart;
                    }
                }

                xml.open("GET","veza.php?id="+id, true);
                xml.send();
                
            })
        }
    </script>

    <div class="mapa" style="display: none;">
        <iframe class="nestov2" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4306.4531090591045!2d17.382766001554305!3d44.10055910795482!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475fa56ca3f17f27%3A0x2755ae6d4c26064c!2sPru%C5%A1%C4%8Dakova%20(Hasana%20Kjafije)%20d%C5%BEamija%20u%20Pruscu%2C%20graditeljska%20cjelina!5e1!3m2!1sen!2sba!4v1679264184307!5m2!1sen!2sba" width="800px" height="450px" style="border:0;"  allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="google"></iframe>
    </div>
    <div class="kontakt" style="display: none;">
        <form id="kontakti">
            <h3>Kontaktirajte nas</h3>
            <input type="text" id="ime" placeholder="Ime" required>
            <input type="email" id="email" placeholder="Email" required>
            <input type="text" id="brojtelefona" placeholder="Broj telefona" required>
            <textarea id="message" rows="5" placeholder="Upišite Vaše mlišljenje"></textarea>
            <button id="kontaktiposalji" onclick="sendEmail()">Pošalji</button> 
        </form>            
    </div>
    <div class="onama" style="display:none">
        <form id="nestoonama">
            <h2 id="naslovonama">O nama</h2>
            <a id="tekstonama">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga beatae autem praesentium suscipit nulla eligendi blanditiis voluptatibus ducimus vel eius tenetur est, sequi nam quia ex excepturi alias optio ipsa.
            </a>
            <br>
            <br>
            <h3 id="rijec">Kontaktirajte nas:</h3>
            <div class="kontaktiraje" id="kon">
                <a id="red" href="https://www.instagram.com"><img src="slike-video/instagram.jpg" alt="instagram" width="30px" height="30px"></a>
                <a id="red" href="https://www.facebook.com"><img src="slike-video/facebook.jpg" alt="facebook" width="30px" height="30px"></a>
                <a id="red"> <b>ili na broj telefona</b>  </a> 
                <img id="red" src="slike-video/telefon.png" alt="telefon" width="30px" height="30px"> 
                <a ><b>+387 64 400 4014</b></a>
            </div>
            
            <br><br>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/GS1fbWkM-3M" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </form>
    </div>
    
    <footer>
        <div class="footer1">
            <p class="dno"> &#169; SI 2023</p>
        </div>
    </footer>
            
</body>
</html>




<script type="text/javascript">
    function pokazimapu() {
        var mapaDiv = document.querySelector('.mapa');
        var sadrzajDiv = document.querySelector('.sadrzaj');
        var pokazikontaktDiv = document.querySelector('.kontakt');
        var onamaDiv = document.querySelector('.onama')
        if (mapaDiv.style.display === "none") {
            mapaDiv.style.display = "block";
            sadrzajDiv.style.display = "none";
            pokazikontaktDiv.style.display = "none";
            onamaDiv.style.display = "none";

        } else {
            mapaDiv.style.display = "none";
            pokazikontaktDiv.style.display = "none";
            sadrzajDiv.style.display = "flex";
            sadrzajDiv.style.flexDirection = "row";
            sadrzajDiv.style.flexWrap = "wrap";
            onamaDiv.style.display = "none";

        }
    }
    
    function pokazikontakt(){
        var pokazikontaktDiv = document.querySelector('.kontakt');
        var mapaDiv = document.querySelector('.mapa');
        var sadrzajDiv = document.querySelector('.sadrzaj')
        var onamaDiv = document.querySelector('.onama')
        if (pokazikontaktDiv.style.display === "none") {
            pokazikontaktDiv.style.display = "flex";
            sadrzajDiv.style.display = "none";
            mapaDiv.style.display = "none";
            onamaDiv.style.display = "none";


        } else {
            pokazikontaktDiv.style.display = "none";
            sadrzajDiv.style.display = "flex";
            sadrzajDiv.style.flexDirection = "row";
            sadrzajDiv.style.flexWrap = "wrap";
            mapaDiv.style.display = "none";
            onamaDiv.style.display = "none";

    }
}
    function pokazionama(){
        var pokazikontaktDiv = document.querySelector('.kontakt');
        var mapaDiv = document.querySelector('.mapa');
        var sadrzajDiv = document.querySelector('.sadrzaj')
        var onamaDiv = document.querySelector('.onama')
        if(onamaDiv.style.display==="none"){
            onamaDiv.style.display = "flex";
            sadrzajDiv.style.display = "none";
            mapaDiv.style.display="none";
            pokazikontaktDiv.style.display="none";

        }else{
            onamaDiv.style.display = "none";
            sadrzajDiv.style.display = "flex";
            sadrzajDiv.style.flexDirection = "row";
            sadrzajDiv.style.flexWrap = "wrap";
            mapaDiv.style.display="none";
            pokazikontaktDiv.style.display="none";

        }
    }
    function vartinazad(){
        window.location.href = 'index.html';
    }
    function sendEmail(){
        var params = {
            name: document.getElementById("ime").value,
            email: document.getElementById("email").value,
            brojtelefona: document.getElementById("brojtelefona").value,
            text: document.getElementById("message").value
            
        };
        const serviceID = "service_r9fqxxp";
        const templateID = "template_3qorx3l";

        emailjs
        .send(serviceID, templateID, params)
        .then((res) => {
                document.getElementById("ime").value = "";
                document.getElementById("email").value = "";
                document.getElementById("brojtelefona").value = "";
                document.getElementById("message").value = "";
                console.log(res);
                alert("poslana poruka");

            })
        .catch((err) => console.log(err));
        }



        /*OVAJ KOD JE NAJVAZNIJI OD SVIH OSTALIH JER OVAJ PREKRIVA DUGME DODAJ U KORPU / KOMENTARE */
        function pokazikomentare() {
            var dugmekorpe = document.querySelectorAll('.cover');
            var dugmekomentari = document.querySelectorAll('.add');

            for (var i = 0; i < dugmekorpe.length; i++) {
                if (dugmekomentari[i].style.display === "none") {
                dugmekomentari[i].style.display = "inline";
                dugmekorpe[i].style.display = "none";
                }else {
                dugmekomentari[i].style.display = "none";
                dugmekorpe[i].style.display = "inline";
                }
            }
        }

</script>
