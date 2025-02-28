<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Inclure le fichier du compteur de visites
    require_once __DIR__ . '/visits-counter.php';
    
    // Incrémenter le compteur de visites
    $visitCount = incrementVisitCounter();
    echo "<!-- Compteur de visites: $visitCount -->";
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
    error_log("Erreur compteur: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FLD Agencement - Plaquiste à Arras et Douai</title>
    <meta name="description" content="Trouvez un plaquiste qualifié à Arras et Douai pour vos projets de plâtrerie. Contactez-nous pour un devis gratuit.">    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
<!-- Navbar -->

<nav class="navbar navbar-expand bg-light shadow-sm">    
    <div class="container">
        <img src="images/Fichier 1.svg" alt="logo FLD" height="50px">
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
                    <a class="nav-link" href="contact.html">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="mb-4">FLD AGENCEMENT</h1>
                <p class="mb-5">Expert en rénovation intérieure sur Arras, Cambrai et Douai</p>
                <a href="contact.html" class="btn btn-primary btn-lg">Demander un devis gratuit</a>
            </div>
        </div>
    </section>
    <section id="services" class="services-section m-0 p-0">
        <div class="container">
            <h2>Nos Services</h2>
            <p class="text-center mb-5">Des solutions complètes pour tous vos projets de rénovation intérieure</p>
            
            <!-- Première rangée: 3 cartes -->
            <div class="row mb-4">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-paint-roller"></i>
                        </div>
                        <h3>Peinture</h3>
                        <p>Travaux de peinture intérieure et extérieure avec des produits de haute qualité pour des finitions durables et esthétiques.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-hammer"></i>
                        </div>
                        <h3>Plâtrerie</h3>
                        <p>Création de cloisons, pose de faux plafonds et rénovation de plafonds anciens avec un travail soigné et précis.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-temperature-low"></i>
                        </div>
                        <h3>Isolation</h3>
                        <p>Solutions d'isolation thermique et phonique pour améliorer le confort et réduire vos factures énergétiques.</p>
                    </div>
                </div>
            </div>
            
            <!-- Deuxième rangée: 2 cartes centrées -->
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-brush"></i>
                        </div>
                        <h3>Enduit</h3>
                        <p>Réalisation d'enduits intérieurs et extérieurs pour un rendu esthétique et durable, adaptés à vos besoins.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h3>Pose</h3>
                        <p>Installation professionnelle de parquet, montage de cuisines et aménagement de salles de bain en collaboration avec <strong>Ets Bertrand Vaast</strong>, mon partenaire plomberie de confiance. Découvrez leur savoir-faire sur Facebook !</p>
                        <div class="mt-3">
                            <a href="https://www.facebook.com/profile.php?id=100075711861190" target="_blank" class="credits-btn facebook-btn">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="text-center mt-4">
        <div class="certification-section">
            <div class="d-inline-block">
                <div class="certification-card">
                    <img src="images/logoRGEqualibat.avif" alt="Certification RGE" class="img-fluid mb-3" width="100" height="100">
                    <h4>RGE Qualibat</h4>
                    <p>Reconnu Garant de l'Environnement</p>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <section id="about" class="about-section m-0 p-0">
        <div class="container">
            <h2>À Propos</h2>
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="about-text">
                        <h3 class="mb-4">Mon Histoire</h3>
                        <p>Fondée en 2020, FLD Agencement est née d'une passion pour le travail bien fait et d'une volonté de proposer des services de qualité en matière de rénovation intérieure.</p>
                        <p>Après 10 ans d'expérience dans le secteur du bâtiment, j'ai décidé de mettre mon expertise au service des particuliers et des professionnels de la région d'Arras, Cambrai et Douai.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-image">
                        <img src="images/LOGO FLD NB[2081].jpg" class="img-fluid" alt="Fondateur FLD Agencement">
                    </div>
                </div>
            </div>


            
            <h2>Les valeurs de l'entreprise</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <h3>Qualité</h3>
                        <p>Fournir un travail de haute qualité, en utilisant les meilleurs matériaux et techniques du marché.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3>Professionnalisme</h3>
                        <p>Respect des délais et maintien d'une communication transparente tout au long de vos projets.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>Satisfaction Client</h3>
                        <p>Votre satisfaction est ma priorité. Je m'adapte à vos besoins et reste à votre écoute.</p>
                    </div>
                </div>
            </div>
            
       </div>
    </section>

    <div class="visits-container m-2">
    <div class="visits-box">
        <div class="visits-display" id="visit-count"><?php echo $visitCount; ?></div>
        <div class="visits-label">Visiteurs</div>
    </div>
</div>
    
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
                    <li><a href="index.html">Accueil</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="informationsLegales.html">Informations Légales</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 FLD Agencement - Tous droits réservés</p>
        </div>
    </footer>
    
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

// Animation pour les cartes de services et valeurs
document.addEventListener('DOMContentLoaded', function() {
// Fonction pour vérifier si un élément est visible dans la fenêtre
function isInViewport(element) {
const rect = element.getBoundingClientRect();
return (
rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
rect.bottom >= 0
);
}

// Fonction pour animer les éléments visibles
function animateOnScroll() {
// Animer les cartes de service
document.querySelectorAll('.service-card').forEach(function(card, index) {
if (isInViewport(card)) {
    setTimeout(function() {
        card.classList.add('animate');
    }, index * 150);
}
});

// Animer les cartes de valeurs
document.querySelectorAll('.value-card').forEach(function(card, index) {
if (isInViewport(card)) {
    setTimeout(function() {
        card.classList.add('animate');
    }, index * 150);
}
});
}

// Lancer l'animation au chargement et au défilement
animateOnScroll();
window.addEventListener('scroll', animateOnScroll);
});
</script>
</body>
</html>