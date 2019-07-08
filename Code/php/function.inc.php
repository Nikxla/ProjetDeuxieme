<?php

session_start();

define('DB_HOST', "127.0.0.1");
define('DB_NAME', "resell");
define('DB_USER', "root");
define('DB_PASS', "");

//Connexion à la base de données
function getConnexion()
{
    static $dbb = null;
    if ($dbb === null) {
        try {
            $connectionString = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '';
            $dbb = new PDO($connectionString, DB_USER, DB_PASS);
            $dbb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbb->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    return $dbb;
}

function register($nom, $prenom, $email, $mdp)
{
    try {
        $connexion = getConnexion();
        $request = $connexion->prepare("INSERT INTO `client` (`nomClient`, `prenomClient`, `emailClient`, `mdpClient`, `role`) VALUES (:nom, :prenom, :email, :mdp, 0)");
        $request->bindParam(':nom', $nom, PDO::PARAM_STR);
        $request->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $request->bindParam(':email', $email, PDO::PARAM_STR);
        $request->bindParam(':mdp', $mdp, PDO::PARAM_STR);
        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}

function checkEmail($email)
{
    try {
        $request = getConnexion()->prepare("SELECT * from `client` WHERE `emailClient` = :email");
        $request->bindParam(':email', $email, PDO::PARAM_STR);
        $request->execute();

        return $request->fetch();
    } catch (PDOException $e) {
        throw $e;
    }
}

function login($email)
{
    try {
        $request = getConnexion()->prepare("SELECT `mdpClient` FROM `client` WHERE emailClient = :email");
        $request->bindParam(':email', $email, PDO::PARAM_STR);
        $request->execute();

        return $request->fetch();
    } catch (PDOException $e) {
        throw $e;
    }
}

function getIdClient($email)
{
    try {
        $request = getConnexion()->prepare("SELECT `idClient` FROM `client` WHERE emailClient = :email");
        $request->bindParam(':email', $email, PDO::PARAM_STR);
        $request->execute();

        return $request->fetch();
    } catch (PDOException $e) {
        throw $e;
    }
}

function getNomClient($id)
{
    try {
        $request = getConnexion()->prepare("SELECT `nomClient` FROM `client` WHERE idClient = :id");
        $request->bindParam(':id', $id, PDO::PARAM_STR);
        $request->execute();

        return $request->fetch();
    } catch (PDOException $e) {
        throw $e;
    }
}

function getPrenomClient($id)
{
    try {
        $request = getConnexion()->prepare("SELECT `prenomClient` FROM `client` WHERE idClient = :id");
        $request->bindParam(':id', $id, PDO::PARAM_STR);
        $request->execute();

        return $request->fetch();
    } catch (PDOException $e) {
        throw $e;
    }
}

function getRole($id)
{
    try {
        $request = getConnexion()->prepare("SELECT `isAdmin` FROM `client` WHERE idClient = :id");
        $request->bindParam(':id', $id, PDO::PARAM_STR);
        $request->execute();

        return $request->fetch();
    } catch (PDOException $e) {
        throw $e;
    }
}

function getTopMarque(){
    try {
        $request = getConnexion()->prepare("SELECT SUBSTRING_INDEX(nomArticle, ' ', 1) from article GROUP BY SUBSTRING_INDEX(nomArticle, ' ', 1) ORDER BY COUNT(idArticle) DESC LIMIT 4");
        $request->execute();

        return $request->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}

function getSneakersParMarque($marque){
    try {
        $request = getConnexion()->prepare("SELECT nomArticle, nomImage, prixArticle FROM `article` JOIN image on IMAGE.idArticle = article.idArticle WHERE SUBSTRING_INDEX(nomArticle, ' ', 1) = :marque");
        $request->bindParam(':marque', $marque, PDO::PARAM_STR);
        $request->execute();

        return $request->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}
?>