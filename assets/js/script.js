
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



// Items for Sale Data
document.addEventListener('DOMContentLoaded', () => {
    const itemsGrid = document.querySelector('.items-grid');
    const filterContainer = document.querySelector('.items-filter');
    const loadMoreContainer = document.querySelector('.load-more-container');
    loadMoreContainer.className = 'load-more-container text-right mt-3';
    itemsGrid.parentNode.appendChild(loadMoreContainer);

    let allItems = [];
    let categories = new Set();
    let currentFilter = 'all';
    let itemsPerPage = 9;
    let currentPage = 1;

    async function fetchItems() {
        try {
            const response = await fetch('admin/api/fetch_items.php');
            const result = await response.json();
            if (result.success) {
                allItems = result.data;

                // Collect unique categories
                allItems.forEach(item => categories.add(item.category));

                // Render category buttons
                renderCategoryButtons();

                // Show first page of all items
                renderItems(currentFilter, currentPage);
            } else {
                itemsGrid.innerHTML = `<p class="text-danger">Failed to load items.</p>`;
            }
        } catch (error) {
            console.error('Error fetching items:', error);
            itemsGrid.innerHTML = `<p class="text-danger">An error occurred while loading items.</p>`;
        }
    }

    function renderCategoryButtons() {
        filterContainer.innerHTML = `<button class="filter-btn active" data-filter="all">All Items</button>`;
        categories.forEach(cat => {
            const displayName = cat.charAt(0).toUpperCase() + cat.slice(1);
            filterContainer.innerHTML += `<button class="filter-btn" data-filter="${cat}">${displayName}</button>`;
        });

        const filterButtons = filterContainer.querySelectorAll('.filter-btn');
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                currentFilter = button.getAttribute('data-filter');
                currentPage = 1; // Reset page
                renderItems(currentFilter, currentPage);
            });
        });
    }

    function renderItems(filter = 'all', page = 1) {
        itemsGrid.innerHTML = '';
        const filteredItems = filter === 'all'
            ? allItems
            : allItems.filter(item => item.category === filter);

        const startIndex = 0;
        const endIndex = page * itemsPerPage;
        const itemsToShow = filteredItems.slice(0, endIndex);

        itemsToShow.forEach(item => {
            const itemCard = document.createElement('div');
            itemCard.className = 'item-card fade-in';
            itemCard.setAttribute('data-category', item.category);

            // Handle images
            let imageContent = '';
            if (item.images.length > 1) {
                imageContent = `<div class="item-slideshow">`;
                item.images.forEach((img, idx) => {
                    const imagePath = img.image_path.replace('../', 'admin/');
                    imageContent += `<img src="${imagePath}" class="${idx === 0 ? 'active' : ''}" alt="${item.name}" />`;
                });
                imageContent += `</div>`;
            } else if (item.images.length === 1) {
                const imagePath = item.images[0].image_path.replace('../', 'admin/');
                imageContent = `<div class="item-img"><img src="${imagePath}" alt="${item.name}" /></div>`;
            } else {
                imageContent = `<div class="item-img" style="background-color: #f0f0f0;">
                                    <i class="fas fa-box" style="font-size:3rem; color:#ff6b6b;"></i>
                                </div>`;
            }

            const isSold = item.status.toLowerCase() === 'sold';
            const soldOverlay = isSold ? `<div class="sold-overlay">SOLD</div>` : '';
            const buttonDisabled = isSold ? 'disabled style="opacity:0.6; cursor:not-allowed;"' : '';

            itemCard.className = `item-card fade-in ${isSold ? 'sold' : ''}`;

            itemCard.innerHTML = `
                ${imageContent}
                ${soldOverlay}
                <div class="item-content">
                    <h4>${item.name}</h4>
                    <p>${item.description}</p>
                    <div class="item-price">₱${Number(item.price).toLocaleString()}</div>
                    <button class="btn btn-primary inquire-btn" ${buttonDisabled} 
                            onclick="window.open('https://www.facebook.com/ldgadgetpawnshop/', '_blank')">
                        Inquire Now
                    </button>
                </div>
            `;

            itemsGrid.appendChild(itemCard);
        });

        setTimeout(() => {
            document.querySelectorAll('.item-card.fade-in').forEach(card => card.classList.add('visible'));
        }, 100);

        initUIFeatures();

        // Render Load More button
        renderLoadMoreButton(filteredItems.length, endIndex);
    }

    function renderLoadMoreButton(totalItems, shownItems) {
        loadMoreContainer.innerHTML = '';
        if (shownItems < totalItems) {
            const loadBtn = document.createElement('button');
            loadBtn.className = 'btn btn-outline-primary';
            loadBtn.textContent = 'LOAD MORE';
            loadBtn.addEventListener('click', () => {
                currentPage++;
                renderItems(currentFilter, currentPage);
            });
            loadMoreContainer.appendChild(loadBtn);
        }
    }

    // function initSlideshows() {
    //     const slideshows = document.querySelectorAll('.item-slideshow');
    //     slideshows.forEach(slideshow => {
    //         const images = slideshow.querySelectorAll('img');
    //         let currentIndex = 0;
    //         setInterval(() => {
    //             images.forEach(img => img.classList.remove('active'));
    //             currentIndex = (currentIndex + 1) % images.length;
    //             images[currentIndex].classList.add('active');
    //         }, 3000);
    //     });
    // }

    function initImageModal() {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImg');
        const captionText = document.getElementById('modalCaption');
        const closeBtn = modal.querySelector('.close-modal');
        const prevBtn = modal.querySelector('.prev');
        const nextBtn = modal.querySelector('.next');

        let currentImages = [];
        let currentIndex = 0;

        document.querySelectorAll('.item-img img, .item-slideshow img').forEach(img => {
            img.addEventListener('click', (e) => {
                const parentCard = e.target.closest('.item-card');
                currentImages = Array.from(parentCard.querySelectorAll('img'));
                currentIndex = currentImages.indexOf(e.target);
                showModal(currentIndex);
            });
        });

        function showModal(index) {
            modal.style.display = 'block';
            modalImg.src = currentImages[index].src;
            captionText.innerHTML = currentImages[index].alt;
        }

        closeBtn.onclick = () => { modal.style.display = 'none'; }
        nextBtn.onclick = () => {
            currentIndex = (currentIndex + 1) % currentImages.length;
            showModal(currentIndex);
        }
        prevBtn.onclick = () => {
            currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
            showModal(currentIndex);
        }
        modal.onclick = (e) => { if (e.target === modal) modal.style.display = 'none'; }
    }

    function initUIFeatures() {
        // initSlideshows();
        initImageModal();
    }

    fetchItems();
});





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

