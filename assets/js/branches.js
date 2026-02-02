// populate branches info
document.addEventListener('DOMContentLoaded', () => {

    const container = document.getElementById('branchesContainer');

    // Fetch branches from admin API
    fetch('admin/api/fetch_branches.php')
        .then(response => response.json())
        .then(data => {
            container.innerHTML = ''; // clear existing cards if any

            if (data.length === 0) {
                container.innerHTML = '<p>No branches found.</p>';
                return;
            }

            data.forEach((branch, index) => {
                const card = document.createElement('div');
                card.className = 'location-card' + (index === 0 ? ' active' : '');
                card.setAttribute('data-location', branch.name.toLowerCase().replace(/\s+/g, '-'));

                card.innerHTML = `
                    <h4>${branch.name}</h4>
                    <p><i class="fas fa-map-marker-alt"></i> ${branch.address}</p>
                    <p><i class="fas fa-phone"></i> ${branch.contact_no}</p>
                    <p><i class="fas fa-clock"></i> ${branch.schedule}</p>
                `;

                container.appendChild(card);
            });

        })
        .catch(error => {
            console.error('Error fetching branches:', error);
            container.innerHTML = '<p>Failed to load branch locations.</p>';
        });


        

});
