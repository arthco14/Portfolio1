<?php

// Fonction pour charger un fichier YAML
require_once("yaml/yaml.php");

// Charger les données des fichiers YAML
$accueil = yaml_parse_file('donneeyaml/accueil.yaml');
$competences = yaml_parse_file('donneeyaml/competences.yaml');
$realisations = yaml_parse_file('donneeyaml/realisations.yaml');
$formation = yaml_parse_file('donneeyaml/formation.yaml');
$contact = yaml_parse_file('donneeyaml/contact.yaml');

// Récupérer la charte graphique
$couleurs = "#007bff"; // Exemple de couleur primaire, à adapter selon la charte
$typographie = "Arial, sans-serif"; // Exemple de typographie, à adapter
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($accueil['site']['titre']); ?></title>
    <link rel="stylesheet" href="index.css"> <!-- Lien vers le CSS -->
</head>
<body>

<nav>
    <ul>
        <?php foreach ([$accueil, $competences, $realisations, $formation, $contact] as $page): ?>
            <li><a href="#<?php echo strtolower($page['site']['pages'][0]['nom']); ?>"><?php echo $page['site']['pages'][0]['nom']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</nav>

<main>

<!-- Accueil -->
<section id="accueil">
    <h1><?php echo $accueil['site']['pages'][0]['contenu'][0]['prénom_nom']; ?></h1>
    <p><?php echo $accueil['site']['pages'][0]['contenu'][1]['accroche']; ?></p>
    <p><?php echo nl2br($accueil['site']['pages'][0]['contenu'][2]['présentation']); ?></p>
    <img src="assets/<?php echo !empty($data['site']['pages'][0]['contenu'][3]['photo']) ? htmlspecialchars($data['site']['pages'][0]['contenu'][3]['photo']) : 'pfp.png'; ?>" alt="Photo de profil" style="width: 200px; height: auto;">
</section>

<!-- Compétences -->
<section id="competences">
    <h2>Compétences</h2>
    <?php foreach ($competences['site']['pages'][0]['contenu'][0]['domaines'] as $domaine): ?>
        <h3><?php echo $domaine['nom']; ?></h3>
        <ul>
            <?php foreach ($domaine['compétences'] as $competence): ?>
                <li><?php echo $competence['nom']; ?> - Niveau : <?php echo $competence['niveau']; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
</section>

<!-- Réalisations -->
<section id="realisations">
    <h2>Réalisations</h2>
    <?php foreach ($realisations['site']['pages'][0]['contenu'][0]['projets'] as $projet): ?>
        <div>
            <h3><?php echo $projet['titre']; ?></h3>
            <p><?php echo $projet['description']; ?></p>
            <img src="assets/<?php echo !empty($projet['illustration']) ? htmlspecialchars($projet['illustration']) : 'default_project_image.png'; ?>" alt="Illustration du projet" style="width: 800px; height: auto;">
        </div>
    <?php endforeach; ?>
</section>

<!-- Formation -->
<section id="formation">
    <h2>Formation</h2>
    <?php foreach ($formation['site']['pages'][0]['contenu'][0]['formations'] as $form): ?>
        <div>
            <h3><?php echo $form['nom']; ?></h3>
            <p><?php echo $form['contenu']; ?></p>
            <p><strong>Établissement:</strong> <?php echo $form['établissement']; ?></p>
        </div>
    <?php endforeach; ?>
</section>

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
    <p>&copy; 2024 <?php echo $accueil['site']['pages'][0]['contenu'][0]['prénom_nom']; ?></p>
</footer>

</body>
</html>
