<?php
require_once "../config/database.php";

$db = new Database();
$conn = $db->connecter();

// listes
$patients = $conn->query("SELECT id, nom, prenom FROM patients")->fetchAll();
$medecins = $conn->query("SELECT id, nom, prenom FROM medecins")->fetchAll();

if (isset($_POST['submit'])) {

    $sql = "INSERT INTO consultations
            (patient_id, medecin_id, date_consultation, motif, diagnostic, traitement, observation)
            VALUES
            (:patient_id, :medecin_id, :date_consultation, :motif, :diagnostic, :traitement, :observation)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        "patient_id" => $_POST['patient_id'],
        "medecin_id" => $_POST['medecin_id'],
        "date_consultation" => $_POST['date_consultation'],
        "motif" => $_POST['motif'],
        "diagnostic" => $_POST['diagnostic'],
        "traitement" => $_POST['traitement'],
        "observation" => $_POST['observation']
    ]);

    header("Location: index.php");
    exit;
}
?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>
<?php include "../includes/sidebar.php"; ?>

<h3>Nouvelle consultation</h3>

<form method="POST">

    <div class="mb-2">
        <label>Patient</label>
        <select name="patient_id" class="form-control" required>
            <?php foreach ($patients as $p): ?>
                <option value="<?= $p['id'] ?>">
                    <?= $p['nom'] . " " . $p['prenom'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-2">
        <label>Médecin</label>
        <select name="medecin_id" class="form-control" required>
            <?php foreach ($medecins as $m): ?>
                <option value="<?= $m['id'] ?>">
                    <?= $m['nom'] . " " . $m['prenom'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-2">
        <label>Date de consultation</label>
        <input type="datetime-local" name="date_consultation" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Motif</label>
        <input type="text" name="motif" class="form-control">
    </div>

    <div class="mb-2">
        <label>Diagnostic</label>
        <textarea name="diagnostic" class="form-control"></textarea>
    </div>

    <div class="mb-2">
        <label>Traitement</label>
        <textarea name="traitement" class="form-control"></textarea>
    </div>

    <div class="mb-2">
        <label>Observation</label>
        <textarea name="observation" class="form-control"></textarea>
    </div>

    <button type="submit" name="submit" class="btn btn-success">
        Enregistrer
    </button>

</form>

<?php include "../includes/footer.php"; ?>
