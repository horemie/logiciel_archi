<?php
require_once "../config/database.php";

$db = new Database();
$conn = $db->connecter();

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM medecins WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit;
