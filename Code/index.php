<?php
require_once('./php/function.inc.php');
require_once('./php/htmlToPhp.php');

$marques = getTopMarque();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Catalogue</title>
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
    <h1 class="text-center pt-5" style="color: #00bbe3;">ACHETER DES SNEAKERS AUTHENTIC</h1>
    <div class="form-group">
        <div class="input-group pt-5 pb-5">
            <input type="text" name="search_text" id="search_text" placeholder="Search for brand, color, etc."
                   class="form-control"/>
        </div>
    </div>
    <div id="result"></div>
</div>

<div class="col-sm-12 pb-5" style="background-color: #00bbe3">
    <div class="container">
        <h3 class="p-5 font-weight-bold text-center" style="color: white;">Les marques les plus populaires</h3>
        <div class="row text-center">

            <?php

            for ($cpt = 0; $cpt < count($marques); $cpt++) {
                if (count($marques) == 1) { ?>
                    <div class="col-lg-12 col-sm-12">
                        <a href="./marque.php?mar=' . $marques[$cpt][0] . '" style="color: white;" class="linkHover">
                            <div class="p-3 explain-icon4"
                                 style="background-image: url('./img/Marques/<?php $marques[$cpt][0] ?>.svg'); margin: auto;"
                                 ;>
                            </div>
                        </a>
                    </div>
                    <?php
                } else if (count($marques) == 2) { ?>
                    <div class="col-lg-6 col-sm-12">
                        <a href="./marque.php?mar=' . $marques[$cpt][0] . '" style="color: white;" class="linkHover">
                            <div class="p-3 explain-icon4"
                                 style="background-image: url('./img/Marques/<?php  $marques[$cpt][0] ?>.svg'); margin: auto;"
                                 ;>
                            </div>
                        </a>
                    </div>
                    <?php
                } else if (count($marques) == 3) { ?>
                    <div class="col-lg-4 col-sm-12">
                        <a href="./marque.php?mar=' . $marques[$cpt][0] . '" style="color: white;" class="linkHover">
                            <div class="p-3 explain-icon4"
                                 style="background-image: url('./img/Marques/<?php $marques[$cpt][0] ?>.svg'); margin: auto;"
                                 ;>
                            </div>
                        </a>
                    </div>
                    <?php
                } else { ?>
                    <div class="col-lg-3 col-sm-12">
                        <a href="./marque.php?mar=<?= $marques[$cpt][0] ?>" style="color: white;" class="linkHover">
                            <div class="p-3 explain-icon4"
                                 style="background-image: url('./img/Marques/<?= $marques[$cpt][0] ?>.svg'); margin: auto;"
                                 ;>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

</div>

<div class="col-sm-12 pt-3 footer" style="background-color: #ffffff">
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

<script>
    $(document).ready(function () {


        function load_data(query) {
            $.ajax({
                url: "./php/ajax/fetch.php",
                method: "POST",
                data: {query: query},
                success: function (data) {
                    $('#result').html(data);
                }
            });
        }

        $('#search_text').keyup(function () {
            var search = $(this).val();
            if (search != '') {
                load_data(search);
            } else {
                load_data();
            }
        });

        load_data();
    });
</script>

</body>

</html>