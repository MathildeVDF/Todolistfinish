<?php
session_start();
$bdd=new PDO('mysql:host=localhost; dbname=todolist', 'root', '');
$bdd -> setAttribute ( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
$bdd -> setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC );
$message = null;
if(isset($_POST['modification'])){
    $identifiant = $_POST['mail'];
    $mdp = $_POST['mdp'];
    if($identifiant !='' && $mdp !=''){
        $requete = $bdd -> prepare("UPDATE utilisateur SET mdp=? WHERE mail=?");
        $userexist = $requete -> execute(array($mdp , $identifiant));
        header("Location:index.php");
    }
    else {
        $message = "Merci de renseigner tous les champs";
    }
    
}
 ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width, initial-scale1.0, shrink-to-fit-no">
<link rel="stylesheet" type="text/css" href="styles.css">
<title> My totool </title>
</head>
<body>
<div class="forgot">
    <h1>Nouveau mot de passe</h1>
    <form action="" method="post">
        <label for="mail">Adresse mail :</label>
        <input type="email" id="mail" name="mail" required
        minlength="8" maxlength="30" size="30">
        <label for="mdp">Nouveau mot de passe :</label>
        <input type="password" id="mdp" name="mdp" required
        minlength="8" maxlength="30" size="30">
        <?php
        if ($message != null){
        ?><div class="erreur">
            <?php
            echo($message);
            ?>
        </div>
        <?php
        }
        ?>
        <div class="button">
            <button type="submit" name="modification">Envoyer la modification</button>
        </div>
    </form>
    <hr>
    <a href="index.php">Retourner à la page de connexion</a>
</div>
</body>