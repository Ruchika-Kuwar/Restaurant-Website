const hamburger = document.getElementById('hamburger');
const navLinks = document.querySelector('.nav-links');

hamburger.addEventListener('click', () => {
  navLinks.classList.toggle('show');
});

// Modal preview functionality
const quickViewButtons = document.querySelectorAll('.quick-view');
const modal = document.getElementById('preview-modal');
const modalTitle = document.getElementById('modal-title');
const closeBtn = document.querySelector('.close-btn');

quickViewButtons.forEach(button => {
  button.addEventListener('click', () => {
    const dishName = button.getAttribute('data-item');
    modalTitle.textContent = dishName;
    modal.style.display = 'block';
  });
});

closeBtn.addEventListener('click', () => {
  modal.style.display = 'none';
});

window.addEventListener('click', event => {
  if (event.target === modal) {
    modal.style.display = 'none';
  }
});

// Fade-in scroll animation for About Section
const aboutSection = document.querySelector('.about-section');

const revealOnScroll = () => {
  const sectionPos = aboutSection.getBoundingClientRect().top;
  const screenPos = window.innerHeight / 1.2;

  if (sectionPos < screenPos) {
    aboutSection.classList.add('fade-in');
  }
};

window.addEventListener('scroll', revealOnScroll);


// script.js

const cards = document.querySelectorAll('.feature-card');

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = 1;
      entry.target.style.transform = 'translateY(0)';
    }
  });
}, {
  threshold: 0.3
});

cards.forEach(card => {
  card.style.opacity = 0;
  card.style.transform = 'translateY(30px)';
  observer.observe(card);
});


const slider = document.getElementById('testimonialSlider');
const dotsContainer = document.getElementById('dotsContainer');
const testimonials = document.querySelectorAll('.testimonial');
let currentSlide = 0;

// Create dots dynamically
testimonials.forEach((_, index) => {
  const dot = document.createElement('span');
  dot.classList.add('dot');
  if (index === 0) dot.classList.add('active');
  dot.addEventListener('click', () => moveToSlide(index));
  dotsContainer.appendChild(dot);
});

function moveToSlide(index) {
  slider.style.transform = `translateX(-${index * 100}%)`;
  currentSlide = index;
  updateDots();
}

function updateDots() {
  const dots = document.querySelectorAll('.dot');
  dots.forEach(dot => dot.classList.remove('active'));
  dots[currentSlide].classList.add('active');
}

// Auto-slide every 5 seconds
setInterval(() => {
  currentSlide = (currentSlide + 1) % testimonials.length;
  moveToSlide(currentSlide);
}, 5000);

// Contact form validation
document.getElementById('contactForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const message = document.getElementById('message').value.trim();
  const status = document.getElementById('formStatus');

  if (name === '' || email === '' || message === '') {
    status.style.color = 'red';
    status.textContent = 'Please fill out all fields.';
    return;
  }

  // Simple email validation
  const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
  if (!email.match(emailPattern)) {
    status.style.color = 'red';
    status.textContent = 'Please enter a valid email address.';
    return;
  }

  // Simulate form submission
  status.style.color = '#4caf50';
  status.textContent = 'Message sent successfully!';

  // Reset form after 2 seconds
  setTimeout(() => {
    document.getElementById('contactForm').reset();
    status.textContent = '';
  }, 2000);
});

// Scroll to Top Button
const scrollBtn = document.getElementById('scrollTopBtn');

window.onscroll = function () {
  if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
    scrollBtn.style.display = "block";
  } else {
    scrollBtn.style.display = "none";
  }
};

scrollBtn.addEventListener('click', () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});
