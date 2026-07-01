<?php
require_once "../config/database.php";

$db = new Database();
$conn = $db->connecter();

$search = "";

if (isset($_GET['search'])) {

    $search = $_GET['search'];

    $sql = "SELECT rv.*, 
                   p.nom AS patient_nom, p.prenom AS patient_prenom,
                   m.nom AS medecin_nom, m.prenom AS medecin_prenom
            FROM rendez_vous rv
            INNER JOIN patients p ON rv.patient_id = p.id
            INNER JOIN medecins m ON rv.medecin_id = m.id
            WHERE p.nom LIKE :search 
               OR m.nom LIKE :search
            ORDER BY rv.id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute(["search" => "%$search%"]);

} else {

    $sql = "SELECT rv.*, 
                   p.nom AS patient_nom, p.prenom AS patient_prenom,
                   m.nom AS medecin_nom, m.prenom AS medecin_prenom
            FROM rendez_vous rv
            INNER JOIN patients p ON rv.patient_id = p.id
            INNER JOIN medecins m ON rv.medecin_id = m.id
            ORDER BY rv.id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

$rendezvous = $stmt->fetchAll();
?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>
<?php include "../includes/sidebar.php"; ?>

<h3>Liste des Rendez-vous</h3>

<a href="ajouter.php" class="btn btn-primary mb-3">
    Nouveau rendez-vous
</a>

<form method="GET" class="mb-3">
    <input type="text" name="search"
           class="form-control"
           placeholder="Rechercher un rendez-vous..."
           value="<?= htmlspecialchars($search) ?>">
</form>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Patient</th>
            <th>Médecin</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Motif</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($rendezvous as $rv): ?>
        <tr>
            <td><?= $rv['id'] ?></td>
            <td><?= $rv['patient_nom'] . " " . $rv['patient_prenom'] ?></td>
            <td><?= $rv['medecin_nom'] . " " . $rv['medecin_prenom'] ?></td>
            <td><?= $rv['date_rdv'] ?></td>
            <td><?= $rv['heure'] ?></td>
            <td><?= $rv['motif'] ?></td>

            <td>
                <span class="badge bg-info">
                    <?= $rv['statut'] ?>
                </span>
            </td>

            <td>
                <a href="modifier.php?id=<?= $rv['id'] ?>" class="btn btn-warning btn-sm">
                    Modifier
                </a>

                <a href="supprimer.php?id=<?= $rv['id'] ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Supprimer ce rendez-vous ?')">
                    Supprimer
                </a>
            </td>
        </tr>
        <?php endforeach; ?>

    </tbody>
</table>

<?php include "../includes/footer.php"; ?>
