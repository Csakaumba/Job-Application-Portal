<?php include 'includes/header.php'; ?>

<style>
/* Enhanced color scheme based on blue palette */
:root {
    --primary-blue: #2563eb;
    --secondary-blue: #0284c7;
    --accent-blue: #0ea5e9;
    --success-green: #10b981;
    --warning-amber: #f59e0b;
    --danger-red: #ef4444;
    --light-bg: #f7fafc;
    --lighter-bg: #edf2f7;
}

/* Additional animation keyframes */
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

@keyframes pulse-glow {
    0% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.5); }
    70% { box-shadow: 0 0 0 15px rgba(37, 99, 235, 0); }
    100% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
}

/* Gradient backgrounds */
.hero {
    background: linear-gradient(120deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
    color: white;
    padding: 3em 0;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(37, 99, 235, 0.2);
}

/* Accent decorative elements */
.position-absolute.top-0 {
    width: 300px;
    height: 300px;
    opacity: 0.3;
    background-color: var(--accent-blue) !important;
}

.position-absolute.bottom-0 {
    width: 350px;
    height: 350px;
    opacity: 0.3;
    background-color: var(--primary-blue) !important;
}

.bg-primary {
    background-color: var(--primary-blue) !important;
}

.bg-info {
    background-color: var(--accent-blue) !important;
}

.text-primary {
    color: var(--primary-blue) !important;
}

.text-info {
    color: var(--accent-blue) !important;
}

.text-warning {
    color: var(--warning-amber) !important;
}

/* Animation enhancements */
.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.btn-light:hover {
    background-color: white !important;
}

.btn-outline-primary:hover {
    background-color: var(--primary-blue) !important;
    color: white !important;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.testimonial-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.08) !important;
}

.feature-icon {
    transition: all 0.4s ease;
}

.feature-card:hover .feature-icon {
    transform: scale(1.1);
}

.cta-footer {
    background: linear-gradient(120deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
    box-shadow: 0 -4px 20px rgba(37, 99, 235, 0.15);
}

/* Enhanced card styling */
.card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 12px;
    overflow: hidden;
}

/* Custom badge styling */
.custom-badge {
    background: var(--secondary);
    color: white;
    padding: 0.5em 1em;
    border-radius: 20px;
    font-weight: 500;
    display: inline-block;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    box-shadow: 0 3px 8px rgba(231, 111, 81, 0.3);
}

/* Special section styling */
.wave-section {
    position: relative;
}

.wave-section::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 70px;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,261.3C960,256,1056,224,1152,186.7C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
    background-size: cover;
    background-repeat: no-repeat;
}
</style>

<!-- Hero Section with Modern Gradient Background -->
<section class="bg-gradient-animate position-relative overflow-hidden wave-section">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content animate__animated animate__fadeInUp">
                <span class="custom-badge">Your Career Journey</span>
                <h1 class="display-4 fw-bold text-white mb-4">Find Your <span class="text-warning">Dream Career</span></h1>
                <p class="lead text-white mb-5">Connecting talented professionals with world-class employers. Your next career move starts here with Job Application Portal.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="register.php" class="btn btn-light btn-lg px-4 py-3 rounded-pill shadow fw-bold transition" style="animation: pulse-glow 2s infinite;">
                        <i class="bi bi-person-plus me-2"></i>Get Started
                    </a>
                    <a href="login.php" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill transition">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block animate__animated animate__fadeInRight animate__delay-1s text-center position-relative">
                <div style="position: absolute; top: -20px; right: -20px; background: rgba(244, 162, 97, 0.3); border-radius: 50%; width: 120px; height: 120px; z-index: 1;"></div>
                <img src="assets/img/hero-illustration.svg" alt="Job Application Portal Illustration" class="img-fluid transition" style="animation: float 6s ease-in-out infinite; position: relative; z-index: 2;" 
                     onerror="this.onerror=null; this.src='https://placehold.co/600x400/2a9d8f/white?text=Job+Application+Portal'">
                <div style="position: absolute; bottom: -30px; left: 20px; background: rgba(42, 157, 143, 0.2); border-radius: 50%; width: 100px; height: 100px; z-index: 1;"></div>
            </div>
        </div>
    </div>
    <div class="position-absolute bottom-0 start-0 translate-middle-x translate-middle-y rounded-circle bg-primary bg-opacity-25 d-none d-lg-block"></div>
</section>

