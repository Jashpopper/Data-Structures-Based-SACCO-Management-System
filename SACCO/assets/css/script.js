// Basic form validation
document.addEventListener('DOMContentLoaded', function() {
    // Get deposit and withdrawal forms if they exist
    const depositForm = document.querySelector('form[action="deposit.php"]');
    const withdrawalForm = document.querySelector('form[action="withdraw.php"]');
    
    // Add validation to deposit form
    if (depositForm) {
        depositForm.addEventListener('submit', function(e) {
            const amount = parseFloat(document.getElementById('amount').value);
            if (isNaN(amount) || amount <= 0) {
                e.preventDefault();
                alert('Please enter a valid amount greater than zero.');
            }
        });
    }
    
    // Add validation to withdrawal form
    if (withdrawalForm) {
        withdrawalForm.addEventListener('submit', function(e) {
            const amount = parseFloat(document.getElementById('amount').value);
            const balance = parseFloat(document.getElementById('amount').getAttribute('max'));
            if (isNaN(amount) || amount <= 0) {
                e.preventDefault();
                alert('Please enter a valid amount greater than zero.');
            } else if (amount > balance) {
                e.preventDefault();
                alert('Withdrawal amount cannot exceed your current balance of UGX ' + balance.toFixed(2));
            }
        });
    }
    
    // Date range validation for statement page
    const statementForm = document.querySelector('form[action="statement.php"]');
    if (statementForm) {
        statementForm.addEventListener('submit', function(e) {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            
            if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                e.preventDefault();
                alert('Start date cannot be after end date.');
            }
        });
    }
});
