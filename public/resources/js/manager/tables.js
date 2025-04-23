// Add to public/resources/js/manager/tables.js
document.addEventListener('DOMContentLoaded', function(){
    // Table Modal
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

    function openTableModal() {
        tableModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeTableModal() {
        tableModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openDeleteModal() {
        deleteModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Add Table Modal Events
    openTableModalBtn.addEventListener('click', openTableModal);
    closeTableModalBtn.addEventListener('click', closeTableModal);
    cancelTableBtn.addEventListener('click', closeTableModal);

    tableModal.addEventListener('click', function(event) {
        if (event.target === tableModal) {
            closeTableModal();
        }
    });

    // Delete Modal Events
    closeDeleteModalBtn.addEventListener('click', closeDeleteModal);
    cancelDeleteBtn.addEventListener('click', closeDeleteModal);

    deleteModal.addEventListener('click', function(event) {
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    });

    // delete buttons
    deleteTableBtns.forEach(button => {
        button.addEventListener('click', function() {
            const deleteUrl = this.getAttribute('data-delete-url');
            const tableName = this.getAttribute('data-table-name');
            deleteTableForm.action = deleteUrl;
            openDeleteModal();
        });
    });
})