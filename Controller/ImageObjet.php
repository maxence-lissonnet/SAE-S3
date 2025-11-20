<?php
require_once __DIR__ . '/../Model/CatalogueArticleModel.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    http_response_code(400);
    exit("ID invalide");
}

$bdd = get_bdd();
$stmt = $bdd->prepare("SELECT imageObjet FROM objet WHERE idObjet = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row || empty($row['imageObjet'])) {
    http_response_code(404);
    exit("Image introuvable");
}

$bin = $row['imageObjet'];

// détecte le mime à partir du binaire
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->buffer($bin) ?: 'image/jpeg'; // fallback au cas où

header("Content-Type: $mime");
header("Content-Length: " . strlen($bin));
echo $bin;
