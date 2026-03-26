// ========================================
// Futuristic Educational Institute - JavaScript
// ========================================

// Global Variables
let currentSlide = 0;
const slides = document.querySelectorAll('.slide-3d');
const totalSlides = slides.length;

// ========================================
// INITIALIZATION
// ========================================

document.addEventListener('DOMContentLoaded', function() {
  initSlider();
  initTiltEffect();
  initParticles();
  initScrollAnimations();
  initSmoothScroll();
  createFloatingElements();

  // ====================================================== //
  // === COURSE & ENROLLMENT MODAL LOGIC (MOVED HERE) === //
  // ====================================================== //

  // --- Enrollment Modal Elements & Functions ---
  const enrollModal = document.getElementById('enrollmentModal');
  const modalCourseName = document.getElementById('modalCourseName');
  const modalCourseInput = document.getElementById('modalCourseInput');
  const enrollForm = document.getElementById('enrollmentForm');
  const enrollButtons = document.querySelectorAll('.enroll-btn');
  
  // --- ADDED: Admission Modal Elements ---
  const admissionModal = document.getElementById('admissionModal');
  const admissionModalTrigger = document.getElementById('openAdmissionModal');

  // Function to open the ENROLLMENT modal
  function openEnrollModal(courseName) {
      if (enrollModal) {
          modalCourseName.textContent = courseName;
          modalCourseInput.value = courseName;
          enrollModal.style.display = 'flex';
      }
  }

  // Function to close the ENROLLMENT modal
  function closeEnrollModal() {
      if (enrollModal) {
          enrollModal.style.display = 'none';
      }
  }

  // --- Program Info Modal Elements & Functions ---
  const infoModalTriggers = document.querySelectorAll('.dropdown-content a[data-course-info]');

  // Add click listeners to "Program" dropdown links
  infoModalTriggers.forEach(trigger => {
      trigger.addEventListener('click', function(e) {
          e.preventDefault();
          const modalId = this.getAttribute('data-course-info');
          const modal = document.getElementById(modalId);
          
          if (modal) {
              modal.style.display = 'flex';
          }
          
          // Also close mobile menu if it's open
          const navMenu = document.getElementById('navMenu');
          if (navMenu && navMenu.classList.contains('active')) {
              toggleMenu(); // Use the main animated toggle function
          }
      });
  });
  
  // --- ADDED: Admission Modal Trigger Listener ---
  if (admissionModalTrigger && admissionModal) {
    admissionModalTrigger.addEventListener('click', function(e) {
      e.preventDefault();
      admissionModal.style.display = 'flex';
    });
  }

  // --- ADDED: About Modal Trigger Listener ---
  const aboutLink = document.querySelector('a[href="#about-ct"]');
  if (aboutLink) {
    aboutLink.addEventListener('click', function(e) {
      e.preventDefault();
      const aboutModal = document.getElementById('aboutModal');
      if (aboutModal) {
        aboutModal.style.display = 'flex';
      }
      
      // Close mobile menu if it's open
      const navMenu = document.getElementById('navMenu');
      if (navMenu && navMenu.classList.contains('active')) {
        toggleMenu();
      }
    });
  }

  // --- ADDED: About Modal Tab Navigation ---
  const aboutMenuItems = document.querySelectorAll('.about-menu-item');
  aboutMenuItems.forEach(item => {
    item.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Remove active class from all items
      aboutMenuItems.forEach(i => i.classList.remove('active'));
      // Add active class to clicked item
      this.classList.add('active');
      
      // Hide all sections
      const sections = document.querySelectorAll('.about-section');
      sections.forEach(section => section.classList.remove('active'));
      
      // Show selected section
      const sectionId = this.getAttribute('href');
      const activeSection = document.querySelector(sectionId);
      if (activeSection) {
        activeSection.classList.add('active');
      }
    });
  });

  // --- Universal Modal Event Listeners ---

  // Add click listeners to ALL "Enroll Now" buttons
  enrollButtons.forEach(button => {
      button.addEventListener('click', function(e) {
          e.preventDefault(); 
          const course = this.getAttribute('data-course');
          
          // NEW: Check if this button is INSIDE another modal and close it
          const parentModal = this.closest('.modal');
          if (parentModal) {
              parentModal.style.display = 'none';
          }
          
          openEnrollModal(course); // Open the enrollment form
      });
  });

  // Add click listeners to ALL modal (X) close buttons
  // This was the problem: This query now runs AFTER the DOM is loaded
  const allCloseButtons = document.querySelectorAll('.info-modal .close-btn, .enroll-modal .close-btn, .about-modal .close-btn');
  allCloseButtons.forEach(btn => {
      btn.addEventListener('click', function() {
          // Find the closest parent modal and close it
          this.closest('.modal').style.display = 'none';
          document.body.style.overflow = 'auto';
      });
  });

  // Add click listener to the window (to close modal by clicking overlay)
  window.addEventListener('click', function(event) {
      // MODIFICATION: Scoped to .info-modal and .enroll-modal to avoid conflict
      if (event.target.classList.contains('info-modal') || event.target.classList.contains('enroll-modal')) {
          event.target.style.display = 'none';
          document.body.style.overflow = 'auto';
      }
  });

  // Handle the enrollment form submission
  if (enrollForm) {
      enrollForm.addEventListener('submit', function(e) {
          e.preventDefault(); 
          const name = document.getElementById('studentName').value;
          const course = modalCourseInput.value;
          
          // MODIFICATION: Use the main file's notification system instead of alert()
          createSuccessNotification(`Thank you, ${name}! Your enrollment for ${course} was received.`);
          
          closeEnrollModal();
          enrollForm.reset();
      });
  }

  // ***** MOVED CODE ENDS HERE *****

  // This block for the main buttons was also in the original DOMContentLoaded
  const buttons = document.querySelectorAll('.btn-primary');
  buttons.forEach(btn => {
    btn.addEventListener('mouseenter', function() {
      createButtonParticles(this);
    });
  });

  // This block for the theme was also in the original DOMContentLoaded
  const savedTheme = localStorage.getItem('theme');
  if (savedTheme === 'light') {
    document.body.classList.add('light-mode');
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
      themeToggle.checked = true;
    }
  }
  
  // This block for the sidebar links was also in the original DOMContentLoaded
  document.querySelectorAll('.sidebar-link').forEach(link => {
    link.addEventListener('click', () => {
      if (!link.hasAttribute('onclick') || link.getAttribute('href') !== '#') {
        toggleSidebar();
      }
    });
  });
  
  // This block for the sidebar overlay was also in the original DOMContentLoaded
  const sidebarOverlay = document.getElementById('sidebarOverlay');
  if (sidebarOverlay) {
    sidebarOverlay.addEventListener('click', toggleSidebar);
  }
  
});

