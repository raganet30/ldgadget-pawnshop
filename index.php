<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LD Gadget Pawnshop | Fast, Safe & Affordable Pawning</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />



    <link rel="stylesheet" href="assets/css/style.css?v=<?= filemtime(__DIR__ . '/assets/css/style.css') ?>" />
    <link rel="icon" type="image/png" href="assets/images/pawnshop.png">
    <!-- keywords -->
    <meta name="keywords"
        content="gadget pawnshop, electronics pawning, low interest pawnshop, fast cash pawnshop, gadget loans, motorcycle pawning, affordable pawnshop, secure pawnshop, flexible pawn terms, gadget appraisal, quick cash loans, pawnshop services, gadget resale, motorcycle loans, gadget collateral">

</head>

<body>
    <!-- Header -->
    <header id="header">
        <div class="container">
            <nav class="navbar">
                <a href="#" class="logo"><i class="fas fa-store-alt"></i> LD Gadget Pawnshop</a>
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="nav-links" id="navLinks">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#rates">Rates</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#how-to">How to Pawn</a></li>
                    <li><a href="#items">Items</a></li>
                    <li><a href="#locations">Locations</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-carousel" id="home">
        <div class="carousel-container" id="heroCarouselContainer">
            <!-- Slides will be inserted here -->
        </div>

        <!-- Carousel Controls -->
        <div class="carousel-controls">
            <span class="prev">&#10094;</span>
            <span class="next">&#10095;</span>
        </div>
    </section>



    <!-- Interest Rates Section -->
    <section class="interest-rates" id="rates">
        <div class="container">
            <div class="section-title">
                <h2>Low Interest Rates</h2>
            </div>
            <div class="rate-cards">
                <div class="rate-card gadget fade-in">
                    <div class="rate-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Gadgets & Electronics</h3>
                    <div class="rate-percent">6<span>%</span></div>
                    <p>Cellphones, laptops, tablets, cameras, and other electronics</p>
                </div>
                <div class="rate-card motorcycle fade-in">
                    <div class="rate-icon">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <h3>Motorcycles</h3>
                    <div class="rate-percent">8<span>%</span></div>
                    <p>All motorcycle brands and models with complete OR/CR</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="container">
            <div class="section-title">
                <h2>Our Services</h2>
            </div>
            <div class="services-grid">
                <div class="service-card fade-in">
                    <div class="service-icon">
                        <i class="fas fa-search-dollar"></i>
                    </div>
                    <h3>Item Evaluation</h3>
                    <p>We provide fair and accurate appraisal of your items based on current market value.</p>
                </div>
                <div class="service-card fade-in">
                    <div class="service-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h3>Fast Cash Release</h3>
                    <p>Receive your cash immediately after approval of your pawn application.</p>
                </div>
                <div class="service-card fade-in">
                    <div class="service-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3>Flexible Terms</h3>
                    <p>Choose from various payment options and renewal terms that suit your needs.</p>
                </div>
                <div class="service-card fade-in">
                    <div class="service-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Secure Storage</h3>
                    <p>Your items are kept in secure storage while in our possession.</p>
                </div>
                <!-- E-wallet Cashin/Cashout Services -->
                <div class="service-card fade-in">
                    <div class="service-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h3>E-Wallet Cashin/Cashout</h3>
                    <p>Conveniently cash in or cash out using e-wallet(e.g. GCash, Maya) in our shop.</p>
                </div>
                <!-- also accept Load, bills payment, send money -->
                <div class="service-card fade-in">
                    <div class="service-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3>Load, Bills Payment & Send Money</h3>
                    <p>We also accept mobile load top-ups, bills payment, and money remittance services.</p>
                </div>
    </section>

    <!-- How to Pawn Section -->
    <section class="how-to-pawn" id="how-to">
        <div class="container">
            <div class="section-title">
                <h2>How to Pawn an Item</h2>
            </div>
            <div class="steps-container">
                <div class="step fade-in">
                    <div class="step-number">1</div>
                    <h4>Bring Item for Evaluation</h4>
                    <p>Visit any branch with the item you want to pawn for free appraisal.</p>
                </div>
                <div class="step fade-in">
                    <div class="step-number">2</div>
                    <h4>Present Valid ID</h4>
                    <p>Bring any government-issued ID for verification (e.g., driver's license, passport).</p>
                </div>
                <div class="step fade-in">
                    <div class="step-number">3</div>
                    <h4>Provide Required Documents</h4>
                    <p>For gadgets: receipt if available. For motorcycles: OR/CR and valid ID.</p>
                </div>
                <div class="step fade-in">
                    <div class="step-number">4</div>
                    <h4>Receive Cash</h4>
                    <p>Get your cash immediately after approval and signing of agreement.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Items Section -->
    <section class="items-for-sale" id="items">
        <div class="container">
            <div class="section-title">
                <h2>Subasta Items</h2>
            </div>
            <div class="items-filter">
                <!-- Category buttons will be generated dynamically -->
            </div>
            <div class="items-grid">
                <!-- Items will be dynamically generated with JavaScript -->
            </div>
            <!-- Load More Button Container -->
            <div class="load-more-container"></div>
        </div>
    </section>
    <!-- Image Zoom Modal -->
    <div id="imageModal" class="image-modal">
        <span class="close-modal">&times;</span>
        <img class="modal-content" id="modalImg">
        <div id="modalCaption"></div>
        <a class="prev">&#10094;</a>
        <a class="next">&#10095;</a>
    </div>

    <!-- Branch Locations Section -->
    <section class="branch-locations" id="locations">
        <div class="container">
            <div class="section-title">
                <h2>Our Branch Locations</h2>
            </div>
            <div class="locations-container">
                <div class="location-info">
                    <div class="location-card active" data-location="main">
                        <h4>Main Branch</h4>
                        <p><i class="fas fa-map-marker-alt"></i> Navarro St. cor. Umbria St., Calbayog City, Samar</p>
                        <p><i class="fas fa-phone"></i> (02) 8123-4567</p>
                        <p><i class="fas fa-clock"></i> Mon-Sat: 9:00 AM - 6:00 PM</p>
                    </div>
                    <div class="location-card" data-location="gandara">
                        <h4>Gandara Branch</h4>
                        <p><i class="fas fa-map-marker-alt"></i>Gandara, Samar</p>
                        <p><i class="fas fa-phone"></i> (02) 8987-6543</p>
                        <p><i class="fas fa-clock"></i> Mon-Sat: 9:00 AM - 6:00 PM</p>
                    </div>
                    <div class="location-card" data-location="catbalogan">
                        <h4>Catbalogan City Branch</h4>
                        <p><i class="fas fa-map-marker-alt"></i>Catbalogan City, Samar</p>
                        <p><i class="fas fa-phone"></i> (02) 8654-3210</p>
                        <p><i class="fas fa-clock"></i> Mon-Sat: 9:00 AM - 6:00 PM</p>
                    </div>
                </div>
                <div class="location-map">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <div class="section-title">
                <h2>Contact Us</h2>
            </div>
            <div class="contact-container">
                <div class="contact-form fade-in">
                    <form id="inquiryForm">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
                <div class="contact-info fade-in">
                    <div class="contact-details">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h4>Phone Number</h4>
                                <p>(02) 8123-4567</p>
                                <p>Globe: 0917-123-4567</p>
                                <p>Smart: 0918-987-6543</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h4>Email Address</h4>
                                <p>info@ldgadgetpawnshop.com</p>
                                <p>sales@gadgetpawnshop.com</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4>Main Office</h4>
                                <p>Navarro St. cor. Umbria St., Calbayog City, Samar</p>
                                <p>Metro Manila, Philippines 1200</p>
                            </div>
                        </div>
                    </div>
                    <div class="business-hours">
                        <h4>Business Hours</h4>
                        <table class="hours-table">
                            <tr>
                                <td>Monday - Saturday</td>
                                <td>9:00 AM - 6:00 PM</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-title">
                <h2>Frequently Asked Questions</h2>
            </div>
            <div class="faq-container">
                <div class="faq-item fade-in">
                    <div class="faq-question">
                        <span>What happens if I can't redeem my item on time?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>We offer a grace period of 30 days after the redemption date. If you're unable to redeem
                            within this period, you may apply for a renewal by paying the interest. If not renewed, the
                            item will be forfeited and made available for sale.</p>
                    </div>
                </div>
                <div class="faq-item fade-in">
                    <div class="faq-question">
                        <span>Do you accept items without receipts?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, we accept items without receipts. However, having the original receipt may result in a
                            higher appraisal value. For gadgets, we conduct thorough testing to determine functionality
                            and value.</p>
                    </div>
                </div>
                <div class="faq-item fade-in">
                    <div class="faq-question">
                        <span>How do you determine the value of my item?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Our expert appraisers consider several factors: current market value, brand, model,
                            condition, age, functionality, and demand. We use up-to-date pricing guides and market
                            analysis to ensure fair valuation.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interest Calculator Section -->
    <section class="calculator-section">
        <div class="container">
            <div class="section-title">
                <h2>Interest Calculator</h2>
            </div>
            <div class="calculator fade-in">
                <p>Calculate how much you'll need to pay to redeem your pawned item:</p>
                <div class="calculator-inputs">
                    <div class="form-group">
                        <label for="loanAmount">Loan Amount (₱)</label>
                        <input type="number" id="loanAmount" class="form-control" value="1000" min="500" max="1000000">
                    </div>
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (%)</label>
                        <select id="interestRate" class="form-control">
                            <option value="6">Gadgets & Electronics - 6%</option>
                            <option value="8">Motorcycles - 8%</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="loanTerm">Loan Term (months)</label>
                        <select id="loanTerm" class="form-control">
                            <option value="1" selected>1 month</option>
                            <option value="3">3 months</option>
                            <option value="6">6 months</option>
                        </select>
                    </div>
                </div>
                <div class="calculator-result">
                    <p>Total Interest Payable:</p>
                    <div class="result-value" id="interestResult">₱1,000.00</div>
                    <p>Total Redemption Amount: <strong id="totalAmount">₱1,060.00</strong></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Gadget Pawnshop</h3>
                    <p>Your trusted partner for fast, safe, and affordable pawning services since 2025. We provide the
                        lowest interest rates with flexible terms.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#rates">Interest Rates</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#how-to">How to Pawn</a></li>
                        <li><a href="#items">Items</a></li>
                        <li><a href="#locations">Branch Locations</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contact Info</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> Navarro St. cor. Umbria St., Calbayog City, Samar</li>
                        <li><i class="fas fa-phone"></i> (02) 8123-4567</li>
                        <li><i class="fas fa-envelope"></i> info@ldgadgetpawnshop.com</li>
                        <li><i class="fas fa-clock"></i> Mon-Sat: 9:00 AM - 7:00 PM</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2026 LD Gadget Pawnshop. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="assets/js/script.js?v=<?= filemtime(__DIR__ . '/assets/js/script.js') ?>"></script>
</body>

</html>