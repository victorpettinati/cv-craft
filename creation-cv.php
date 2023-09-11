<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: connexion.php");
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $resume = $_POST['resume'];
    $diplome = $_POST['diplome'];
    $titre_poste = $_POST['titre_poste'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $entreprise = $_POST['entreprise'];
    $detail_poste = $_POST['detail_poste'];
    $competence = $_POST['competence'];

    // Connexion à la base de données (à adapter selon ta configuration)
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

    // Insérer les données dans la base de données (à adapter selon ta structure de base de données)
    $sql = "INSERT INTO experience (utilisateur_id, titre, entreprise, date_debut, date_fin, description, competence, coordonnee, resume, diplome) VALUES (:utilisateur_id, :titre, :entreprise, :date_debut, :date_fin, :description, :competence, :coordonnee, :resume, :diplome)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':utilisateur_id', $_SESSION['utilisateur_id'], PDO::PARAM_INT);
    $stmt->bindParam(':titre', $titre_poste, PDO::PARAM_STR);
    $stmt->bindParam(':entreprise', $entreprise, PDO::PARAM_STR);
    $stmt->bindParam(':date_debut', $date_debut, PDO::PARAM_STR);
    $stmt->bindParam(':date_fin', $date_fin, PDO::PARAM_STR);
    $stmt->bindParam(':description', $detail_poste, PDO::PARAM_STR);
    $stmt->bindParam(':competence', $competence, PDO::PARAM_STR);
    $stmt->bindParam(':coordonnee', $telephone, PDO::PARAM_STR);
    $stmt->bindParam(':resume', $resume, PDO::PARAM_STR);
    $stmt->bindParam(':diplome', $diplome, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Rediriger vers la page de profil ou une autre page de confirmation
        header("Location: profil.php");
        exit();
    } else {
        $message = "Erreur lors de la création du CV.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de CV</title>
</head>
<body>
    <h1>Création de CV</h1>
    <form action="" method="post">
        <!-- Ajoute les champs du formulaire pour les informations du CV -->
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br>
        
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required><br>

        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email" required><br>

        <label for="telephone">Numéro de téléphone :</label>
        <input type="text" id="telephone" name="telephone"><br>

        <label for="resume">Résumé :</label>
        <textarea id="resume" name="resume" required></textarea><br>

        <label for="diplome">Diplôme :</label>
        <input type="text" id="diplome" name="diplome" required><br>

        <label for="titre_poste">Titre du poste :</label>
        <input type="text" id="titre_poste" name="titre_poste" required><br>

        <label for="date_debut">Date de début :</label>
        <input type="date" id="date_debut" name="date_debut" required><br>

        <label for="date_fin">Date de fin :</label>
        <input type="date" id="date_fin" name="date_fin" required><br>

        <label for="entreprise">Entreprise :</label>
        <input type="text" id="entreprise" name="entreprise" required><br>

        <label for="detail_poste">Détail du poste :</label>
        <textarea id="detail_poste" name="detail_poste" required></textarea><br>

        <label for="competence">Compétence :</label>
        <input type="text" id="competence" name="competence" required><br>

        <input type="submit" value="Créer le CV">
    </form>
    <?php
    // Afficher le message de confirmation ou d'erreur
    if (!empty($message)) {
        echo "<p>$message</p>";
    }
    ?>
</body>
</html>