<!-- Stats Counter Section -->
<section class="stats bg-white py-5 position-relative overflow-hidden">
    <div class="position-absolute" style="width: 200px; height: 200px; background: rgba(42, 157, 143, 0.1); border-radius: 50%; top: -100px; right: -50px;"></div>
    <div class="position-absolute" style="width: 150px; height: 150px; background: rgba(244, 162, 97, 0.1); border-radius: 50%; bottom: -70px; left: 10%;"></div>
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="custom-badge">Our Impact</span>
            <h2 class="display-5 fw-bold mb-3">Powering Your <span class="text-primary">Career Growth</span></h2>
            <p class="lead text-muted">Join thousands of professionals who have found success with our platform</p>
        </div>
        <div class="row text-center g-4">
            <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up">
                <div class="p-4 rounded-4 shadow-sm bg-primary bg-opacity-10 transition border-top border-5 border-primary">
                    <div class="icon-circle bg-white mb-3 mx-auto">
                        <i class="bi bi-briefcase text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <h3 class="h2 fw-bold" id="jobsCounter">750+</h3>
                    <p class="text-muted">Active Job Listings</p>
                </div>
            </div>
            <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="100">
                <div class="p-4 rounded-4 shadow-sm bg-secondary bg-opacity-10 transition border-top border-5 border-secondary">
                    <div class="icon-circle bg-white mb-3 mx-auto">
                        <i class="bi bi-people text-secondary" style="font-size: 2rem;"></i>
                    </div>
                    <h3 class="h2 fw-bold" id="companiesCounter">350+</h3>
                    <p class="text-muted">Partner Companies</p>
                </div>
            </div>
            <div class="col-md-4" class="animate__animated animate__fadeInUp animate__delay-2s">
                <div class="p-4 rounded-4 shadow-sm bg-primary bg-opacity-10 transition">
                    <i class="bi bi-person-check text-primary mb-3" style="font-size: 2.5rem;"></i>
                    <h3 class="h2 fw-bold" id="hiresCounter">2,500+</h3>
                    <p class="text-muted">Successful Hires</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section with Hover Effects -->
<section class="features py-5 bg-light">
    <div class="container py-4">
        <h2 class="text-center mb-5 display-5 fw-bold animate__animated animate__fadeIn">Why Choose <span class="text-primary">Job Application Portal</span>?</h2>
        <div class="row g-4">
            <div class="col-md-4 animate__animated animate__fadeInUp">
                <div class="card border-0 shadow-sm h-100 feature-card transition">
                    <div class="card-body p-4 text-center">
                        <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 mx-auto mb-4 transition" style="width: 70px; height: 70px;">
                            <i class="bi bi-file-earmark-check" style="font-size: 1.8rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Easy Job Applications</h3>
                        <p class="text-muted">Apply to jobs with just a few clicks and upload your CV securely. Track application status in real-time.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 animate__animated animate__fadeInUp animate__delay-1s">
                <div class="card border-0 shadow-sm h-100 feature-card transition">
                    <div class="card-body p-4 text-center">
                        <div class="feature-icon bg-sky-500 bg-opacity-10 text-info rounded-circle p-3 mx-auto mb-4 transition" style="width: 70px; height: 70px;">
                            <i class="bi bi-building" style="font-size: 1.8rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Employer Dashboard</h3>
                        <p class="text-muted">Post jobs, manage applicants, and streamline your hiring process with our powerful employer dashboard.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" class="animate__animated animate__fadeInUp animate__delay-2s">
                <div class="card border-0 shadow-sm h-100 feature-card transition">
                    <div class="card-body p-4 text-center">
                        <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 mx-auto mb-4 transition" style="width: 70px; height: 70px;">
                            <i class="bi bi-shield-check" style="font-size: 1.8rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Secure & Private</h3>
                        <p class="text-muted">Your data is protected and only visible to relevant employers or applicants. We prioritize your privacy.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Jobs Section (New) -->
