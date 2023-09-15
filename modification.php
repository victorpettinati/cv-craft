
<?php
session_start();

if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: connexion.php");
    exit();
}

$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$email = $_SESSION['email'];
$coordonnee = $_SESSION['coordonnee'];
$diplome = $_SESSION['diplome'];
$resume = $_SESSION['resume'];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mes informations</title>
</head>
<body>
    <h1>Modifier mes informations</h1>
    <form action="traitement-modification.php" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo $nom; ?>" required><br>

        <label for="prenom">Prenom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo $prenom; ?>" required><br>

        <label for="email">Email :</label>
        <input type="text" id="email" name="email" value="<?php echo $email; ?>" required><br>

        <label for="coordonnee">Coordonnee :</label>
        <input type="text" id="coordonnee" name="coordonnee" value="<?php echo $coordonnee; ?>" required><br>

        <label for="diplome">Diplome :</label>
        <input type="text" id="diplome" name="diplome" value="<?php echo $diplome; ?>" required><br>

        <label for="resume">Resume :</label>
        <input type="text" id="resume" name="resume" value="<?php echo $resume; ?>" required><br>

        <!-- Ajoutez des champs pour d'autres informations à modifier -->

        <input type="submit" value="Enregistrer les modifications">
    </form>
</body>
</html>
