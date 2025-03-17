<?php
// Charger la configuration
$config = require_once 'lib/config.php';
require_once '../admin/includes/security_headers.php'; // Inclure les en-têtes de sécurité en premier
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
    
    <link rel="canonical" href="https://fld-agencement.com/contact.php">
    <link rel="icon" href="/images/favicon.png" type="image/png">
    <link rel="shortcut icon" href="images/favicon-16x16.png" type="image/png">

    <!-- reCAPTCHA avec attributs de sécurité -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

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

   <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
           <div class="modal-header" id="responseModalHeader">
             <h5 class="modal-title" id="responseModalLabel">Message</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
             <p id="responseMessage"></p>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
           </div>
         </div>
       </div>
     </div>

   <main>
       <section class="contact py-5">
           <div class="container">
               <div class="row">
                   <div class="col-md-6">
                       <div class="contact-form p-4 bg-white shadow rounded">
                           <h2>Contactez-nous</h2>
                           <p class="required-fields">* Champs obligatoires</p>
                           <form id="contactForm" aria-labelledby="contactFormLabel">
                               <div class="mb-3">
                                   <label for="nom" class="form-label">Nom complet *</label>
                                   <input type="text" id="nom" name="nom" class="form-control" required maxlength="100">
                               </div>
                               <div class="mb-3">
                                   <label for="email" class="form-label">Email *</label>
                                   <input type="email" id="email" name="email" class="form-control" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}">
                               </div>
                               <div class="mb-3">
                                   <label for="tel" class="form-label">Téléphone</label>
                                   <input type="tel" id="tel" name="tel" class="form-control" pattern="(\+[0-9]{1,3})?[0-9\s\-]{6,15}">
                               </div>
                               <div class="mb-3">
                                   <label for="message" class="form-label">Message *</label>
                                   <textarea id="message" name="message" class="form-control" rows="4" required maxlength="1000"></textarea>
                               </div>
                               <div class="mb-3 form-check">
                                   <input type="checkbox" class="form-check-input" id="acceptPolicy" required>
                                   <label class="form-check-label" for="acceptPolicy">J'accepte la politique de confidentialité *</label>
                               </div>
                               <div><a href="informationsLegales.html">Consulter la politique</a></div>
                               
                               <!-- reCAPTCHA -->
                               <div class="g-recaptcha mb-3" data-sitekey="<?php echo $config['recaptcha']['site_key']; ?>"></div>
                               
                               <button type="submit" class="btn btn-danger text-white fw-bold shadow-lg">Envoyer</button>
                           </form>
                       </div>
                   </div>
                   <div class="col-md-6">
                       <div class="map-container shadow rounded">
                           <h2>Où nous trouver</h2>

                           
                           <iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2555.905043567056!2d2.7743382760424615!3d50.16291250802618!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47dd4fefab6bf471%3A0x72fce8ba09c10e65!2s10%20Rue%20Jules%20Ferry%2C%2062121%20Courcelles-le-Comte!5e0!3m2!1sfr!2sfr!4v1740408239471!5m2!1sfr!2sfr" 
    width="100%" 
    height="450" 
    style="border:0;" 
    allowfullscreen 
    loading="lazy" 
    referrerpolicy="strict-origin-when-cross-origin"
    sandbox="allow-scripts allow-same-origin"
    title="Localisation de FLD Agencement"
></iframe>                       

</div>
                   </div>
               </div>
           </div>
       </section>
   </main>

   <footer>
       <div class="footer-container m-3">
           <div class="footer-section">
               <h4 class="footer-heading">FLD Agencement</h4>
               <ul class="footer-contact-info">
                   <li><i class="fas fa-map-marker-alt"></i><span>10 Rue Jules Ferry, 62121 Courcelles-le-Comte</span></li>
                   <li><i class="fas fa-phone-alt"></i><span>06 50 29 70 05</span></li>
                   <li><i class="fas fa-envelope"></i><span>fldagencement@gmail.com</span></li>
                   <li><i class="fas fa-building"></i><span>SIRET : 91424937000026</span></li>
               </ul>
           </div>
           <div class="footer-section">
               <h4 class="footer-heading">Suivez-nous sur Facebook</h4>
               <div class="social-icons">
                   <a href="https://www.facebook.com/fldagencement" target="_blank" class="facebook-icon" aria-label="Facebook">
                       <i class="fab fa-facebook-f"></i>
                   </a>
               </div>
           </div>
           <div class="footer-section">
               <h4 class="footer-heading">Liens Utiles</h4>
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
   document.getElementById("contactForm").addEventListener("submit", function(event) {
       event.preventDefault();

       // Validation
       const email = document.getElementById("email").value;
       const tel = document.getElementById("tel").value;
       const nom = document.getElementById("nom").value;
       const message = document.getElementById("message").value;
       
       // Email validation
       if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
           showModal("Erreur", "Format d'email invalide.");
           return;
       }
       
       // Phone validation (if provided)
       if (tel && !/^(\+[0-9]{1,3})?[0-9\s\-]{6,15}$/.test(tel)) {
           showModal("Erreur", "Format de téléphone invalide.");
           return;
       }
       
       // CAPTCHA validation
       if (grecaptcha.getResponse() === '') {
           showModal("Erreur", "Veuillez valider le CAPTCHA.");
           return;
       }

       var formData = new FormData(this);

       fetch("traitement.php", {
           method: "POST",
           body: formData
       })
       .then(response => response.text())
       .then(data => {
           if (data.includes("Erreur")) {
               showModal("Erreur", data);
           } else {
               showModal("Message envoyé !", "Merci pour votre message. Nous vous contacterons dans les plus brefs délais.");
               document.getElementById("contactForm").reset();
               grecaptcha.reset();
           }
       })
       .catch(error => {
           showModal("Erreur", "Erreur lors de l'envoi du message. Veuillez réessayer.");
       });
       
       function showModal(title, message) {
           const modalHeader = document.getElementById("responseModalHeader");
           const responseMessage = document.getElementById("responseMessage");
           
           if (title === "Erreur") {
               modalHeader.classList.remove("bg-success", "text-white");
               modalHeader.classList.add("bg-danger", "text-white");
           } else {
               modalHeader.classList.remove("bg-danger", "text-white");
               modalHeader.classList.add("bg-success", "text-white");
           }
           
           document.getElementById("responseModalLabel").textContent = title;
           responseMessage.textContent = message;
           
           var responseModal = new bootstrap.Modal(document.getElementById('responseModal'));
           responseModal.show();
       }
   });
   </script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>