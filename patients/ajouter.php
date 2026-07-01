<?php
require_once "../config/database.php";

$db = new Database();
$conn = $db->connecter();

if (isset($_POST['submit'])) {

    $numero = "PAT-" . time();

    $sql = "INSERT INTO patients 
            (numero_patient, nom, prenom, sexe, date_naissance, adresse, telephone)
            VALUES
            (:numero, :nom, :prenom, :sexe, :date_naissance, :adresse, :telephone)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        "numero" => $numero,
        "nom" => $_POST['nom'],
        "prenom" => $_POST['prenom'],
        "sexe" => $_POST['sexe'],
        "date_naissance" => $_POST['date_naissance'],
        "adresse" => $_POST['adresse'],
        "telephone" => $_POST['telephone']
    ]);

    header("Location: index.php");
    exit;
}
?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>
<?php include "../includes/sidebar.php"; ?>

<h3>Ajouter un patient</h3>

<form method="POST">

    <div class="mb-2">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Prénom</label>
        <input type="text" name="prenom" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Sexe</label>
        <select name="sexe" class="form-control">
            <option>Masculin</option>
            <option>Feminin</option>
        </select>
    </div>

    <div class="mb-2">
        <label>Date de naissance</label>
        <input type="date" name="date_naissance" class="form-control">
    </div>

    <div class="mb-2">
        <label>Adresse</label>
        <input type="text" name="adresse" class="form-control">
    </div>

    <div class="mb-2">
        <label>Téléphone</label>
        <input type="text" name="telephone" class="form-control">
    </div>

    <button type="submit" name="submit" class="btn btn-success">
        Enregistrer
    </button>

</form>

<?php include "../includes/footer.php"; ?>
