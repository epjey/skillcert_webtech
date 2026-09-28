<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="../fontawesome-free-7.1.0-web/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="webfonts/Oswald" />
    <link rel="stylesheet" href="../included/landing.css">

    <title>Landing Page</title>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow flex-column vw-100 p-3 fixed-top" style="background:#f8f9fa;">
  <div class="container-fluid">

    <!-- Logo -->
    <a class="navbar-brand fw-bold text-black" href="#">
      <img src="../assets/pp.svg" alt="SkillCert Logo" class="svg-logo"> 
    </a>

    <!-- Toggle button -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- Nav Links -->
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ms-auto">
              <a class="nav-link fw-bold text-black" href="#what_we_offer">
                What we offer
              </a>
        <a class="nav-link active text-black fw-bold" aria-current="page" href="#how_it_work">How it Works</a>
        <a class="nav-link text-black fw-bold" href="#about-1">About</a>
        <a class="nav-link text-black fw-bold" href="../authentication/login.php">Log In</a>
        <button class="btn  ms-2" type="submit fw-bold"><a href="../authentication/register.php" style=" text-decoration: none">Get Started</a></button>
      </div>
    </div>
  </div>
</nav>

<!-- landing page -->
<section> 
  <div class="d-flex align-items-center text-white" 
       style="height: 100vh; 
              background: linear-gradient(135deg, #ffffff, #f9a602, #d4af37);
              backdrop-filter: blur(12px); 
              border: 1px solid #1C1C1C;">

    <div class="container d-flex justify-content-between align-items-center">
      
      <!-- Left Content -->
      <div style="max-width: 60%;">
        <h1 class="hero-title text-start" style="font-size: 4rem; color: #2f2f2f;">Get Certified For Free</h1>
        <br> 
        <p class="fs-4" style="color: #2f2f2f;">Learn new skills, test your knowledge, and earn free certificates  all at no cost. <i class="fa-solid fa-rocket fa-xl"></i></p>
        <br>
        <button class="custom btn btn-lg fw-bold"><a href="../authentication/register.php">Get Started ⮞</a></button>
        <br><br>

        <!-- Tech Icons -->
        <div class="d-grid" style="grid-template-columns: auto auto auto; column-gap: 0; row-gap: 0;">
          <div class="d-flex gap-3">
            <div class="tech-icons">
              <!-- JavaScript -->
              <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" alt="JavaScript" >
              
              <!-- HTML5 -->
              <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" alt="HTML5" >
              
              <!-- PHP -->
              <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" alt="PHP" >
              
              <!-- SQL (MySQL logo) -->
              <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" alt="SQL" >
              
              <!-- CSS3 -->
              <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg" alt="CSS3" class="img-fluid">
            </div>
          </div>
        </div>
      </div>

      <!-- Right Image -->
      <div style="max-width: 35%;">
        <img src="../assets/prog.svg" alt="Description" class="img-fluid" style="width: 500px;"/>
      </div>
    </div>
  </div>
  
</section>

<!-- About Section -->
<section id="about-1" class="flex-column justify-content-center text-center py-5" style="background:#f8f9fa;">
  <div class="container">
    <h1 class="text-black" style="font-size: 60px; ">About us</h1>
    <p class="mt-4 fs-5 mb-5" style="color: #555555;">
      We’re not here to make learning boring.
        We’re here to give students a fun and interactive way to learn and get certified.
    </p>

    <div class="row text-center">

  <!-- Take Courses -->
  <div class="about col-md-4 mb-4">
    <div class="card text-white text-center custom-card"
         data-aos="fade-right" data-aos-duration="1500" style="background-color: #feffffff;">
      <div class="card-body" style="height: 220px;">
        <i class="fa-solid fa-book fa-2xl fa-bounce" style="color: #daa520;"></i>
        <h5 class="card-title fw-bold mt-3 text-black" style="font-size: 30px;">Take Courses</h5>
        <p class="card-text" style="font-size: 20px; color: #555555; font-weight: 400">Learn at your own pace with engaging lessons designed to build real skills.</p>
      </div>
    </div>
  </div>

  <!-- Take Exam -->
  <div class="about col-md-4 mb-4">
    <div class="card text-white text-center custom-card"
         data-aos="fade-up" data-aos-duration="1500" style="background-color: #ffffffff;">
      <div class="card-body" style="height: 220px;">
      <i class="fa-solid fa-keyboard fa-2xl fa-bounce" style="color: #daa520;"></i>
        <h5 class="card-title fw-bold text-black mt-3" style="font-size: 30px;">Take Exam</h5>
        <p class="card-text" style="font-size: 20px; color: #555555; font-weight: 400">Test your knowledge with exams that challenge and prepare you for success.</p>
      </div>
    </div>
  </div>

  <!-- Get Certified -->
  <div class="about col-md-4 mb-4">
    <div class="card text-white text-center custom-card"
         data-aos="fade-left" data-aos-duration="1500" style="background-color: #ffffffff;">
      <div class="card-body" style="height: 220px;">
        <i class="fa-solid fa-award fa-2xl fa-bounce" style="color: #daa520;"></i>
        <h5 class="card-title fw-bold text-black mt-3" style="font-size: 30px;">Get Certified</h5>
        <p class="card-text" style="font-size: 20px; color: #555555; font-weight: 400">Earn certificates that showcase your skills and boost your career opportunities.</p>
      </div>
    </div>
  </div>
</div>
</section>

<!-- Offer Section 2 -->
<section class="flex-column justify-content-center text-center" id="what_we_offer" style="background:#f8f9fa; padding: 80px 0 60px 0;">
      <div class="container">
    <h1 class="text-black" style="font-size: 60px;">What we offer?</h1>
    <p class="mt-4 fs-5" style=" color: #555555;">
       Master the most essential coding skills and get certified — all for free, anytime, anywhere.
    </p>
  <div class="row g-4">

    <!-- courses -->
    <div class="pt-3 text-center mt-5">
      <div class="image-container">
        <div class="row gap-3">
          <div class=" col" data-aos="fade-right" data-aos-duration="1500">
            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" alt="JavaScript">
            <p class="text-black mt-2 fs-5">Javascript</p>
          </div>
          <div class="col" data-aos="fade-up" data-aos-duration="1500">
            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" alt="HTML5">
            <p class="text-black mt-2 fs-5">HTML</p>
          </div>
          <div class="col" data-aos="fade-down" data-aos-duration="1500">
            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" alt="PHP">
            <p class="text-black mt-2 fs-5">PHP</p>
          </div>
          <div class="col" data-aos="fade-up" data-aos-duration="1500">
            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" alt="SQL">
            <p class="text-black mt-2 fs-5">SQL</p>
          </div>
          <div class="col" data-aos="fade-left" data-aos-duration="1500">
           <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg" alt="CSS3">
            <p class="text-black mt-2 fs-5">CSS</p>
          </div>
        </div>  
      </div>
    </div>
</section>

<!-- Gamified Learning Section -->
<section class="d-flex flex-column justify-content-center text-center" style="background:#e9ecef; padding: 60px 0 40px 0;">
  <div class="container">
    <h1 class="fw-bold text-dark mb-4">Interactive Learning Experience</h1>
    <p class="text-secondary fs-5 mb-5">
      Learning becomes more engaging with leaderboards, certificates, and average scores that track your progress 
      and keep you motivated throughout your journey.
    </p>

    <div class="row g-4 justify-content-center">
      <!-- Leaderboards -->
      <div class="col-md-4" data-aos="zoom-in-right" data-aos-duration="1500">
        <div class="card shadow-lg border-0 h-100" 
             style="background:#f8f9fa; border-radius: 15px;">
          <div class="card-body p-4">
            <i class="fa-solid fa-trophy fa-2xl" style="color: #daa520;"></i>
            <h3 class="fw-bold mt-3 text-black">Leaderboards</h3>
            <p class="text-black mt-2">
              Compete with other learners and climb the leaderboard as you gain more certificates 
              through your exams.
            </p>
          </div>
        </div>
      </div>

      <!-- XP -->
      <div class="col-md-4" data-aos="zoom-in-up" data-aos-duration="1500">
        <div class="card shadow-lg border-0 h-100" 
             style="background: #f8f9fa; border-radius: 15px;">
          <div class="card-body p-4">
            <i class="fa-solid fa-chart-simple fa-2xl" style="color: #daa520;"></i>
            <h3 class="fw-bold mt-3 text-black">Average Scores</h3>
            <p class="text-black mt-2">
             Track your performance and see how well you’re doing in your courses through your average scores.
            </p>
          </div>
        </div>
      </div>

      <!-- Stamina -->
      <div class="col-md-4" data-aos="zoom-in-left" data-aos-duration="1500">
        <div class="card shadow-lg border-0 h-100" 
             style="background: #f8f9fa; border-radius: 15px;">
          <div class="card-body p-4">
            <i class="fa-solid fa-award fa-2xl" style="color: #daa520;"></i>
            <h3 class="fw-bold mt-3 text-black">Certifications</h3>
            <p class="text-black mt-2">
              Certifications are your key to climbing the leaderboard.
              The more certifications you earn, the higher your rank — showcasing 
              your dedication, skill, and progress as a top learner.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Progress Bar -->
        <div class="progress-container">
        <p>Progress: 70%</p>
        <div class="progress-bar">
          <div class="progress-fill" style="width:65%"></div>
        </div>
      </div>
    </div>
  </div>
       
  
    <!-- Closing line -->
    <p class="fs-5 text-dark mt-3 mb-5">
      Browse courses, complete lessons, test your knowledge, and get certified — all while 
      enjoying a gamified learning journey!
    </p>
  </div>
</section>

<!--FROM START TO FINISH-->
<section id="how_it_work" class="d-flex flex-column justify-content-center text-center py-5" style="background:#e9ecef;">
  <div class="container">
  <div class="container">
    <h1 class="fw-bold text-black" style="font-size: 60px; margin-bottom: 50px;">How it Works</h1>

  <div class="row text-center">

  <!-- Take Courses -->
  <div class="about col-md-3 mb-4">
    <div class="card text-white text-center custom-card"
         data-aos="fade-right" data-aos-duration="1500" style="background: #ffffff; ">
      <div class="card-body" style="height: 200px;">
        <i class="fa-solid fa-hammer fa-2xl" style="color: #daa520;"></i>
        <h5 class="card-title fw-bold mt-3 text-black mt-3" style="font-size: 30px;">Create Account</h5>
        <p class="card-text" style="font-size: 16px; color: #2f2f2f;"> Sign up in minutes and unlock access to a wide range of learning opportunities.</p>
      </div>
    </div>
  </div>

  <!-- Take Exam -->
  <div class="about col-md-3 mb-4">
    <div class="card text-white text-center custom-card"
         data-aos="fade-up" data-aos-duration="1500" style="background: #ffffff;">
      <div class="card-body" style="height: 200px;">
      <i class="fa-solid fa-layer-group fa-2xl" style="color: #daa520;"></i>
        <h5 class="card-title fw-bold text-black mt-3" style="font-size: 30px;">Choose Course</h5>
        <p class="card-text" style="font-size: 16px; color: #2f2f2f;">Browse our library and pick the course that matches your passion and goals.</p>
      </div>
    </div>
  </div>

  <!-- Get Certified -->
  <div class="about col-md-3 mb-4">
    <div class="card text-white text-center custom-card"
         data-aos="fade-down" data-aos-duration="1500" style="background: #ffffff;">
      <div class="card-body" style="height: 200px;">
        <i class="fa-solid fa-bullseye fa-2xl" style="color: #daa520;"></i>
        <h5 class="card-title fw-bold text-black mt-3" style="font-size: 30px;">Take Course</h5>
        <p class="card-text" style="font-size: 16px; color: #2f2f2f;">Learn at your own pace with step-by-step lessons and hands-on activities.</p>
      </div>
    </div>
  </div>

    <div class="about col-md-3 mb-4">
    <div class="card text-white text-center custom-card"
         data-aos="fade-left" data-aos-duration="1500" style="background: #ffffff;">
      <div class="card-body" style="height: 200px;">
        <i class="fa-solid fa-graduation-cap fa-2xl" style="color: #daa520;"></i>
        <h5 class="card-title fw-bold text-black mt-3" style="font-size: 30px;">Certified</h5>
        <p class="card-text" style="font-size: 16px; color: #2f2f2f;">Gain certificates that make learning fun, rewarding, and officially recognized.</p>
      </div>
    </div>
  </div>
</div>

<!-- Testimonials -->
<section class="testimonials" style="background-color: #e9ecef; padding: 80px 0 60px 0;">
  <h2>What Our Learners Say</h2>
    <div>
      <div class="testimonial">
        <p>"SkillCert helped me pass my certification exam in one try!"</p>
        <h3>- John Aaron Pore</h3>
      </div>
      <div class="testimonial">
        <p>"The gamified learning experience kept me motivated every day."</p>
        <h3>- Crisostomo Gino</h3>
      </div>
    </div>
</section>
</div>
</section>



<!-- Footer Section -->
<footer style="background: linear-gradient(185deg, #000000, #1c1c1c, #2e2e2e, #ffffff20); padding: 50px 20px; font-family: Arial, sans-serif; color: white">
  <div class="container d-flex flex-wrap justify-content-between gap-4">

    <!-- About -->
    <div style="flex: 1; min-width: 200px;">
      <h3 class="fw-bold mb-3">Skill Cert</h3>
      <p style="line-height: 1.7;" >
        Empowering learners to master coding skills and earn certifications for free.  
        Our mission is to make education accessible and engaging for everyone.
      </p>
    </div>

    <!-- Quick Links -->
    <div style="flex: 1; min-width: 150px;">
      <h4 class="fw-bold mb-3">Quick Links</h4>
      <ul class="list-unstyled">
        <li><a href="#" class="text-decoration-none text-white"><i class="fa-solid fa-house-user fa-lg" style="color: #daa520;"></i> Home</a></li>
        <li><a href="#about-1" class="text-decoration-none text-white"><i class="fa-solid fa-lightbulb fa-lg" style="color: #daa520;"></i> About</a></li>
      </ul>
    </div>

    <!-- Contact -->
    <div style="flex: 1; min-width: 200px;" id="contact" >
      <h4 class="fw-bold mb-3">Contact Us</h4>
      <p><i class="fa-solid fa-envelope fa-lg" style="color: #daa520;"></i> support@skillcert.com</p>
      <p><i class="fa-solid fa-phone-volume fa-lg" style="color: #daa520;"></i> +63 912 345 6789</p>
      <p><i class="fa-solid fa-map-pin fa-lg" style="color: #daa520;"></i> Manila, Philippines</p>
    </div>

  </div>

  <hr style="margin: 30px 0; border-color: rgba(255,255,255,0.2);">

  <p class="mb-0 text-center text-white">&copy; 2025 Skill Cert. All rights reserved.</p>
</footer>


<!-- AOS ANIMATE -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>

</body>
<script src="../js/bootstrap.js"></script>
</html>