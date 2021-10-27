<?php

include('db.php');

//Traitement des données
$sql = "SELECT id, nom, prenom, email, pays FROM contact";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    // on boucle sur les résultats de la requête pour alimenter le tableau $array
    while ($row = $result->fetch_assoc()) {
        $arrayTemp[] = $row;
    }

    // On définit un nouveau tableau pour y stocker le premier tableau précédé des paramêtres attendus par Datatables
    $dataset = array(
        "echo" => 1,
        "totalrecords" => count($arrayTemp),
        "totaldisplayrecords" => count($arrayTemp),
        "data" => $arrayTemp
    );

    // On retourne à la vue index.php nos résultats au format JSON !
    echo json_encode($dataset);
} else {
    echo "DIE !";
}
$connection->close();
