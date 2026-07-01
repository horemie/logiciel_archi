<?php
require_once "../config/database.php";

$db = new Database();
$conn = $db->connecter();

$search = "";

if (isset($_GET['search'])) {

    $search = $_GET['search'];

    $sql = "SELECT * FROM medecins
            WHERE nom LIKE :search
            OR prenom LIKE :search
            OR specialite LIKE :search
            ORDER BY id DESC";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        "search" => "%$search%"
    ]);

} else {

    $sql = "SELECT * FROM medecins ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

$medecins = $stmt->fetchAll();
?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>
<?php include "../includes/sidebar.php"; ?>

<h3>Liste des Médecins</h3>

<a href="ajouter.php" class="btn btn-primary mb-3">
    Ajouter un médecin
</a>

<form method="GET" class="mb-3">
    <input type="text" name="search"
           class="form-control"
           placeholder="Rechercher un médecin..."
           value="<?= htmlspecialchars($search) ?>">
</form>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Spécialité</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($medecins as $m): ?>
        <tr>
            <td><?= $m['id'] ?></td>
            <td><?= $m['nom'] ?></td>
            <td><?= $m['prenom'] ?></td>
            <td><?= $m['specialite'] ?></td>
            <td><?= $m['telephone'] ?></td>
            <td><?= $m['email'] ?></td>

            <td>
                <a href="modifier.php?id=<?= $m['id'] ?>"
                   class="btn btn-warning btn-sm">
                    Modifier
                </a>

                <a href="supprimer.php?id=<?= $m['id'] ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Supprimer ce médecin ?')">
                    Supprimer
                </a>
            </td>
        </tr>
        <?php endforeach; ?>

    </tbody>
</table>

<?php include "../includes/footer.php"; ?>
