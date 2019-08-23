<?php
require_once('./php/function.inc.php');
require_once('./php/htmlToPhp.php');

if ($_SESSION['role'][0] != 1) {
    header("location: index.php");
}

$error = array();

$_SESSION['updateOk'] = "notOk";

$getCategorie = getCategorie();

$taille = getAllTaille();

if (isset($_SESSION['role'][0]) == 1) {
    if (isset($_GET['art'])) {
        $artId = $_GET['art'];

        $sneakers = getSneakersInfo($artId);

        $nomArticle = $sneakers[0];
        $prixArticle = $sneakers[1];
        $imageArticle = $sneakers[2];

        $tailleDispo = getTailleSneakers($artId);

    } else {
        header("location: index.php");
    }
} else {
    header("location: index.php");
}

if (isset($_POST['submit'])) {
    if (!empty($_POST['nom']) && !empty($_POST['prix']) && !empty($_POST['categorie']) && !empty($_FILES['image']) && !empty($_POST['taille'])) {
        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
        $prix = filter_input(INPUT_POST, 'prix', FILTER_SANITIZE_NUMBER_INT);
        $categorie = filter_input(INPUT_POST, 'categorie', FILTER_SANITIZE_NUMBER_INT);

        updateSneakers($nom, $prix, $categorie, $artId);

        $tailleDispoFinal = $_POST['taille'];

        if (isset($tailleDispoFinal)) {
            for ($cpt2 = 0; $cpt2 < count($tailleDispo); $cpt2++) {
                deleteStock($artId, $tailleDispo[$cpt2][0]);
            }

            for ($cpt = 0; $cpt < count($tailleDispoFinal); $cpt++) {
                insertStock($artId, $tailleDispoFinal[$cpt]);
            }
        }

        if ($_FILES['image']['name'] != "") {
            $image = $_FILES['image'];
            $idUnique = uniqid("STX_");
            $count = explode('.', $_FILES['image']['name']);
            $count2 = strlen($count[1]);
            $extension = substr($_FILES['image']['name'], -$count2);
            $nomMedia = $idUnique . "." . $extension;

            move_uploaded_file($_FILES['image']['tmp_name'], "./uploads/$nomMedia");

            if (!is_uploaded_file($_FILES['image']['tmp_name'])) {
                updateMedia($nomMedia, $artId);
                if(isset($imageArticle)){
                    unlink("./uploads/" . $imageArticle);
                }
            }
        }

        $_SESSION['updateOk'] = "Ok";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Administration</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="menuRight">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation"
                style="background-color: #00bbe3;">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php" style="font-size: 15px;">Catalogue</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php" style="font-size: 15px;">A propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="font-size: 15px;" href="./panier.php">Panier</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="administration.php" style="font-size: 15px;">Administration <span
                                class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" style="font-size: 15px;">Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container pt-5" id="container">
    <section>
        <article>
            <?php
            if ($_SESSION['updateOk'] == "Ok") {
                if (isset($artId)) {
                    header("refresh:2;url=./article.php?art=" . $artId);
                }

                ?>
                <div class="alert table-success error" style="margin-top: 0px;">';
                    <p>L'article a bien été modifié.</p>
                </div>';
                <?php

            } ?>
            <form action="updateArticle.php?art=<?php echo $artId ?>" method="post" enctype="multipart/form-data">
                <label><b>Nom de l'article</b></label>
                <input type="text" class="form-control" name="nom" id="addArticle-nom" placeholder="Nom de l'article"
                       value="<?php echo $nomArticle ?>"/>
                <br/>
                <label><b>Prix de l'article</b></label>
                <input type="text" class="form-control" name="prix" id="addArticle-prix" placeholder="Prix de l'article"
                       value="<?php echo $prixArticle ?>"/>
                <br/>
                <label><b>Catégorie de l'article</b></label>
                <br/>
                <select class="form-control" name="categorie">
                    <?php for ($cpt = 0; $cpt < count($getCategorie); $cpt++) { ?>
                        <option value="<?= $getCategorie[$cpt][0]; ?>"><?= $getCategorie[$cpt][1]; ?></option>
                    <?php } ?>
                </select>
                <br/>
                <label><b>Image de l'article</b></label>
                <input type="file" accept="image/jpeg, image/png, image/gif" class="form-control" name="image"/>
                <br/>
                <label><b>Tailles disponibles</b></label>
                <br/>
                <?php for ($cpt = 0; $cpt < count($taille); $cpt++) { ?>
                    <input class="ml-3 mr-3" type="checkbox" name="taille[]"
                           value="<?= $taille[$cpt][0] ?>"
                        <?php

                        for ($cpt2 = 0; $cpt2 < count($tailleDispo); $cpt2++) {
                            if ($tailleDispo[$cpt2][1] == $taille[$cpt][1]) {
                                echo "checked";
                            }
                        }

                        ?>>

                    <?= $taille[$cpt][1] ?>
                    <?php if ($cpt % 2) { ?>
                        <br/>
                    <?php }
                } ?>
                <br/>
                <button id="addArticle-submit" type="submit" class="btn btn-primary" name="submit"
                        style="float: right; background-color: #00bbe3;">Modifier
                </button>
            </form>
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

