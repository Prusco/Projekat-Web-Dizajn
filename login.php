<?php
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli("localhost","root","","online_naručivanje_deluxe_food");
    if($conn->connect_error){
        die("Failed to connect : " .$conn->connect_error);
    }else{
        $stmt = $conn->prepare("select * from registracija where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt_result = $stmt->get_result();
        if($stmt_result->num_rows > 0){
            $data = $stmt_result->fetch_assoc();
            if($data['password'] === $password){
                if($data['id_rolovi']==1){
                    header("Location: admin.php?username=" . urlencode($username));
                    exit();
                }elseif($data["id_rolovi"]==2){
                    header("Location: testadmin.php?username=" . urlencode($username));
                    exit();
                }elseif($data["id_rolovi"]==3){

                    header("Location: mainv2.php?username=" . urlencode($username));
                    exit();
                }
            }else{
                echo '<script>alert("Incorrect password. Please try again."); window.location.href = "login.html";</script>';
                exit();
            }   
        }else{
            echo '<script>alert("Username not found. Please try again or register on this link ."); window.location.href = "register.html";</script>';
            exit();
        }

    }
?>