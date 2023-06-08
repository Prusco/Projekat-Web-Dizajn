    <!DOCTYPE html>
    <html lang="en">
    <head>
    <?php
    session_start();
    $id = $_GET['id'];
    $proizvod = $_GET["proizvod"];
    ?>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="komentari.css">
        <title>Komentari za <?php echo $proizvod?></title>
    </head>
    <body>

    <?php
    
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "online_naručivanje_deluxe_food";

        
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql1 = "SELECT * FROM proizvodi WHERE naziv_proizvoda = '$proizvod'";
        $retzltat1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_assoc($retzltat1);
        $proizvodId = $row1["proizvod_id"];
        ?>
        <div class="pozadina">

            <video autoplay loop muted class="video">
                <source src="slike-video/video.mp4" type="video/mp4">
            </video>

            <header class="main-header">
            <div class="logo">
                <h1 class="naslov"><em>DELUXE</em> FOOD</h1>
            </div>

            </header>
            
        <?php
        //Sluzi za produkte iz baze
        $produktiQuery = "SELECT * FROM proizvodi WHERE proizvod_id = $proizvodId ";
        $produktiRezultat = $conn->query($produktiQuery);
        ?>
        
        <div class="sadrzaj">
            <div class="poruka"> 
                <?php if ($produktiRezultat->num_rows > 0) {
                    $prokuktiRow = $produktiRezultat->fetch_assoc();
                    echo "<h1>Komentari za Proizvod: <b>" . $prokuktiRow["naziv_proizvoda"] . "</b></h1><hr>";
                } ?>
            
            </div>
        </div>
        
        <?php
        //Komentari iz baze
        $komentariQuery = "SELECT * FROM komentari WHERE ID_proizvoda = $proizvodId";
        $komentariRezultat = $conn->query($komentariQuery);
        ?>
        <?php if ($komentariRezultat->num_rows > 0) { 
            while ($row = $komentariRezultat->fetch_assoc()) {
        //Prikaz komentara
        ?>
            
            <div class="card">
                <p class="naziv"><?php echo "<p><b>Naziv: </b>" . $row["naziv"] . "</p>"; ?></p>
                <p class="komentar"><?php echo "<p><b>Komentar:</b> " . $row["tekst"] . "</p>"; ?></p>
                <p class="korisnik"><?php //Prikazuje korisnika 
                    $korisnikId = $row["id_usera"];
                    $korisnikQuery = "SELECT * FROM registracija WHERE ID = $korisnikId";
                    $korisnikRezultat = $conn->query($korisnikQuery);

                    if ($korisnikRezultat->num_rows > 0) {
                        $korisnikRow = $korisnikRezultat->fetch_assoc();
                        echo "<p><b>Korisnik: </b>" . $korisnikRow["Ime"] . "</p>";
                    } else {
                        echo "<p><b>Korisnik</b>: Nepoznata ličnost</p>";
                    } ?>
                </p>
                <div class="dug">
                    <?php
                    if ($id == 1 || $id == 2) {
                        echo '<button class="obrisi" type="button" data-id="' . $row["id_komentara"] . '">Obriši</button>';
                    }
                    ?>
                </div>
                
            </div>
        
            <script>
            var ukloni = document.getElementsByClassName("obrisi");
            for(var i=0; i<ukloni.length; i++){
                ukloni[i].addEventListener("click", function(event){
                    var target = event.target;
                    var komentar_id = target.getAttribute("data-id");
                    var xml = new XMLHttpRequest();
                    xml.onreadystatechange = function(){
                        if(this.readyState == 4 && this.status == 200){
                            target.innerHTML = this.responseText;
                            target.style.opacity = .3;
                        }
                    }

                    xml.open("GET", "veza.php?komentar_id="+komentar_id, true);
                    xml.send();
                })
            }

        </script>        
            
    
        
            <?php }}else { ?>
                <div class="card1">
                    <?php echo "<p>Nema još komentara.</p>"; ?>
                </div>
            <?php
                }
            ?>

        </div>  
        

        <?php
            $conn->close();
        ?>
        <div class="form">
        <form action="komentari.php?id=<?php echo urlencode($id); ?>&proizvod=<?php echo urlencode($proizvod); ?>" method="post">
            
            <input type="text" placeholder="Naziv komentara" name="naziv" required>
            <textarea placeholder="Tekst komentara" id="komen" cols="20 " rows="5" name="tekstkomentara" required></textarea> 
            <br>
            <br>
            <button type="submit" name="submit" onclick="dodajKomentar()">Postavi</button>
        </form>
        </div>

        </div>
        <div class="footer">
            <p class="dno"> &#169; SI 2023</p>
        </div>



    <script>
        function dodajKomentar(){
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
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Get form data
                $naziv = $_POST['naziv'];
                $tekstkomentara = $_POST['tekstkomentara'];
                
                // Insert data into table
                $sql2 = "INSERT INTO komentari (id_usera, naziv, tekst, ID_proizvoda) 
                        VALUES ('$id', '$naziv', '$tekstkomentara', '$proizvodId')";
                
                if ($conn->query($sql2) === TRUE) {
                    header("Location: komentari.php?id=" . urlencode($id) . "&proizvod=" . urlencode($proizvod));
                    exit();
                } else {
                    echo "Error inserting record: " . $conn->error;
                }
            }
    
            $conn->close();
        ?>
        }



    </script>




    </body>
    </html>

