<?php
include('session.php');
include('connection.php'); // Make sure DB connection is available

// Fetch full user data
$username = $_SESSION['username'];
$sql = "SELECT * FROM accounts WHERE username = '$username'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Profile image fallback
$profileImage = (!empty($user['profile_image']) && file_exists($user['profile_image']))
  ? $user['profile_image']
  : 'default-avatar.png';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard - Freight System</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }

    .sidebar {
      height: 100vh;
      background: #2c3e50;
      padding-top: 20px;
      position: fixed;
      width: 240px;
      color: white;
    }

    .sidebar a {
      display: block;
      padding: 12px;
      color: white;
      text-decoration: none;
      transition: background 0.3s;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #0b5ed7;
      border-radius: 5px;
    }

    .main-content {
      margin-left: 240px;
      padding: 20px;
    }

    .card {
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .table thead {
      background: #0d6efd;
      color: white;
    }

    .dark-mode {
      background-color: #1a1a2e;
      color: white;
    }

    .dark-mode .card {
      background-color: #16213e;
      color: white;
    }

    .dark-mode .table {
      color: white;
    }

    .theme-toggle {
      cursor: pointer;
    }
  </style>
</head>

<body>

  <!-- Sidebar -->
  <div class="sidebar d-flex flex-column">
    <div class="text-center mb-4">
      <img src="slate_logo-removebg-preview.png" alt="Freight Logo" class="img-fluid mb-2" style="max-width:120px;">
      <h5>Freight System</h5>
    </div>
    <a href="user-acct.php" class="active">🏠 Dashboard</a>
    <a href="user-shipment.php">📦 Track Shipment</a>
    <a href="user-book-shipment.php">📝 Book Shipment</a>
    <a href="user-ship-history.php">📜 Shipment History</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3>Welcome, <?php echo $_SESSION['username']; ?> 👋</h3>

      <div class="d-flex align-items-center gap-3">
        <!-- Dark Mode Toggle -->
        <div class="form-check form-switch theme-toggle mb-0">
          <input class="form-check-input" type="checkbox" id="theme-toggle">
          <label class="form-check-label" for="theme-toggle">🌙</label>
        </div>

        <!-- Profile Picture Dropdown -->
        <div class="dropdown">
          <img src="<?php echo $profileImage; ?>" alt="Profile" class="rounded-circle"
            style="width:55px; height:55px; object-fit:cover; border:2px solid #0d6efd; cursor:pointer;"
            id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
            <li><a class="dropdown-item" href="user-profile.php">👤 Profile</a></li>
            <li><a class="dropdown-item" href="logout.php">🚪 Logout</a></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Dashboard Cards -->
    <!-- Main Content -->
    <div class="col-md-10 p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Customer Portal & Notification Hub</h2>

      </div>

      <div class="row g-4">
        <!-- Notifications -->
        <div class="col-md-6">
          <div class="card card-custom p-3">
            <h5>Notifications</h5>
            <input type="text" class="form-control mb-2" placeholder="Search Notifications...">
            <div class="d-flex gap-2 mb-3">
              <button class="btn btn-sm btn-outline-light">Unread</button>
              <button class="btn btn-sm btn-outline-light">Read</button>
              <button class="btn btn-sm btn-outline-light">Mark as Read</button>
              <button class="btn btn-sm btn-outline-light">Archive</button>
            </div>

            <div class="notification-item">
              <strong>System Update</strong> <span class="badge bg-secondary">Medium</span>
              <div class="small">2 hours ago</div>
            </div>
            <div class="notification-item">
              <strong>SLA Alert</strong> <span class="badge bg-danger">High</span>
              <div class="small">Yesterday</div>
            </div>
            <div class="notification-item">
              <strong>Document Reminder</strong> <span class="badge bg-success">Low</span>
              <div class="small">2 days ago</div>
            </div>

            <h6 class="mt-3">Current Placements</h6>
            <div class="notification-item">
              <strong>My Documents</strong> <br>
              <span class="small">Compliance Cert will expire in 5 days</span>
            </div>
          </div>
        </div>

        <!-- Profile Overview -->
        <div class="col-md-6">
          <div class="card card-custom p-3">
            <h5>Customer Portal</h5>
            <div class="mb-3">
              <strong>Profile Overview</strong><br>
              <?php echo htmlspecialchars($user['username'] ?? 'Not Set'); ?> <br>
              <?php echo htmlspecialchars($user['email'] ?? 'Not Set'); ?> <br>
              <?php echo htmlspecialchars($user['role'] ?? 'Not Set'); ?> <br>
              <?php echo htmlspecialchars($user['created_at'] ?? 'Not Set'); ?>
            </div>

            <h6>Contracts & SLA Snapshot</h6>
            <ul>
              <li><span class="text-success">●</span> Active</li>
              <li><span class="text-warning">●</span> Expiring Soon</li>
              <li><span class="text-danger">●</span> Breach Alert</li>
            </ul>

            <h6>Documents & Compliance</h6>
            <button class="btn btn-sm btn-outline-light">My Documents</button>

            <h6 class="mt-3">Shipments</h6>
            <p>Active Shipments: 2</p>
          </div>
        </div>
      </div>
    </div>



    <!-- Recent Shipments Table -->
    <div class="card p-3">
      <h5>Recent Shipments</h5>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Tracking No</th>
              <th>Origin</th>
              <th>Destination</th>
              <th>Status</th>
              <th>Booked Date</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>FRT12345</td>
              <td>Manila</td>
              <td>Cebu</td>
              <td><span class="badge bg-warning">In Transit</span></td>
              <td>2025-09-01</td>
            </tr>
            <tr>
              <td>FRT67890</td>
              <td>Davao</td>
              <td>Manila</td>
              <td><span class="badge bg-success">Delivered</span></td>
              <td>2025-08-28</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS + Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Dark Mode
    document.getElementById("theme-toggle").addEventListener("change", function () {
      document.body.classList.toggle("dark-mode");
    });


  </script>
</body>

</html>