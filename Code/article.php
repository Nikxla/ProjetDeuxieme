<?php
require_once('./php/function.inc.php');
require_once('./php/htmlToPhp.php');

$message = array();

if (isset($_GET['art'])) {
    $artId = $_GET['art'];
    $_SESSION['addToPanier'] = "None";
} else {
    header('location: index.php');
}

$artInfo = getSneakersInfo($artId);

if ($artInfo == false) {
    header('location: index.php');
}

if (count($artInfo) == 0) {
    header('location: index.php');
} else {
    $taille = getTailleSneakers($artId);
}

if (isset($_SESSION['idClient'])) {
    $varPanier = createNewPanier($_SESSION['idClient'][0]);
}

if (isset($_POST['submit'])) {
    $date = date("Y-m-d");
    insertArticlePanier($varPanier[0][0], $artId, $_POST['tailleChoisi'], $date);
    $_SESSION['addToPanier'] = "Ok";
}

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'][0] == 1) {
        if (isset($_GET['delete'])) {
            if ($_GET['delete'] == "ok") {
                if (isset($_GET['art'])) {
                    if ($_GET['art'] != 0) {
                        $idArticle = $_GET['art'];
                        deleteArticle($idArticle);

                        if (isset($artInfo[2])) {
                            unlink("./uploads/" . $artInfo[2]);
                        }

                        array_push($message, "L'article à bien été supprimé.");
                    }
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $artInfo[0] ?></title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="index.php" style="font-size: 15px;">Catalogue <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./about.php" style="font-size: 15px;">A propos</a>
                </li>
                <?php
                menu();
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="col-lg-10 text-center m-auto pb-3">
        <br/>
        <?php

        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'][0] == 1) {
                ?>

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                        style="background-color: #00bbe3">
                    Supprimer l'article
                </button>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment supprimer cette
                                    article ?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                <a href="article.php?delete=ok&art=<?php echo $artId ?>">
                                    <button style="background-color: #00bbe3" type="button" class="btn btn-primary">
                                        Supprimer
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="updateArticle.php?art=<?php echo $artId ?>">
                    <button type="button" class="btn btn-warning ml-2" name="redirect"
                            style="background-color: #00bbe3">
                        Modifier l'article
                    </button>
                </a>
                <?php
            }
        }

        ?>
        <h3 class="pt-4" style="color: #00bbe3"><?= $artInfo[0] ?></h3>
        <?php

        if (count($message) > 0) {
            echo '<div class="alert table-success" style="text-align: center;">';
            for ($i = 0; $i < count($message); $i++) {
                echo $message[$i];
                echo '<br/>';
            };
            echo '</div>';
            header("location: index.php");
        }

        if ($_SESSION['addToPanier'] == "Ok") { ?>
            <div class="alert table-success error" style="padding-top: 30px;">
                <p>L'article a bien été ajouté au panier.</p>
            </div>
            <?php
        } ?>
        <div class="imageArticle" style="background-image: url('./uploads/<?= $artInfo[2] ?>')"></div>
        <div class="container pt-5" id="container">
            <section>
                <article>

                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-4 col-sm-12 mt-3">
                                <h5 style="color: #00bbe3">Prix : <?= $artInfo[1] ?> CHF</h5>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <select name="tailleChoisi" class="form-control" id="selectTaille">
                                    <option selected disabled hidden>Choisir une taille</option>
                                    <?php for ($cpt = 0; $cpt < count($taille); $cpt++) { ?>
                                        <option value="<?= $taille[$cpt][0] ?>"><?= $taille[$cpt][1] ?></option>
                                        <?php
                                    } ?>
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-12" id="buttonAdd">
                                <?php
                                if (isset($_SESSION['logged']) == true) {
                                    ?>
                                    <button type="submit" class="btn btn-primary" name="submit"
                                            style="background-color: #00bbe3;">
                                        Ajouter au panier
                                    </button>
                                    <?php
                                } else {
                                    ?>
                                    <a href="login.php">
                                        <button type="button" class="btn btn-primary" name="redirect"
                                                style="background-color: #00bbe3;">
                                            Connectez-vous
                                        </button>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </form>
                </article>
            </section>
        </div>
    </div>
</div>
</div>

<div class="col-sm-12 footer" style="background-color: #00bbe3">
    <div class="row ml-auto mr-auto justify-content-center">
        <a href="https://www.instagram.com/" target="_blank">
            <div class="explain-icon3 mr-3" style="background-image: url('img/Social/white/instagram.svg')"></div>
        </a>
        <a href="https://twitter.com/" target="_blank">
            <div class="explain-icon3 mr-3" style="background-image: url('img/Social/white/twitter.svg')"></div>
        </a>
        <a href="https://www.facebook.com/" target="_blank">
            <div class="explain-icon3 mr-3" style="background-image: url('img/Social/white/facebook.svg')"></div>
        </a>
        <a href="https://www.youtube.com/" target="_blank">
            <div class="explain-icon3" style="background-image: url('img/Social/white/youtube.svg')"></div>
        </a>
    </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>

</html>

<script>
    $(document).ready(function () {
        $('#buttonAdd').hide();
    });

    $(function () {
        $('#selectTaille').change(function () {
            $('#buttonAdd').show();
        });
    });
</script>