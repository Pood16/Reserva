

document.addEventListener('DOMContentLoaded', function() {
    // add Restaurant modal
    const modal = document.getElementById('addRestaurantModal');
    const openButton = document.getElementById('openRestaurantModal');
    const closeButton = document.getElementById('closeRestaurantModal');

    openButton.addEventListener('click', function() {
        modal.classList.remove('hidden');
    });

    closeButton.addEventListener('click', function() {
        modal.classList.add('hidden');
    });

    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });

    const allFoodTypesCheckbox = document.getElementById('all-food-types');
    const foodTypeCheckboxes = document.querySelectorAll('.food-type-checkbox');


    allFoodTypesCheckbox.addEventListener('change', function() {
        foodTypeCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });


    foodTypeCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(foodTypeCheckboxes).every(cb => cb.checked);
            const noneChecked = Array.from(foodTypeCheckboxes).every(cb => !cb.checked);

            if (allChecked) {
                allFoodTypesCheckbox.checked = true;
                allFoodTypesCheckbox.indeterminate = false;
            } else if (noneChecked) {
                allFoodTypesCheckbox.checked = false;
                allFoodTypesCheckbox.indeterminate = false;
            } else {
                allFoodTypesCheckbox.checked = false;
                allFoodTypesCheckbox.indeterminate = true;
            }
        });
    });
});
