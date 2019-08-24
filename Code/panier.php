<?php

require_once('./php/function.inc.php');
require_once('./php/htmlToPhp.php');

$message = array();

if (isset($_SESSION['idClient'])) {
    $panier = getPanier($_SESSION['idClient'][0]);

    if (isset($_GET['trans']) == "ok") {
        if (count($panier) > 0) {
            $date = date("Y-m-d");
            validerPanier($panier[0][4], $date);

            array_push($message, "La commande à bien été passée.");

            header("Refresh:3;url=panier.php");
        }
    }

    if (isset($_GET['remove'])) {
        if (isset($_GET['taille'])) {
            $idArticleRemove = $_GET['remove'];
            $idTailleRemove = $_GET['taille'];

            deleteArticleFromPanier($idArticleRemove, $idTailleRemove);

            //array_push($message, "L'article à bien été retiré du panier.");

            header("location: panier.php");
        }
    }
} else {
    header("location: index.php");
}


?>

<!doctype html>

<html lang="fr">
<head>
    <title>Panier</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

    <script src="https://pay.sandbox.datatrans.com/upp/payment/js/datatrans-2.0.0.min.js"></script>

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
                <li class="nav-item active">
                    <a class="nav-link" href="./panier.php" style="font-size: 15px;">Panier <span class="sr-only">(current)</span></a>
                </li>

                <?php

                if (isset($_SESSION['role'][0])) {
                    if ($_SESSION['role'][0] == 1) { ?>
                        <li class="nav-item ">
                            <a class="nav-link" href="administration.php" style="font-size: 15px;">Administration</a>
                        </li>
                        <?php
                    }
                }
                ?>

                <li class="nav-item">
                    <a class="nav-link" href="logout.php" style="font-size: 15px;">Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container pt-5 inBody pb-5">
    <section>
        <article>
            <h1 class="text-center font-weight-bold pb-3 titre">Panier</h1>
            <div class="row">
                <div class="col-lg-2 col-sm-12">
                </div>
                <div class="col-lg-8 col-sm-12">
                    <?php
                    if (count($message) > 0) {
                        echo '<div class="alert table-success" style="text-align: center;">';
                        for ($i = 0; $i < count($message); $i++) {
                            echo $message[$i];
                            echo '<br/>';
                        };
                        echo '</div>';
                    }
                    ?>

                    <?php

                    if (isset($panier)) {
                        if (count($panier) > 0) {

                            ?>
                            <table class="table table-striped" style="text-align: center;">
                                <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Taille</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $prixTotal = 0;

                                for ($cpt = 0; $cpt < count($panier); $cpt++) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $panier[$cpt][0] ?></th>
                                        <td><a href="article.php?art=<?php echo $panier[$cpt][0] ?>"
                                               style="text-decoration: underline; color: #919aa1;"><?= $panier[$cpt][1] ?></a>
                                        </td>
                                        <td><?= $panier[$cpt][2] ?></td>
                                        <td><?= $panier[$cpt][3] ?> CHF</td>
                                        <td>
                                            <a href="panier.php?remove=<?php echo $panier[$cpt][0] ?>&taille=<?php echo $panier[$cpt][5] ?>"
                                               style="color: #919aa1;">X</a></td>
                                    </tr>
                                    <?php

                                    $prixTotal = $prixTotal + $panier[$cpt][3];
                                }

                                ?>
                                </tbody>
                            </table>
                            <hr/>
                            <p style="font-size: 13pt; float: left;">Prix total : <label
                                        class="font-weight-bold font-italic"><?= $prixTotal ?> CHF </label></p>

                            <?php

                            if (isset($panier)) {
                                if (count($panier) > 0) {

                                    $prixFinal = $prixTotal * 100;
                                    ?>
                                    <div style="margin-bottom: 100px;">
                                        <form id="paymentForm" style="float: right; background-color: #00bbe3;"
                                              data-merchant-id="1100018721"
                                              data-amount="<?php echo $prixFinal ?>"
                                              data-currency="CHF"
                                              data-refno="123456789"
                                              data-sign="30916165706580013">
                                            <a id="paymentButton" class="btn btn-primary"
                                               style="background-color: #00bbe3; color: white;">Passer le commande</a>
                                        </form>
                                    </div>
                                    <?php
                                }
                            }

                            ?>
                            <?php
                        } else {
                            echo '<div class="alert table-active" style="text-align: center;">';
                            echo 'Votre panier est vide.';
                            echo '<br/>';
                            echo '</div>';
                        }
                    }

                    ?>


                </div>
                <div class="col-lg-2 col-sm-12">
                </div>
            </div>
        </article>
    </section>
</div>

<footer>
    <div class="col-sm-12 footer fixed-bottom"
         style="background-color: #00bbe3;">
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
</footer>

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

<script type="text/javascript">

    $(document).ready(function () {
        var theId = getParameterByName(trans)
        var newPath = 'https://esig-sandbox.ch/nikolaantnj/panier.php?trans=' + theId
        alert('OK');
        // window.location.href=newPath;
    });

    $("#paymentButton").click(function () {
        Datatrans.startPayment({'form': '#paymentForm'});
    });
</script>