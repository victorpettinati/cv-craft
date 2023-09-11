<?php
session_start(); // Démarrer la session

$message = ""; // Initialiser le message de confirmation ou d'erreur à une chaîne vide

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire de connexion
    $email_connexion = $_POST['email_connexion'];
    $mot_de_passe_connexion = $_POST['mot_de_passe_connexion'];

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

    // Vérifier les informations de connexion
    $sql = "SELECT * FROM utilisateur WHERE email = :email_connexion";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email_connexion', $email_connexion, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($mot_de_passe_connexion, $row['mot_de_passe'])) {
            // Les informations de connexion sont correctes
            $_SESSION['utilisateur_id'] = $row['id'];
            $_SESSION['nom'] = $row['nom'];
            $_SESSION['prenom'] = $row['prenom'];

            // Rediriger vers la page de profil ou une autre page sécurisée
            header("Location: profil.php");
            exit();
        } else {
            $message = "Mot de passe incorrect.";
        }
    } else {
        $message = "Adresse e-mail non trouvée.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <form action="" method="post">
        <label for="email_connexion">Adresse e-mail :</label>
        <input type="email" id="email_connexion" name="email_connexion" required><br>

        <label for="mot_de_passe_connexion">Mot de passe :</label>
        <input type="password" id="mot_de_passe_connexion" name="mot_de_passe_connexion" required><br>

        <input type="submit" value="Se Connecter">
    </form>
    <?php
    // Afficher le message de confirmation ou d'erreur
    if (!empty($message)) {
        echo "<p>$message</p>";
    }
    ?>
</body>
</html>
