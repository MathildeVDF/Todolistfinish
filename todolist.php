<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}
$bdd=new PDO('mysql:host=localhost; dbname=todolist', 'root', '');
$bdd -> setAttribute ( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
$bdd -> setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC );
$message = null;
if(isset($_POST['task'])){
    $title = $_POST['title'];
    $date = date("Y-m-d");
    if($title !=''){
        $requete = $bdd -> prepare("INSERT INTO liste(title, date, user_id) VALUE(?, ?, ?)");
        $userexist = $requete -> execute(array($title , $date, $_SESSION['id']));
    }
    else {
    $message = "Merci de renseigné un titre à la liste.";
    }
}

 ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width-device-width, initial-scale1.0, shrink-to-fit-no">
    <link rel="stylesheet" type="text/css" href="stylestodo.css">
    <title> My totool </title>
</head>
<body>
    <div class="choix">
        <a class="off" href="deconnexion.php"><img src="off.svg" alt="deconnexion"></a>
        <h1>Bonjour, <?php echo $_SESSION['name']?></h1>
        <h2>Bienvenue sur my to tool</h2>
        <h3>Choisissez votre liste</h3>
        <div class="liste">
            <?php
            $requete = $bdd -> prepare("SELECT * FROM liste WHERE user_id = ?");
            $requete -> execute(array($_SESSION['id']));
            while ($liste = $requete->fetch()) {?>
            <div class="test">
                <a class="suppr" href="delete.php?liste=<?php echo $liste['id']?>"><img src="sup.svg" alt="suppression"></a>
                <h4><?php echo $liste['title']?></h4>
                <p><?php echo $liste['date']?></p>
                <a class="suite" href="liste.php?id=<?= $liste['id'] ?>">Voir la liste</a>
            </div>
            <?php    
            }
            ?>
        </div>
        <hr>
        <div class="nouveau">
            <h3>Ajouter une nouvelle liste</h3>
            <div class="newtache">
                <form action="" method="post">
                    <label for="titre">Titre :</label>
                    <input type="text" id="title" name="title" required
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
                        <button type="submit" name="task">Ajouter cette liste</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>