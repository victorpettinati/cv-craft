<?php

$db_host = 'localhost';    
$db_name = 'cv_craft';    
$db_user = 'root';    
$db_pass = 'Laplateforme.06!'; 

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

session_start();
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: profil.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $entreprise = $_POST['entreprise'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $description = $_POST['description'];
    $competence = $_POST['competence'];
    $resume = $_POST['resume'];
    $diplome = $_POST['diplome'];
    
    $user_id = $_SESSION['utilisateur_id'];
    $query = "INSERT INTO experience (utilisateur_id, titre, entreprise, date_debut, date_fin, description, competence) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    
    try {
        $stmt->execute([$user_id, $titre, $entreprise, $date_debut, $date_fin, $description, $competence]);
        header("Location: profil.php");
        exit;
    } catch (PDOException $e) {
        echo "Une erreur s'est produite lors de l'insertion des données : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de CV</title>
</head>
<body>
    <h1>Création de CV</h1>
    <form method="POST" action="creation-cv.php">
        <label for="titre">Titre :</label>
        <input type="text" name="titre" required><br>
        
        <label for="entreprise">Entreprise :</label>
        <input type="text" name="entreprise" required><br>
        
        <label for="date_debut">Date de début :</label>
        <input type="date" name="date_debut" required><br>
        
        <label for="date_fin">Date de fin :</label>
        <input type="date" name="date_fin" required><br>
        
        <label for="description">Description :</label>
        <textarea name="description" required></textarea><br>
        
        <label for="competence">Compétence :</label>
        <input type="text" name="competence" required><br>
        
        <input type="submit" value="Enregistrer">
        
    </form>

    
</body>
</html>
