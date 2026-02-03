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
