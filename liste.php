<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}
$bdd=new PDO('mysql:host=localhost;dbname=todolist;port=3307', 'root', '');
$bdd -> setAttribute ( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
$bdd -> setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC );

$message = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $requete = $bdd -> prepare("SELECT * FROM liste WHERE id = ?");
    $userexist = $requete -> execute(array($id));
    $liste = $requete -> fetch();
    if (!$liste) {
        header("Location: todolist.php");
    } else {
        $message = null;
        if(isset($_POST['task'])){
            $title = $_POST['title'];
            $date = date("Y-m-d");
            if ($title !=''){
                $requete = $bdd->prepare("INSERT INTO taches(title, date, liste_id) VALUE(?, ?, ?)");
                $userexist = $requete->execute(array($title , $date, $id));
            }
            else {
            $message = "Merci de renseigné un titre à la liste.";
            }
        }
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
        <div class="top">
            <a class="retour" href="todolist.php"><img src="return.svg" alt="retour">Voir toutes les listes</a>
            <a class="off" href="deconnexion.php"><img src="off.svg" alt="deconnexion"></a>
        </div>
        <h1>Bonjour, <?= $_SESSION['name'] ?></h1>
        <h2><?= $liste['title'] ?></h2>
        <h3>Listes de vos tâches</h3>
        <div class="liste">
            <?php
            $requete = $bdd->prepare("SELECT * FROM taches WHERE liste_id = ?");
            $requete->execute(array($_GET['id']));
            while ($liste = $requete->fetch()) {?>
            <div class="tachetest">
                <a class="suppr" href="delete.php?tache=<?php echo $liste['id']?>&id=<?= $_GET['id'] ?>"><img src="sup.svg" alt="suppression"></a>
                <h4><?php echo $liste['title']?></h4>
                <p><?php echo date("d/m/Y", strtotime($liste['date']))?></p>
            </div>
            <?php    
            }
            ?>
        </div>
        <hr>
        <div class="nouveau">
            <h3>Ajouter une nouvelle tâche</h3>
            <div class="newtache">
                <form method="post">
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
                        <button type="submit" name="task">Ajouter cette tâche</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>