document.addEventListener('DOMContentLoaded', () => {
    const imageUploadArea = document.getElementById('imageUploadArea');
    if (!imageUploadArea) {
        return;
    }

    const imageUploadInput = document.getElementById('imageUpload');
    const imagePreviewContainer = document.getElementById('image-preview-container');
    const imagePreview = document.getElementById('image-preview');
    const imageName = document.getElementById('image-name');
    const imageSize = document.getElementById('image-size');
    const deleteImageBtn = document.getElementById('delete-image-btn');

    imageUploadInput.addEventListener('click', (event) => {
        event.stopPropagation();
    });

    if (!imageUploadInput || !imagePreviewContainer || !imagePreview || !imageName || !imageSize || !deleteImageBtn) {
        console.error('One or more required elements for signalement image preview are missing.');
        return;
    }

    imageUploadInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (!file) {
            return;
        }

        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format d\'image non valide. Veuillez utiliser JPG, PNG, ou GIF.');
            resetImageUpload();
            return;
        }

        const maxSize = 5 * 1024 * 1024; // 5MB
        if (file.size > maxSize) {
            alert('L\'image est trop lourde. Le maximum est de 5MB.');
            resetImageUpload();
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            imagePreview.src = e.target.result;
            imageName.textContent = file.name;
            imageSize.textContent = `${(file.size / 1024).toFixed(1)} KB`;

            imageUploadArea.classList.add('hidden-by-js');
            imagePreviewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });

    deleteImageBtn.addEventListener('click', (e) => {
        e.preventDefault();
        resetImageUpload();
    });

    function resetImageUpload() {
        imageUploadInput.value = '';
        imagePreview.src = '#';
        imagePreviewContainer.style.display = 'none';
        imageUploadArea.classList.remove('hidden-by-js');
    }
});
