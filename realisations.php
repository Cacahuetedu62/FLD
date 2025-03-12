<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'lib/pdo.php';

try {
    $stmt = $pdo->query("SELECT * FROM projets ORDER BY date DESC");
    $projets = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Erreur de récupération des projets : " . $e->getMessage());
    $projets = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Préchargement des ressources critiques -->
    <link rel="preload" href="styles.css" as="style">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Plaquiste professionnel à Arras et Douai | Rénovation intérieure haute qualité par un plaquiste expert | Devis gratuit</title>
    
    <meta name="description" content="fld agencement : votre plaquiste qualifié à Arras et Douai. Expertise en plâtrerie, cloisons et isolation. Devis gratuit pour tous vos projets d'aménagement intérieur.">

    <!-- CSS non bloquants -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="styles.css">

    <meta property="og:title" content="FLD Agencement - Plaquiste Professionnel">
    <meta property="og:description" content="Experts en rénovation intérieure">
    <meta property="og:image" content="https://site.com/image.jpg">
    <meta property="og:url" content="https://fld-agencement.com">
    
    <link rel="canonical" href="https://fld-agencement.com/realisations.php">
    <link rel="icon" href="/images/favicon.png" type="image/png">
    <link rel="shortcut icon" href="images/favicon-16x16.png" type="image/png">
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-expand shadow-sm">       
    <div class="container">
        <img src="images/LogoFLDblanc.svg" alt="logo FLD" loading="lazy" height="50">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#about">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="realisations.php">Réalisations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <section id="projects" class="projects-section">
        <div class="container">
            <h2>Nos Travaux Récents</h2>
            <p class="text-center mb-5">Chaque projet est réalisé avec soin et attention aux détails</p>

            <?php if (!empty($projets)): ?>
                <?php 
                // Préchargement de toutes les images avec leur projet_id pour éviter des requêtes multiples
                $stmtAllImages = $pdo->query("SELECT * FROM images ORDER BY projet_id");
                $allImages = $stmtAllImages->fetchAll(PDO::FETCH_ASSOC);
                
                // Organisation des images par projet_id
                $imagesByProject = [];
                foreach ($allImages as $image) {
                    $projectId = $image['projet_id'];
                    if (!isset($imagesByProject[$projectId])) {
                        $imagesByProject[$projectId] = [];
                    }
                    $imagesByProject[$projectId][] = $image;
                }
                
                // Affichage des projets
                foreach ($projets as $index => $projet): 
                    $projetId = $projet['id'];
                ?>
                    <div class="row mb-5 <?= $index % 2 == 0 ? '' : 'flex-row-reverse' ?>">
                        <div class="col-lg-6">
                            <div class="project-info">
                                <h3><?= htmlspecialchars($projet['titre']) ?></h3>
                                <?php if (!empty($projet['sous_titre'])): ?>
                                    <p class="lead"><?= htmlspecialchars($projet['sous_titre']) ?></p>
                                <?php endif; ?>
                                <ul class="project-details">
                                    <?php if (!empty($projet['date'])): ?>
                                        <li><i class="fas fa-calendar-alt"></i> Date: <?= htmlspecialchars($projet['date']) ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($projet['lieu'])): ?>
                                        <li><i class="fas fa-map-marker-alt"></i> Lieu: <?= htmlspecialchars($projet['lieu']) ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($projet['type_travaux'])): ?>
                                        <li><i class="fas fa-tasks"></i> Travaux: <?= htmlspecialchars($projet['type_travaux']) ?></li>
                                    <?php endif; ?>
                                </ul>
                                <?php if (!empty($projet['description'])): ?>
                                    <p><?= nl2br(htmlspecialchars($projet['description'])) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <?php
                            // Récupérer les images pour ce projet spécifique depuis notre tableau organisé
                            $projetImages = isset($imagesByProject[$projetId]) ? $imagesByProject[$projetId] : [];
                            ?>
                            
                            <?php if (!empty($projetImages)): ?>
                                <div id="carouselProject<?= $projetId ?>" class="carousel slide" data-bs-ride="false">
                                    <div class="carousel-indicators">
                                        <?php foreach ($projetImages as $key => $image): ?>
                                            <button type="button" data-bs-target="#carouselProject<?= $projetId ?>" data-bs-slide-to="<?= $key ?>" <?= $key === 0 ? 'class="active" aria-current="true"' : '' ?> aria-label="Slide <?= $key + 1 ?>"></button>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="carousel-inner">
                                        <?php foreach ($projetImages as $key => $image): ?>
                                            <div class="carousel-item <?= $key === 0 ? 'active' : '' ?>">
                                                <img loading="lazy" src="<?= htmlspecialchars($image['chemin']) ?>" class="d-block w-100" alt="Image du projet <?= htmlspecialchars($projet['titre']) ?> - <?= $key + 1 ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselProject<?= $projetId ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Précédent</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselProject<?= $projetId ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Suivant</span>
                                    </button>
                                </div>
                            <?php else: ?>
                                <div class="text-center p-4 bg-light rounded">
                                    <i class="fas fa-camera fa-3x mb-3 text-muted"></i>
                                    <p>Aucune photo disponible pour ce projet.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Aucun projet disponible pour le moment.
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section text-center">
        <div class="container">
            <h2 class="m-2">Vous avez un projet similaire ?</h2>
            <p class="m-2">Contactez-nous dès aujourd'hui pour discuter de vos besoins et obtenir un devis gratuit</p>
            <a href="contact.php" class="btn btn-danger text-white fw-bold shadow-lg">Demander un devis</a>
        </div>
    </section>

    <footer>
        <div class="footer-container m-3">
            <div class="footer-section">
                <h4 class="footer-heading"> FLD Agencement</h4>
                <ul class="footer-contact-info">
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>10 Rue Jules Ferry, 62121 Courcelles-le-Comte</span>
                    </li>
                    <li>
                        <i class="fas fa-phone-alt"></i>
                        <span>06 50 29 70 05</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>fldagencement@gmail.com</span>
                    </li>
                    <li>
                        <i class="fas fa-building"></i>
                        <span>SIRET : 91424937000026</span>
                    </li>
                </ul>
            </div>
            <div class="footer-section">
                <h4 class="footer-heading"> Suivez-nous sur Facebook</h4>
                <div class="social-icons">
                    <a href="https://www.facebook.com/fldagencement" target="_blank" class="facebook-icon" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </div>
            </div>
            <div class="footer-section">
                <h4 class="footer-heading"> Liens Utiles</h4>
                <ul class="footer-links list-unstyled">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="informationsLegales.html">Informations Légales</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 FLD Agencement - Tous droits réservés</p>
        </div>
    </footer>



    <script>
        // Script pour changer la couleur de la navbar lors du défilement
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Initialisation des carrousels
        document.addEventListener('DOMContentLoaded', function() {
            // Options des carrousels
            const carouselOptions = {
                interval: false, // Désactive le défilement automatique
                wrap: true,
                ride: false
            };

            // Initialisation des carrousels Bootstrap
            const carousels = document.querySelectorAll('.carousel');
            carousels.forEach(function(carousel) {
                new bootstrap.Carousel(carousel, carouselOptions);
            });
        });
    </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" defer></script>
</body>
</html>