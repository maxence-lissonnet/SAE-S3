// popup.js

console.log('popup.js chargé');

document.addEventListener('DOMContentLoaded', () => {
  const popup       = document.getElementById('confirmationPopup');
  const titleElem   = document.getElementById('popupTitle');
  const messageElem = document.getElementById('popupMessage');
  const confirmBtn  = document.getElementById('confirmAction');
  const cancelBtn   = document.getElementById('cancelAction');
  const closeBtn    = document.getElementById('closePopup');

  if (!popup || !titleElem || !messageElem || !confirmBtn || !cancelBtn || !closeBtn) {
    console.error('[popup] HTML de la popup manquant');
    return;
  }

  let confirmCallback = null;

  function showPopup(title, message, callback) {
    confirmCallback         = callback;
    titleElem.textContent   = title;
    messageElem.textContent = message;
    popup.style.display     = 'flex';
    document.body.style.overflow = 'hidden';
  }

  function hidePopup() {
    popup.style.display = 'none';
    document.body.style.overflow = '';
    confirmCallback = null;
  }

  confirmBtn.addEventListener('click', () => {
    if (typeof confirmCallback === 'function') {
      confirmCallback();
    }
    hidePopup();
  });

  cancelBtn.addEventListener('click', hidePopup);
  closeBtn.addEventListener('click', hidePopup);

  function attachDelete(buttonId, formId, title, message) {
    const btn  = document.getElementById(buttonId);
    const form = document.getElementById(formId);

    if (!btn || !form) {
      console.log(`[popup] ${buttonId} ou ${formId} introuvable sur cette page`);
      return;
    }

    console.log(`[popup] Bouton ${buttonId} trouvé, on accroche les events`);

    btn.addEventListener('click', (e) => {
      e.preventDefault();
      showPopup(title, message, () => {
        form.submit();
      });
    });
  }

  // Communication (page com.php)
  attachDelete(
    'deleteButton',
    'deleteForm',
    'Supprimer la communication',
    'Êtes-vous sûr de vouloir supprimer cette communication ?'
  );

  // Evènement (page evenement.php)
  attachDelete(
    'eventDeleteButton',
    'eventDeleteForm',
    'Supprimer cet évènement',
    'Êtes-vous sûr de vouloir supprimer cet évènement ?'
  );

 attachDelete(
  'validateButton',
  'validateForm',
  'Valider cet évènement',
  'Confirmez-vous l\'enregistrement de cet évènement ?'
);
attachDelete(
    'publishButton',
    'publishForm',
    'Valider cette publication',
    'Confirmez-vous l\'enregistrement de cette communication ?'
  );

});
