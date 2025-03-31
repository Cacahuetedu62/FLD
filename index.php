<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Charger les variables d'environnement
require_once __DIR__ . '/lib/config.php';

// Compteur de visites MongoDB
require_once __DIR__ . '/lib/visit_counter.php';

// Incrémente le compteur uniquement pour les vraies visites (non AJAX)
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
    $visitCount = incrementVisitCounter();
} else {
    $visitCount = getVisitCount();
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
    
    <title>Plaquiste professionnel à Arras et Douai | Rénovation intérieure par un plaquiste expert | Devis gratuit</title>
    
    <meta name="description" content="Votre plaquiste entre Arras et Douai. Expertise en plâtrerie, cloisons et isolation. Devis gratuit pour tous vos projets d'aménagement intérieur.">

    <!-- CSS non bloquants -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="styles.css">

    <meta property="og:title" content="FLD Agencement - Plaquiste Professionnel">
    <meta property="og:description" content="Experts en rénovation intérieure">
    <meta property="og:image" content="https://site.com/image.jpg">
    <meta property="og:url" content="https://fld-agencement.com">
    
    <link rel="canonical" href="https://fld-agencement.com/index.php">
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

<!-- Hero Section -->
<section class="hero" id="hero">
   <div class="container">
       <div class="hero-content">
           <h1 class="mb-4">FLD AGENCEMENT</h1>
           <p class="mb-5">Expert en rénovation intérieure sur Arras, Cambrai et Douai</p>
           <a href="contact.php" class="btn btn-danger text-white fw-bold shadow-lg">Demander un devis gratuit</a>
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
              <img src="images/logoRGEqualibat.avif" alt="Certification RGE" loading="lazy" class="img-fluid mb-3" width="100" height="100">
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
                  <img src="images/LogoFLDblanc.svg" class="img-fluid" loading="lazy" alt="Fondateur FLD Agencement">
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
        <div class="visits-display" id="visit-count"><?php echo number_format($visitCount); ?></div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" defer></script>
</body>
</html>