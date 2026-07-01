<?php
require_once "../config/database.php";

$db = new Database();
$conn = $db->connecter();

// patients
$patients = $conn->query("SELECT id, nom, prenom FROM patients")->fetchAll();

// médecins
$medecins = $conn->query("SELECT id, nom, prenom FROM medecins")->fetchAll();

if (isset($_POST['submit'])) {

    $sql = "INSERT INTO rendez_vous
            (patient_id, medecin_id, date_rdv, heure, motif, statut)
            VALUES
            (:patient_id, :medecin_id, :date_rdv, :heure, :motif, :statut)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        "patient_id" => $_POST['patient_id'],
        "medecin_id" => $_POST['medecin_id'],
        "date_rdv" => $_POST['date_rdv'],
        "heure" => $_POST['heure'],
        "motif" => $_POST['motif'],
        "statut" => $_POST['statut']
    ]);

    header("Location: index.php");
    exit;
}
?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>
<?php include "../includes/sidebar.php"; ?>

<h3>Créer un rendez-vous</h3>

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
        <label>Date</label>
        <input type="date" name="date_rdv" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Heure</label>
        <input type="time" name="heure" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Motif</label>
        <input type="text" name="motif" class="form-control">
    </div>

    <div class="mb-2">
        <label>Statut</label>
        <select name="statut" class="form-control">
            <option>Programmé</option>
            <option>Confirmé</option>
            <option>Annulé</option>
            <option>Effectué</option>
        </select>
    </div>

    <button type="submit" name="submit" class="btn btn-success">
        Enregistrer
    </button>

</form>

<?php include "../includes/footer.php"; ?>
