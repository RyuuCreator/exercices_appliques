<?php
    // Initialize the session
    session_start();
    
    // Check if the user is logged in, if not then redirect him to login page
    // if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    //     header("location: login.php");
    //     exit;
    // }
    
    // Include config file
    require_once "config.php";

    $username = $_SESSION['username'];
    // Selectionne l'info de fileToUploadPDF
    $sql = "SELECT fileToUploadPDF FROM users WHERE username='$username'";
    $req = mysqli_query($link, $sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysqli_error());
    $row = mysqli_fetch_assoc($req);

    // Récupère les données "FileToUploadPDF" sur la BDD
    $fileToUploadPDF = $row['fileToUploadPDF'];

?>
 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/style2.css">
    <title>Portfolio - RyuuCreator</title>
</head>

<body>
    <header class="headerTitre">
        <div class="titreLogo">
            <img src="./assets/img/logo.png" alt="Logo représentant un dragon noir et rouge."/>
            <h1 class="titre">RyuuCreator</h1>
        </div>
        <p class="sousTitre">Portfolio - Dev Web</p>
    </header>

    <nav class="nav">
        <div class="divNav">
            <li class="navLi">
                <a class="navLink" href="index.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="navLi">
                <a class="navLink" href="competences.php">Compétences</a>
            </li>
            <li class="navLi">
                <a class="navLink" href="projet.php">Projets</a>
            </li>
            <li class="navLi">
                <a class="navLink" href="apropos.php">À propos</a>
            </li>
            <li class="navLi">
                <a class="navLink" href="contact.php">Contact</a>
            </li>
        </div>
        <div class="divNav">
                <!-- VUE HORS LIGNE -->
            <?php if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) : ?>
                <div class="navLi menuImgProfilLi">
                    <div class="menuImgProfilDiv">
                        <i class="fas fa-angle-down"></i>
                        <div class="menuImgProfil" style="background-image: url(uploads/usersDefault/usersDefault.jpg);"></div>
                    </div>
                    <div class="sousMenu">
                        <li class="navLi">
                            <a class="navLink" href="register.php">Inscription</a>
                        </li>
                        <li class="navLi">
                            <a class="navLink" href="login.php">Connexion</a>
                        </li>
                    </div>   
                </div>
                <!-- VUE ADMIN -->
            <?php elseif ($_SESSION['role'] == 'admin') : ?>
                <!-- RECUPERATION DE L'INFO SESSION LIER A LA CONNEXTION -->
                <?php $imgProfil = $_SESSION['fileToUpload']; ?>
                <div class="navLi menuImgProfilLi">
                    <div class="menuImgProfilDiv">
                        <i class="fas fa-angle-down"></i>
                        <div class="menuImgProfil" style="background-image: url(<?php echo $imgProfil; ?>);"></div>
                    </div>
                    <div class="sousMenu">
                        <li class="navLi">
                            <a class="navLink" href="welcome.php">Mon compte</a>
                        </li>
                        <li class="navLi">
                            <a class="navLink" href="admin.php">Administration</a>
                        </li>
                        <li class="navLi">
                            <a class="navLink" href="signature.php">Signature</a>
                        </li>
                        <li class="navLi">
                            <a class="navLink" href="logout.php">Déconnexion</a>
                        </li>
                    </div>
                </div>
                <!-- VUE GUEST -->
            <?php elseif ($_SESSION['role'] == 'guest') : ?>
                <!-- RECUPERATION DE L'INFO SESSION LIER A LA CONNEXTION -->
                <?php $imgProfil = $_SESSION['fileToUpload']; ?>
                <div class="navLi menuImgProfilLi">
                    <div class="menuImgProfilDiv">
                        <i class="fas fa-angle-down"></i>
                        <div class="menuImgProfil" style="background-image: url(<?php echo $imgProfil; ?>);"></div>
                    </div>
                    <div class="sousMenu">
                        <li class="navLi">
                            <a class="navLink" href="welcome.php">Mon compte</a>
                        </li>
                        <li class="navLi">
                            <a class="navLink" href="logout.php">Déconnexion</a>
                        </li>
                    </div>
                </div>
            
            <?php endif ?>
        </div>
    </nav>

    <section>
        <div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">                  
                <?php if (!empty($fileToUploadPDF)) : ?>
                    <object class="input_pdf" onload="form_base64_decode_preview(this)" onplay="this.onload()" onloadedmetadata="this.onload()" onerror="this.support_decode_preview=false" type="application/pdf" data="data:application/pdf;base64,<?php echo $fileToUploadPDF; ?>"></object>
                <?php else : ?>
                    <p>Visualisation du PDF</p>
                <?php endif ?>
            </form>
        </div>
    </section>
    
    <footer>
        <div class="social">
            <a class="github" href="https://github.com/RyuuCreator">
                <i class="fab fa-github"></i>
            </a>
            <a class="linkedin" href="https://fr.linkedin.com/in/mickael-tailhades-248533216">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a class="twitter" href="https://twitter.com/ryuucreator">
                <i class="fab fa-twitter"></i>
            </a>
            <a class="twitch" href="https://www.twitch.tv/ryuucreator">
                <i class="fab fa-twitch"></i>
            </a>
        </div>
        <?php echo "<p class=\"copyright\"> &copy; Copyright 2009-" . date("Y") . " - RyuuCreator. Tout droits réservés.</p>"; ?>
    </footer>
    
    <script src="assets/js/script.js"></script>
</body>
</html>