// ========================================
// 3D SLIDER FUNCTIONALITY
// ========================================

function initSlider() {
  // Create indicators
  const indicatorsContainer = document.getElementById('indicators');
  if (indicatorsContainer) {
    for (let i = 0; i < totalSlides; i++) {
      const indicator = document.createElement('div');
      indicator.className = 'indicator';
      if (i === 0) indicator.classList.add('active');
      indicator.addEventListener('click', () => goToSlide(i));
      indicatorsContainer.appendChild(indicator);
    }
  }

  // Auto-slide every 5 seconds
  setInterval(() => {
    changeSlide(1);
  }, 5000);
}

function changeSlide(direction) {
  const currentSlideEl = slides[currentSlide];
  currentSlideEl.classList.remove('active');

  currentSlide += direction;
  if (currentSlide >= totalSlides) currentSlide = 0;
  if (currentSlide < 0) currentSlide = totalSlides - 1;

  const nextSlideEl = slides[currentSlide];
  nextSlideEl.classList.add('active');

  updateIndicators();
  createSlideParticles(nextSlideEl);
}

function goToSlide(index) {
  slides[currentSlide].classList.remove('active');
  currentSlide = index;
  slides[currentSlide].classList.add('active');
  updateIndicators();
}

function updateIndicators() {
  const indicators = document.querySelectorAll('.indicator');
  indicators.forEach((indicator, index) => {
    indicator.classList.toggle('active', index === currentSlide);
  });
}

// ========================================
// PARTICLE EFFECTS
// ========================================

function createSlideParticles(slideElement) {
  const overlay = slideElement.querySelector('.slide-overlay');
  if (!overlay) return;

  for (let i = 0; i < 10; i++) {
    const particle = document.createElement('div');
    particle.style.cssText = `
      position: absolute;
      width: 4px;
      height: 4px;
      background: rgba(99, 179, 237, 0.8);
      border-radius: 50%;
      left: ${Math.random() * 100}%;
      top: ${Math.random() * 100}%;
      animation: particleFade 2s ease-out forwards;
      box-shadow: 0 0 10px rgba(99, 179, 237, 1);
    `;
    overlay.appendChild(particle);

    setTimeout(() => particle.remove(), 2000);
  }
}

