document.addEventListener('DOMContentLoaded', () => {
    const popup = document.getElementById('popup');
    const popupMessage = document.getElementById('popupMessage');

    // Si PHP a injecté un message, on ouvre le popup immédiatement
    if (popup && popupMessage && popupMessage.innerHTML.trim() !== "") {
        popup.showModal();
    }
});

document.querySelectorAll('.object.clickable').forEach(item => {
    item.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        const rightContainer = document.querySelector('.right-container');
        fetch(`index.php?page=MesDons&id=${id}`)
            .then(response => response.text())
            .then(html => { rightContainer.innerHTML = html; })
        const deleteBtn = document.getElementById('delete');
        deleteBtn.style.display = 'flex';
        deleteBtn.href = `index.php?page=MesDons&id=${id}&action=deleteConfirmation`;


    });
});