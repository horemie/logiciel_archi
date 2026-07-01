<?php
require_once "../config/database.php";

$db = new Database();
$conn = $db->connecter();

if (isset($_POST['submit'])) {

    $sql = "INSERT INTO medecins
            (nom, prenom, specialite, telephone, email)
            VALUES
            (:nom, :prenom, :specialite, :telephone, :email)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        "nom" => $_POST['nom'],
        "prenom" => $_POST['prenom'],
        "specialite" => $_POST['specialite'],
        "telephone" => $_POST['telephone'],
        "email" => $_POST['email']
    ]);

    header("Location: index.php");
    exit;
}
?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>
<?php include "../includes/sidebar.php"; ?>

<h3>Ajouter un médecin</h3>

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
        <label>Spécialité</label>
        <input type="text" name="specialite" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Téléphone</label>
        <input type="text" name="telephone" class="form-control">
    </div>

    <div class="mb-2">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>

    <button type="submit" name="submit" class="btn btn-success">
        Enregistrer
    </button>

</form>

<?php include "../includes/footer.php"; ?>
