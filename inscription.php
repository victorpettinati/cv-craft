<?php
$message = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $coordonnee = $_POST['coordonnee'];
    $diplome = $_POST['diplome'];
    $resume = $_POST['resume'];
    $mot_de_passe = $_POST['mot_de_passe'];

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

    $sql_check_email = "SELECT * FROM utilisateur WHERE email = :email";
    $stmt_check_email = $conn->prepare($sql_check_email);
    $stmt_check_email->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt_check_email->execute();

    if ($stmt_check_email->rowCount() > 0) {
        $message = "L'adresse e-mail est déjà utilisée. Veuillez choisir une autre adresse.";
    } else {
        $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);

        $sql = "INSERT INTO utilisateur (nom, prenom, email, coordonnee, diplome, resume, mot_de_passe) VALUES (:nom, :prenom, :email, :coordonnee, :diplome, :resume, :mot_de_passe)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':coordonnee', $coordonnee, PDO::PARAM_STR);
        $stmt->bindParam(':diplome', $diplome, PDO::PARAM_STR);
        $stmt->bindParam(':resume', $resume, PDO::PARAM_STR);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe_hache, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: connexion.php");
            exit();
        } else {
            $message = "Erreur lors de l'inscription.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <form action="" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required><br>

        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email" required><br>

        <label for="coordonnee">Coordonnee :</label>
        <input type="text" id="coordonnee" name="coordonnee" required><br>

        <label for="diplome">Diplome :</label>
        <input type="text" id="diplome" name="diplome" required><br>

        <label for="resume">Resume :</label>
        <input type="text" id="resume" name="resume" required><br>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br>

        <input type="submit" value="S'Inscrire">
    </form>
    <?php

    if (!empty($message)) {
        echo "<p>$message</p>";
    }
    ?>
</body>
</html>
