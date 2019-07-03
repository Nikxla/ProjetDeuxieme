<?php

require_once('../php/function.inc.php');

if (isset($_SESSION['logged']) == true) {
    header("location: index.php");
}

$error = array();

if (isset($_POST['submit'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $mdp = sha1($_POST['password']);

        $mdpBDD = login($email);

        if ($mdpBDD[0] == $mdp) {
            $_SESSION['logged'] = true;
            $_SESSION['idClient'] = getIdClient($email);
            $_SESSION['nomClient'] = getNomClient($_SESSION['idClient'][0]);
            $_SESSION['prenomClient'] = getPrenomClient($_SESSION['idClient'][0]);
        } else {
            array_push($error, "Mauvaises informations.");
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
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
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
                <li class="nav-item">
                    <a class="nav-link" href="./register.php">Inscription</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="./login.php">Connexion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container pt-5">
    <section>
        <article>
            <?php
            //Affichage du menu suivant le rôle
            if (count($error) > 0) {
                echo '<div class="alert alert-danger error">';
                for ($i = 0; $i < count($error); $i++) {
                    echo $error[$i];
                    echo '<br/>';
                };
                echo '</div>';
                //Affichage du message de connexion
            } elseif (isset($_SESSION['logged']) == true) {
                echo '<div class="alert alert-success error">';
                echo "Bienvenue " .$_SESSION['prenomClient'][0] . " " . $_SESSION['nomClient'][0] . " !";
                echo '</div>';
                header("refresh:5;url=./index.php");
            }

            ?>
            <form action="login.php" method="post" enctype="multipart/form-data" style=" margin: auto;">
                <label><b>Email</b></label>
                <input type="text" class="form-control" placeholder="Email" name="email"/>
                <br/>
                <label><b>Mot de passe</b></label>
                <input type="password" class="form-control" placeholder="Mot de passe" name="password"/>
                <br/>
                <button type="submit" class="btn btn-primary" name="submit" style="float: right;">Connexion</button>
                <p class="font-weight-bold">Vous n'avez pas encore de compte ? <a href="./register.php"> Inscrivez-vous
                        ici</a></p>
            </form>
        </article>
    </section>
</div>
</html>