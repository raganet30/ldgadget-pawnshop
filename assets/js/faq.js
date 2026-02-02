// FAQ Toggle
// Fetch FAQs from API and populate
function loadFAQs() {
    $.ajax({
        url: 'admin/api/fetch_faqs.php',
        type: 'GET',
        dataType: 'json',
        success: function (faqs) {
            const container = $('#faqContainer');
            container.empty(); // clear existing items

            faqs.forEach(faq => {
                const faqItem = `
                    <div class="faq-item fade-in">
                        <div class="faq-question">
                            <span>${faq.question}</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>${faq.answer}</p>
                        </div>
                    </div>
                `;
                container.append(faqItem);
            });

            // Re-initialize FAQ toggle
            initFaqToggle();
        },
        error: function () {
            $('#faqContainer').html('<p>Failed to load FAQs. Please try again later.</p>');
        }
    });
}

// FAQ Toggle function
function initFaqToggle() {
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
}

// Call on page load
$(document).ready(function () {
    loadFAQs();
});
