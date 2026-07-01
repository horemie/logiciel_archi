<?php
require_once "../config/database.php";

$db = new Database();
$conn = $db->connecter();

$id = $_GET['id'];

// rendez-vous
$stmt = $conn->prepare("SELECT * FROM rendez_vous WHERE id = ?");
$stmt->execute([$id]);
$rv = $stmt->fetch();

// listes
$patients = $conn->query("SELECT id, nom, prenom FROM patients")->fetchAll();
$medecins = $conn->query("SELECT id, nom, prenom FROM medecins")->fetchAll();

if (isset($_POST['update'])) {

    $sql = "UPDATE rendez_vous SET
            patient_id = :patient_id,
            medecin_id = :medecin_id,
            date_rdv = :date_rdv,
            heure = :heure,
            motif = :motif,
            statut = :statut
            WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        "patient_id" => $_POST['patient_id'],
        "medecin_id" => $_POST['medecin_id'],
        "date_rdv" => $_POST['date_rdv'],
        "heure" => $_POST['heure'],
        "motif" => $_POST['motif'],
        "statut" => $_POST['statut'],
        "id" => $id
    ]);

    header("Location: index.php");
    exit;
}
?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>
<?php include "../includes/sidebar.php"; ?>

<h3>Modifier rendez-vous</h3>

<form method="POST">

    <select name="patient_id" class="form-control mb-2">
        <?php foreach ($patients as $p): ?>
            <option value="<?= $p['id'] ?>"
                <?= $p['id'] == $rv['patient_id'] ? 'selected' : '' ?>>
                <?= $p['nom'] . " " . $p['prenom'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <select name="medecin_id" class="form-control mb-2">
        <?php foreach ($medecins as $m): ?>
            <option value="<?= $m['id'] ?>"
                <?= $m['id'] == $rv['medecin_id'] ? 'selected' : '' ?>>
                <?= $m['nom'] . " " . $m['prenom'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="date" name="date_rdv"
           value="<?= $rv['date_rdv'] ?>"
           class="form-control mb-2">

    <input type="time" name="heure"
           value="<?= $rv['heure'] ?>"
           class="form-control mb-2">

    <input type="text" name="motif"
           value="<?= $rv['motif'] ?>"
           class="form-control mb-2">

    <select name="statut" class="form-control mb-2">
        <option <?= $rv['statut']=='Programmé'?'selected':'' ?>>Programmé</option>
        <option <?= $rv['statut']=='Confirmé'?'selected':'' ?>>Confirmé</option>
        <option <?= $rv['statut']=='Annulé'?'selected':'' ?>>Annulé</option>
        <option <?= $rv['statut']=='Effectué'?'selected':'' ?>>Effectué</option>
    </select>

    <button type="submit" name="update" class="btn btn-primary">
        Modifier
    </button>

</form>

<?php include "../includes/footer.php"; ?>
