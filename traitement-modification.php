<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: connexion.php");
    exit();
}

// Connexion à la base de données
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire de modification
    $nouveauNom = $_POST['nom'];
    $nouveauPrenom = $_POST['prenom'];
    $nouveauEmail = $_POST['email'];
    $nouveauCoordonnee = $_POST['coordonnee'];
    $nouveauDiplome = $_POST['diplome'];
    $nouveauResume = $_POST['resume'];
    // Récupérer d'autres données à modifier (ajustez en fonction de vos champs)

    // Mettez à jour les informations de l'utilisateur dans la base de données
    $utilisateur_id = $_SESSION['utilisateur_id'];
    $sql = "UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email, coordonnee = :coordonnee, diplome = :diplome, resume = :resume WHERE id = :utilisateur_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nom', $nouveauNom, PDO::PARAM_STR);
    $stmt->bindParam(':prenom', $nouveauPrenom, PDO::PARAM_STR);
    $stmt->bindParam(':email', $nouveauEmail, PDO::PARAM_STR);
    $stmt->bindParam(':coordonnee', $nouveauCoordonnee, PDO::PARAM_STR);
    $stmt->bindParam(':diplome', $nouveauDiplome, PDO::PARAM_STR);
    $stmt->bindParam(':resume', $nouveauResume, PDO::PARAM_STR);
    $stmt->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
    $stmt->execute();
    // Mettez à jour d'autres champs si nécessaire

    // Mettez à jour les informations dans la session
    $_SESSION['nom'] = $nouveauNom;
    $_SESSION['prenom'] = $nouveauPrenom;
    $_SESSION['email'] = $nouveauEmail;
    $_SESSION['coordonnee'] = $nouveauCoordonnee;
    $_SESSION['diplome'] = $nouveauDiplome;
    $_SESSION['resume'] = $nouveauResume;

    // Mettez à jour d'autres informations dans la session si nécessaire

    // Rediriger vers la page de profil
    header("Location: profil.php");
    exit();
}
?>






