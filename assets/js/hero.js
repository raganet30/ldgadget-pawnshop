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