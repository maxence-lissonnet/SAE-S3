document.addEventListener('DOMContentLoaded', () => {
    const popup = document.getElementById('popup');
    const popupMessage = document.getElementById('popupMessage');

    if (popup && popupMessage && popupMessage.innerHTML.trim() !== "") {
        popup.showModal();
    }
});

document.querySelectorAll('.object.clickable').forEach(item => {
    item.addEventListener('click', function () {
        // 1. On récupère l'ID de l'OBJET pour l'affichage (fetch)
        const idObjet = this.getAttribute('data-id');
        
        // 2. On récupère l'ID de la RÉSERVATION pour la suppression
        const idReservation = this.getAttribute('data-idreservation');

        const rightContainer = document.querySelector('.right-container');
        
        // On garde idObjet ici pour afficher les détails correctement
        fetch(`index.php?page=Reservation&id=${idObjet}`)
            .then(response => response.text())
            .then(html => { rightContainer.innerHTML = html; })
        
        const deleteBtn = document.getElementById('delete');
        deleteBtn.style.display = 'flex';
        
        // 3. IMPORTANT : On utilise idReservation pour le lien de suppression
        deleteBtn.href = `index.php?page=Reservation&id=${idReservation}&action=deleteConfirmation`;
    });
});