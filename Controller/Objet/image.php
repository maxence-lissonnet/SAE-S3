<?php
require_once __DIR__ . '/Model/CatalogueArticleModel.php'; // fournit get_bdd()

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    exit;
}

$bdd = get_bdd();
$stmt = $bdd->prepare('SELECT imageObjet AS image, mime_type FROM objet WHERE idObjet = ? LIMIT 1');
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row || empty($row['image'])) {
    http_response_code(404);
    exit;
}

$data = $row['image'];
// détermination du mime si non stocké
$mime = !empty($row['mime_type']) ? $row['mime_type'] : (new finfo(FILEINFO_MIME_TYPE))->buffer($data);

header('Content-Type: ' . $mime);
header('Content-Length: ' . strlen($data));
header('Cache-Control: public, max-age=86400'); // optionnel
echo $data;
exit;
?>