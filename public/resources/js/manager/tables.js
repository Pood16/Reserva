document.addEventListener('DOMContentLoaded', function(){
    // Add Table
    const tableModal = document.getElementById('addTableModal');
    const openTableModalBtn = document.getElementById('openTableModal');
    const closeTableModalBtn = document.getElementById('closeTableModal');
    const cancelTableBtn = document.getElementById('cancelTable');

    // Delete Modal
    const deleteModal = document.getElementById('deleteTableModal');
    const closeDeleteModalBtn = document.getElementById('closeDeleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDelete');
    const deleteTableForm = document.getElementById('deleteTableForm');
    const deleteTableBtns = document.querySelectorAll('.delete-table-btn');

    // Functions
    function openTableModal() {
        tableModal.classList.remove('hidden');
    }

    function closeTableModal() {
        tableModal.classList.add('hidden');
    }

    function openDeleteModal() {
        deleteModal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
    }

    // Add Events
    if (openTableModalBtn && closeTableModalBtn && cancelTableBtn) {
        openTableModalBtn.addEventListener('click', openTableModal);
        closeTableModalBtn.addEventListener('click', closeTableModal);
        cancelTableBtn.addEventListener('click', closeTableModal);

        tableModal.addEventListener('click', function(event) {
            if (event.target === tableModal) {
                closeTableModal();
            }
        });
    }

    // Delete Modal Events
    if (closeDeleteModalBtn && cancelDeleteBtn) {
        closeDeleteModalBtn.addEventListener('click', closeDeleteModal);
        cancelDeleteBtn.addEventListener('click', closeDeleteModal);

        deleteModal.addEventListener('click', function(event) {
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        });
    }

    // Delete table buttons
    if (deleteTableBtns.length > 0) {
        deleteTableBtns.forEach(button => {
            button.addEventListener('click', function() {
                const deleteUrl = this.getAttribute('data-delete-url');
                const tableName = this.getAttribute('data-table-name');

                deleteTableForm.action = deleteUrl;

                openDeleteModal();
            });
        });
    }
});
