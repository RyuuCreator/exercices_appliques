<?php 
    include('db.php');
    
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $pays = $_POST['pays'];
    $ip = $_SERVER['REMOTE_ADDR'];
        
    $query = "INSERT INTO `contact` (nom, prenom, email, pays, ip) VALUES ('$nom', '$prenom', '$email', '$pays', '$ip')";
    $result = $connection->query($query);
?>