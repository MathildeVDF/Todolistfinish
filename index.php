<?php
session_start();

$bdd=new PDO('mysql:host=localhost;dbname=todolist;port=3307', 'root', '');
$bdd -> setAttribute ( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
$bdd -> setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC );
$message = null;
if(isset($_POST['formconnexion'])){
    $identifiant = $_POST['mail'];
    $mdp = $_POST['mdp'];
    
    if($identifiant !='' && $mdp !=''){
        $requete = $bdd->prepare("SELECT * FROM utilisateur WHERE mail= ? AND mdp= ?");
        $userexist = $requete->execute(array($identifiant , md5($mdp)));
            $user=$requete->fetch();
            if($user != null) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                header("Location:todolist.php");
                exit;
        }
        else {
            $message = "L'email et le mot de passe ne correpondent pas.";
        }
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
<div class="connexion">
    <h1>Connectez-vous</h1>
    <form action="" method="post">
        <label for="mail">Identifiant :</label>
        <input type="email" id="mail" name="mail" required
        minlength="8" maxlength="30" size="30">
        <label for="mdp">Mot de passe :</label>
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
            <button type="submit" name="formconnexion">Connexion</button>
        </div>
    </form>
    <hr>
    <a href="inscription.php">Vous n'avez pas encore de compte? Inscrivez-vous</a>
    <a href="forget.php">Mot de passe oublié</a>
</div>
</body>