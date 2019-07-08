<?php
require_once('./php/function.inc.php');
require_once('./php/htmlToPhp.php');

$marque = $_GET['mar'];

$sneakers = getSneakersParMarque($marque);

//var_dump($sneakers);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des sneakers de la marque <?= $marque ?></title>
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
                    <a class="nav-link" href="index.php">Catalogue <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./about.php">A propos</a>
                </li>
                <?php
                menu();
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="col-lg-12 text-center mt-5 mb-5">
        <div class="row">
            <?php for ($cpt = 0; $cpt < count($sneakers); $cpt++) {
                ?>
                <div class="col-lg-4 pb-4 pt-4 table">
                    <h5><?= $sneakers[$cpt][0] ?></h5>
                    <div class="col-sm-12 explain-icon5"
                         style="background-image: url('uploads/<?= $sneakers[$cpt][1] ?>') "></div>
                    <h5>Prix : <?= $sneakers[$cpt][2] ?> CHF</h5>
                </div> <?php
            } ?>
        </div>
    </div>
</div>

<hr>

<div class="col-sm-12 pb-5 footer pt-3" style="background-color: white">
    <div class="row ml-auto mr-auto justify-content-center">
        <a href="https://www.instagram.com/nikxla_/" target="_blank">
            <div class="explain-icon3 mr-3" style="background-image: url('img/Social/instagram.svg')"></div>
        </a>
        <a href="https://twitter.com/Nikxla_" target="_blank">
            <div class="explain-icon3 mr-3" style="background-image: url('img/Social/twitter.svg')"></div>
        </a>
        <a href="https://www.facebook.com/nikola.antonijevic.9022?ref=bookmarks" target="_blank">
            <div class="explain-icon3 mr-3" style="background-image: url('img/Social/facebook.svg')"></div>
        </a>
        <a href="https://www.youtube.com/channel/UCmEu6EPOxqwciFihpdBxdvw?view_as=subscriber" target="_blank">
            <div class="explain-icon3" style="background-image: url('img/Social/youtube.svg')"></div>
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