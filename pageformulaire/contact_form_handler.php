<?php 
    include('connect.php');
    $errors = '';
    $myemail = 'm.tailhades@codeur.online';
    if(
        empty($_POST['name']) ||
        empty($_POST['pseudo']) ||
        empty($_POST['anniversaire']) ||
        empty($_POST['email']) ||
        empty($_POST['subject']) ||
        empty($_POST['message']) 
    ) {
        $errors .= "\n Error: Tous les champs sont requis";
    }

    $name = $_POST['name'];
    $pseudo = $_POST['pseudo'];
    $birthday = $_POST['anniversaire'];
    $email_address = $_POST['email'];
    $objet = $_POST['subject'];
    $message = $_POST['message'];

    if(empty($errors)) {
        $to = $myemail;
        $email_subjet = "Soumission du formulaire de contact : $name";
        $email_body = "<p style=\"font-size: 25px\">Vous avez reçu un nouveau message.</p><p style=\"font-size: 20px;\">Voici les détails :</p><br><p><strong><u>Nom</u> :</strong>$name</p><p><strong><u>Pseudo</u> : </strong>$pseudo</p><p><strong><u>Date de naissance</u> : </strong>$birthday</p><p><strong><u>E-mail</u> : </strong>$email_address</p><br><p><strong><u>Objet:</u> : </strong>$objet</p><p><strong><u>Message</u> : </strong>$message</p>";
        
        $header  = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $header .= "From: $email_address\n";
        $header .= "Reply-To: $email_address";

        mail($to, $email_subjet, $email_body, $header);

        $query = 'INSERT INTO `contact` (name, pseudo, anniversaire, email, subject, message) VALUES (' . $name . ', ' . $pseudo . ', ' . $birthday . ', ' . $email_address . ', ' . $objet . ', ' . $message . ')';
        $result = mysqli_query($connection, $query);

        //redirect to the "thank you" page
        header('location: contact_form_thank_you.php');
    }
?>

