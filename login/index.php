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
            <img src="assets/img/logo.png" alt="Logo représentant un dragon noir et rouge."/>
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

    <section id="sectionAccueil" class="sectionAccueil">
        <header>
            <h2>Page d'accueil</h2>
            <h3>Accueil en construction</h3>
        </header>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Cumque dignissimos nemo dolore, minima nam, et quam corporis itaque dolores pariatur corrupti quos dicta reiciendis eaque esse totam molestiae ducimus! A.
        Ex ab explicabo, molestiae soluta sit ipsum unde, ad ratione error doloribus accusamus neque! Numquam quam, minima dolore odit quo, aperiam nesciunt commodi, consequatur architecto hic iure facere? Eos, facere.
        Cupiditate, placeat nam repudiandae blanditiis, pariatur ducimus natus, fugit aut doloremque deserunt est perferendis cumque beatae cum iste at dolor eius itaque similique ipsam labore ea tempore. Impedit, odio eaque.
        Rem illo itaque pariatur ducimus corrupti cumque alias excepturi non repellat molestiae, ut labore cum repudiandae aperiam, soluta ipsum est facere quia reiciendis ea aut nostrum possimus accusantium. Ipsum, animi.
        Totam quaerat quod obcaecati cumque consequuntur officiis assumenda iusto impedit. Nobis dolorum laboriosam dolorem cumque qui eveniet id quaerat vero odio, eius praesentium est eum soluta earum quibusdam mollitia facilis?
        Temporibus hic iusto eum porro itaque ratione commodi necessitatibus voluptatibus nostrum eaque excepturi exercitationem perspiciatis laborum nobis esse nulla quis, vel nihil ut ullam repellendus nemo illo? Est, beatae error.
        Harum, sequi ex, eos magnam totam architecto nesciunt molestias dicta esse autem, voluptatum natus laudantium facilis. Aperiam impedit ab ex doloribus voluptatum excepturi repudiandae atque dolorem soluta nisi, consequatur numquam?
        Repellendus vitae similique, repellat minima mollitia, sint quis molestiae debitis optio vel unde praesentium? Officiis nulla voluptatum asperiores. Voluptatum, ex! Id asperiores accusantium aperiam, tenetur dolores doloremque alias dicta nesciunt.
        Perspiciatis ipsa explicabo dolore iste eaque necessitatibus magnam beatae cupiditate ratione veniam quos assumenda, tempora quidem sunt doloribus quasi incidunt eveniet facilis facere sed et sint dolorem eligendi adipisci! Omnis?
        Cum eum, molestias id excepturi consequuntur neque quos eaque minima, doloribus ducimus dolorem accusantium fugiat tempore dignissimos deserunt repellat alias provident ratione est rem corporis? Fugiat laborum dolorum accusamus maiores?</p>
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