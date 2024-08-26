<?php
// Connexion au fichier de données
$fichier = 'donnees.txt';
date_default_timezone_set('Europe/Paris');

// Récupérer les données du formulaire
$nom = htmlspecialchars($_POST['nom']);

// Vérifie si la durée est envoyée via le chronomètre ou manuellement
if (isset($_POST['dureeChrono']) && !empty($_POST['dureeChrono'])) {
    $duree = floatval($_POST['dureeChrono']);
} elseif (isset($_POST['duree']) && !empty($_POST['duree'])) {
    $duree = floatval($_POST['duree']);
} else {
    $duree = 0; // Valeur par défaut si aucune durée n'est saisie
}

$timestamp = date('Y-m-d H:i:s');

// Préparer la ligne à ajouter
$ligne = "$timestamp | $nom | $duree\n";

// Ajouter la ligne au fichier
file_put_contents($fichier, $ligne, FILE_APPEND);

// Rediriger vers la page de résultats
header('Location: resultats.html');
exit();
?>
