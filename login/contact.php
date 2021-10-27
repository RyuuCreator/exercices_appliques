<?php
    // Initialize the session
    session_start();
    
    // Check if the user is logged in, if not then redirect him to login page
    
    // if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    //     header("location: login.php");
    //     exit;
    // }
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

    <section id="sectionContact" class="sectionContact">
        <header>
            <h2>Contactez-moi</h2>
            <p>Vous voulez me contacter pour un projet, une information ou juste me demander quelque chose! N'hésitez pas tout se passe ci-dessous.</p>
        </header>
        <div class="containerContact">
            <form class="style_form" method="POST" action="contact_form.php">
                <div class="card">
                    <div class="card_body">
                        <div class="form_header">
                            <h3 class="h3"><i class="far fa-envelope red"></i> Écrivez-moi :</h3>
                        </div>
                        <span class="input input--fumi">
                            <input class="input__field input__field--fumi" type="text" id="form_name" name="name" minlength="3" required>
                            <label class="input__label input__label--fumi" for="form_name">
                                <i class="far fa-user icon icon--fumi"></i>
                                <span class="input__label-content input__label-content--fumi">Votre nom</span>
                            </label>
                        </span>
                        <label id="form_name-error" class="error" for="form_name"></label>
                        <span class="input input--fumi">
                            <input class="input__field input__field--fumi" type="text" id="form_email" name="email" required>
                            <label class="input__label input__label--fumi" for="form_email">
                                <i class="far fa-envelope icon icon--fumi"></i>
                                <span class="input__label-content input__label-content--fumi">Votre e-mail</span>
                            </label>
                        </span>
                        <label id="form_email-error" class="error" for="form_email"></label>
                        <span class="input input--fumi">
                            <input class="input__field input__field--fumi" type="text" id="form_subject" name="subject" minlength="3 " required>
                            <label class="input__label input__label--fumi" for="form_subject">
                                <i class="far fa-bookmark icon icon--fumi"></i>
                                <span class="input__label-content input__label-content--fumi">Objet du mail</span>
                            </label>
                        </span>
                        <label id="form_subject-error" class="error" for="form_subject"></label>
                        <span class="input input--fumi">
                            <textarea class="input__field input__field--fumi" type="text" id="form_text" name="message" required></textarea>
                            <label class="input__label input__label--fumi" for="form_text">
                                <i class="far fa-edit icon icon--fumi"></i>
                                <span class="input__label-content input__label-content--fumi">Votre message</span>
                            </label>
                        </span>
                        <label id="form_text-error" class="error" for="form_text"></label>
                        <div class="text_center">
                            <button type="submit" value="Submit" class="btn_envoyer">Envoyer</button>
                        </div>
        
                    </div>
                </div>
            </form>

            <div class="containerMapInfo">
                <div class="containerMap">
                    <iframe src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=st%20vulbas+()&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" allowfullscreen=""></iframe>
                </div>
                <div class="containerInfo">
                    <div class="info">
                        <a><i class="fas fa-map-marker-alt red"></i></a>
                        <p>St-Vulbas, 01150</p>
                        <p>France</p>
                    </div>

                    <div class="info">
                        <a><i class="fas fa-mobile-alt red"></i></a>
                        <p>06 xx xx xx xx</p>
                        <p>Lun - Sam, 8h-20h</p>
                    </div>

                    <div class="info">
                        <a><i class="far fa-envelope red"></i></a>
                        <p>m.tailhades@codeur.online</p>
                        <p></p>
                    </div>
                </div>
            </div>
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