// FAQ Toggle
document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', () => {
        const answer = question.nextElementSibling;
        const icon = question.querySelector('i');

        // Toggle current FAQ
        answer.classList.toggle('open');
        icon.classList.toggle('fa-chevron-down');
        icon.classList.toggle('fa-chevron-up');

        // Close other FAQs
        document.querySelectorAll('.faq-answer').forEach(otherAnswer => {
            if (otherAnswer !== answer) {
                otherAnswer.classList.remove('open');
                const otherIcon = otherAnswer.previousElementSibling.querySelector('i');
                otherIcon.classList.remove('fa-chevron-up');
                otherIcon.classList.add('fa-chevron-down');
            }
        });
    });
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


// hero section carousel
const carouselContainer = document.getElementById('heroCarouselContainer');
const prev = carouselContainer.querySelector('.prev');
const next = carouselContainer.querySelector('.next');

let slides = [];
let current = 0;

// Fetch ads from admin API
fetch('admin/api/fetch_ads.php')
    .then(res => res.json())
    .then(data => {
        if (!data.success || data.data.length === 0) {
            console.warn('No hero ads found.');
            return;
        }

        // Build slides dynamically
        // Build slides dynamically
        data.data.forEach((ad, index) => {
            const slide = document.createElement('div');
            slide.classList.add('carousel-slide');
            if (index === 0) slide.classList.add('active');

            // full path for image
            const imagePath = ad.image
                ? `admin/assets/${ad.image}`
                : '';

            slide.style.backgroundImage = `url('${imagePath}')`;

            // Carousel content
            const content = document.createElement('div');
            content.classList.add('carousel-content');

            const title = document.createElement('h1');
            title.textContent = ad.title;

            const desc = document.createElement('p');
            desc.textContent = ad.description;

            const buttonsDiv = document.createElement('div');
            buttonsDiv.classList.add('hero-buttons');

            if (index % 2 === 0) {
                // Even slides
                const btn1 = document.createElement('a');
                btn1.classList.add('btn', 'btn-primary');
                btn1.href = '#how-to';
                btn1.textContent = 'Get Started';

                const btn2 = document.createElement('a');
                btn2.classList.add('btn', 'btn-secondary');
                btn2.href = '#items';
                btn2.textContent = 'View Items';

                buttonsDiv.appendChild(btn1);
                buttonsDiv.appendChild(btn2);
            } else {
                // Odd slides
                const btn = document.createElement('a');
                btn.classList.add('btn', 'btn-primary');
                btn.href = '#how-to';
                btn.textContent = 'Pawn Item';

                buttonsDiv.appendChild(btn);
            }

            content.appendChild(title);
            content.appendChild(desc);
            content.appendChild(buttonsDiv);


            slide.appendChild(content);
            carouselContainer.insertBefore(slide, prev); // insert before controls
        });


        // Update slides NodeList
        slides = carouselContainer.querySelectorAll('.carousel-slide');
        setupCarousel();
    })
    .catch(err => console.error('Error fetching hero ads:', err));

function setupCarousel() {
    slides = carouselContainer.querySelectorAll('.carousel-slide');
    if (slides.length === 0) return; // No slides, exit

    const prev = document.querySelector('.prev');
    const next = document.querySelector('.next');

    if (!prev || !next) return; // Controls missing, exit

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
    }

    prev.addEventListener('click', () => {
        current = (current === 0) ? slides.length - 1 : current - 1;
        showSlide(current);
    });

    next.addEventListener('click', () => {
        current = (current === slides.length - 1) ? 0 : current + 1;
        showSlide(current);
    });

    // Auto-slide every 5 seconds
    setInterval(() => {
        current = (current + 1) % slides.length;
        showSlide(current);
    }, 7000);
}

