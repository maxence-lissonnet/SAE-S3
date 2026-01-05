<?php
if (ob_get_level()) {
    ob_end_clean();
}

require_once __DIR__ . '/../../Model/BDDModel.php';

$id = (int)($_GET['id'] ?? 0);

$bdd = get_dtb();
$stmt = $bdd->prepare("SELECT imageObjet FROM objet WHERE idObjet = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);


$bin = $row['imageObjet'];

// 3. Détection MIME
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->buffer($bin) ?: 'image/jpeg';

// 4. Envoi des headers
header("Content-Type: $mime");
header("Content-Length: " . strlen($bin));

echo $bin;
exit; // Important pour ne rien envoyer d'autre après