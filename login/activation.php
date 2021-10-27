<?php
    // Initialize the session
    session_start();
    
    require_once "config.php";
    // Récupère les donnée du lien et vérifie que les données ne sont pas vide
    if (isset($_GET['username']) && !empty($_GET['username']) && isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['verification']) && !empty($_GET['verification'])){
        // indiquer les variables
        $username = $_GET['username'];
        $email = $_GET['email'];
        $verification = $_GET['verification'];
        
        // Selectionne les données de "verification" et "isactive" de l'utilisateur qui veux valider son compte.
        $sql = "SELECT verification, isactive, created_at, fileToUpload FROM users WHERE username='$username'";
        $req = mysqli_query($link, $sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysqli_error());
        $row = mysqli_fetch_assoc($req);

        // récupère les données "verification", "isactive" et FileToUpload sur la BDD
        $verifbdd = $row['verification']; 
        $isactive = $row['isactive']; 
        $imgProfil = $row['fileToUpload'];
        //récupère la date et heure de création dans la BDD
        $created_at = $row['created_at'];

        //strotime passe la date en français et de string à int
        $now    = time();
        $target = strtotime($created_at);
        $diff   = $now - $target;

        // 15 minutes = 15*60 seconds = 900
        if ($diff <= 900) {
            // Verifie si "isactive" est sur 0 et que verification du lien soit le même que sur la BDD
            if($isactive == 0 && $verification == $verifbdd) { 
                // si oui change isactive en 1
                $req = "UPDATE users SET isactive=1 WHERE username='$username'";
                mysqli_query($link, $req);

                $alert = '<div class="alert alert_success">Compte activé avec succès !</div>';

                header("location: login.php?alert=$alert");
    
            } elseif($isactive == 1) { // sinon si isactive est deja sur 1 envoyer le message appropier
                $alert = '<div class="alert alert_success">Le compte est déja activé !</div>';

                header("location: login.php?alert=$alert");
    
            } else { // sinon dire que le lien est invalide. 
                $alert = '<div class="alert alert_danger">Le lien d\'activation est invalide !</div>';

                header("location: login.php?alert=$alert");
            }
        } else {

            // VERIFIE SI LE FICHIER N'EST PAS EGAL AVEC CELUI PART DEFAULT, SI IL L'EST LE SUPPRIME
            if($imgProfil != 'uploads/usersDefault/usersDefault.jpg') {
                unlink($imgProfil);
            }
            // VERIFIE SI LE DOSSIER USERNAME EXISTE, SI OUI LE SUPPRIME
            if(is_dir("uploads/$username")) {
                rmdir("uploads/$username");
            }

            $sql = "DELETE FROM users WHERE username='$username'";
            $req = mysqli_query($link, $sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysqli_error());
            
            $alert = '<div class="alert alert_danger">Le lien d\'activation à expiré, veuillez vous réinscrire !</div>';

            header("location: register.php?alert=$alert");
        }
    }

?>