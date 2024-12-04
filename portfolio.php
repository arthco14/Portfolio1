<?php

require_once("yaml/yaml.php");
$data=yaml_parse_file('donnee.yaml');


$couleurs = $data['site']['charte_graphique']['couleurs'];
$typographie = $data['site']['charte_graphique']['typographie'];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($data['site']['titre']); ?></title>
    <!-- Lien vers la feuille de style CSS -->
    <link rel="stylesheet" href="style.css"> <!-- Assurez-vous que le chemin est correct -->
</head>
<body>

<!-- Menu de navigation -->
<nav>
    <ul>
        <?php foreach ($data['site']['pages'] as $page): ?>
            <li><a href="#<?php echo strtolower($page['nom']); ?>"><?php echo $page['nom']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</nav>

<main>

<!-- Accueil -->
<section id="accueil">
    <h1><?php echo $data['site']['pages'][0]['contenu'][0]['prénom_nom']; ?></h1>
    <p><?php echo $data['site']['pages'][0]['contenu'][1]['accroche']; ?></p>
    <p><?php echo nl2br($data['site']['pages'][0]['contenu'][2]['présentation']); ?></p>
    <img src="assets/<?php echo !empty($data['site']['pages'][0]['contenu'][3]['photo']) ? htmlspecialchars($data['site']['pages'][0]['contenu'][3]['photo']) : 'pfp.png'; ?>" alt="Photo de profil" style="width: 200px; height: auto;">

<!-- Compétences -->
<section id="competences">
    <h2>Compétences</h2>
    <?php foreach ($data['site']['pages'][1]['contenu'][0]['domaines'] as $domaine): ?>
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
    <?php foreach ($data['site']['pages'][2]['contenu'][0]['projets'] as $projet): ?>
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
    <?php foreach ($data['site']['pages'][3]['contenu'][0]['formations'] as $formation): ?>
        <div>
            <h3><?php echo $formation['nom']; ?></h3>
            <?php foreach ($formation['contenu'] as $contenu): ?>
                <p><?php echo $contenu; ?></p>
            <?php endforeach; ?>

            <p><strong>Établissement :</strong> <?php echo $formation['établissement']; ?>, <?php echo $formation['lieu']; ?></p>
            <p><strong>Période :</strong> <?php echo $formation['date_debut']; ?> - <?php echo $formation['date_fin']; ?></p>
        </div>
    <?php endforeach; ?>
    <a href="assets/<?php echo !empty($data['site']['pages'][3]['contenu'][1]['cv_pdf']) ? htmlspecialchars($data['site']['pages'][3]['contenu'][1]['cv_pdf']) : 'default_cv.pdf'; ?>" download>Télécharger le CV</a>
</section>

<!-- Contact -->
<section id="contact">
    <h2>Contact</h2>
    <form action="#contact" method="POST">
        <?php
        $formulaire = $data['site']['pages'][4]['contenu'][0]['formulaire'];
        $destinataire = $data['site']['pages'][4]['contenu'][1]['envoi_mail'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $objet = $_POST['objet'];
            $message = $_POST['message'];
            mail($destinataire, $objet, $message, "From: $nom <$email>");
            echo "<p>Message envoyé avec succès !</p>";
        }

        foreach ($formulaire as $champ): ?>
            <label><?php echo $champ['champ']; ?>:</label>
            <?php if ($champ['type'] === 'textarea'): ?>
                <textarea name="<?php echo strtolower($champ['champ']); ?>" required></textarea>
            <?php else: ?>
                <input type="<?php echo $champ['type']; ?>" name="<?php echo strtolower($champ['champ']); ?>" required>
            <?php endif; ?>
        <?php endforeach; ?>
        <button type="submit">Envoyer</button>
    </form>
</section>

</main>

<footer>
    <p>&copy; 2024 <?php echo $data['site']['pages'][0]['contenu'][0]['prénom_nom']; ?></p>
</footer>

</body>
</html>