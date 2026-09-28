




<style>
    body {
      background: #f5f7fa;
    }
    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      max-width: 600px;
      margin: 3rem auto;
      text-align: center;
    }
    .profile-img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
      margin: 1.5rem auto;
      display: block;
    }
    .form-control {
      border-radius: 0.5rem;
      padding: 0.6rem 0.8rem;
    }
    .btn-primary {
      border-radius: 0.5rem;
      padding: 0.5rem 1.25rem;
      font-weight: 500;
    }
    .btn-outline-secondary {
      border-radius: 0.5rem;
    }
  </style>
<main id="main-content">
  <div class="container">
    <div class="card p-4">
      <img src="https://via.placeholder.com/100" alt="Avatar" class="profile-img">
      <h4 class="mb-1" id="profileName">Your Name</h4>
      <p class="text-muted mb-4" id="userEmailPreview">user@example.com</p>
      <hr>

      <h5 class="mb-3">Account Settings</h5>
      <form class="row g-3 text-start px-2">
        <div class="col-md-6">
          <label class="form-label">First Name</label>
          <input type="text" id="firstName" class="form-control" placeholder="First name">
        </div>
        <div class="col-md-6">
          <label class="form-label">Last Name</label>
          <input type="text" id="lastName" class="form-control" placeholder="Last name">
        </div>
        <div class="col-12">
          <label class="form-label">Email</label>
          <input type="email" id="email" class="form-control" placeholder="you@example.com">
        </div>
        <div class="col-12">
          <label class="form-label">Old Password</label>
          <input type="password" id="oldPassword" class="form-control" placeholder="Current password">
        </div>
        <div class="col-12">
          <label class="form-label">New Password</label>
          <input type="password" id="password" class="form-control" placeholder="New password">
        </div>
      </form>

      <div class="mt-4 d-flex justify-content-end">
        <button id="cancel" class="btn btn-outline-secondary me-2">Cancel</button>
        <button id="save" class="btn btn-primary">Save Changes</button>
      </div>
    </div>
  </div>

</main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const KEY = 'app_settings_v1';
    const defaultSettings = { firstName:'', lastName:'', email:'user@example.com', password:'' };

    function loadSettings(){ 
      try { return JSON.parse(localStorage.getItem(KEY)) || defaultSettings; } 
      catch(e){ return defaultSettings; } 
    }

    function saveSettings(obj){ localStorage.setItem(KEY, JSON.stringify(obj)); }

    function applyToUI(s){
      document.getElementById('firstName').value = s.firstName;
      document.getElementById('lastName').value = s.lastName;
      document.getElementById('email').value = s.email;
      document.getElementById('password').value = '';
      document.getElementById('oldPassword').value = '';

      document.getElementById('profileName').textContent = (s.firstName + ' ' + s.lastName).trim() || 'Your Name';
      document.getElementById('userEmailPreview').textContent = s.email || 'user@example.com';
    }

    function readFromUI(){ 
      return {
        firstName: document.getElementById('firstName').value.trim(),
        lastName: document.getElementById('lastName').value.trim(),
        email: document.getElementById('email').value.trim(),
        password: document.getElementById('password').value.trim(),
        oldPassword: document.getElementById('oldPassword').value.trim()
      }; 
    }

    const settings = loadSettings();
    applyToUI(settings);

    document.getElementById('save').addEventListener('click', (e) => {
      e.preventDefault();
      const s = readFromUI();
      const stored = loadSettings();

      if (stored.password && s.oldPassword !== stored.password) {
        alert('Old password is incorrect.');
        return;
      }

      if (s.password === '') {
        s.password = stored.password;
      }

      saveSettings(s);
      applyToUI(s);
      alert('Settings saved!');
    });

    document.getElementById('cancel').addEventListener('click', (e) => {
      e.preventDefault();
      applyToUI(loadSettings());
      alert('Changes reverted');
    });
  </script>