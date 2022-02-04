<?php
session_start();
$bdd=new PDO('mysql:host=localhost; dbname=todolist', 'root', '');
$bdd -> setAttribute ( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
$bdd -> setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC );
$message = null;
if(isset($_POST['inscription'])){
    $nom = $_POST['surname'];
    $prenom = $_POST['name'];
    $identifiant = $_POST['mail'];
    $mdp = md5($_POST['mdp']);
    if($nom !=''&& $prenom !='' && $identifiant !='' && $mdp !=''){
        $requete = $bdd -> prepare("SELECT* FROM utilisateur WHERE mail= ?");
        $userexist = $requete -> execute(array($identifiant));
            $user=$requete -> fetch();
            if($user == null){
                $requete = $bdd -> prepare("INSERT INTO utilisateur(surname, name, mail,mdp) VALUE (?,?,?,?)");
                $userexist = $requete -> execute(array($nom , $prenom , $identifiant , $mdp));
                header("Location:index.php");
            }
            else{
                $message = "L'email est déjà enregistré";
            }
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
<div class="inscription">
    <h1>Inscrivez-vous</h1>
    <form action="" method="post">
        <label for="surname">Nom :</label>
        <input type="text" id="surname" name="surname" required
        minlength="8" maxlength="30" size="30">
        <label for="name">Prénom :</label>
        <input type="text" id="name" name="name" required
        minlength="8" maxlength="30" size="30">
        <label for="mail">Adresse mail :</label>
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
            <button type="submit" name="inscription">Inscription</button>
        </div>
    </form>
    <hr>
    <a href="index.php">Retourner à la page de connexion</a>
</div>
</body>