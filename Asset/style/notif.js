// notif.js

document.addEventListener('DOMContentLoaded', () => {
  const deleteBar  = document.getElementById('notifDeleteBar');
  const archiveBar = document.getElementById('notifArchiveBar');
  const btnDelete  = document.getElementById('btnNotifDelete');
  const btnArchive = document.getElementById('btnNotifArchive');

  // S'il n'y a pas de notification courante, on n'a pas ces éléments
  if (!deleteBar || !archiveBar || !btnDelete || !btnArchive) {
    console.log('[notif] éléments manquants sur la page (probablement aucune notif)');
    return;
  }

  function hideBars() {
    deleteBar.hidden  = true;
    archiveBar.hidden = true;
  }

  btnDelete.addEventListener('click', () => {
    hideBars();
    deleteBar.hidden = false;
  });

  btnArchive.addEventListener('click', () => {
    hideBars();
    archiveBar.hidden = false;
  });

  document.addEventListener('click', (e) => {
    const action = e.target.getAttribute('data-bar-action');
    if (!action) return;

    if (action === 'cancel') {
      hideBars();
    } else if (action === 'confirm-delete') {
      const form = document.getElementById('notifDeleteForm');
      if (form) form.submit();
    } else if (action === 'confirm-archive') {
      const form = document.getElementById('notifArchiveForm');
      if (form) form.submit();
    }
  });
});
