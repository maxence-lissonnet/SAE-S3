<?php
require_once __DIR__ . '/../../Model/BDDModel.php';

$id = (int)($_GET['id'] ?? 0);


$bdd = get_dtb();

$stmt = $bdd->prepare("SELECT imageObjet FROM objet WHERE idObjet = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$bin = $row['imageObjet'];
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->buffer($bin) ?: 'image/jpeg';

header("Content-Type: $mime");
header("Content-Length: " . strlen($bin));

echo $bin;

