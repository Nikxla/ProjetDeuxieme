<?php

require_once('../php/function.inc.php');
require_once('../php/checkInput.php');

if (isset($_SESSION['logged']) == true) {
    header("location: index.php");
}

$error = array();
$_SESSION['register'] = "none";

if (isset($_POST['submit'])) {
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['password1']) && !empty($_POST['password2'])) {
        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
        $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_STRING);
        $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING);


        if (!OnlyLetters($nom)) {
            array_push($error, "Le nom ne doit contenir que des charactères.");
        } else {
            $_SESSION['nomRegister'] = $nom;
        }
        if (!OnlyLetters($prenom)) {
            array_push($error, "Le prénom ne doit contenir que des caractères.");
        } else {
            $_SESSION['prenomRegister'] = $prenom;
        }
        if ($email == false) {
            array_push($error, "Veuillez entrer un email valide.");
        } else {
            if (checkEmail($email) == true) {
                array_push($error, "Un compte existe déjà avec l'email : " . $email);
            } else {
                $_SESSION['emailRegister'] = $email;
            }
        }
        if ($password1 != $password2) {
            array_push($error, "Les mots de passe ne correspondent pas.");
        } else {
            if (strlen($password1) < 8 || strlen($password1) > 16) {
                array_push($error, "Le mot de passe doit avec au minimum 8 caractères et 16 au maximum.");
            }
        }

        if (count($error) <= 0) {
            $finalPassword = sha1($_POST['password1']);
            register($nom, $prenom, $email, $finalPassword);
            $_SESSION['register'] = "Ok";
        }

    } else {
        array_push($error, "Veuillez remplir tous les champs.");
    }
}
?>

<!doctype html>

<html lang="fr">
<head>
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="menuRight">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation" style="background-color: #00bbe3;">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php">Catalogue <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./about.php">A propos</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="./register.php">Inscription</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./login.php">Connexion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container pt-5" id="container">
    <section>
        <article>
            <?php
            if (count($error) > 0) {
                echo '<div class="alert table-danger error">';
                for ($i = 0; $i < count($error); $i++) {
                    echo $error[$i];
                    echo '<br/>';
                };
                echo '</div>';
                ?>
                <script>
                    var element = document.getElementById("container");
                    element.classList.remove("pt-5");
                </script>
            <?php
            } else if ($_SESSION['register'] == "Ok") {
                echo '<div class="alert table-success error">';
                echo "Votre inscription est terminée " . $prenom . " " . $nom . " !";
                echo '</div>';
                $_SESSION['email'] = $email;
                $_SESSION['idClient'] = getIdClient($_SESSION['email']);
                $_SESSION['logged'] = true;
                $_SESSION['role'] = "visitor";

                header("refresh:2;url=./index.php");
                ?>
                <script>
                    var element = document.getElementById("container");
                    element.classList.remove("pt-5");
                </script>
                <?php
            }
            ?>
            <form action="register.php" method="post" enctype="multipart/form-data">
                <label><b>Nom</b></label>
                <input type="text" class="form-control

                <?php /*
                for ($variable = 0; $variable < count($error); $variable++) {
                    if (isset($error[$variable]) == "Le nom ne doit contenir que des charactères.") {
                        echo "alert-danger ";
                    }
                } */
                ?>

                " name="nom" id="register-nom" <?php

                if (isset($_SESSION['nomRegister']) != "") {
                    ?>
                    placeholder="<?= $_SESSION['nomRegister'] ?>" value="<?= $_SESSION['nomRegister']; ?>"
                    <?php
                } else {
                    ?>
                    placeholder="Nom"
                    <?php
                }
                ?>/>
                <br/>
                <label><b>Prénom</b></label>
                <input type="text" class="form-control" name="prenom" id="register-prenom"
                    <?php
                    if (isset($_SESSION['prenomRegister']) != "") {
                        ?>
                        placeholder="<?= $_SESSION['prenomRegister'] ?>" value="<?= $_SESSION['prenomRegister']; ?>"
                        <?php
                    } else {
                        ?>
                        placeholder="Prenom"
                        <?php
                    } ?>/>
                <br/>
                <label><b>Email</b></label>
                <input type="text" class="form-control" name="email" id="register-email"
                    <?php
                    if (isset($_SESSION['emailRegister']) != "") {
                        ?>
                        placeholder="<?= $_SESSION['emailRegister'] ?>" value="<?= $_SESSION['emailRegister']; ?>"
                        <?php
                    } else {
                        ?>
                        placeholder="Email"
                        <?php
                    } ?>
                />
                <br/>
                <label><b>Mot de passe</b></label>
                <input type="password" class="form-control" placeholder="Entre 8 et 16 caractères." name="password1"
                       id="register-password1"/>
                <br/>
                <label><b>Confirmation du mot de passe</b></label>
                <input type="password" class="form-control" placeholder="Entre 8 et 16 caractères." name="password2"
                       id="register-password2"/>
                <br/>
                <button id="register-submit" type="submit" class="btn btn-primary" name="submit" style="float: right; background-color: #00bbe3;">Inscription</button>
            </form>
            <br/>
            <p class="font-weight-bold">Vous avez un déjà un compte ? <a href="./login.php">Connectez-vous ici</a></p>
        </article>
    </section>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>
</body>
</html>