<?php

function menu(){
    if(isset($_SESSION['logged']) == true){
        echo '<li class="nav-item">
                    <a class="nav-link" href="./logout.php">Déconnexion</a>
                </li>';
    } else {
        echo '<li class="nav-item">
                    <a class="nav-link" href="./register.php">Inscription</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./login.php">Connexion</a>
                </li>';
    }
}