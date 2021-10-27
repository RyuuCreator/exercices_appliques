<?php
    // Initialize the session
    session_start();  

    // Include config file
    require_once "config.php";
    
    // Define variables and initialize with empty values
    $username = $email = $password = $confirm_password = "";
    $username_err = $email_err = $password_err = $confirm_password_err = "";
    
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        // Validate username
        if(empty(trim($_POST["username"]))){
            $username_err = "Merci d'entrer un nom d'utilisateur.";
        } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
            $username_err = "Le nom d'utilisateur ne peut contenir que des lettres, des chiffres et des traits de soulignement.";
        } else {
            // Prepare a select statement
            $sql = "SELECT id FROM users WHERE username = ?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                
                // Set parameters
                $param_username = trim($_POST["username"]);
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    /* store result */
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $username_err = "Ce nom d'utilisateur est déjà pris.";
                    } else{
                        $username = trim($_POST["username"]);
                    }
                } else{
                    $alert = '<div class="alert alert_danger">Oups! Quelque chose s\'est mal passé. Veuillez réessayer plus tard.';
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (empty($_POST["email"])) {
            $email_err = "Email requis";
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_err = "Format d'email incorrecte";
            }
        }

        // Validate password
        if(empty(trim($_POST["password"]))){
            $password_err = "Veuillez entrer un mot de passe.";     
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "Le mot de passe doit avoir au moins 6 caractères.";
        } else{
            $password = trim($_POST["password"]);
        }
        
        // Validate confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Veuillez confirmer le mot de passe.";     
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Le mot de passe ne correspond pas.";
            }
        }
        
        // Check input errors before inserting in database
        if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
            // Creation code de vérification 
            $verification = substr(md5(mt_rand()), 0, 15);
            
            // Prepare an insert statement
            $sql = "INSERT INTO users (username, email, password, fileToUpload, role, isactive, verification, created_at) VALUES (?, ?, ?, 'uploads/usersDefault/usersDefault.jpg', 'guest', 0, '$verification', now())";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
                
                // Set parameters
                $param_username = $username;
                $param_email = $email;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                
                if(!is_dir("uploads")) {
                    mkdir("uploads", 0755, true);
                }

                if(!is_dir("uploads/$username")) {
                    mkdir("uploads/$username");
                }
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Envoi mail
                    $to = $email;
                    $from = 'm.tailhades@codeur.online';
                    $subjet = "Code d'activation pour le test RyuuCreator.";
                    $body = "Votre Code d'activation est " . $verification . "\n";
                    $body .= 'S\'il vous plait, cliquez sur ici : <a href="localhost/login/activation.php?username=' . $username . '&email=' . $email . '&verification=' . $verification. '">ACTIVATION</a> pour activer votre compte.';
                    
                    $header  = 'MIME-Version: 1.0' . "\n";
                    $header .= 'Content-type: text/html; charset=utf-8' . "\n";
                    $header .= "From: $from \n";
                    $header .= "Reply-To: $from ";

                    mail($to, $subjet, $body, $header);

                    $alert = '<div class="alert alert_success">Un code d\'activation vous a été envoyé, vérifiez vos e-mails.</div>';

                    // Redirect to login page
                    header("location: login.php?alert=$alert");
                } else{
                    $alert = '<div class="alert alert_danger">Oups! Quelque chose s\'est mal passé. Veuillez réessayer plus tard.</div>';
                }
                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
        // Close connection
        mysqli_close($link);
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/style2.css">
    <title>Page Création Login</title>
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
        </div>
    </nav>

    <section>
        <form class="container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="contour">
                <h2 class="h2">Inscrivez-vous</h2>
                <p>Veuillez remplir ce formulaire pour créer un compte.</p>

                <?php
                    if(isset($_GET['alert'])){
                        $alert = $_GET['alert'];
                    }

                    if(!empty($alert)){ 
                        echo $alert; 
                    }
                ?>
                <div class="input_group">
                    <i class="fas fa-user red input_group_prepend <?php echo (!empty($username_err)) ? 'is_invalid' : ''; ?>""></i>
                    <input type="text" id="form_username" class="form_control <?php echo (!empty($username_err)) ? 'is_invalid' : ''; ?>" value="<?php echo $username; ?>" name="username" placeholder="Nom d'utilisateur">
                    <span class="invalid_feedback"><?php echo $username_err; ?></span>
                </div>
                <div class="input_group">
                    <i class="fas fa-envelope red input_group_prepend <?php echo (!empty($email_err)) ? 'is_invalid' : ''; ?>""></i>
                    <input type="text" id="form_email" class="form_control <?php echo (!empty($email_err)) ? 'is_invalid' : ''; ?>" value="<?php echo $email; ?>" name="email" placeholder="Votre e-mail">
                    <span class="invalid_feedback"><?php echo $email_err; ?></span>
                </div>
                <div class="input_group">
                    <i class="fas fa-lock red input_group_prepend <?php echo (!empty($password_err)) ? 'is_invalid' : ''; ?>""></i>
                    <input type="password" id="form_password" class="form_control <?php echo (!empty($password_err)) ? 'is_invalid' : ''; ?>" value="<?php echo $password; ?>" name="password" placeholder="Mot de passe">
                    <span class="invalid_feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="input_group">
                    <i class="fas fa-key red input_group_prepend <?php echo (!empty($confirm_password_err)) ? 'is_invalid' : ''; ?>""></i>
                    <input type="password" id="form_confirm_password" class="form_control <?php echo (!empty($confirm_password_err)) ? 'is_invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" name="confirm_password" placeholder="Confirmez le mot de passe">
                    <span class="invalid_feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="div_btn">
                    <button type="submit" value="Submit" class="btn_submit">S'enregistrer</button>
                </div>
                <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous</a>.</p>
            </div>
        </form>
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

    <script src="./assets/js/script.js"></script>
</body>
</html>