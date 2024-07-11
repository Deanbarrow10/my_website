// assets/js/main.js

// Add event listener for form submission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(event) {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const message = document.getElementById('message').value.trim();

        if (!name || !email || !message) {
            event.preventDefault();
            alert('Please fill out all fields.');
        } else if (!validateEmail(email)) {
            event.preventDefault();
            alert('Please enter a valid email address.');
        }
    });
});

// Basic email validation function
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}