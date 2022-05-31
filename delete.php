<?php
session_start();
$bdd=new PDO('mysql:host=localhost;dbname=todolist;port=3307', 'root', '');
$bdd -> setAttribute ( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
$bdd -> setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC );
$message = null;
if(isset($_GET['liste'])){
    $requete = $bdd -> prepare("DELETE FROM liste WHERE id = ? ");
    $requete -> execute(array($_GET['liste']));
    header("Location:todolist.php");
}

if(isset($_GET['tache'])){
    $requete = $bdd -> prepare("DELETE FROM taches WHERE id = ? ");
    $requete -> execute(array($_GET['tache']));
    $id = $_GET['id'];
    header("Location:liste.php?id=" . $id . "");
}

 ?>