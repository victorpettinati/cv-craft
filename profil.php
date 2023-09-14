<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: connexion.php");
    exit();
}

// Si l'utilisateur clique sur le bouton de déconnexion
if (isset($_POST['deconnexion'])) {
    // Détruire la session et rediriger vers la page de connexion
    session_destroy();
    header("Location: connexion.php");
    exit();
}

// Récupérer les informations de l'utilisateur depuis la session
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$email = $_SESSION['email'];
$coordonnee = $_SESSION['coordonnee'];
// $diplome = $_SESSION['diplome'];
// $resume = $_SESSION['resume'];

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
    $cv_html = "<h1> CV ".$row['nom'] ." ". $row['prenom']."</h1>";



    // Ajoute les informations de l'utilisateur au CV
    $cv_html .= "<p> Nom : ".$row['nom'] . "</p>";
    $cv_html .= "<p> Prenom : ".$row['prenom']. "</p>";
    $cv_html .= "<p> Email : ".$row['email']. "</p>";
    $cv_html .= "<p> Coordonnee : ".$row['coordonnee']. "</p>";
    $cv_html .= "<p> Diplome : ".$row['diplome']. "</p>";
    $cv_html .= "<p> Resume : ".$row['resume']. "</p>";    
    
    // Exemple : Récupérer toutes les informations de la table "experience" depuis la base de données (ajuste en fonction de ta structure de base de données)
    $sql_experience = "SELECT * FROM experience WHERE utilisateur_id = :utilisateur_id";
    $stmt_experience = $conn->prepare($sql_experience);
    $stmt_experience->bindParam(':utilisateur_id', $_SESSION['utilisateur_id'], PDO::PARAM_INT);
    $stmt_experience->execute();

    if ($stmt_experience->rowCount() > 0) {
        $cv_html .= "<h2>Expériences</h2>";
        while ($experience_row = $stmt_experience->fetch(PDO::FETCH_ASSOC)) {
            $cv_html .= "<h3>Titre du poste : " . htmlspecialchars($experience_row['titre']) . "</h3>";
            $cv_html .= "<p>Entreprise : " . htmlspecialchars($experience_row['entreprise']) . "</p>";
            $cv_html .= "<p>Date de début : " . htmlspecialchars($experience_row['date_debut']) . "</p>";
            $cv_html .= "<p>Date de fin : " . htmlspecialchars($experience_row['date_fin']) . "</p>";
            $cv_html .= "<p>Description : " . htmlspecialchars($experience_row['description']) . "</p>";
            $cv_html .= "<p>Compétence : " . htmlspecialchars($experience_row['competence']) . "</p>";
            // $cv_html .= "<p>Coordonnée : " . htmlspecialchars($experience_row['coordonnee']) . "</p>";
            // $cv_html .= "<p>Résumé : " . htmlspecialchars($experience_row['resume']) . "</p>";
            // $cv_html .= "<p>Diplôme : " . htmlspecialchars($experience_row['diplome']) . "</p>";
        }
    }
    
    // Ajoute d'autres informations au CV (ajuste en fonction de ta structure de base de données)
    
} else {
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
    <?php echo $cv_html; ?> <!-- Affiche le CV généré -->

    <h1>Profil de <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?></h1>

        <!-- Bouton pour créer un CV -->
        <form method="get" action="creation-cv.php">
        <input type="submit" value="Créer un CV">
    </form>

    <!-- Bouton de déconnexion -->
    <form method="post">
        <input type="submit" name="deconnexion" value="Déconnexion">
    </form>
    
    <!-- Le reste de ton code pour afficher le CV et d'autres informations du profil -->

</body>
</html>
