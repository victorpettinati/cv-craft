<?php
session_start();

if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: connexion.php");
    exit();
}

if (isset($_POST['deconnexion'])) {
    session_destroy();
    header("Location: connexion.php");
    exit();
}

$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$email = $_SESSION['email'];
$coordonnee = $_SESSION['coordonnee'];

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

$sql = "SELECT * FROM utilisateur WHERE id = :utilisateur_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':utilisateur_id', $_SESSION['utilisateur_id'], PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $cv_html = "<h1> CV ".$row['nom'] ." ". $row['prenom']."</h1>";



    $cv_html .= "<p> Nom : ".$row['nom'] . "</p>";
    $cv_html .= "<p> Prenom : ".$row['prenom']. "</p>";
    $cv_html .= "<p> Email : ".$row['email']. "</p>";
    $cv_html .= "<p> Coordonnee : ".$row['coordonnee']. "</p>";
    $cv_html .= "<p> Diplome : ".$row['diplome']. "</p>";
    $cv_html .= "<p> Resume : ".$row['resume']. "</p>";    
    
    $sql_experience = "SELECT * FROM experience WHERE utilisateur_id = :utilisateur_id";
    $stmt_experience = $conn->prepare($sql_experience);
    $stmt_experience->bindParam(':utilisateur_id', $_SESSION['utilisateur_id'], PDO::PARAM_INT);
    $stmt_experience->execute();

    if ($stmt_experience->rowCount() > 0) {
        $cv_html .= "<h2>Expériences</h2>";
        while ($experience_row = $stmt_experience->fetch(PDO::FETCH_ASSOC)) {
            $cv_html .= "<div class='experience'>";
            $cv_html .= "<div class='experience-content'>";
            $cv_html .= "<p><strong>Titre du poste :</strong> " . htmlspecialchars($experience_row['titre']) . "</p>";
            $cv_html .= "<p><strong>Entreprise :</strong>" . htmlspecialchars($experience_row['entreprise']) . "</p>";
            $cv_html .= "<p><strong>Date de début :</strong> " . htmlspecialchars($experience_row['date_debut']) . "</p>";
            $cv_html .= "<p><strong>Date de fin :</strong> " . htmlspecialchars($experience_row['date_fin']) . "</p>";
            $cv_html .= "<p><strong>Description :</strong> " . htmlspecialchars($experience_row['description']) . "</p>";
            $cv_html .= "<p><strong>Compétence :</strong> " . htmlspecialchars($experience_row['competence']) . "</p>";
            $cv_html .= "</div>"; 
            $cv_html .= "<a href='supprimer_experience.php?id=".$experience_row['id']."' class='delete-experience'>Supprimer expérience</a>";
            $cv_html .= "</div>"; 
        }
    }
    
    
    
    
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
    <link rel="stylesheet" href="style.css">
</head>
<body>



<h1>Profil de <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?></h1>

        <?php echo $cv_html; ?> 
    
        

        <div class="experience-actions">
    <form method="get" action="creation-cv.php">
        <input type="submit" value="Rajouter Experience">
    </form>

    <form method="get" action="modification.php">
        <input type="submit" value="Modifier mes informations">
    </form>

    <form method="post">
        <input type="submit" name="deconnexion" value="Déconnexion">
    </form>
</div>


    
</body>
</html>
