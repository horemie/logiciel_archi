<?php
require_once "../config/database.php";

$db = new Database();
$conn = $db->connecter();

$id = $_GET['id'];

// récupérer patient
$stmt = $conn->prepare("SELECT * FROM patients WHERE id = ?");
stmt->execute([$id]);
$patient = $stmt->fetch();

if (isset($_POST['update'])) {

    $sql = "UPDATE patients SET
            nom = :nom,
            prenom = :prenom,
            sexe = :sexe,
            date_naissance = :date_naissance,
            adresse = :adresse,
            telephone = :telephone
            WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        "nom" => $_POST['nom'],
        "prenom" => $_POST['prenom'],
        "sexe" => $_POST['sexe'],
        "date_naissance" => $_POST['date_naissance'],
        "adresse" => $_POST['adresse'],
        "telephone" => $_POST['telephone'],
        "id" => $id
    ]);

    header("Location: index.php");
    exit;
}
?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>
<?php include "../includes/sidebar.php"; ?>

<h3>Modifier patient</h3>

<form method="POST">

    <input type="text" name="nom" value="<?= $patient['nom'] ?>" class="form-control mb-2">
    <input type="text" name="prenom" value="<?= $patient['prenom'] ?>" class="form-control mb-2">

    <select name="sexe" class="form-control mb-2">
        <option <?= $patient['sexe']=='Masculin'?'selected':'' ?>>Masculin</option>
        <option <?= $patient['sexe']=='Feminin'?'selected':'' ?>>Feminin</option>
    </select>

    <input type="date" name="date_naissance" value="<?= $patient['date_naissance'] ?>" class="form-control mb-2">

    <input type="text" name="adresse" value="<?= $patient['adresse'] ?>" class="form-control mb-2">

    <input type="text" name="telephone" value="<?= $patient['telephone'] ?>" class="form-control mb-2">

    <button type="submit" name="update" class="btn btn-primary">
        Modifier
    </button>

</form>

<?php include "../includes/footer.php"; ?>
