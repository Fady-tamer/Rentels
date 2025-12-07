let loginForm = document.querySelector('.login');
let signUpForm = document.querySelector('.signUp');

function toggleForms() {
    if (loginForm.classList.contains('active')) {
        loginForm.classList.remove('active');
        loginForm.classList.add('hidden');
        signUpForm.classList.add('active');
        signUpForm.classList.remove('hidden');
    } else {
        loginForm.classList.add('active');
        loginForm.classList.remove('hidden');
        signUpForm.classList.add('hidden');
        signUpForm.classList.remove('active');
    }
}

document.querySelectorAll('.toggleLink').forEach(link => {
    link.addEventListener('click', toggleForms);
});