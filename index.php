<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C-Tree Institute | Future of Education</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="icon" type="image/png" href="logo.png">
</head>

<body>
  <div class="animated-bg">
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
  </div>

  <div style="display: flex; flex-direction: column; min-height: 100vh;">
  <nav class="main-nav">
    <div class="main-nav-container">
      <div class="logo">
        <img src="logo.png" alt="Concept-Tree" title="Concept-Tree" class="brand-logo"/>
      </div>

      <button class="menu-toggle" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
      </button>

      <ul class="nav-menu" id="navMenu">
        <li class="dropdown">
          <a href="#about">About</a>
          <div class="dropdown-content">
            <a href="#about-ct"><span class="dropdown-icon">📖</span> About C-T</a>
            <a href="#vision"><span class="dropdown-icon">🎯</span> Vision | Mission</a>
            <a href="#staff"><span class="dropdown-icon">👥</span> Staff</a>
            
            <a href="#faq"><span class="dropdown-icon">❓</span> FAQ</a>
          </div>
        </li>
        <li class="dropdown">
          <a href="#program">Courses</a>
          <div class="dropdown-content">
            <a href="#" data-course-info="jeeInfoModal"><span class="dropdown-icon">⚡</span> JEE</a>
            <a href="#" data-course-info="neetInfoModal"><span class="dropdown-icon">🏥</span> NEET</a>
            <a href="#" data-course-info="mhtcetInfoModal"><span class="dropdown-icon">📊</span> MHT-CET</a>
            <a href="#" data-course-info="std1112InfoModal"><span class="dropdown-icon">📚</span> 11th & 12th</a>
          </div>
        </li>
        <li><a href="#" onclick="openResultsModal(event)">Results</a></li>
        <li><a href="#" id="openAdmissionModal">Admission</a></li>
        <li><a href="#" onclick="openContactModal(event)">Contact</a></li>
      </ul>
    </div>
  </nav>

  <button class="hamburger-btn" onclick="toggleSidebar()">
    <span></span>
    <span></span>
    <span></span>
  </button>

  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <h3>Menu</h3>
    </div>

    <nav class="sidebar-nav">
      <a href="#home" class="sidebar-link">
        <span class="sidebar-icon">🏠</span>
        <span>Home</span>
      </a>
      
      <a href="#" onclick="openLoginModal(event)" class="sidebar-link">
        <span class="sidebar-icon">🔐</span>
        <span>Login</span>
      </a>
      <a href="#" onclick="openLoginModal(event); showTab('register')" class="sidebar-link">
        <span class="sidebar-icon">📝</span>
        <span>Registration</span>
      </a>
      <a href="#updates" class="sidebar-link">
        <span class="sidebar-icon">🔔</span>
        <span>New Updates</span>
      </a>
    </nav>

    <div class="sidebar-divider"></div>

    <div class="sidebar-settings">
      <h4>Settings</h4>
      <div class="theme-toggle">
        <span class="theme-icon">🌙</span>
        <label class="switch">
          <input type="checkbox" id="themeToggle" onchange="toggleTheme()">
          <span class="slider-toggle"></span>
        </label>
        <span class="theme-icon">☀️</span>
      </div>
      <p class="theme-label">Dark / Light Mode</p>
    </div>
  </div>

  <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

  <div id="loginModal" class="modal">
    <div class="modal-backdrop" onclick="closeLoginModal()"></div>
    <div class="modal-content">
      <button class="close-btn" onclick="closeLoginModal()">
        <span class="close-line"></span>
        <span class="close-line"></span>
      </button>

      <div class="modal-tabs">
        <button class="tab-btn active" onclick="showTab('login')">
          <span>Login</span>
          <div class="tab-glow"></div>
        </button>
        <button class="tab-btn" onclick="showTab('register')">
          <span>Register</span>
          <div class="tab-glow"></div>
        </button>
      </div>

      <div id="loginForm" class="tab-content active">
        <h2>Student Login</h2>
        <form onsubmit="handleLogin(event)">
          <div class="form-group">
            <input type="text" required placeholder=" ">
            <label>Email / Student ID</label>
            <span class="input-border"></span>
          </div>
          <div class="form-group">
            <input type="password" required placeholder=" ">
            <label>Password</label>
            <span class="input-border"></span>
          </div>
          <div class="form-group checkbox-group">
            <input type="checkbox" id="remember">
            <label for="remember">Remember me</label>
          </div>
          <button type="submit" class="btn btn-primary">
            <span class="btn-text">Login</span>
            <span class="btn-glow"></span>
          </button>
          <a href="#" class="forgot-link">Forgot Password?</a>
        </form>
      </div>

      <div id="registerForm" class="tab-content">
        <h2>Student Registration</h2>
        <form onsubmit="handleRegister(event)">
          <div class="form-group">
            <input type="text" required placeholder=" ">
            <label>Full Name</label>
            <span class="input-border"></span>
          </div>
          <div class="form-group">
            <input type="email" required placeholder=" ">
            <label>Email</label>
            <span class="input-border"></span>
          </div>
          <div class="form-group">
            <input type="tel" required placeholder=" " pattern="[0-9]{10}">
            <label>Phone Number</label>
            <span class="input-border"></span>
          </div>
          <div class="form-group">
            <select required>
              <option value="">Select a course</option>
              <option value="jee">JEE Preparation</option>
              <option value="neet">NEET Preparation</option>
              <option value="mhtcet">MHT-CET Preparation</option>
              <option value="11th">11th Standard</option>
              <option value="12th">12th Standard</option>
            </select>
            <label class="select-label">Course</label>
            <span class="input-border"></span>
          </div>
          <div class="form-group">
            <input type="password" required placeholder=" " minlength="6">
            <label>Password</label>
            <span class="input-border"></span>
          </div>
          <div class="form-group">
            <input type="password" required placeholder=" " minlength="6">
            <label>Confirm Password</label>
            <span class="input-border"></span>
          </div>
          <button type="submit" class="btn btn-primary">
            <span class="btn-text">Register</span>
            <span class="btn-glow"></span>
          </button>
        </form>
      </div>
    </div>
  </div>

 <!-- Contact Modal -->
  <div id="contactModal" class="modal">
    <div class="modal-backdrop" onclick="closeContactModal()"></div>
    <div class="modal-content">
      <button class="close-btn" onclick="closeContactModal()">
        <span class="close-line"></span>
        <span class="close-line"></span>
      </button>

      <div id="contactForm" class="tab-content active" style="padding-top: 20px;">
        <h2>Contact Us</h2>

        <!-- Location Map Image -->
        <div class="location-map-container" style="cursor: pointer;" onclick="openGoogleMaps()">
          <img src="location.png" alt="C-T Institute Location" class="location-map-image"
            title="Click to open in Google Maps" style="cursor: pointer;">
          <div class="map-overlay">
            <span class="map-icon">📍</span>
            <p>Click to view on Google Maps</p>
          </div>
        </div>

        <div class="contact-info-modal">
          <p><strong><i class="fas fa-map-marker-alt"></i> Address:</strong> concept-tree, Maharanan Pratap Chowk,
            Maldad Road Sangamner, 422605</p>
          <p><strong><i class="fas fa-phone-alt"></i> Phone:</strong> 9009800848 (Admissions)</p>
          <p><strong><i class="fas fa-envelope"></i> Email:</strong> info@ctreeinstitute.com</p>
          <p><strong><i class="fas fa-clock"></i> Hours:</strong> Mon - Fri: 9:30 AM - 6:30 PM</p>
        </div>

        <form onsubmit="handleContactForm(event)" style="margin-top: 30px;">
          <div class="form-group">
            <input type="text" required placeholder=" ">
            <label>Your Name</label>
            <span class="input-border"></span>
          </div>
          <div class="form-group">
            <input type="email" required placeholder=" ">
            <label>Your Email</label>
            <span class="input-border"></span>
          </div>
          <div class="form-group">
            <input type="text" placeholder=" ">
            <label>Subject</label>
            <span class="input-border"></span>
          </div>
          <div class="form-group">
            <textarea id="contactMessage" class="form-control-textarea" required placeholder=" " rows="4"></textarea>
            <label for="contactMessage" class="textarea-label">Your Message</label>
            <span class="input-border"></span>
          </div>
          <button type="submit" class="btn btn-primary">
            <span class="btn-text">Send Message</span>
            <span class="btn-glow"></span>
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Main content wrapper -->
  <main style="flex: 1;">
    <!-- Hero section -->
    <section class="hero-section" id="home">
      <div class="hero-container">
        <div class="hero-slider">
          <div class="slides-wrapper" id="slidesWrapper">
            <div class="slide-3d active" data-index="0">
              <img src="neet-cet.png" alt="Mathematics">
              <div class="slide-overlay">
                <h3>Excellence in Mathematics</h3>
                <div class="slide-particles"></div>
              </div>
            </div>
            <div class="slide-3d" data-index="1">
              <img src="jee-cet.jpeg" alt="Science">
              <div class="slide-overlay">
                <h3>Advanced Science Labs</h3>
                <div class="slide-particles"></div>
              </div>
            </div>
            <div class="slide-3d" data-index="2">
              <img src="building.jpeg" alt="Success">
              <div class="slide-overlay">
                <h3>Student Success Stories</h3>
                <div class="slide-particles"></div>
              </div>
            </div>
          </div>

          <button class="slider-nav prev" onclick="changeSlide(-1)">
            <svg viewBox="0 0 24 24">
              <path d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <button class="slider-nav next" onclick="changeSlide(1)">
            <svg viewBox="0 0 24 24">
              <path d="M9 5l7 7-7 7" />
            </svg>
          </button>

          <div class="slider-indicators" id="indicators"></div>
        </div>

        <div class="hero-content">
          <h1 class="glitch-text" data-text="Welcome to the Future of Education">
            Welcome to the Future of Education
          </h1>
          <p class="hero-subtitle">Empowering Tomorrow's Leaders Through Innovation</p>

          <div class="features-grid-hero">
            <div class="feature-box" data-delay="0">
              <div class="feature-icon-3d">
                <div class="icon-cube">
                  <div class="cube-face front">📚</div>
                  <div class="cube-face back">📚</div>
                  <div class="cube-face left">📚</div>
                  <div class="cube-face right">📚</div>
                  <div class="cube-face top">📚</div>
                  <div class="cube-face bottom">📚</div>
                </div>
              </div>
              <h3>Expert Faculty</h3>
              <p>IIT/AIIMS Alumni</p>
            </div>
            <div class="feature-box" data-delay="100">
              <div class="feature-icon-3d">
                <div class="icon-cube">
                  <div class="cube-face front">🎯</div>
                  <div class="cube-face back">🎯</div>
                  <div class="cube-face left">🎯</div>
                  <div class="cube-face right">🎯</div>
                  <div class="cube-face top">🎯</div>
                  <div class="cube-face bottom">🎯</div>
                </div>
              </div>
              <h3>Smart Learning</h3>
              <p>AI-Powered Platform</p>
            </div>
            <div class="feature-box" data-delay="200">
              <div class="feature-icon-3d">
                <div class="icon-cube">
                  <div class="cube-face front">🏆</div>
                  <div class="cube-face back">🏆</div>
                  <div class="cube-face left">🏆</div>
                  <div class="cube-face right">🏆</div>
                  <div class="cube-face top">🏆</div>
                  <div class="cube-face bottom">🏆</div>
                </div>
              </div>
              <h3>Top Results</h3>
              <p>95% Success Rate</p>
            </div>
          </div>

          <div class="cta-buttons">
            <button class="btn btn-primary enroll-btn" data-course="General Inquiry">
              <span class="btn-text">Enroll Now</span>
              <span class="btn-glow"></span>
              <span class="btn-particles"></span>
            </button>
            <button class="btn btn-secondary" onclick="openResultsModal()">
              <span class="btn-text">View Results</span>
              <span class="btn-glow"></span>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Updates section -->
    <section class="updates-section" id="updates">
      <div class="container">
        <div class="section-header">
          <span class="section-badge">🔔 Latest</span>
          <h2 class="holographic-text">Updates & Announcements</h2>
        </div>

        <div class="updates-grid">
          <div class="update-card-3d" data-tilt>
            <div class="card-glow"></div>
            <div class="update-badge-new">NEW</div>
            <div class="update-icon-wrapper">
              <div class="icon-orbit">
                <div class="orbit-ring"></div>
                <div class="orbit-ring"></div>
                <span class="icon-center">📢</span>
              </div>
            </div>
            <h3>Admissions Open 2025-26</h3>
            <p>Now accepting applications for JEE, NEET, MHT-CET programs. Limited seats!</p>
            <div class="update-date">Nov 15, 2025</div>
            <a href="#" class="update-link-arrow enroll-btn" data-course="Admissions Open 2025-26">
              Apply Now
              <svg viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7" />
              </svg>
            </a>
          </div>

          <div class="update-card-3d" data-tilt>
            <div class="card-glow"></div>
            <div class="update-icon-wrapper">
              <div class="icon-orbit">
                <div class="orbit-ring"></div>
                <div class="orbit-ring"></div>
                <span class="icon-center">🎓</span>
              </div>
            </div>
            <h3>3-Month Crash Course</h3>
            <p>Intensive program for JEE Main 2026 with daily tests and doubt sessions.</p>
            <div class="update-date">Nov 10, 2025</div>
            <a href="#program" class="update-link-arrow">
              View Details
              <svg viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7" />
              </svg>
            </a>
          </div>

          <div class="update-card-3d" data-tilt>
            <div class="card-glow"></div>
            <div class="update-icon-wrapper">
              <div class="icon-orbit">
                <div class="orbit-ring"></div>
                <div class="orbit-ring"></div>
                <span class="icon-center">💻</span>
              </div>
            </div>
            <h3>Hybrid Learning Mode</h3>
            <p>Flexible options to attend classes online or offline based on convenience.</p>
            <div class="update-date">Nov 5, 2025</div>
            <a href="#information" class="update-link-arrow">
              Learn More
              <svg viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7" />
              </svg>
            </a>
          </div>

          <div class="update-card-3d" data-tilt>
            <div class="card-glow"></div>
            <div class="update-icon-wrapper">
              <div class="icon-orbit">
                <div class="orbit-ring"></div>
                <div class="orbit-ring"></div>
                <span class="icon-center">🎁</span>
              </div>
            </div>
            <h3>Early Bird - 20% OFF</h3>
            <p>Register before Dec 15th for special discount and scholarship opportunities.</p>
            <div class="update-date">Nov 1, 2025</div>
            <a href="#" class="update-link-arrow enroll-btn" data-course="Early Bird - 20% OFF">
              Register Now
              <svg viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7" />
              </svg>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Staff section -->
    <section class="staff-section" id="staff">
      <div class="container">
        <div class="section-header">
          <span class="section-badge">👥 Our Team</span>
          <h2 class="holographic-text">Meet Our Expert Faculty</h2>
          <p>Highly qualified educators dedicated to your success</p>
        </div>

        <div class="staff-grid">
          <div class="staff-card-3d" data-tilt>
            <div class="staff-card-glow"></div>
            <div class="staff-image-wrapper">
              <img src="gaurav-sir.jpeg" alt="Gaurav Khule">
              <div class="staff-overlay">
                <div class="expertise-badge">Physics Expert</div>
              </div>
            </div>
            <div class="staff-info">
              <h3>Gaurav Khule</h3>
              <p class="subject">Physics Specialist</p>
              <div class="staff-details">
                <p><strong>Education:</strong> B.Tech, MBA</p>
                <p><strong>Experience:</strong> 5+ Years</p>
                <p><strong>Specialization:</strong> IIT-JEE, Mechanics & Electromagnetism</p>
              </div>
              <div class="staff-social">
                <a href="#" aria-label="Email"><i class="fas fa-envelope"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="staff-card-3d" data-tilt>
            <div class="staff-card-glow"></div>
            <div class="staff-image-wrapper">
              <img src="dongare-sir.jpeg" alt="Mangesh Dongare">
              <div class="staff-overlay">
                <div class="expertise-badge">Chemistry Expert</div>
              </div>
            </div>
            <div class="staff-info">
              <h3>Mangesh Dongare</h3>
              <p class="subject">Chemistry Specialist</p>
              <div class="staff-details">
                <p><strong>Education:</strong> M.Sc. Chemistry, B.Ed</p>
                <p><strong>Experience:</strong> 12+ Years</p>
                <p><strong>Specialization:</strong> Organic & Inorganic Chemistry</p>
              </div>
              <div class="staff-social">
                <a href="#" aria-label="Email"><i class="fas fa-envelope"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="staff-card-3d" data-tilt>
            <div class="staff-card-glow"></div>
            <div class="staff-image-wrapper">
              <img src="sonavane-sir.jpeg" alt="Tushar Sonawane">
              <div class="staff-overlay">
                <div class="expertise-badge">Mathematics Expert</div>
              </div>
            </div>
            <div class="staff-info">
              <h3>Tushar Sonawane</h3>
              <p class="subject">Mathematics Specialist</p>
              <div class="staff-details">
                <p><strong>Education:</strong> M.Sc. Mathematics</p>
                <p><strong>Experience:</strong> 18+ Years</p>
                <p><strong>Specialization:</strong> Calculus, Algebra & Trigonometry</p>
              </div>
              <div class="staff-social">
                <a href="#" aria-label="Email"><i class="fas fa-envelope"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="staff-card-3d" data-tilt>
            <div class="staff-card-glow"></div>
            <div class="staff-image-wrapper">
              <img src="mayuri-mam.jpeg" alt="Mayuri Dongare">
              <div class="staff-overlay">
                <div class="expertise-badge">Biology Expert</div>
              </div>
            </div>
            <div class="staff-info">
              <h3>Mayuri Dongare</h3>
              <p class="subject">Biology Specialist</p>
              <div class="staff-details">
                <p><strong>Education:</strong> M.Sc. Zoology</p>
                <p><strong>Experience:</strong> 3+ Years</p>
                <p><strong>Specialization:</strong> NEET Biology, Botany & Zoology</p>
              </div>
              <div class="staff-social">
                <a href="#" aria-label="Email"><i class="fas fa-envelope"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer at the bottom -->
  <footer class="footer-futuristic">
    <div class="footer-glow"></div>
    <div class="footer-columns container">
      <div class="footer-col">
        <h4>Courses</h4>
        <ul class="footer-links">
          <li><a href="#program">MHT-CET</a></li>
          <li><a href="#program">JEE</a></li>
          <li><a href="#program">NEET</a></li>
          <li><a href="#program">11th &amp; 12th</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Contact Info</h4>
        <ul class="footer-links">
          <li><i class="fas fa-map-marker-alt"></i> concept-tree institute, Maharana Pratap Chowk, Maldad Road, Sangamner, 422605</li>
          <li><i class="fas fa-phone-alt"></i> 9009800848</li>
          <li><i class="fas fa-envelope"></i> info@example.com</li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Connect With Us</h4>
        <p>Follow our journey on social media.</p>
        <div class="footer-social">
          <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.instagram.com/__concept__tree__?igsh=MXA3YmFsZDI4dXpkZQ==" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2025 Concept Tree. All Rights Reserved. </p>
    </div>
  </footer>

  <script src="script.js"></script>

  <div id="jeeInfoModal" class="modal info-modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>
      <div class="program-icon">🔬</div>
      <h2>JEE (Joint Entrance Examination)</h2>
      <p>Prepare for India's top engineering colleges like IITs and NITs with our comprehensive JEE Main & Advanced coaching program.</p>
      <a href="#" class="btn btn-primary btn-card enroll-btn" data-course="JEE (Joint Entrance Examination)">Enroll Now</a>
    </div>
  </div>

  <div id="neetInfoModal" class="modal info-modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>
      <div class="program-icon">🩺</div>
      <h2>NEET (National Eligibility cum Entrance Test)</h2>
      <p>Achieve your dream of becoming a medical professional. Our expert-led program provides in-depth preparation for the NEET exam.</p>
      <a href="#" class="btn btn-primary btn-card enroll-btn" data-course="NEET (National Eligibility cum Entrance Test)">Enroll Now</a>
    </div>
  </div>

  <div id="aboutModal" class="modal about-modal">
    <div class="modal-content">
      <button class="close-btn" onclick="closeAboutModal()">&times;</button>
      <div class="about-sidebar">
        <a href="#about-ct" class="about-menu-item active">About C-T</a>
        <a href="#vision" class="about-menu-item">Vision | Mission</a>
        <a href="#staff" class="about-menu-item">Staff</a>
        <a href="#faq" class="about-menu-item">FAQ</a>
      </div>
      <div class="about-content">
        
        <div id="about-ct" class="about-section active">
          <h2>About C-T Institute</h2>
          <p>Concept-Tree is a premier coaching institute for JEE, NEET, and MHT-CET, founded by a team of IIT and AIIMS alumni. We are dedicated to providing top-quality education and fostering a learning environment that encourages students to achieve their academic goals.</p>
          <p>Our innovative teaching methods and personalized approach ensure that every student receives the attention and support they need to succeed. With a proven track record of excellent results and student satisfaction, we have become a trusted name in competitive exam preparation.</p>
          <p>We believe in holistic development, combining rigorous academics with personality development and mentoring to prepare students not just for exams, but for life's challenges.</p>
        </div>

        <div id="vision" class="about-section">
          <h2>Vision & Mission</h2>
          <div style="display: grid; gap: 30px;">
            <div>
              <h3>🎯 Our Vision</h3>
              <p>To be a leading educational institution that empowers students to achieve their full potential and become leaders in their chosen fields. We envision a world where every student has access to quality education and the opportunity to pursue their dreams.</p>
            </div>
            <div>
              <h3>🎓 Our Mission</h3>
              <p>To provide a dynamic and supportive learning environment that offers:</p>
              <ul style="list-style: none; padding: 0; margin: 10px 0;">
                <li>✓ High-quality education with expert faculty</li>
                <li>✓ Innovative teaching methodologies</li>
                <li>✓ Personalized attention to every student</li>
                <li>✓ Comprehensive study materials and resources</li>
                <li>✓ Regular assessments and progress tracking</li>
                <li>✓ Mentoring and career guidance</li>
                <li>✓ A culture of excellence and integrity</li>
              </ul>
            </div>
            <div>
              <h3>💡 Our Core Values</h3>
              <ul style="list-style: none; padding: 0;">
                <li><strong>Excellence:</strong> We strive for the highest standards in everything we do</li>
                <li><strong>Integrity:</strong> We maintain honesty and transparency in all dealings</li>
                <li><strong>Empowerment:</strong> We empower students to believe in themselves</li>
                <li><strong>Innovation:</strong> We constantly innovate our teaching methods</li>
                <li><strong>Inclusivity:</strong> We believe every student deserves quality education</li>
              </ul>
            </div>
          </div>
        </div>

        <div id="staff" class="about-section">
          <h2>Our Expert Faculty</h2>
          <div class="staff-container">
            <div class="staff-member">
              <img src="gaurav-sir.jpeg" alt="Dr. Rajesh Kumar">
              <h3>Gaurav Khule sir</h3>
              <p><strong>Subject:</strong> Physics</p>
              <p><strong>Education:</strong> B.Tech,MBA</p>
              <p><strong>Experience:</strong> 5+ Years</p>
            </div>
            <div class="staff-member">
              <img src="dongare-sir.jpeg" alt="Prof. Priya Sharma">
              <h3>Mangesh Dongare Sir</h3>
              <p><strong>Subject:</strong> Chemistry</p>
              <p><strong>Education:</strong> M.Sc. Chemistry,Bed</p>
              <p><strong>Experience:</strong> 12+ Years</p>
            </div>
            <div class="staff-member">
              <img src="sonavane-sir.jpeg" alt="Mr. Vikram Singh">
              <h3>Mr.Tushar Sonawane Sir</h3>
              <p><strong>Subject:</strong> Mathematics</p>
              <p><strong>Education:</strong> Msc Mathematics</p>
              <p><strong>Experience:</strong> 18+ Years</p>
            </div>
            <div class="staff-member">
              <img src="" alt="Dr. Anjali Patel">
              <h3>Mayuri Dongare mam</h3>
              <p><strong>Subject:</strong> Biology</p>
              <p><strong>Education:</strong> Msc zoology</p>
              <p><strong>Experience:</strong> 3+ Years</p>
            </div>
            
          </div>
        </div>

        <div id="faq" class="about-section">
          <h2>Frequently Asked Questions</h2>
          <div style="display: grid; gap: 20px;">
            <div class="faq-item">
              <h3>❓ What courses do you offer?</h3>
              <p>We offer comprehensive coaching for:</p>
              <ul style="list-style: none; padding-left: 10px;">
                <li>• <strong>JEE Main & Advanced</strong> - 1 Year & 2 Year Programs</li>
                <li>• <strong>NEET</strong> - 1 Year & 2 Year Programs</li>
                <li>• <strong>MHT-CET</strong> - Crash & Regular Batches</li>
                <li>• <strong>11th & 12th Science</strong> - Foundation Programs</li>
              </ul>
            </div>
            <div class="faq-item">
              <h3>❓ Who are the faculty members?</h3>
              <p>Our faculty consists of experienced educators and alumni from prestigious institutions like IITs (Indian Institute of Technology) and AIIMS (All India Institute of Medical Sciences). Each faculty member has 10+ years of teaching experience and a proven track record of student success.</p>
            </div>
            <div class="faq-item">
              <h3>❓ Do you provide study materials?</h3>
              <p>Yes! We provide comprehensive study materials including:</p>
              <ul style="list-style: none; padding-left: 10px;">
                <li>• Detailed notes and concept sheets</li>
                <li>• Practice papers and problem sets</li>
                <li>• Mock tests and sample papers</li>
                <li>• Video lectures and online resources</li>
              </ul>
            </div>
            <div class="faq-item">
              <h3>❓ What is the batch size?</h3>
              <p>We maintain small batch sizes (typically 30-40 students per batch) to ensure personalized attention and effective learning. This allows faculty to understand individual student needs and provide targeted help.</p>
            </div>
            <div class="faq-item">
              <h3>❓ Do you offer online classes?</h3>
              <p>Yes! We offer flexible learning options:</p>
              <ul style="list-style: none; padding-left: 10px;">
                <li>• <strong>Offline Classes:</strong> At our institute in Sangamner</li>
                <li>• <strong>Online Classes:</strong> Live interactive sessions via Zoom/Google Meet</li>
                <li>• <strong>Hybrid Mode:</strong> Mix of online and offline classes</li>
                <li>• <strong>Recorded Lectures:</strong> Available for revision anytime</li>
              </ul>
            </div>
            <div class="faq-item">
              <h3>❓ What is your success rate?</h3>
              <p>Our institute has a <strong>95% success rate</strong> in competitive exams. Over 80% of our students get admission to top colleges like IITs, NITs, AIIMS, and top state colleges. Many of our students have secured ranks in the top 500 in various competitive exams.</p>
            </div>
            <div class="faq-item">
              <h3>❓ How are you different from other coaching institutes?</h3>
              <p>What sets us apart:</p>
              <ul style="list-style: none; padding-left: 10px;">
                <li>✓ Expert faculty from IITs and AIIMS</li>
                <li>✓ Small batch sizes for personalized attention</li>
                <li>✓ Regular progress tracking and assessments</li>
                <li>✓ Mentoring and career guidance</li>
                <li>✓ Flexible learning modes (online/offline/hybrid)</li>
                <li>✓ Affordable fees with scholarship options</li>
                <li>✓ Proven track record of results</li>
              </ul>
            </div>
            <div class="faq-item">
              <h3>❓ What is the fee structure?</h3>
              <p>Our fee structure is transparent and competitive:</p>
              <ul style="list-style: none; padding-left: 10px;">
                <li>• JEE/NEET 2-Year: ₹2,00,000 - ₹2,50,000</li>
                <li>• JEE/NEET 1-Year: ₹1,50,000 - ₹1,80,000</li>
                <li>• MHT-CET Crash: ₹50,000 - ₹80,000</li>
                <li>• 11th/12th Foundation: ₹1,00,000 - ₹1,50,000</li>
              </ul>
              <p><em>Scholarships available based on merit and financial need. Early bird discounts up to 20%!</em></p>
            </div>
            <div class="faq-item">
              <h3>❓ How do I enroll?</h3>
              <p>Enrollment is simple:</p>
              <ul style="list-style: none; padding-left: 10px;">
                <li>1. <strong>Click "Enroll Now"</strong> on our website</li>
                <li>2. <strong>Fill the form</strong> with your details</li>
                <li>3. <strong>Take an aptitude test</strong> (optional)</li>
                <li>4. <strong>Meet with our counselor</strong> for guidance</li>
                <li>5. <strong>Complete admission formalities</strong></li>
              </ul>
              <p>Or visit us directly at our center in Sangamner!</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div id="mhtcetInfoModal" class="modal info-modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>
      <div class="program-icon">💻</div>
      <h2>MHT-CET</h2>
      <p>Secure admission to top engineering and pharmacy colleges in Maharashtra with our focused and result-oriented MHT-CET course.</p>
      <a href="#" class="btn btn-primary btn-card enroll-btn" data-course="MHT-CET">Enroll Now</a>
    </div>
  </div>

  <div id="std1112InfoModal" class="modal info-modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>
      <div class="program-icon">📚</div>
      <h2>11th and 12th (Science)</h2>
      <p>Build a strong foundation in Physics, Chemistry, Maths, and Biology for your board exams and competitive tests.</p>
      <a href="#" class="btn btn-primary btn-card enroll-btn" data-course="11th and 12th (Science)">Enroll Now</a>
    </div>
  </div>

  <div id="enrollmentModal" class="modal enroll-modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>
      <h2>Enrollment Form</h2>
      <p>Please fill out the form to enroll for <strong id="modalCourseName"></strong>.</p>

      <form id="enrollmentForm" class="modal-form">
        <input type="hidden" id="modalCourseInput" name="course">
        <div class="form-group">
          <label for="studentName">Full Name:</label>
          <input type="text" id="studentName" name="studentName" required>
        </div>
        <div class="form-group">
          <label for="studentEmail">Email Address:</label>
          <input type="email" id="studentEmail" name="studentEmail" required>
        </div>
        <div class="form-group">
          <label for="studentPhone">Phone Number:</label>
          <input type="tel" id="studentPhone" name="studentPhone" required>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary" style="width: 100%;">Submit Enrollment</button>
        </div>
      </form>
    </div>
  </div>

  <div id="admissionModal" class="modal info-modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>
      <h2>Batch Start Dates 2025-26</h2>
      
      <table class="batch-table">
        <thead>
          <tr>
            <th>Course</th>
            <th>Batch Name</th>
            <th>Start Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>JEE</td>
            <td>Pathfinder Batch (1Y)</td>
            <td>Dec 1, 2025</td>
          </tr>
          <tr>
            <td>JEE</td>
            <td>Apex Batch (2Y)</td>
            <td>Dec 15, 2025</td>
          </tr>
          <tr>
            <td>NEET</td>
            <td>Catalyst Batch (1Y)</td>
            <td>Dec 5, 2025</td>
          </tr>
          <tr>
            <td>NEET</td>
            <td>Aarambh Batch (2Y)</td>
            <td>Dec 20, 2025</td>
          </tr>
          <tr>
            <td>MHT-CET</td>

            <td>Turbo Batch (Crash)</td>
            <td>Jan 10, 2026</td>
          </tr>
          <tr>
            <td>11th Science</td>
            <td>Foundation Batch</td>
            <td>Dec 15, 2025</td>
          </tr>
          <tr>
            <td>12th Science</td>
            <td>Booster Batch</td>
            <td>Dec 1, 2025</td>
          </tr>
        </tbody>
      </table>
      
      <a href="#" class="btn btn-primary btn-card enroll-btn" data-course="General Admission Inquiry" style="margin-top: 20px;">Enroll Now</a>
    </div>
  </div>

  <div id="resultsModal" class="modal info-modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>
      <h2>Student Results</h2>
      <div class="results-grid">
        <div class="result-card">
          <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=200&q=80" alt="Student">
          <div class="result-info">
            <h3>Akash Patil</h3>
            <p class="percentage">95%</p>
            <p class="subjects">PCM • JEE</p>
          </div>
        </div>
        <div class="result-card">
          <img src="https://images.unsplash.com/photo-1547425260-76bcadfb4f2c?w=200&q=80" alt="Student">
          <div class="result-info">
            <h3>Neha Kulkarni</h3>
            <p class="percentage">92%</p>
            <p class="subjects">PCB • NEET</p>
          </div>
        </div>
        <div class="result-card">
          <img src="https://images.unsplash.com/photo-1544005313-ff6b8f1c9c88?w=200&q=80" alt="Student">
          <div class="result-info">
            <h3>Rahul Deshmukh</h3>
            <p class="percentage">89%</p>
            <p class="subjects">PCM • MHT-CET</p>
          </div>
        </div>
        <div class="result-card">
          <img src="https://images.unsplash.com/photo-1545996124-0501ebae84d1?w=200&q=80" alt="Student">
          <div class="result-info">
            <h3>Pooja Shinde</h3>
            <p class="percentage">93%</p>
            <p class="subjects">Science • 12th</p>
          </div>
        </div>
        <div class="result-card">
          <img src="https://images.unsplash.com/photo-1544005313-7fc2a82d50f6?w=200&q=80" alt="Student">
          <div class="result-info">
            <h3>Aman Joshi</h3>
            <p class="percentage">88%</p>
            <p class="subjects">PCM • JEE</p>
          </div>
        </div>
        <div class="result-card">
          <img src="https://images.unsplash.com/photo-1544005313-61f6f92f7cf0?w=200&q=80" alt="Student">
          <div class="result-info">
            <h3>Sneha More</h3>
            <p class="percentage">90%</p>
            <p class="subjects">PCB • NEET</p>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
