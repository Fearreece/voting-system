// JavaScript code in script.js

// Function to redirect to the student page
function redirectToStudentPage() {
    window.location.href = './student';
}

// Function to redirect to the registrar page
function redirectToRegistrarPage() {
    window.location.href = './registrar/index.php';
}

// Function to animate the welcome message and options
function animateWelcomeAndOptions() {
    const welcomeContainer = document.querySelector('.welcome-container');
    const optionsContainer = document.querySelector('.options-container');
    
    welcomeContainer.classList.add('animate-fadeIn');
    optionsContainer.classList.add('animate-slideIn');
}

// Trigger animations when the page is loaded
document.addEventListener('DOMContentLoaded', function() {
    animateWelcomeAndOptions();
});

// Event listeners for option buttons
document.getElementById('studentBtn').addEventListener('click', redirectToStudentPage);
document.getElementById('registrarBtn').addEventListener('click', redirectToRegistrarPage);
