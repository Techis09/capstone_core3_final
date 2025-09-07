<?php
session_start();
include('connection.php'); // DB connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Ensure session has username
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = "roy"; // fallback for testing
}

$username = $_SESSION['username'];

// ✅ Fetch profile image
$sql = "SELECT profile_image FROM accounts WHERE username = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$profileImage = (!empty($row['profile_image'])) ? $row['profile_image'] : 'default-avatar.png';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Shipment - Freight System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --bg-color: #f8f9fa;
      --text-color: #000;
      --container-bg: #fff;
    }
    body.dark {
      --bg-color: #121212;
      --text-color: #f8f9fa;
      --container-bg: #1e1e1e;
    }
    body {
      font-family: Arial, sans-serif;
      background: var(--bg-color);
      color: var(--text-color);
      margin: 0;
      padding: 0;
      display: flex;
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
      background: #0056b3;
      border-radius: 5px;
    }
    .main {
      margin-left: 240px;
      padding: 20px;
      width: calc(100% - 240px);
    }
    .topbar {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      margin-bottom: 20px;
      gap: 15px;
    }
    .container {
      max-width: 700px;
      margin: 20px auto;
      background: var(--container-bg);
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    h2 {
      text-align: center;
      color: #007bff;
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar d-flex flex-column">
    <div class="text-center mb-4">
      <img src="logo.png" alt="Freight Logo" class="img-fluid mb-2" style="max-width:120px;">
      <h5>Freight System</h5>
    </div>
    <a href="user-acct.php">🏠 Dashboard</a>
    <a href="user-shipment.php">📦 Track Shipment</a>
    <a href="user-book-shipment.php" class="active">📝 Book Shipment</a>
    <a href="user-ship-history.php">📜 Shipment History</a>
  </div>

  <!-- Main content -->
  <div class="main">
    <!-- Topbar -->
    <div class="topbar">
      <!-- Dark mode toggle -->
      <div class="form-check form-switch theme-toggle mb-0">
        <input class="form-check-input" type="checkbox" id="theme-toggle">
        <label class="form-check-label" for="theme-toggle">🌙</label>
      </div>

      <!-- Profile dropdown -->
      <div class="dropdown">
        <img src="<?php echo $profileImage; ?>" alt="Profile"
             class="rounded-circle"
             style="width:55px; height:55px; object-fit:cover; border:2px solid #0d6efd; cursor:pointer;"
             id="profileDropdown"
             data-bs-toggle="dropdown"
             aria-expanded="false">
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
          <li><a class="dropdown-item" href="user-profile.php">👤 My Profile</a></li>
          <li><a class="dropdown-item" href="settings.php">⚙️ Settings</a></li>
          <li><a class="dropdown-item" href="logout.php">🚪 Logout</a></li>
        </ul>
      </div>
    </div>

    <!-- Book Shipment -->
    <div class="container">
      <h2>📝 Book a Shipment</h2>
      <form method="POST">
        <div class="mb-3">
          <label for="origin" class="form-label">Origin</label>
          <input type="text" class="form-control" id="origin" name="origin" required>
        </div>
        <div class="mb-3">
          <label for="destination" class="form-label">Destination</label>
          <input type="text" class="form-control" id="destination" name="destination" required>
        </div>
        <div class="mb-3">
          <label for="weight" class="form-label">Weight (kg)</label>
          <input type="number" class="form-control" id="weight" name="weight" required>
        </div>
        <button type="submit" class="btn btn-primary">Book Shipment</button>
      </form>

      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $origin = $_POST['origin'];
          $destination = $_POST['destination'];
          $weight = $_POST['weight'];
          $date = date("Y-m-d H:i:s");

          // Example insert (adjust table name/columns to your DB)
          $insert = "INSERT INTO shipments (username, origin, destination, weight, status, booked_date) 
                     VALUES ('$username', '$origin', '$destination', '$weight', 'Pending', '$date')";
          if ($conn->query($insert) === TRUE) {
              echo "<div class='alert alert-success mt-3'>✅ Shipment booked successfully!</div>";
          } else {
              echo "<div class='alert alert-danger mt-3'>❌ Error: " . $conn->error . "</div>";
          }
      }
      ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById("theme-toggle").addEventListener("change", function() {
      document.body.classList.toggle("dark");
    });
  </script>
</body>
</html>
