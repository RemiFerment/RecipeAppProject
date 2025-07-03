const emailInput = document.getElementById('email');
const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

const form = document.querySelector('form');

emailInput.addEventListener('input', () => {
    if (emailRegex.test(emailInput.value)) {
        emailInput.setAttribute('style', 'color:green;font-weight:bold;');
    } else {
        emailInput.setAttribute('style', 'color:red;font-weight:bold;');
    }
});

form.addEventListener('submit', (e) => {
    if (!emailRegex.test(emailInput.value)) {
        e.preventDefault();
        alert('Please enter a valid email address.');
    }
});
