<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.css">
        <link rel="stylesheet" href="./assets/css/thanks.css">
        <title>Formulaire</title>
    </head>

    <body>
        <div class="thanks">
            <p>Merci pour l'envoi de ce mail.</p>
        </div>
        <?php
            include ("connect.php");

            $result = $connection->query('SELECT * FROM contact;') ;

            if (!$result) {
                die('<p>ERREUR Requête invalide : '.$connection->error.'</p>');
            }
        ?>
        <table id="table_id" class="display">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Pseudo</th>
                    <th>Anniversaire</th>
                    <th>E-mail</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    for ($i=0 ; $i < $result->num_rows ; $i++) {
                            $row = $result->fetch_assoc() ;
                            $name = $row['name'] ;
                            $pseudo = $row['pseudo'] ;
                            $anniversaire = $row['anniversaire'];
                            $email = $row['email'];
                            $subject = $row['subject'];
                            $message = $row['message'];
                            $time = $row['time'];

                            echo "<tr><td>$name</td><td>$pseudo</td><td>$anniversaire</td><td>$email</td><td>$subject</td><td>$message</td><td>$time</td></tr>";
                        }
                        
                    $result->free() ;

                    $connection->close() ;
                ?>
            </tbody>
        </table>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.js"></script>
        <script src="./assets/js/table.js"></script>
    </body>

</html>