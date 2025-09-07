<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Freight Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      padding: 0;
    }

    .hero {
      background: url('https://images.unsplash.com/photo-1581091870634-1e7e2e04a3a6?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
      color: white;
      height: 100vh;
      display: flex;
      align-items: center;
      text-align: center;
      position: relative;
    }

    .hero::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: #16213e;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      width: 100%;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: 700;
    }

    .hero p {
      font-size: 1.2rem;
      margin: 1rem 0;
    }

    .section-title {
      margin-bottom: 2rem;
      font-weight: 600;
    }

    .feature-card {
      border: none;
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
    }

    .feature-card:hover {
      transform: translateY(-8px);
    }

    .footer {
      background: #2c3e50;
      color: white;
      padding: 2rem 0;
      text-align: center;
    }
    .logo img {
      height: 250px;
      margin-bottom: 100px;
      padding-bottom: 100px;
      align-items: end;
     
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#"><i class="bi bi-truck me-2"></i>FreightSys</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="#hero">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">User Account</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero" id="hero">
    <div class="hero-content container">
      <div class="logo">
            <img src="slate_logo-removebg-preview.png" alt="SLATE Logo">
        </div>
      <h1> SLATE: FREIGHT MANAGEMENT CORE TRANSACTION 3
        WITH SLA COMPLIANCE FORECASTING AND MONITORING
        SYSTEM USING TENSORFLOW
        </h1>
      <p>Track, optimize, and streamline your logistics operations in one system.</p>
      <a href="#features" class="btn btn-primary btn-lg mt-3">Explore Features</a>
    </div>
  </section>

  <!-- Features -->
  <section class="py-5" id="features">
    <div class="container">
      <h2 class="text-center section-title">Our Features</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="feature-card text-center bg-light">
            <i class="bi bi-geo-alt fs-1 text-primary mb-3"></i>
            <h5>Real-Time Tracking</h5>
            <p>Monitor your shipments with GPS-enabled real-time tracking across the globe.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card text-center bg-light">
            <i class="bi bi-graph-up fs-1 text-success mb-3"></i>
            <h5>Analytics Dashboard</h5>
            <p>Gain insights with detailed analytics to optimize routes and reduce costs.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card text-center bg-light">
            <i class="bi bi-file-earmark-text fs-1 text-warning mb-3"></i>
            <h5>Contract & Compliance</h5>
            <p>Manage freight contracts and ensure SLA compliance seamlessly.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About -->
  <section class="py-5 bg-light" id="about">
    <div class="container text-center">
      <h2 class="section-title">About Us</h2>
      <p class="lead">FreightSys is a next-generation freight management solution designed to simplify logistics, improve transparency, and empower businesses with data-driven decision-making.</p>
    </div>
  </section>

  <!-- Contact -->
  <section class="py-5" id="contact">
    <div class="container">
      <h2 class="text-center section-title">Contact Us</h2>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form>
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Your Name" required>
            </div>
            <div class="mb-3">
              <input type="email" class="form-control" placeholder="Your Email" required>
            </div>
            <div class="mb-3">
              <textarea class="form-control" rows="4" placeholder="Message" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Message</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <p>© 2025 FreightSys. All Rights Reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>