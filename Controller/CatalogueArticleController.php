<?php
require_once __DIR__ . '/../Model/ObjetModel.php';

// Valeurs par défaut
$selectedCategorie = 'Tous';
$selectedLocalisation = 'Tous';
$selectedEtat = 'Tous';

$articles = get_obj();
$categories = get_categories();
$locations = get_locations();
$etats = get_etat();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reset'])) { // reset demandé
        $articles = get_obj();
        $selectedCategorie = $selectedLocalisation = $selectedEtat = 'Tous';
    } else {
        // Récupère les valeurs postées (sans écraser les tableaux)
        $selectedCategorie = $_POST['categorie'] ?? 'Tous';
        $selectedLocalisation = $_POST['localisation'] ?? 'Tous';
        $selectedEtat = $_POST['etat'] ?? 'Tous';

        if ($selectedCategorie == "Tous" && $selectedLocalisation == "Tous" && $selectedEtat == "Tous") {
            $articles = get_obj();
        }
        else if ($selectedCategorie != "Tous" && $selectedLocalisation == "Tous" && $selectedEtat == "Tous") {
            $articles = filter_articles_categorie($selectedCategorie);
        }
        else if ($selectedCategorie == "Tous" && $selectedLocalisation != "Tous" && $selectedEtat == "Tous") {
            $articles = filter_articles_localisation($selectedLocalisation);
        }
        else if ($selectedCategorie == "Tous" && $selectedLocalisation == "Tous" && $selectedEtat != "Tous") {
            $articles = filter_articles_etat($selectedEtat);
        }
        else if ($selectedCategorie != "Tous" && $selectedLocalisation != "Tous" && $selectedEtat == "Tous") {
            $articles = filter_articles_categorie_localisation($selectedCategorie, $selectedLocalisation);
        }
        else if ($selectedCategorie != "Tous" && $selectedLocalisation == "Tous" && $selectedEtat != "Tous") {
            $articles = filter_articles_categorie_etat($selectedCategorie, $selectedEtat);
        }
        else if ($selectedCategorie == "Tous" && $selectedLocalisation != "Tous" && $selectedEtat != "Tous") {
            $articles = filter_articles_localisation_etat($selectedLocalisation, $selectedEtat);
        }
        else if ($selectedCategorie != "Tous" && $selectedLocalisation != "Tous" && $selectedEtat != "Tous") {
            $articles = filter_articles_all($selectedCategorie, $selectedLocalisation, $selectedEtat);
        }
    }
}

    ?>