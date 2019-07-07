<?php

require_once('../php/function.inc.php');
require_once('../php/htmlToPhp.php');

?>

<!doctype html>

<html lang="fr">
<head>
    <title>A propos</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="./about.php">A propos</a>
                </li>
                <?php
                menu();
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container pt-5 inBody pb-5">
    <section>
        <article>
            <h1 class="text-center font-weight-bold pb-5 titre">LES BASES</h1>
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="explain-icon" style="background-image: url('../img/303792.svg'); border-color: #ff8000"></div>
                    <h4 class="text-center pt-3 font-weight-bold" style="color: #ff8000">Anonymat</h4>
                    <p class="pstyle text-center">Ne vous inquiétez jamais des acheteurs ou des vendeurs légitimes - nous sommes au centre.</p>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="explain-icon" style="background-image: url('../img/1114113.svg'); border-color: #32CD32"></div>
                    <h4 class="text-center pt-3 font-weight-bold" style="color: #32CD32">Transparence</h4>
                    <p class="pstyle text-center">Données de marché en temps réel pour des achats et des ventes intelligents.</p>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="explain-icon" style="background-image: url('../img/294185.svg'); border-color: #00BFFF"></div>
                    <h4 class="text-center pt-3 font-weight-bold" style="color: #00BFFF">Authenticité</h4>
                    <p class="pstyle text-center">Nos experts authentifient chaque produit vendu sur notre plateforme.</p>
                </div>
            </div>
        </article>
    </section>
</div>

<div class="col-sm-12 pb-5" style="background-color: #00bbe3">
    <div class="container">
        <h1 class="p-5 font-weight-bold" style="color: white;">Acheter sur notre plateforme</h1>

        <div class="pb-5">
            <div class="col-lg-2 col-sm-3 float-left">
                <div class="explain-icon2 float-left" style="background-image: url('../img/hammer.svg')"></div>
            </div>
            <div class="col-lg-10 col-sm-9 float-right">
                <h4 style="color: white; font-size: 20pt;">BID (ACHETER)</h4>
                <p style="color: white; font-size: 15pt;">Faites une offre que tout vendeur peut accepter ou achetez immédiatement au plus bas demandez.</p>
            </div>
        </div>
        <br><br><br><br><br><br>
        <div class="pb-5">
            <div class="col-lg-2 col-sm-3 float-left">
                <div class="explain-icon2 float-left" style="background-image: url('../img/icon.svg')"></div>
            </div>
            <div class="col-lg-10 col-sm-9 float-right">
                <h4 style="color: white; font-size: 20pt;">AUTHENTIFIER</h4>
                <p style="color: white; font-size: 15pt;">Le vendeur nous envoie. Nous authentifions, puis nous libérons des fonds au vendeur.</p>
            </div>
        </div>
        <br><br><br><br><br><br>
        <div class="pb-5">
            <div class="col-lg-2 col-sm-3 float-left">
                <div class="explain-icon2 float-left" style="background-image: url('../img/cash.svg')"></div>
            </div>
            <div class="col-lg-10 col-sm-9 float-right">
                <h4 style="color: white; font-size: 20pt;">PROSPÉRER</h4>
                <p style="color: white; font-size: 15pt;">Nous livrons à vous. Vous sirotez un daiquiri, sachant que vous ne recevrez jamais de faux.</p>
            </div>
        </div>
        <br><br><br><br>
    </div>
</div>


<div class="col-sm-12 pb-5 footer" style="background-color: white">
    <div class="row ml-auto mr-auto justify-content-center">
        <a href="https://www.instagram.com/nikxla_/" target="_blank"><div class="explain-icon3 mr-3" style="background-image: url('../img/instagram.svg')"></div></a>
        <a href="https://twitter.com/Nikxla_" target="_blank"><div class="explain-icon3 mr-3" style="background-image: url('../img/twitter.svg')"></div></a>
        <a href="https://www.facebook.com/nikola.antonijevic.9022?ref=bookmarks" target="_blank"><div class="explain-icon3 mr-3" style="background-image: url('../img/facebook.svg')"></div></a>
        <a href="https://www.youtube.com/channel/UCmEu6EPOxqwciFihpdBxdvw?view_as=subscriber" target="_blank"><div class="explain-icon3" style="background-image: url('../img/youtube.svg')"></div></a>
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
</body>
</html>