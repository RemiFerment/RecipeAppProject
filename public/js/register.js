const emailInput = document.getElementById('email');
const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

const passwordInput = document.getElementById('password');
const checkPasswordInput = document.getElementById('checkPassword');
const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d])[A-Za-z\d\S]{8,}$/;

const pseudoInput = document.getElementById('username');
const pseudoRegex = /^[a-zA-Z0-9_-]{3,20}$/;

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
        alert('Merci de saisir une adresse e-mail valide.');
    }
    if (!passwordRegex.test(passwordInput.value)) {
        e.preventDefault();
        alert('Merci de saisir un mot de passe valide. Il doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.');
    }
    if (passwordInput.value !== checkPasswordInput.value) {
        e.preventDefault();
        alert('Les mots de passe ne correspondent pas.');
    }
    if (!pseudoRegex.test(pseudoInput.value)) {
        e.preventDefault();
        alert('Merci de saisir un pseudo valide. Il doit contenir entre 3 et 20 caractères, et ne peut contenir que des lettres, des chiffres, des tirets ou des underscores.');
    }
});

passwordInput.addEventListener('input', () => {
    if (passwordRegex.test(passwordInput.value)) {
        passwordInput.setAttribute('style', 'color:green;font-weight:bold;');
    } else {
        passwordInput.setAttribute('style', 'color:red;font-weight:bold;');
    }
});

checkPasswordInput.addEventListener('input', () => {
    if (checkPasswordInput.value === passwordInput.value) {
        checkPasswordInput.setAttribute('style', 'color:green;font-weight:bold;');
    } else {
        checkPasswordInput.setAttribute('style', 'color:red;font-weight:bold;');
    }
});

pseudoInput.addEventListener('input', () => {
    if (pseudoRegex.test(pseudoInput.value)) {
        pseudoInput.setAttribute('style', 'color:green;font-weight:bold;');
    } else {
        pseudoInput.setAttribute('style', 'color:red;font-weight:bold;');
    }
});


