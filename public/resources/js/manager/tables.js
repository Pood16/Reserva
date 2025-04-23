// Add to public/resources/js/manager/tables.js
document.addEventListener('DOMContentLoaded', function(){
    // Add Table Modal
    const tableModal = document.getElementById('addTableModal');
    const openTableModalBtn = document.getElementById('openTableModal');
    const closeTableModalBtn = document.getElementById('closeTableModal');
    const cancelTableBtn = document.getElementById('cancelTable');

    // Edit Table Modal
    const editTableModal = document.getElementById('editTableModal');
    const closeEditModalBtn = document.getElementById('closeEditModal');
    const cancelEditBtn = document.getElementById('cancelEdit');
    const editTableForm = document.getElementById('editTableForm');
    const editTableBtns = document.querySelectorAll('.edit-table-btn');
    const editTableTitle = document.getElementById('editTableTitle');

    // Delete Modal
    const deleteModal = document.getElementById('deleteTableModal');
    const closeDeleteModalBtn = document.getElementById('closeDeleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDelete');
    const deleteTableForm = document.getElementById('deleteTableForm');
    const deleteTableBtns = document.querySelectorAll('.delete-table-btn');

    // Modal Functions
    function openTableModal() {
        tableModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeTableModal() {
        tableModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openEditModal() {
        editTableModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeEditModal() {
        editTableModal.classList.add('hidden');
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

    // Edit Table Modal Events
    if (closeEditModalBtn && cancelEditBtn) {
        closeEditModalBtn.addEventListener('click', closeEditModal);
        cancelEditBtn.addEventListener('click', closeEditModal);

        editTableModal.addEventListener('click', function(event) {
            if (event.target === editTableModal) {
                closeEditModal();
            }
        });
    }

    // Edit table buttons
    if (editTableBtns.length > 0) {
        editTableBtns.forEach(button => {
            button.addEventListener('click', function() {
                const tableId = this.getAttribute('data-table-id');
                const tableName = this.getAttribute('data-table-name');
                const tableCapacity = this.getAttribute('data-table-capacity');
                const tableLocation = this.getAttribute('data-table-location');
                const tableDescription = this.getAttribute('data-table-description');
                const tableAvailable = this.getAttribute('data-table-available') === 'true';
                const tableActive = this.getAttribute('data-table-active') === 'true';
                const editUrl = this.getAttribute('data-edit-url');

                // Set form action
                editTableForm.action = editUrl;

                // Set form values
                editTableTitle.textContent = tableName;
                document.getElementById('edit_name').value = tableName;
                document.getElementById('edit_capacity').value = tableCapacity;

                // Set the correct location option
                const locationSelect = document.getElementById('edit_location');
                for (let i = 0; i < locationSelect.options.length; i++) {
                    if (locationSelect.options[i].value === tableLocation) {
                        locationSelect.options[i].selected = true;
                        break;
                    }
                }

                document.getElementById('edit_description').value = tableDescription || '';
                document.getElementById('edit_is_available').checked = tableAvailable;
                document.getElementById('edit_is_active').checked = tableActive;

                // Open modal
                openEditModal();
            });
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

                // Set delete form action
                deleteTableForm.action = deleteUrl;

                // Open delete confirmation modal
                openDeleteModal();
            });
        });
    }
});
