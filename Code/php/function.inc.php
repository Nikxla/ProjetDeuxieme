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
        $request = $connexion->prepare("INSERT INTO `client` (`nomClient`, `prenomClient`, `emailClient`, `mdpClient`, `isAdmin`) VALUES (:nom, :prenom, :email, :mdp, 0)");
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
        $request = getConnexion()->prepare("SELECT article.idArticle, nomArticle, nomImage, prixArticle FROM `article` JOIN image on image.idArticle = article.idArticle WHERE SUBSTRING_INDEX(nomArticle, ' ', 1) = :marque");
        $request->bindParam(':marque', $marque, PDO::PARAM_STR);
        $request->execute();

        return $request->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}

function getSneakersInfo($id){
    try {
        $request = getConnexion()->prepare("SELECT article.nomArticle, article.prixArticle, image.nomImage FROM `article` JOIN image ON image.idArticle = article.idArticle WHERE article.idArticle = :id");
        $request->bindParam(':id', $id, PDO::PARAM_INT);
        $request->execute();

        return $request->fetch();
    } catch (PDOException $e) {
        throw $e;
    }
}

function getTailleSneakers($id){
    try {
        $request = getConnexion()->prepare("SELECT taille.idTaille, taille.nomTaille FROM `taille` JOIN stock ON stock.idTaille = taille.idTaille JOIN article ON article.idArticle = stock.idArticle WHERE article.idArticle = :id ORDER BY taille.nomTaille ASC");
        $request->bindParam(':id', $id, PDO::PARAM_INT);
        $request->execute();

        return $request->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}

function getCategorie(){
    try {
        $request = getConnexion()->prepare("SELECT categorie.idCategorie, categorie.nomCategorie FROM `categorie`");
        $request->execute();

        return $request->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}

function getAllTaille(){
    try {
        $request = getConnexion()->prepare("SELECT idTaille, nomTaille FROM `taille` ORDER BY nomTaille ASC");
        $request->execute();

        return $request->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}

function insertSneakers($nom, $prix, $categorie){
    try {
        $connexion = getConnexion();
        $request = $connexion->prepare("INSERT INTO `article` (`nomArticle`, `prixArticle`, `idCategorie`) VALUES (:nom, :prix, :categorie)");
        $request->bindParam(':nom', $nom, PDO::PARAM_STR);
        $request->bindParam(':prix', $prix, PDO::PARAM_INT);
        $request->bindParam(':categorie', $categorie, PDO::PARAM_INT);
        $request->execute();

        $id = $connexion->lastInsertId();

        return $id;
    } catch (PDOException $e) {
        throw $e;
    }
}

function insertImage($nomImage, $idArticle){
    try {
        $connexion = getConnexion();
        $request = $connexion->prepare("INSERT INTO `image` (`nomImage`, `idArticle`) VALUES (:nomImage, :idArticle)");
        $request->bindParam(':nomImage', $nomImage, PDO::PARAM_STR);
        $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}

function insertStock($idArticle, $idTaille){
    try {
        $connexion = getConnexion();
        $request = $connexion->prepare("INSERT INTO `stock` (`idArticle`, `idTaille`) VALUES (:idArticle, :idTaille)");
        $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
        $request->bindParam(':idTaille', $idTaille, PDO::PARAM_INT);
        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}

function countNbPanier($idClient){
    try {
        $request = getConnexion()->prepare("SELECT COUNT(`idPanier`) FROM `panier` WHERE idClient = :idClient AND idPanier NOT IN (select idPanier FROM `commande`)");
        $request->bindParam(':idClient', $idClient, PDO::PARAM_INT);
        $request->execute();

        return $request->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}

function createNewPanier($idClient){
    $var = countNbPanier($idClient);
    $idPanier = -1;
    $connexion = getConnexion();

    if($var[0][0] == 0){
        try {
            $request = $connexion->prepare("INSERT INTO `panier` (`idReduction`, `idClient`) VALUES (NULL, :idClient)");
            $request->bindParam(':idClient', $idClient, PDO::PARAM_INT);
            $request->execute();

            $idPanier = $connexion->lastInsertId();

        } catch (PDOException $e) {
            throw $e;
        }
    } else {
        try {
            $request = $connexion->prepare("SELECT idPanier FROM `panier` WHERE idClient = :idClient AND idPanier NOT IN (select idPanier FROM `commande`)");
            $request->bindParam(':idClient', $idClient, PDO::PARAM_INT);
            $request->execute();

        } catch (PDOException $e) {
            throw $e;
        }

        if($idPanier != -1){
            return $idPanier;
        } else {
            return $request->fetchAll();
        }
    }
}

function insertArticlePanier($idPanier, $idArticle, $idTaille, $date){
    try {
        $connexion = getConnexion();
        $request = $connexion->prepare("INSERT INTO `article_panier` (`idPanier`, `idArticle`, `idTaille`, `dateAjout`) VALUES (:idPanier, :idArticle, :idTaille, :laDate)");
        $request->bindParam(':idPanier', $idPanier, PDO::PARAM_INT);
        $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
        $request->bindParam(':idTaille', $idTaille, PDO::PARAM_INT);
        $request->bindParam(':laDate', $date, PDO::PARAM_STR);
        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}

function getPanier($idUser){
    try {
        $request = getConnexion()->prepare("SELECT `article`.idArticle, `article`.nomArticle, `taille`.`nomTaille` ,`article`.prixArticle, `panier`.idPanier FROM `article` JOIN `article_panier` ON `article_panier`.idArticle = `article`.idArticle JOIN `taille` ON `taille`.`idTaille` = `article_panier`.`idTaille` JOIN `panier` ON `panier`.`idPanier` = `article_panier`.`idPanier` WHERE `panier`.`idClient` = :idUser AND `panier`.`idPanier` NOT IN (SELECT `commande`.`idPanier` FROM `commande`)");
        $request->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $request->execute();

        return $request->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}

function validerPanier($idPanier, $dateCommande){
    try {
        $connexion = getConnexion();
        $request = $connexion->prepare("INSERT INTO `commande` (`idPanier`, `dateCommande`) VALUES (:idPanier, :dateCommande)");
        $request->bindParam(':idPanier', $idPanier, PDO::PARAM_INT);
        $request->bindParam(':dateCommande', $dateCommande, PDO::PARAM_STR);
        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}

function deleteArticle($idArticle){
    try {
        $request = getConnexion()->prepare("DELETE FROM `article` WHERE idArticle = :id");
        $request->bindParam(':id', $idArticle, PDO::PARAM_INT);
        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}

function updateSneakers($nomArticle, $prixArticle, $idCategorie, $idArticle)
{
    try {
        $request = getConnexion()->prepare("UPDATE `article` SET `nomArticle` = :nomArticle, `prixArticle` = :prixArticle, `idCategorie` = :idCategorie WHERE idArticle = :id");
        $request->bindParam(':nomArticle', $nomArticle, PDO::PARAM_STR);
        $request->bindParam(':prixArticle',$prixArticle, PDO::PARAM_INT);
        $request->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
        $request->bindParam(':id', $idArticle, PDO::PARAM_INT);
        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}

function deleteStock($idArticle, $idTaille){
    try {
        $request = getConnexion()->prepare("DELETE FROM `stock` WHERE idArticle = :idArticle AND idTaille = :idTaille");
        $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
        $request->bindParam(':idTaille', $idTaille, PDO::PARAM_INT);
        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}

function updateMedia($nomImage, $idArticle)
{
    try {
        $request = getConnexion()->prepare("UPDATE `image` SET `nomImage` = :nomImage, `idArticle` = :idArticle WHERE idArticle = :idArticle");
        $request->bindParam(':nomImage', $nomImage, PDO::PARAM_STR);
        $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}
