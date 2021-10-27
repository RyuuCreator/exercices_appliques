<?php
    // Initialize the session
    session_start();
    
    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: welcome.php");
        exit;
    }

    // Include config file
    require_once "config.php";
    
    // Define variables and initialize with empty values
    $username = $password = "";
    $username_err = $password_err = $login_err = "";
    
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        // Check if username is empty
        if(empty(trim($_POST["username"]))){
            $username_err = "Veuillez saisir le nom d'utilisateur.";
        } else{
            $username = trim($_POST["username"]);
        }
        
        // Check if password is empty
        if(empty(trim($_POST["password"]))){
            $password_err = "S'il vous plait entrez votre mot de passe.";
        } else{
            $password = trim($_POST["password"]);
        }
        
        // Validate credentials
        if(empty($username_err) && empty($password_err)){
            // Prepare a select statement
            $sql = "SELECT id, username, password, role, fileToUpload, isactive FROM users WHERE username = ?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                
                // Set parameters
                $param_username = $username;
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Store result
                    mysqli_stmt_store_result($stmt);
                    
                    // Check if username exists, if yes then verify password
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $role, $fileToUpload, $isactive);
                        mysqli_stmt_fetch($stmt);

                        if($isactive == 1){
                            if(password_verify($password, $hashed_password)){
                                
                                // Password is correct, so start a new session
                                // session_start();
                                
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;  
                                $_SESSION["role"] = $role;
                                $_SESSION["fileToUpload"] = $fileToUpload;
                                
                                // Redirect user to welcome page
                                header("location: welcome.php");
                            } else{
                                // Password is not valid, display a generic error message
                                $login_err = '<div class="alert alert_danger">Nom d\'utilisateur ou mot de passe invalide.';
                            }
                        } else{
                            $invalid = '<div class="alert alert_danger">Votre compte n\'est pas activé. Veuillez regarder vos mail pour le faire.';
                        }
                        
                    } else{
                        // Username doesn't exist, display a generic error message
                        $login_err = '<div class="alert alert_danger">Nom d\'utilisateur invalide.';
                    }
                } else{
                    $invalid = '<div class="alert alert_danger">Oups! Quelque chose s\'est mal passé. Veuillez réessayer plus tard.';
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

    <form class="container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="contour">
            <h2 class="h2">Connexion</h2>
            <p>Veuillez renseigner vos identifiants pour vous connecter.</p>
            
            <?php
                if(isset($_GET['alert'])){
                    $alert = $_GET['alert'];
                    echo $alert;
                }
                
                if(!empty($invalid)){ 
                    echo $invalid ; 
                } 

                if(!empty($login_err)){ 
                    echo $login_err ; 
                }        
            ?>

            <div class="input_group">
                <i class="fas fa-user red input_group_prepend <?php echo (!empty($username_err)) ? 'is_invalid' : ''; ?>""></i>
                <input type="text" id="form_username" class="form_control <?php echo (!empty($username_err)) ? 'is_invalid' : ''; ?>" value="<?php echo $username; ?>" name="username" placeholder="Nom d'utilisateur">
                <span class="invalid_feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="input_group">
                <i class="fas fa-lock red input_group_prepend <?php echo (!empty($password_err)) ? 'is_invalid' : ''; ?>""></i>
                <input type="password" id="form_password" class="form_control <?php echo (!empty($password_err)) ? 'is_invalid' : ''; ?>" value="<?php echo $password; ?>" name="password" placeholder="Mot de passe">
                <span class="invalid_feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="div_btn">
                <button type="submit" value="Submit" class="btn_submit">Se connecter</button>
            </div>
            <p>Vous n'avez pas de compte ? <a href="register.php">Inscrivez-vous</a>.</p>
        </div>
    </form>
    
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