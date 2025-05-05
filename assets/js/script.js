/**
    * @description      : 
    * @author           : Schadrack
    * @group            : 
    * @created          : 05/05/2025 - 01:15:16
    * 
    * MODIFICATION LOG
    * - Version         : 1.0.0
    * - Date            : 05/05/2025
    * - Author          : Schadrack
    * - Modification    : 
**/
document.addEventListener('DOMContentLoaded', function() {
    // Calculate total price for stock in/out forms
    const quantityInputs = document.querySelectorAll('input[name="quantity"], input[name="price"]');
    quantityInputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
    });

    function calculateTotal() {
        const form = this.closest('form');
        if (!form) return;

        const quantity = parseFloat(form.querySelector('input[name="quantity"]').value) || 0;
        const price = parseFloat(form.querySelector('input[name="price"]').value) || 0;
        const total = quantity * price;
        
        if (form.querySelector('input[name="total"]')) {
            form.querySelector('input[name="total"]').value = total.toFixed(2);
        }
    }

    // Confirm before deleting
    const deleteButtons = document.querySelectorAll('.btn-danger');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this record?')) {
                e.preventDefault();
            }
        });
    });
});