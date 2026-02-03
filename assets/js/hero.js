// hero section carousel
const carouselContainer = document.getElementById('heroCarouselContainer');
const prev = document.querySelector('.prev');
const next = document.querySelector('.next');

let slides = [];
let current = 0;
let slideInterval;

// Fetch ads from admin API
fetch('admin/api/fetch_ads.php')
    .then(res => res.json())
    .then(data => {
        if (!data.success || data.data.length === 0) {
            console.warn('No hero ads found.');
            return;
        }

        // Build slides dynamically
        data.data.forEach((ad, index) => {
            const slide = document.createElement('div');
            slide.classList.add('carousel-slide');
            slide.setAttribute('data-slide-index', index);
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
            carouselContainer.appendChild(slide);
        });

        // Update slides NodeList
        slides = carouselContainer.querySelectorAll('.carousel-slide');
        
        // Create dots container
        createDots();
        
        // Setup carousel functionality
        setupCarousel();
    })
    .catch(err => console.error('Error fetching hero ads:', err));

// Create dot indicators
function createDots() {
    // Remove existing dots if any
    const existingDots = document.querySelector('.carousel-controls');
    if (existingDots) {
        existingDots.remove();
    }
    
    // Create dots container
    const dotsContainer = document.createElement('div');
    dotsContainer.classList.add('carousel-controls');
    
    // Create a dot for each slide
    slides.forEach((_, index) => {
        const dot = document.createElement('span');
        dot.classList.add('dot');
        dot.setAttribute('data-slide-index', index);
        
        // Add active class to first dot
        if (index === 0) {
            dot.classList.add('active');
        }
        
        // Add click event
        dot.addEventListener('click', () => {
            goToSlide(index);
        });
        
        dotsContainer.appendChild(dot);
    });
    
    // Add dots container after carousel
    carouselContainer.parentNode.insertBefore(dotsContainer, carouselContainer.nextSibling);
}

// Update active dot
function updateActiveDot() {
    const dots = document.querySelectorAll('.dot');
    dots.forEach((dot, index) => {
        if (index === current) {
            dot.classList.add('active');
        } else {
            dot.classList.remove('active');
        }
    });
}

// Navigate to specific slide
function goToSlide(index) {
    current = index;
    showSlide(current);
    resetAutoSlide();
}

// Show specific slide
function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.toggle('active', i === index);
    });
    updateActiveDot();
}

// Reset auto-slide timer
function resetAutoSlide() {
    clearInterval(slideInterval);
    startAutoSlide();
}

// Start auto-slide
function startAutoSlide() {
    slideInterval = setInterval(() => {
        current = (current + 1) % slides.length;
        showSlide(current);
    }, 7000);
}

// Setup carousel with controls
function setupCarousel() {
    if (slides.length === 0) return; // No slides, exit

    // If you want to keep arrow buttons (optional - remove if not needed)
    if (prev && next) {
        prev.addEventListener('click', () => {
            current = (current === 0) ? slides.length - 1 : current - 1;
            showSlide(current);
            resetAutoSlide();
        });

        next.addEventListener('click', () => {
            current = (current === slides.length - 1) ? 0 : current + 1;
            showSlide(current);
            resetAutoSlide();
        });
    }

    // Start auto-slide
    startAutoSlide();
    
    // Optional: Pause auto-slide on hover
    carouselContainer.addEventListener('mouseenter', () => {
        clearInterval(slideInterval);
    });
    
    carouselContainer.addEventListener('mouseleave', () => {
        startAutoSlide();
    });
    
    // Optional: Pause auto-slide on touch devices
    carouselContainer.addEventListener('touchstart', () => {
        clearInterval(slideInterval);
    });
    
    carouselContainer.addEventListener('touchend', () => {
        setTimeout(startAutoSlide, 3000); // Resume after 3 seconds
    });
}