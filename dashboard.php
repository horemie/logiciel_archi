<?php
require_once "config/database.php";

$db = new Database();
$conn = $db->connecter();

/* =========================
   STATISTIQUES GLOBALES
========================= */

// Patients
$patients = $conn->query("SELECT COUNT(*) AS total FROM patients")
                  ->fetch()['total'];

// Médecins
$medecins = $conn->query("SELECT COUNT(*) AS total FROM medecins")
                  ->fetch()['total'];

// Rendez-vous
$rendezvous = $conn->query("SELECT COUNT(*) AS total FROM rendez_vous")
                    ->fetch()['total'];

// Consultations
$consultations = $conn->query("SELECT COUNT(*) AS total FROM consultations")
                      ->fetch()['total'];

/* =========================
   DONNEES RECENTES
========================= */

// derniers rendez-vous
$rdv_recent = $conn->query("
    SELECT rv.*, p.nom AS patient_nom, p.prenom AS patient_prenom,
           m.nom AS medecin_nom, m.prenom AS medecin_prenom
    FROM rendez_vous rv
    INNER JOIN patients p ON rv.patient_id = p.id
    INNER JOIN medecins m ON rv.medecin_id = m.id
    ORDER BY rv.id DESC
    LIMIT 5
")->fetchAll();

// dernières consultations
$consult_recent = $conn->query("
    SELECT c.*, p.nom AS patient_nom, p.prenom AS patient_prenom,
           m.nom AS medecin_nom, m.prenom AS medecin_prenom
    FROM consultations c
    INNER JOIN patients p ON c.patient_id = p.id
    INNER JOIN medecins m ON c.medecin_id = m.id
    ORDER BY c.id DESC
    LIMIT 5
")->fetchAll();
?>

<?php include "includes/header.php"; ?>
<?php include "includes/navbar.php"; ?>
<?php include "includes/sidebar1.php"; ?>

<h3 class="mb-4">Tableau de bord</h3>

<!-- =======================
     CARTES STATISTIQUES
======================= -->

<div class="row">

    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body text-center">
                <h5>Patients</h5>
                <h2><?= $patients ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body text-center">
                <h5>Médecins</h5>
                <h2><?= $medecins ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body text-center">
                <h5>Rendez-vous</h5>
                <h2><?= $rendezvous ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body text-center">
                <h5>Consultations</h5>
                <h2><?= $consultations ?></h2>
            </div>
        </div>
    </div>

</div>

<!-- =======================
     DERNIERS RENDEZ-VOUS
======================= -->

<h4 class="mt-4">Derniers rendez-vous</h4>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Patient</th>
            <th>Médecin</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Statut</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($rdv_recent as $r): ?>
        <tr>
            <td><?= $r['patient_nom'] . " " . $r['patient_prenom'] ?></td>
            <td><?= $r['medecin_nom'] . " " . $r['medecin_prenom'] ?></td>
            <td><?= $r['date_rdv'] ?></td>
            <td><?= $r['heure'] ?></td>
            <td>
                <span class="badge bg-info">
                    <?= $r['statut'] ?>
                </span>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- =======================
     DERNIERES CONSULTATIONS
======================= -->

<h4 class="mt-4">Dernières consultations</h4>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Patient</th>
            <th>Médecin</th>
            <th>Date</th>
            <th>Diagnostic</th>
            <th>Traitement</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($consult_recent as $c): ?>
        <tr>
            <td><?= $c['patient_nom'] . " " . $c['patient_prenom'] ?></td>
            <td><?= $c['medecin_nom'] . " " . $c['medecin_prenom'] ?></td>
            <td><?= $c['date_consultation'] ?></td>
            <td><?= $c['diagnostic'] ?></td>
            <td><?= $c['traitement'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include "includes/footer.php"; ?>
