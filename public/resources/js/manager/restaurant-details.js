

document.addEventListener('DOMContentLoaded', function(){

    // add Image modal
    const openImageModal = document.getElementById('openImageModal');
    const closeImageModal = document.getElementById('closeImageModal');
    const cancelImage = document.getElementById('cancelImage');
    const addImageModal = document.getElementById('addImageModal');

    if (openImageModal) {
        openImageModal.addEventListener('click', function() {
            addImageModal.classList.remove('hidden');
        });
    }

    if (closeImageModal) {
        closeImageModal.addEventListener('click', function() {
            addImageModal.classList.add('hidden');
        });
    }

    if (cancelImage) {
        cancelImage.addEventListener('click', function() {
            addImageModal.classList.add('hidden');
        });
    }
})

