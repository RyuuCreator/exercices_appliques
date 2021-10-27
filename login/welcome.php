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

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $imgProfil = $_SESSION['fileToUpload'];
        
        $target_dir = "uploads/$username/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $imgAlert = '<div class="alert alert_success">Le fichier est une image - ' . $check["mime"] . '.</div>';
            $uploadOk = 1;
        } else {
            $imgAlert = '<div class="alert alert_danger">Le fichier n\'est pas une image.</div>';
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $imgAlert = '<div class="alert alert_warning">Désolé, le fichier existe déjà.</div>';
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $imgAlert = '<div class="alert alert_danger">Désolé, le fichier est trop volumineux.</div>';
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $imgAlert = '<div class="alert alert_warning">Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.</div>';
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $imgAlert .= '<div class="alert alert_danger">Désolé, votre fichier n\'a pas été téléchargé.</div>';
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $imgAlert = '<div class="alert alert_success">Le fichier ' . htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])) . ' as bien était uploadé.</div>';

                $sql = "UPDATE users SET fileToUpload = '$target_file' WHERE username = '$username'";
                mysqli_query($link, $sql);

                if($imgProfil != 'uploads/usersDefault/usersDefault.jpg') {
                    unlink($imgProfil);
                }
                $_SESSION['fileToUpload'] = $target_file;

                header("location: welcome.php?imgAlert=$imgAlert");

            } else {
                $imgAlert = '<div class="alert alert_danger">Désolé, une erreur s\'est produite lors du téléchargement de votre fichier.</div>';
            }
        }
    }
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

    <section>
        <div class="container">
            <div class="contour">
                <h1 class="h1">Salouter, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Bienvenue sur mon site.</h1>
                <?php if ($_SESSION['role'] == 'admin') : ?>
                    <h3 style="color:red;">JE SUIS ADMIN !!!!!!</h3>
                <?php elseif ($_SESSION['role'] == 'guest') : ?>
                    <h1>JE SUIS UN GUEST</h1>
                <?php endif ?>
                <?php
                    if(isset($_GET['imgAlert'])){
                        $imgAlert = $_GET['imgAlert'];
                    }

                    if(!empty($imgAlert)){ 
                        echo $imgAlert; 
                    }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div class="imgProfilDiv">
                        <div class="imgProfil" style="background-image: url(<?php echo $imgProfil; ?>);"></div>
                    </div>
                    <p>Selectionnez votre image:</p>
                    <div class="input_img">
                        <input class="testInput" type="file" name="fileToUpload" id="fileToUpload">
                        <div class="testInput">
                            <input type="submit" value="Upload Image" name="submit">
                        </div>
                    </div>
                </form>
                <button class="div_btn btn_submit"><a href="reset_password.php" class="btn_lien">Réinitialisation de mot de passe</a></button>
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