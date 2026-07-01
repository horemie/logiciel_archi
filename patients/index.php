<?php
require_once "../config/database.php";

$db = new Database();
$conn = $db->connecter();

// Recherche
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT * FROM patients 
              WHERE nom LIKE :search 
              OR prenom LIKE :search 
              OR numero_patient LIKE :search
              ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute(['search' => "%$search%"]);
} else {
    $query = "SELECT * FROM patients ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
}

$patients = $stmt->fetchAll();
?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>
<?php include "../includes/sidebar.php"; ?>

<h3>Liste des Patients</h3>

<a href="ajouter.php" class="btn btn-primary mb-3">
    Ajouter un patient
</a>

<form method="GET" class="mb-3">
    <input type="text" name="search" class="form-control"
           placeholder="Rechercher un patient..."
           value="<?= htmlspecialchars($search) ?>">
</form>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Numéro</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Sexe</th>
            <th>Téléphone</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($patients as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['numero_patient'] ?></td>
            <td><?= $p['nom'] ?></td>
            <td><?= $p['prenom'] ?></td>
            <td><?= $p['sexe'] ?></td>
            <td><?= $p['telephone'] ?></td>

            <td>
                <a href="modifier.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                <a href="supprimer.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Supprimer ce patient ?')">
                    Supprimer
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include "../includes/footer.php"; ?>
