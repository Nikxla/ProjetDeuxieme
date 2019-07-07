<?php

function menu()
{
    if (isset($_SESSION['logged']) == true) {
        if ($_SESSION['role'][0] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link" href="./administration.php">Administration</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./logout.php">Déconnexion</a>
            </li>
            <?php
        } else if($_SESSION['role'][0] == 0){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php">Déconnexion</a>
                </li>
                <?php
        }
    } else  {
        ?>
        <li class="nav-item">
            <a class="nav-link" href="./register.php">Inscription</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./login.php">Connexion</a>
        </li>
    <?php }
}