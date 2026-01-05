<?php
// Controller/Autre/NotifController.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// utilisateur courant
$idUser = $_SESSION['idUser'] ?? 5;

// 1) Récupération de toutes les notifications de la BDD
$allNotifications = notif_getAllForUser($idUser) ?? [];

// 2) États en session (soft delete / archive / lu)
$_SESSION['notif_deleted']  = $_SESSION['notif_deleted']  ?? [];
$_SESSION['notif_archived'] = $_SESSION['notif_archived'] ?? [];
$_SESSION['notif_read']     = $_SESSION['notif_read']     ?? [];

$deleted  = &$_SESSION['notif_deleted'];
$archived = &$_SESSION['notif_archived'];
$read     = &$_SESSION['notif_read'];

// 3) Boîte active (réception / archive) - on la détermine tôt (utile pour POST)
$box = $_GET['box'] ?? 'inbox';
if (!in_array($box, ['inbox', 'archive'], true)) {
    $box = 'inbox';
}

// 4) Traitement des actions POST (delete / archive / unarchive / mark_read / mark_unread)
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['action'], $_POST['notif_id'])
    && ctype_digit($_POST['notif_id'])
) {
    $id = (int) $_POST['notif_id'];

    // par défaut, on reste dans la box actuelle
    $redirectBox = $box;

    switch ($_POST['action']) {
        case 'delete':
            $deleted[$id] = true;
            unset($archived[$id]);
            break;

        case 'archive':
            if (empty($deleted[$id])) {
                $archived[$id] = true;
                $redirectBox = 'archive'; // logique : tu viens d’archiver
            }
            break;

        case 'unarchive':
            unset($archived[$id]);
            $redirectBox = 'inbox'; // logique : tu viens de désarchiver
            break;

        case 'mark_unread':
            unset($read[$id]);
            break;

        case 'mark_read':
            $read[$id] = true;
            break;
    }

    header('Location: ?page=notifications&box=' . $redirectBox);
    exit;
}

// 5) Construire les listes réception / archive
$notificationsInbox = [];
$notificationsArchive = [];

foreach ($allNotifications as $n) {
    $id = $n['id'];

    if (!empty($deleted[$id])) {
        continue; // soft delete => on n’affiche plus
    }

    if (!empty($archived[$id])) {
        $notificationsArchive[] = $n;
    } else {
        $notificationsInbox[] = $n;
    }
}

// Liste affichée dans la colonne gauche
$notifications = ($box === 'archive') ? $notificationsArchive : $notificationsInbox;

// 6) Nombre de non lues (sur tout ce qui n’est pas supprimé)
$_SESSION['unreadCount'] = 0;
foreach ($allNotifications as $n) {
    $id = $n['id'];
    if (!empty($deleted[$id])) {
        continue;
    }
    if (empty($read[$id])) {
        $_SESSION['unreadCount']++;
    }
}

// 7) Notification courante
$currentNotif = null;

if (!empty($notifications)) {
    $currentId = (isset($_GET['id']) && ctype_digit($_GET['id']))
        ? (int) $_GET['id']
        : $notifications[0]['id'];

    foreach ($notifications as $n) {
        if ($n['id'] === $currentId) {
            $currentNotif = $n;
            break;
        }
    }

    if ($currentNotif === null) {
        $currentNotif = $notifications[0];
        $currentId = $currentNotif['id'];
    }

    // celle qu’on lit passe automatiquement en “lu”
    $read[$currentId] = true;
}

// 8) Flag isUnread pour chaque notif de la liste affichée
foreach ($notifications as &$n) {
    $id = $n['id'];
    $n['isUnread'] = empty($read[$id]);
}
unset($n);

// 9) Total (réception + archive) sans les supprimées
$totalCount = count($notificationsInbox) + count($notificationsArchive);

require __DIR__ . '/../../Vue/Autre/notification.php';
