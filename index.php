<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Charger les variables d'environnement
require_once __DIR__ . '/lib/config.php';

// Récupérer les clés pour le compteur
$jsonbin_id = $config['jsonbin']['id'] ?? '';
$jsonbin_key = $config['jsonbin']['key'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Plaquiste Professionnel à Arras et Douai | Rénovation Intérieure Haute Qualité</title>
<meta name="description" content="Experts en plâtrerie et rénovation intérieure à Arras, Douai et Cambrai. Devis gratuit, travaux de qualité, transformation de vos espaces sur mesure. Contactez FLD Agencement aujourd'hui !">  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<meta property="og:title" content="FLD Agencement - Plaquiste Professionnel">
<meta property="og:description" content="Experts en rénovation intérieure">
<meta property="og:image" content="https://site.com/image.jpg">
<meta property="og:url" content="https://fld-agencement.com">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-expand bg-light shadow-sm">    
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
          <a href="contact.php" class="btn btn-primary btn-lg">Demander un devis gratuit</a>
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
      <div class="visits-display" id="visit-count">...</div>
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

  // JSONbin counter avec variables PHP
  const BIN_ID = '<?php echo $jsonbin_id; ?>';
  const API_KEY = '<?php echo $jsonbin_key; ?>';

  // Récupérer le nombre de visites
  async function getVisitCount() {
      try {
          const response = await fetch(`https://api.jsonbin.io/v3/b/${BIN_ID}/latest`, {
              headers: {
                  'X-Master-Key': API_KEY
              }
          });
          const data = await response.json();
          return data.record.visits || 0;
      } catch (error) {
          console.error('Erreur lors de la récupération du compteur:', error);
          return 0;
      }
  }

  // Incrémenter le compteur
  async function incrementVisitCount() {
      try {
          const currentCount = await getVisitCount();
          const newCount = currentCount + 1;
          
          await fetch(`https://api.jsonbin.io/v3/b/${BIN_ID}`, {
              method: 'PUT',
              headers: {
                  'Content-Type': 'application/json',
                  'X-Master-Key': API_KEY
              },
              body: JSON.stringify({ visits: newCount })
          });
          
          document.getElementById('visit-count').textContent = newCount;
      } catch (error) {
          console.error('Erreur lors de l\'incrémentation:', error);
      }
  }

  // Initialisation
  getVisitCount().then(count => {
      document.getElementById('visit-count').textContent = count;
  });
  
  // Puis incrémenter
  incrementVisitCount();
});
</script>
</body>
</html>