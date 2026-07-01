<?php
require_once "../config/database.php";

$db = new Database();
$conn = $db->connecter();

$id = $_GET['id'];

// consultation
$stmt = $conn->prepare("SELECT * FROM consultations WHERE id = ?");
$stmt->execute([$id]);
$c = $stmt->fetch();

// listes
$patients = $conn->query("SELECT id, nom, prenom FROM patients")->fetchAll();
$medecins = $conn->query("SELECT id, nom, prenom FROM medecins")->fetchAll();

if (isset($_POST['update'])) {

    $sql = "UPDATE consultations SET
            patient_id = :patient_id,
            medecin_id = :medecin_id,
            date_consultation = :date_consultation,
            motif = :motif,
            diagnostic = :diagnostic,
            traitement = :traitement,
            observation = :observation
            WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        "patient_id" => $_POST['patient_id'],
        "medecin_id" => $_POST['medecin_id'],
        "date_consultation" => $_POST['date_consultation'],
        "motif" => $_POST['motif'],
        "diagnostic" => $_POST['diagnostic'],
        "traitement" => $_POST['traitement'],
        "observation" => $_POST['observation'],
        "id" => $id
    ]);

    header("Location: index.php");
    exit;
}
?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>
<?php include "../includes/sidebar.php"; ?>

<h3>Modifier consultation</h3>

<form method="POST">

    <select name="patient_id" class="form-control mb-2">
        <?php foreach ($patients as $p): ?>
            <option value="<?= $p['id'] ?>"
                <?= $p['id'] == $c['patient_id'] ? 'selected' : '' ?>>
                <?= $p['nom'] . " " . $p['prenom'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <select name="medecin_id" class="form-control mb-2">
        <?php foreach ($medecins as $m): ?>
            <option value="<?= $m['id'] ?>"
                <?= $m['id'] == $c['medecin_id'] ? 'selected' : '' ?>>
                <?= $m['nom'] . " " . $m['prenom'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="datetime-local" name="date_consultation"
           value="<?= str_replace(' ', 'T', $c['date_consultation']) ?>"
           class="form-control mb-2">

    <input type="text" name="motif"
           value="<?= $c['motif'] ?>"
           class="form-control mb-2">

    <textarea name="diagnostic" class="form-control mb-2"><?= $c['diagnostic'] ?></textarea>

    <textarea name="traitement" class="form-control mb-2"><?= $c['traitement'] ?></textarea>

    <textarea name="observation" class="form-control mb-2"><?= $c['observation'] ?></textarea>

    <button type="submit" name="update" class="btn btn-primary">
        Modifier
    </button>

</form>

<?php include "../includes/footer.php"; ?>
