/**
 * Ce script gère :
 * 1) L’ouverture/fermeture de la sidebar (mobile/tablette)
 * 2) La fermeture de la flash-success après 5 secondes (optionnel, l’animation CSS gère déjà le fadeOut)
 * 3) L’ouverture/fermeture des modales (pour le secrétaire)
 */

document.addEventListener('DOMContentLoaded', function() {
  // 1) Sidebar toggle
  const sidebar = document.querySelector('.sidebar');
  const overlay = document.querySelector('.overlay');
  const mainContent = document.querySelector('.main-content');
  const toggleBtn = document.querySelector('#sidebarToggle');
  if (toggleBtn && sidebar && overlay && mainContent) {
    toggleBtn.addEventListener('click', function() {
      const isOpen = sidebar.classList.contains('open');
      if (isOpen) {
        sidebar.classList.remove('open');
        overlay.style.display = 'none';
        mainContent.classList.remove('with-sidebar');
      } else {
        sidebar.classList.add('open');
        overlay.style.display = 'block';
        mainContent.classList.add('with-sidebar');
      }
    });

    // Quand on clique sur l’overlay, on ferme la sidebar
    overlay.addEventListener('click', function() {
      sidebar.classList.remove('open');
      overlay.style.display = 'none';
      mainContent.classList.remove('with-sidebar');
    });
  }

  // 2) Modales (pour le secrétaire)
  // On sélectionne tous les boutons « accepter » et les modales correspondantes
  const acceptButtons = document.querySelectorAll('[data-open-modal]');
  acceptButtons.forEach(btn => {
    const modalId = btn.getAttribute('data-open-modal');
    const modalBackdrop = document.getElementById(modalId);
    const closeBtn = modalBackdrop ? modalBackdrop.querySelector('[data-close-modal]') : null;

    // Ouvre la modal
    btn.addEventListener('click', function() {
      if (modalBackdrop) {
        modalBackdrop.classList.add('open');
      }
    });

    // Ferme la modal au clic sur le bouton « Annuler » ou sur le fond
    if (closeBtn && modalBackdrop) {
      closeBtn.addEventListener('click', function() {
        modalBackdrop.classList.remove('open');
      });
    }
    // Fermer en cliquant en dehors de la boîte blanche
    if (modalBackdrop) {
      modalBackdrop.addEventListener('click', function(e) {
        if (e.target === modalBackdrop) {
          modalBackdrop.classList.remove('open');
        }
      });
    }
  });
});
