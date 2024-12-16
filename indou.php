<?php

// Fonction pour charger un fichier YAML
require_once("yaml/yaml.php");

// Charger les données des fichiers YAML avec des valeurs par défaut si le fichier n'est pas chargé correctement
$accueil = yaml_parse_file('donneeyaml/accueil.yaml') ?: [];
$competences = yaml_parse_file('donneeyaml/competences.yaml') ?: [];
$realisations = yaml_parse_file('donneeyaml/realisations.yaml') ?: [];
$formation = yaml_parse_file('donneeyaml/formation.yaml') ?: [];
$contact = yaml_parse_file('donneeyaml/contact.yaml') ?: [];

// Récupérer la charte graphique
$couleurs = "#007bff"; // Exemple de couleur primaire, à adapter selon la charte
$typographie = "Arial, sans-serif"; // Exemple de typographie, à adapter
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($accueil['site']['titre'] ?? 'Portfolio'); ?></title>
    <link rel="stylesheet" href="assets/css/index.css"> <!-- Lien vers le CSS -->
</head>
<body>

<nav>
    <ul>
        <?php foreach ([$accueil, $competences, $realisations, $formation, $contact] as $page): 
            $pageNom = $page['site']['pages'][0]['nom'] ?? null;
        ?>
            <li><a href="#<?php echo strtolower($pageNom ?? 'contact'); ?>">
                <?php echo htmlspecialchars($pageNom ?? 'Contact'); ?></a></li>
        <?php endforeach; ?>
    </ul>
</nav>

<main>

<!-- Accueil -->
<section id="accueil">
    <h1><?php echo htmlspecialchars($accueil['site']['pages'][0]['contenu'][0]['prénom_nom'] ?? 'Nom inconnu'); ?></h1>
    <p><?php echo htmlspecialchars($accueil['site']['pages'][0]['contenu'][1]['accroche'] ?? 'Bienvenue sur mon portfolio'); ?></p>
    <p><?php echo nl2br(htmlspecialchars($accueil['site']['pages'][0]['contenu'][2]['présentation'] ?? 'Présentation manquante')); ?></p>
    <img src="assets/<?php echo htmlspecialchars($accueil['site']['pages'][0]['contenu'][3]['photo'] ?? 'pfp.png'); ?>" alt="Photo de profil" style="width: 200px; height: auto;">
</section>

<!-- Compétences -->
<section id="competences">
    <h2>Compétences</h2>
    <?php foreach ($competences['site']['pages'][0]['contenu'][0]['domaines'] ?? [] as $domaine): ?>
        <h3><?php echo htmlspecialchars($domaine['nom'] ?? 'Domaine inconnu'); ?></h3>
        <ul>
            <?php foreach ($domaine['compétences'] ?? [] as $competence): ?>
                <li><?php echo htmlspecialchars($competence['nom'] ?? 'Compétence inconnue'); ?> - Niveau : <?php echo htmlspecialchars($competence['niveau'] ?? 'Inconnu'); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
</section>

<!-- Réalisations -->
<section id="realisations">
    <h2>Réalisations</h2>
    <?php foreach ($realisations['site']['pages'][0]['contenu'][0]['projets'] ?? [] as $projet): ?>
        <div>
            <h3><?php echo htmlspecialchars($projet['titre'] ?? 'Projet inconnu'); ?></h3>
            <p><?php echo htmlspecialchars($projet['description'] ?? 'Description manquante'); ?></p>
            <img src="assets/<?php echo htmlspecialchars($projet['illustration'] ?? 'default_project_image.png'); ?>" alt="Illustration du projet" style="width: 800px; height: auto;">
        </div>
    <?php endforeach; ?>
</section>

<!-- Formation -->
<section id="formation">
    <h2>Formation</h2>
    <?php foreach ($formation['site']['pages'][0]['contenu'][0]['formations'] as $form): ?>
        <div>
            <h3><?php echo $form['nom']; ?></h3>
            <p><strong>Établissement:</strong> <?php echo $form['établissement']; ?></p>
            <p><strong>Date de début:</strong> <?php echo $form['date_debut']; ?></p>
            <p><strong>Date de fin:</strong> <?php echo $form['date_fin']; ?></p>
            <p><strong>Lieu:</strong> <?php echo $form['lieu']; ?></p>
            <p><?php echo $form['contenu']; ?></p>
            <p><?php echo $form['reseau']; ?></p>
        </div>
    <?php endforeach; ?>
</section>

<!-- Formulaire de contact -->
<section id="contact">
    <h2>Contact</h2>
    <form action="contact.php" method="POST">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="objet">Objet</label>
        <input type="text" name="objet" id="objet" required>

        <label for="message">Message</label>
        <textarea name="message" id="message" required></textarea>

        <button type="submit">Envoyer</button>
    </form>
</section>

</main>

<footer>
    <p>&copy; 2024 <?php echo htmlspecialchars($accueil['site']['pages'][0]['contenu'][0]['prénom_nom'] ?? 'Auteur inconnu'); ?></p>
</footer>

</body>
</html>