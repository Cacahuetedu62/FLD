document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour mettre à jour le compteur de visites
    function updateVisitCounter() {
        fetch('get_visit_count.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
                }
                return response.json();
            })
            .then(data => {
                const visitCountElement = document.getElementById('visit-count');
                if (visitCountElement) {
                    visitCountElement.textContent = new Intl.NumberFormat().format(data.count);
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération du compteur:', error);
            });
    }

    // Actualiser le compteur toutes les 30 secondes
    updateVisitCounter(); // Première mise à jour
    setInterval(updateVisitCounter, 30000); // Mises à jour suivantes
});