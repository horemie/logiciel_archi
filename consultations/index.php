<?php
require_once "../config/database.php";

$db = new Database();
$conn = $db->connecter();

$sql = "SELECT c.*,
               p.nom AS patient_nom, p.prenom AS patient_prenom,
               m.nom AS medecin_nom, m.prenom AS medecin_prenom
        FROM consultations c
        INNER JOIN patients p ON c.patient_id = p.id
        INNER JOIN medecins m ON c.medecin_id = m.id
        ORDER BY c.id DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();

$consultations = $stmt->fetchAll();
?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>
<?php include "../includes/sidebar.php"; ?>

<h3>Liste des Consultations</h3>

<a href="ajouter.php" class="btn btn-primary mb-3">
    Nouvelle consultation
</a>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Patient</th>
            <th>Médecin</th>
            <th>Date</th>
            <th>Motif</th>
            <th>Diagnostic</th>
            <th>Traitement</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($consultations as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['patient_nom'] . " " . $c['patient_prenom'] ?></td>
            <td><?= $c['medecin_nom'] . " " . $c['medecin_prenom'] ?></td>
            <td><?= $c['date_consultation'] ?></td>
            <td><?= $c['motif'] ?></td>
            <td><?= $c['diagnostic'] ?></td>
            <td><?= $c['traitement'] ?></td>

            <td>
                <a href="modifier.php?id=<?= $c['id'] ?>" class="btn btn-warning btn-sm">
                    Modifier
                </a>

                <a href="supprimer.php?id=<?= $c['id'] ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Supprimer cette consultation ?')">
                    Supprimer
                </a>
            </td>
        </tr>
        <?php endforeach; ?>

    </tbody>
</table>

<?php include "../includes/footer.php"; ?>