<section class="latest-jobs py-5 bg-light">
    <div class="container py-4">
        <h2 class="text-center mb-5 display-5 fw-bold" data-aos="fade-up">Latest <span class="text-primary">Opportunities</span></h2>
        <div class="row g-4">
            <?php
            // Sample job listings - in a real app, these would come from the database
            $jobs = [
                [
                    'title' => 'Senior Web Developer',
                    'company' => 'TechSolutions Ltd',
                    'location' => 'New York, NY',
                    'salary' => '$90,000 - $120,000',
                    'type' => 'Full-time',
                    'icon' => 'bi-code-square'
                ],
                [
                    'title' => 'Marketing Manager',
                    'company' => 'Brand Elevate',
                    'location' => 'Chicago, IL',
                    'salary' => '$75,000 - $95,000',
                    'type' => 'Full-time',
                    'icon' => 'bi-graph-up'
                ],
                [
                    'title' => 'UX/UI Designer',
                    'company' => 'Creative Minds',
                    'location' => 'Remote',
                    'salary' => '$70,000 - $90,000',
                    'type' => 'Contract',
                    'icon' => 'bi-palette'
                ]
            ];
            
            foreach ($jobs as $job): 
            ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="card border-0 shadow-sm job-card h-100 transition">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="badge bg-primary rounded-pill px-3 py-2"><?= $job['type'] ?></span>
                            <i class="bi <?= $job['icon'] ?> text-muted"></i>
                        </div>
                        <h3 class="fw-bold mb-2 h4"><?= $job['title'] ?></h3>
                        <p class="text-muted mb-1"><?= $job['company'] ?></p>
                        <div class="d-flex mb-3">
                            <i class="bi bi-geo-alt text-muted me-2"></i>
                            <p class="text-muted mb-0"><?= $job['location'] ?></p>
                        </div>
                        <p class="fw-bold mb-3"><?= $job['salary'] ?></p>
                        <a href="#" class="btn btn-outline-primary rounded-pill w-100 transition">Apply Now</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="#" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">Browse All Jobs <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials py-5 bg-white">
    <div class="container py-4">
        <h2 class="text-center mb-5 display-5 fw-bold animate__animated animate__fadeIn">What Our Users <span class="text-primary">Say</span></h2>
        <div class="row g-4">
            <div class="col-md-6 animate__animated animate__fadeInLeft">
                <div class="card border-0 shadow-sm testimonial-card p-4 transition">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <span class="text-warning me-1"><i class="bi bi-star-fill"></i></span>
                            <span class="text-warning me-1"><i class="bi bi-star-fill"></i></span>
                            <span class="text-warning me-1"><i class="bi bi-star-fill"></i></span>
                            <span class="text-warning me-1"><i class="bi bi-star-fill"></i></span>
                            <span class="text-warning"><i class="bi bi-star-fill"></i></span>
                        </div>
                        <p class="fs-5 fst-italic mb-4">"Job Application Portal made my job search incredibly efficient. I found and applied to relevant positions in my field and landed my dream job within weeks!"</p>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <span class="fw-bold">A</span>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Alex Johnson</h5>
                                <p class="text-muted mb-0">Software Developer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 animate__animated animate__fadeInRight animate__delay-1s">
                <div class="card border-0 shadow-sm testimonial-card p-4 transition">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <span class="text-warning me-1"><i class="bi bi-star-fill"></i></span>
                            <span class="text-warning me-1"><i class="bi bi-star-fill"></i></span>
                            <span class="text-warning me-1"><i class="bi bi-star-fill"></i></span>
                            <span class="text-warning me-1"><i class="bi bi-star-fill"></i></span>
                            <span class="text-warning"><i class="bi bi-star-fill"></i></span>
                        </div>
                        <p class="fs-5 fst-italic mb-4">"As an employer, Job Application Portal has transformed our hiring process. The analytics dashboard helps us track performance and find quality candidates quickly."</p>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-sky-500 text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <span class="fw-bold">P</span>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Priya Sharma</h5>
                                <p class="text-muted mb-0">HR Manager</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section (New) -->
<section class="newsletter py-5 bg-light">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <h2 class="fw-bold mb-4">Stay Updated with New Opportunities</h2>
                <p class="text-muted mb-4">Subscribe to our newsletter and be the first to know about new job listings and career tips.</p>
                <div class="input-group mb-3 shadow-sm rounded-pill overflow-hidden w-75 mx-auto">
                    <input type="email" class="form-control border-0 py-3 px-4" placeholder="Enter your email address" aria-label="Email address">
                    <button class="btn btn-primary px-4" type="button">Subscribe</button>
                </div>
                <p class="small text-muted mt-3">We respect your privacy. Unsubscribe at any time.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call-to-Action Section -->
<section class="cta-footer py-5 text-white text-center position-relative overflow-hidden">
    <div class="container py-4 position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-8 animate__animated animate__zoomIn">
                <h2 class="display-5 fw-bold mb-4">Ready to boost your career?</h2>
                <p class="lead mb-4">Join thousands of job seekers and employers who trust Job Application Portal.</p>
                <a href="register.php" class="btn btn-light btn-lg px-5 py-3 rounded-pill shadow fw-bold transition" style="animation: pulse-glow 2s infinite;">
                    <i class="bi bi-arrow-right-circle me-2"></i>Join Now
                </a>
            </div>
        </div>
    </div>
    <!-- Decorative elements -->
    <div class="position-absolute top-0 end-0 translate-middle-x translate-middle-y rounded-circle bg-info bg-opacity-25 d-none d-lg-block"></div>
    <div class="position-absolute bottom-0 start-0 translate-middle-x translate-middle-y rounded-circle bg-primary bg-opacity-25 d-none d-lg-block"></div>
</section>

<!-- Add JavaScript for animations -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize countUp.js
        const jobsCounter = new CountUp('jobsCounter', 0, 750, 0, 2.5, {useEasing: true});
        const companiesCounter = new CountUp('companiesCounter', 0, 350, 0, 2.5, {useEasing: true});
        const hiresCounter = new CountUp('hiresCounter', 0, 2500, 0, 2.5, {useEasing: true});
        
        // Start counting when element is in viewport
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    jobsCounter.start();
                    companiesCounter.start();
                    hiresCounter.start();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        // Observe the counters container
        const statsSection = document.querySelector('.stats');
        if (statsSection) {
            observer.observe(statsSection);
        }
        
        // Add scroll animations for the navbar
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.main-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Add scroll animations using Intersection Observer
        const animateElements = document.querySelectorAll('.animate-on-scroll');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__animated');
                    entry.target.classList.add(entry.target.dataset.animation || 'animate__fadeIn');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });
    });
</script>

<?php include 'includes/footer.php'; ?>
