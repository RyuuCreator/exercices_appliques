<?php

include('db.php');

//var_dump($_POST);
$id = $_POST['id_r'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$pays = $_POST['pays'];

//Traitement des données
$query = 'UPDATE `contact` SET nom=' . $nom . ', prenom=' . $prenom . ', email=' . $email . ', pays=' . $pays . ' WHERE id=' . $id . '';
$result = $connection->query($query);

echo json_encode(true);
