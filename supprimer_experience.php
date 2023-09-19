<?php
session_start();

if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: connexion.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $experience_id = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "Laplateforme.06!";
    $dbname = "cv_craft";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }

    // Supprimer l'expérience correspondante dans la base de données
    $sql_delete = "DELETE FROM experience WHERE id = :experience_id";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bindParam(':experience_id', $experience_id, PDO::PARAM_INT);
    $stmt_delete->execute();

    // Rediriger l'utilisateur vers son profil après la suppression
    header("Location: profil.php");
    exit();
} else {
    header("Location: profil.php");
    exit();
}
?>
