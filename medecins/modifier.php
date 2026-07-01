<?php
require_once "../config/database.php";

$db = new Database();
$conn = $db->connecter();

$id = $_GET['id'];

// récupération médecin
$stmt = $conn->prepare("SELECT * FROM medecins WHERE id = ?");
$stmt->execute([$id]);
$medecin = $stmt->fetch();

if (isset($_POST['update'])) {

    $sql = "UPDATE medecins SET
            nom = :nom,
            prenom = :prenom,
            specialite = :specialite,
            telephone = :telephone,
            email = :email
            WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        "nom" => $_POST['nom'],
        "prenom" => $_POST['prenom'],
        "specialite" => $_POST['specialite'],
        "telephone" => $_POST['telephone'],
        "email" => $_POST['email'],
        "id" => $id
    ]);

    header("Location: index.php");
    exit;
}
?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>
<?php include "../includes/sidebar.php"; ?>

<h3>Modifier médecin</h3>

<form method="POST">

    <input type="text" name="nom"
           value="<?= $medecin['nom'] ?>"
           class="form-control mb-2">

    <input type="text" name="prenom"
           value="<?= $medecin['prenom'] ?>"
           class="form-control mb-2">

    <input type="text" name="specialite"
           value="<?= $medecin['specialite'] ?>"
           class="form-control mb-2">

    <input type="text" name="telephone"
           value="<?= $medecin['telephone'] ?>"
           class="form-control mb-2">

    <input type="email" name="email"
           value="<?= $medecin['email'] ?>"
           class="form-control mb-2">

    <button type="submit" name="update" class="btn btn-primary">
        Modifier
    </button>

</form>

<?php include "../includes/footer.php"; ?>
