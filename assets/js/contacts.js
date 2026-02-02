document.addEventListener('DOMContentLoaded', () => {

    const container = document.getElementById('branchesContactContainer');

    fetch('admin/api/fetch_branches.php')
        .then(response => response.json())
        .then(data => {
            container.innerHTML = ''; // clear existing content

            if (data.length === 0) {
                container.innerHTML = '<p>No branch contact info available.</p>';
                return;
            }

            // Collect all phones and emails
            let phones = [];
            let emails = [];

            data.forEach(branch => {
                if (branch.contact_no) phones.push(branch.contact_no);
                if (branch.email) emails.push(branch.email);
            });

            // Remove duplicates
            phones = [...new Set(phones)];
            emails = [...new Set(emails)];

            // Create phone contact item
            const phoneItem = document.createElement('div');
            phoneItem.className = 'contact-item';
            phoneItem.innerHTML = `
                <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div>
                    <h4>Phone Number</h4>
                    ${phones.map(p => `<p>${p}</p>`).join('')}
                </div>
            `;
            container.appendChild(phoneItem);

            // Create email contact item
            const emailItem = document.createElement('div');
            emailItem.className = 'contact-item';
            emailItem.innerHTML = `
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <h4>Email Address</h4>
                    ${emails.map(e => `<p>${e}</p>`).join('')}
                </div>
            `;
            container.appendChild(emailItem);

        })
        .catch(error => {
            console.error('Error fetching branch contacts:', error);
            container.innerHTML = '<p>Failed to load contact info.</p>';
        });

});