function initParticles() {
  const style = document.createElement('style');
  style.textContent = `
    @keyframes particleFade {
      0% {
        transform: translate(0, 0) scale(1);
        opacity: 1;
      }
      100% {
        transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * -100}px) scale(0);
        opacity: 0;
      }
    }
  `;
  document.head.appendChild(style);
}

// ========================================
// 3D TILT EFFECT
// ========================================

function initTiltEffect() {
  const tiltElements = document.querySelectorAll('[data-tilt]');

  tiltElements.forEach(element => {
    element.addEventListener('mousemove', handleTilt);
    element.addEventListener('mouseleave', resetTilt);
  });
}

function handleTilt(e) {
  const element = e.currentTarget;
  const rect = element.getBoundingClientRect();
  
  const x = e.clientX - rect.left;
  const y = e.clientY - rect.top;
  
  const centerX = rect.width / 2;
  const centerY = rect.height / 2;
  
  const rotateX = (y - centerY) / 20;
  const rotateY = (centerX - x) / 20;
  
  element.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(10px)`;
}

function resetTilt(e) {
  e.currentTarget.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateZ(0)';
}

// ========================================
// MODAL FUNCTIONALITY
// ========================================

function openLoginModal(event) {
  if (event) event.preventDefault();
  const modal = document.getElementById('loginModal');
  modal.style.display = 'block';
  document.body.style.overflow = 'hidden';
  
  // Add entrance animation
  const modalContent = modal.querySelector('.modal-content');
  modalContent.style.animation = 'modalSlide 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
}

function closeLoginModal() {
  const modal = document.getElementById('loginModal');
  const modalContent = modal.querySelector('.modal-content');
  
  modalContent.style.animation = 'modalSlideOut 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
  
  setTimeout(() => {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
  }, 300);
  
  // Add exit animation
  const style = document.createElement('style');
  style.textContent = `
    @keyframes modalSlideOut {
      from {
        transform: translateY(0) scale(1);
        opacity: 1;
      }
      to {
        transform: translateY(-50px) scale(0.9);
        opacity: 0;
      }
    }
  `;
  if (!document.getElementById('modal-exit-style')) {
    style.id = 'modal-exit-style';
    document.head.appendChild(style);
  }
}

function showTab(tabName) {
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');
  const tabBtns = document.querySelectorAll('.tab-btn');
  
  tabBtns.forEach(btn => btn.classList.remove('active'));
  
  if (tabName === 'login') {
    loginForm.classList.add('active');
    registerForm.classList.remove('active');
    tabBtns[0].classList.add('active');
  } else {
    loginForm.classList.remove('active');
    registerForm.classList.add('active');
    tabBtns[1].classList.add('active');
  }
}

function openResultsModal(event) {
  if (event) event.preventDefault();
  const modal = document.getElementById('resultsModal');
  if (modal) {
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }
  const navMenu = document.getElementById('navMenu');
  if (navMenu && navMenu.classList.contains('active')) {
    toggleMenu();
  }
}

// MODIFY: handleRegister function
function handleRegister(event) {
  event.preventDefault();
  const form = event.target;
  const passwords = form.querySelectorAll('input[type="password"]');
  
  if (passwords[0].value !== passwords[1].value) {
    createErrorNotification('Passwords do not match!');
    return;
  }
  
  const btn = form.querySelector('.btn-primary');
  const originalText = btn.querySelector('.btn-text').textContent;
  btn.querySelector('.btn-text').textContent = 'Registering...';
  btn.disabled = true;
  
  // Collect form data
  const formData = new FormData(form);
  const data = new FormData();
  data.append('full_name', form.querySelector('input[type="text"]').value);
  data.append('email', form.querySelectorAll('input[type="email"]')[0].value);
  data.append('phone', form.querySelector('input[type="tel"]').value);
  data.append('course', form.querySelector('select').value);
  data.append('password', passwords[0].value);
  data.append('confirm_password', passwords[1].value);
  
  // Send to server
  fetch('api_handle_register.php', {
    method: 'POST',
    body: data
  })
  .then(response => response.json())
  .then(result => {
    if (result.success) {
      createSuccessNotification(result.message);
      closeLoginModal();
      showTab('login');
      form.reset();
    } else {
      createErrorNotification(result.message);
    }
    btn.querySelector('.btn-text').textContent = originalText;
    btn.disabled = false;
  })
  .catch(error => {
    createErrorNotification('Error: ' + error.message);
    btn.querySelector('.btn-text').textContent = originalText;
    btn.disabled = false;
  });
}

// MODIFY: handleLogin function
function handleLogin(event) {
  event.preventDefault();
  const form = event.target;
  const btn = form.querySelector('.btn-primary');
  const originalText = btn.querySelector('.btn-text').textContent;
  btn.querySelector('.btn-text').textContent = 'Logging in...';
  btn.disabled = true;
  
  const data = new FormData();
  data.append('email_or_id', form.querySelector('input[type="text"]').value);
  data.append('password', form.querySelector('input[type="password"]').value);
  
  fetch('api_handle_login.php', {
    method: 'POST',
    body: data
  })
  .then(response => response.json())
  .then(result => {
    if (result.success) {
      createSuccessNotification(result.message);
      closeLoginModal();
      // Redirect to dashboard after 1 second
      setTimeout(() => {
        window.location.href = result.redirect;
      }, 1000);
    } else {
      createErrorNotification(result.message);
    }
    btn.querySelector('.btn-text').textContent = originalText;
    btn.disabled = false;
  })
  .catch(error => {
    createErrorNotification('Error: ' + error.message);
    btn.querySelector('.btn-text').textContent = originalText;
    btn.disabled = false;
  });
}

// MODIFY: handleContactForm function
function handleContactForm(event) {
  event.preventDefault();
  const form = event.target;
  const data = new FormData();
  data.append('full_name', form.querySelector('input[type="text"]').value);
  data.append('email', form.querySelector('input[type="email"]').value);
  data.append('subject', form.querySelectorAll('input[type="text"]')[1].value);
  data.append('message', document.getElementById('contactMessage').value);
  
  fetch('api_handle_contact.php', {
    method: 'POST',
    body: data
  })
  .then(response => response.json())
  .then(result => {
    if (result.success) {
      createSuccessNotification(result.message);
      form.reset();
      closeContactModal();
    } else {
      createErrorNotification(result.message);
    }
  })
  .catch(error => {
    createErrorNotification('Error: ' + error.message);
  });
}

// ========================================
// NOTIFICATION SYSTEM
// ========================================

function createSuccessNotification(message) {
  createNotification(message, 'success');
}

function createErrorNotification(message) {
  createNotification(message, 'error');
}

function createNotification(message, type) {
  const notification = document.createElement('div');
  notification.className = `notification notification-${type}`;
  notification.textContent = message;
  
  notification.style.cssText = `
    position: fixed;
    top: 100px;
    right: 20px;
    padding: 20px 30px;
    background: ${type === 'success' ? 'rgba(72, 187, 120, 0.9)' : 'rgba(245, 101, 101, 0.9)'};
    color: white;
    border-radius: 10px;
    font-weight: 600;
    z-index: 3000;
    animation: slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 10px 40px ${type === 'success' ? 'rgba(72, 187, 120, 0.4)' : 'rgba(245, 101, 101, 0.4)'};
    backdrop-filter: blur(10px);
    border: 1px solid ${type === 'success' ? 'rgba(72, 187, 120, 0.5)' : 'rgba(245, 101, 101, 0.5)'};
  `;
  
  document.body.appendChild(notification);
  
  setTimeout(() => {
    notification.style.animation = 'slideOutRight 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
    setTimeout(() => notification.remove(), 400);
  }, 3000);
  
  // Add animation styles
  const style = document.createElement('style');
  style.textContent = `
    @keyframes slideInRight {
      from {
        transform: translateX(400px);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }
    @keyframes slideOutRight {
      from {
        transform: translateX(0);
        opacity: 1;
      }
      to {
        transform: translateX(400px);
        opacity: 0;
      }
    }
  `;
  if (!document.getElementById('notification-style')) {
    style.id = 'notification-style';
    document.head.appendChild(style);
  }
}

// ========================================
// CAREER SECTION
// ========================================

function showCareer(careerType) {
  // Hide all career contents
  const careerContents = document.querySelectorAll('.career-content-3d');
  careerContents.forEach(content => {
    content.classList.remove('active');
  });
  
  // Remove active class from all buttons
  const careerBtns = document.querySelectorAll('.career-tab-3d');
  careerBtns.forEach(btn => {
    btn.classList.remove('active');
  });
  
  // Show selected career content
  const selectedContent = document.getElementById(careerType + 'Career');
  if (selectedContent) {
    selectedContent.classList.add('active');
    animateCareerCards(selectedContent);
  }
  
  // Add active class to clicked button
  const clickedBtn = document.querySelector(`[data-career="${careerType}"]`);
  if (clickedBtn) {
    clickedBtn.classList.add('active');
  }
}

function animateCareerCards(container) {
  const cards = container.querySelectorAll('.career-card-hologram');
  cards.forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    
    setTimeout(() => {
      card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
      card.style.opacity = '1';
      card.style.transform = 'translateY(0)';
    }, index * 100);
  });
}

// ========================================
// MENU TOGGLE
// ========================================

function toggleMenu() {
  const navMenu = document.getElementById('navMenu');
  navMenu.classList.toggle('active');
  
  const toggle = document.querySelector('.menu-toggle');
  toggle.classList.toggle('active');
  
  // Animate hamburger icon
  const spans = toggle.querySelectorAll('span');
  if (toggle.classList.contains('active')) {
    spans[0].style.transform = 'rotate(45deg) translateY(10px)';
    spans[1].style.opacity = '0';
    spans[2].style.transform = 'rotate(-45deg) translateY(-10px)';
  } else {
    spans[0].style.transform = 'none';
    spans[1].style.opacity = '1';
    spans[2].style.transform = 'none';
  }
}

// ========================================
// SIDEBAR TOGGLE
// ========================================

function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const hamburger = document.querySelector('.hamburger-btn');
  
  sidebar.classList.toggle('active');
  overlay.classList.toggle('active');
  hamburger.classList.toggle('active');
  
  if (sidebar.classList.contains('active')) {
    document.body.style.overflow = 'hidden';
  } else {
    document.body.style.overflow = 'auto';
  }
}

// ========================================
// THEME TOGGLE
// ========================================

function toggleTheme() {
  const body = document.body;
  const isLight = body.classList.toggle('light-mode');
  
  // Save preference
  localStorage.setItem('theme', isLight ? 'light' : 'dark');
  
  // Add transition effect
  body.style.transition = 'all 0.3s ease';
  setTimeout(() => {
    body.style.transition = '';
  }, 300);
}

// ========================================
// LOAD SAVED THEME ON PAGE LOAD
// ========================================
// (This is handled inside the DOMContentLoaded listener at the top)

// ========================================
// CLOSE SIDEBAR ON ESCAPE KEY
// ========================================

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    const sidebar = document.getElementById('sidebar');
    if (sidebar && sidebar.classList.contains('active')) {
      toggleSidebar();
    }
  }
});

// ========================================
// SCROLL ANIMATIONS
// ========================================

function initScrollAnimations() {
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
  };
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
        
        // Add special effects for certain elements
        if (entry.target.classList.contains('update-card-3d')) {
          createCardSparkles(entry.target);
        }
      }
    });
  }, observerOptions);
  
  // Observe elements
  const animatedElements = document.querySelectorAll('.update-card-3d, .career-card-hologram, .feature-box');
  animatedElements.forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(50px)';
    el.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
    observer.observe(el);
  });
}

function createCardSparkles(card) {
  for (let i = 0; i < 5; i++) {
    setTimeout(() => {
      const sparkle = document.createElement('div');
      sparkle.style.cssText = `
        position: absolute;
        width: 6px;
        height: 6px;
        background: #63b3ed;
        border-radius: 50%;
        top: ${Math.random() * 100}%;
        left: ${Math.random() * 100}%;
        pointer-events: none;
        box-shadow: 0 0 10px #63b3ed;
        animation: sparkleFade 1s ease-out forwards;
      `;
      card.style.position = 'relative';
      card.appendChild(sparkle);
      
      setTimeout(() => sparkle.remove(), 1000);
    }, i * 100);
  }
  
  // Add sparkle animation
  const style = document.createElement('style');
  style.textContent = `
    @keyframes sparkleFade {
      0% {
        transform: scale(0) rotate(0deg);
        opacity: 1;
      }
      100% {
        transform: scale(2) rotate(180deg);
        opacity: 0;
      }
    }
  `;
  if (!document.getElementById('sparkle-style')) {
    style.id = 'sparkle-style';
    document.head.appendChild(style);
  }
}

// ========================================
// SMOOTH SCROLL
// ========================================

function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      
      // Skip if it's just "#" or has onclick
      if (href === '#' || this.hasAttribute('onclick') || this.hasAttribute('data-course-info') || this.id === 'openAdmissionModal') {
        return;
      }
      
      e.preventDefault();
      const target = document.querySelector(href);
      
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
        
        // Close mobile menu if open
        const navMenu = document.getElementById('navMenu');
        if (navMenu && navMenu.classList.contains('active')) {
          toggleMenu();
        }
      }
    });
  });
}

// ========================================
// FLOATING ELEMENTS
// ========================================

function createFloatingElements() {
  // Create floating geometric shapes in background
  const shapes = ['◆', '●', '▲', '■', '★'];
  const colors = ['#63b3ed', '#7c3aed', '#a78bfa'];
  
  for (let i = 0; i < 10; i++) {
    const shape = document.createElement('div');
    shape.textContent = shapes[Math.floor(Math.random() * shapes.length)];
    shape.style.cssText = `
      position: fixed;
      font-size: ${Math.random() * 30 + 10}px;
      color: ${colors[Math.floor(Math.random() * colors.length)]};
      opacity: 0.1;
      pointer-events: none;
      z-index: -1;
      left: ${Math.random() * 100}%;
      top: ${Math.random() * 100}%;
      animation: floatShape ${Math.random() * 10 + 10}s infinite ease-in-out;
      animation-delay: ${Math.random() * 5}s;
    `;
    document.body.appendChild(shape);
  }
  
  // Add float animation
  const style = document.createElement('style');
  style.textContent = `
    @keyframes floatShape {
      0%, 100% {
        transform: translate(0, 0) rotate(0deg);
      }
      25% {
        transform: translate(50px, -50px) rotate(90deg);
      }
      50% {
        transform: translate(-30px, 30px) rotate(180deg);
      }
      75% {
        transform: translate(40px, 20px) rotate(270deg);
      }
    }
  `;
  if (!document.getElementById('float-shape-style')) {
    style.id = 'float-shape-style';
    document.head.appendChild(style);
  }
}

// ========================================
// BUTTON PARTICLE EFFECTS
// ========================================
// (This is handled inside the DOMContentLoaded listener at the top)

function createButtonParticles(button) {
  const particlesContainer = button.querySelector('.btn-particles');
  if (!particlesContainer) return;
  
  for (let i = 0; i < 3; i++) {
    const particle = document.createElement('div');
    particle.style.cssText = `
      position: absolute;
      width: 4px;
      height: 4px;
      background: white;
      border-radius: 50%;
      top: 50%;
      left: ${Math.random() * 100}%;
      animation: btnParticle 1s ease-out forwards;
      animation-delay: ${i * 0.1}s;
    `;
    particlesContainer.appendChild(particle);
    
    setTimeout(() => particle.remove(), 1100);
  }
  
  // Add particle animation
  const style = document.createElement('style');
  style.textContent = `
    @keyframes btnParticle {
      0% {
        transform: translateY(0) scale(1);
        opacity: 1;
      }
      100% {
        transform: translateY(-30px) scale(0);
        opacity: 0;
      }
    }
  `;
  if (!document.getElementById('btn-particle-style')) {
    style.id = 'btn-particle-style';
    document.head.appendChild(style);
  }
}

// ========================================
// KEYBOARD NAVIGATION
// ========================================

document.addEventListener('keydown', (e) => {
  // Escape key closes modal
  if (e.key === 'Escape') {
    const modal = document.getElementById('loginModal');
    if (modal && modal.style.display === 'block') {
      closeLoginModal();
    }
    // ADDED: Close other modals on Escape
    const contactModal = document.getElementById('contactModal');
    if (contactModal && contactModal.style.display === 'block') {
      closeContactModal();
    }
    // Check for the new modals as well
    const enrollModal = document.getElementById('enrollmentModal');
    if (enrollModal && enrollModal.style.display === 'flex') {
      enrollModal.style.display = 'none'; // Use simple hide
    }
    const admissionModal = document.getElementById('admissionModal');
    if (admissionModal && admissionModal.style.display === 'flex') {
        admissionModal.style.display = 'none';
    }
    document.querySelectorAll('.info-modal').forEach(modal => {
        if (modal.style.display === 'flex') {
            modal.style.display = 'none';
        }
    });
    document.body.style.overflow = 'auto';
  }
  
  // Arrow keys for slider
  if (e.key === 'ArrowLeft') {
    changeSlide(-1);
  } else if (e.key === 'ArrowRight') {
    changeSlide(1);
  }
});

// ========================================
// CURSOR TRAIL EFFECT
// ========================================

let cursorTrail = [];
document.addEventListener('mousemove', (e) => {
  // Throttle for performance
  if (Math.random() > 0.7) {
    const trail = document.createElement('div');
    trail.style.cssText = `
      position: fixed;
      width: 8px;
      height: 8px;
      background: radial-gradient(circle, rgba(99, 179, 237, 0.6), transparent);
      border-radius: 50%;
      pointer-events: none;
      z-index: 9999;
      left: ${e.clientX}px;
      top: ${e.clientY}px;
      animation: trailFade 0.8s ease-out forwards;
    `;
    document.body.appendChild(trail);
    
    setTimeout(() => trail.remove(), 800);
  }
});

// Add trail animation
const trailStyle = document.createElement('style');
trailStyle.textContent = `
  @keyframes trailFade {
    0% {
      transform: scale(1);
      opacity: 0.6;
    }
    100% {
      transform: scale(0);
      opacity: 0;
    }
  }
`;
if (!document.getElementById('trail-style')) {
  trailStyle.id = 'trail-style';
  document.head.appendChild(trailStyle);
}

// ========================================
// PERFORMANCE OPTIMIZATION
// ========================================

// Reduce animations on low-end devices
if (navigator.hardwareConcurrency <= 4) {
  document.body.classList.add('reduced-motion');
}

// Pause animations when tab is not visible
document.addEventListener('visibilitychange', () => {
  if (document.hidden) {
    document.body.classList.add('paused');
  } else {
    document.body.classList.remove('paused');
  }
});

// ========================================
// CONSOLE EASTER EGG
// ========================================

console.log('%c🚀 Welcome to C-T Institute!', 'font-size: 20px; color: #63b3ed; font-weight: bold;');
console.log('%cBuilt with passion for the future of education', 'font-size: 14px; color: #a0aec0;');

// ========================================
// CONTACT MODAL FUNCTIONALITY
// ========================================

function openContactModal(event) {
  if (event) event.preventDefault();
  document.getElementById('contactModal').style.display = 'block';
  document.body.style.overflow = 'hidden';
}

function closeContactModal() {
  document.getElementById('contactModal').style.display = 'none';
  document.body.style.overflow = 'auto';
}

function handleContactForm(event) {
  event.preventDefault();
  const form = event.target;
  const data = new FormData();
  data.append('full_name', form.querySelector('input[type="text"]').value);
  data.append('email', form.querySelector('input[type="email"]').value);
  data.append('subject', form.querySelectorAll('input[type="text"]')[1].value);
  data.append('message', document.getElementById('contactMessage').value);
  
  fetch('api_handle_contact.php', {
    method: 'POST',
    body: data
  })
  .then(response => response.json())
  .then(result => {
    if (result.success) {
      createSuccessNotification(result.message);
      form.reset();
      closeContactModal();
    } else {
      createErrorNotification(result.message);
    }
  })
  .catch(error => {
    createErrorNotification('Error: ' + error.message);
  });
}

// ========================================
// GOOGLE MAPS INTEGRATION
// ========================================

function openGoogleMaps() {
  // Coordinates for Sangamner, Maharashtra
  const latitude = 19.8950;
  const longitude = 74.8616;
  const address = 'concept-tree, Maharanan Pratap Chowk, Maldad Road, Sangamner, 422605';
  
  // Open Google Maps in a new tab
  const googleMapsUrl = `https://www.google.com/maps/search/${encodeURIComponent(address)}/@${latitude},${longitude},15z`;
  window.open(googleMapsUrl, '_blank');
  
  // Optional: Show notification
  createSuccessNotification('Opening Google Maps...');
}

// Close About Modal Function
function closeAboutModal() {
  const modal = document.getElementById('aboutModal');
  if (modal) {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
  }
}

