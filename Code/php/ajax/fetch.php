<?php

$connect = mysqli_connect("localhost", "root", "", "resell");
$output = '';

if(isset($_POST["query"]))
{
    $search = mysqli_real_escape_string($connect, $_POST["query"]);

    $arr = explode(' ',trim($search));
    $like = '';

    if(count($arr) == 1){
        $like = ' nomArticle LIKE "%' . $arr[0] . '%"';
    } else {
        for($cpt = 0; $cpt < count($arr); $cpt++){
            if($cpt != count($arr) - 1){
                $like .= ' nomArticle LIKE "%' . $arr[$cpt] . '%" OR';
            } else if ($cpt = count($arr) - 1){
                $like .= ' nomArticle LIKE "%' . $arr[$cpt] . '%"';
            }
        }
    }

    $query = "
  SELECT idArticle, nomArticle FROM article WHERE". $like ." LIMIT 10 
  ";
}
else
{
    $query = "SELECT * FROM article WHERE idArticle = 9999"; /* Requête qui ne retourne rien, exprès */
}
$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result) > 0)
{
    $output .= '
  <div class="table-responsive">
   <table class="table table bordered">
    ';
    while($row = mysqli_fetch_array($result))
    {
        $output .= '
   <tr>
        <td><a href="article.php?art='. $row['idArticle'] . '">'.$row["nomArticle"].'</a></td>
   </tr>
  ';
    }
    echo $output;
} else{
    if(isset($_POST["query"])){
        echo "Aucun résultat";
    }
}


