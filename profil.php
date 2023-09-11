<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: connexion.php");
    exit();
}

// Récupérer les informations de l'utilisateur depuis la session
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];

// Récupérer d'autres informations de l'utilisateur depuis la base de données (ajuste la requête en fonction de ta structure de base de données)
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

// Éventuellement, récupère d'autres informations sur l'utilisateur à partir de la base de données
$sql = "SELECT * FROM utilisateur WHERE id = :utilisateur_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':utilisateur_id', $_SESSION['utilisateur_id'], PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // Récupère les autres informations de l'utilisateur
    // ...

    // Génération du CV au format HTML
    $cv_html = "<h1>CV de $prenom $nom</h1>";

    // Ajoute les informations de l'utilisateur au CV
    $cv_html .= "<p>Nom : $nom</p>";
    $cv_html .= "<p>Prénom : $prenom</p>";
    
    // Exemple : Ajoute les compétences de l'utilisateur depuis la base de données (ajuste en fonction de ta structure de base de données)
    $sql_competences = "SELECT competence FROM experience WHERE utilisateur_id = :utilisateur_id";
    $stmt_competences = $conn->prepare($sql_competences);
    $stmt_competences->bindParam(':utilisateur_id', $_SESSION['utilisateur_id'], PDO::PARAM_INT);
    $stmt_competences->execute();

    if ($stmt_competences->rowCount() > 0) {
        $cv_html .= "<h2>Compétences</h2>";
        $cv_html .= "<ul>";
        while ($competence_row = $stmt_competences->fetch(PDO::FETCH_ASSOC)) {
            $cv_html .= "<li>" . $competence_row['competence'] . "</li>";
        }
        $cv_html .= "</ul>";
    }
    
    // Ajoute d'autres informations au CV (ajuste en fonction de ta structure de base de données)
    // ...
    
} else {
    // L'utilisateur n'a pas été trouvé dans la base de données
    header("Location: deconnexion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>
    <h1>Profil de <?php echo $prenom . ' ' . $nom; ?></h1>
    
    <!-- Afficher le CV généré au format HTML -->
    <?php echo $cv_html; ?>

    <!-- Ajoute d'autres éléments de la page de profil si nécessaire -->
</body>
</html>
