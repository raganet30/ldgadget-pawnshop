
// Mobile Menu Toggle
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const navLinks = document.getElementById('navLinks');

mobileMenuBtn.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    mobileMenuBtn.innerHTML = navLinks.classList.contains('active')
        ? '<i class="fas fa-times"></i>'
        : '<i class="fas fa-bars"></i>';
});

// Close mobile menu when clicking a link
document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', () => {
        navLinks.classList.remove('active');
        mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
    });
});

// Header scroll effect
// window.addEventListener('scroll', () => {
//     const header = document.getElementById('header');
//     if (window.scrollY > 50) {
//         header.classList.add('scrolled');
//     } else {
//         header.classList.remove('scrolled');
//     }
// });



// Map initialization
let map;
const branchLocations = {
    main: { lat: 12.068662, lng: 124.594642, name: "Main Branch" }
    // gandara: { lat: 14.6762, lng: 121.0439, name: "Gandara Branch" },
    // catbalogan: { lat: 14.5750, lng: 121.0832, name: "Catbalogan City Branch" }
};

function initMap() {
    // Initialize map centered on Main Branch
    map = L.map('map').setView([branchLocations.main.lat, branchLocations.main.lng], 12);

    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Add markers for each branch
    Object.keys(branchLocations).forEach(key => {
        const branch = branchLocations[key];
        const marker = L.marker([branch.lat, branch.lng]).addTo(map);
        marker.bindPopup(`<b>${branch.name}</b>`);

        // Highlight main branch
        if (key === 'main') {
            marker.openPopup();
        }
    });
}

// Initialize map when page loads
document.addEventListener('DOMContentLoaded', initMap);

// Location card interaction
const locationCards = document.querySelectorAll('.location-card');
locationCards.forEach(card => {
    card.addEventListener('click', () => {
        // Update active card
        locationCards.forEach(c => c.classList.remove('active'));
        card.classList.add('active');

        // Center map on selected location
        const location = card.getAttribute('data-location');
        const coords = branchLocations[location];
        map.setView([coords.lat, coords.lng], 14);
    });
});



// Interest Calculator
const loanAmount = document.getElementById('loanAmount');
const interestRate = document.getElementById('interestRate');
const loanTerm = document.getElementById('loanTerm');
const interestResult = document.getElementById('interestResult');
const totalAmount = document.getElementById('totalAmount');

function calculateInterest() {
    // Get values and convert to numbers
    const amount = parseFloat(loanAmount.value) || 1000;
    const rate = parseFloat(interestRate.value) / 100; // Convert percentage to decimal
    const term = parseFloat(loanTerm.value);

    // Calculate interest: amount × interest rate × number of months
    // Example: 1000 × 0.06 × 1 = 60
    const interest = amount * rate * term;
    const total = amount + interest;

    // Format with proper decimal places and currency symbol
    interestResult.textContent = `₱${interest.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',')}`;
    totalAmount.textContent = `₱${total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',')}`;
}

// Calculate on input change
[loanAmount, interestRate, loanTerm].forEach(input => {
    input.addEventListener('input', calculateInterest);
});

// Initial calculation
calculateInterest();
// Contact Form Submission
const inquiryForm = document.getElementById('inquiryForm');
inquiryForm.addEventListener('submit', function (e) {
    e.preventDefault();

    // Get form values
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;

    // In a real application, you would send this data to a server
    // For this demo, we'll just show an alert
    alert(`Thank you, ${name}! Your inquiry has been submitted. We'll contact you at ${email} soon.`);

    // Reset form
    inquiryForm.reset();
});



// Scroll animations
function checkScroll() {
    const fadeElements = document.querySelectorAll('.fade-in');

    fadeElements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;

        if (elementTop < windowHeight - 100) {
            element.classList.add('visible');
        }
    });
}

// Initial check
checkScroll();

// Check on scroll
window.addEventListener('scroll', checkScroll);

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        const targetId = this.getAttribute('href');
        if (targetId === '#') return;

        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: 'smooth'
            });
        }
    });
});




