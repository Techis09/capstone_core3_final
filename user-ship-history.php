<?php
session_start();

include('connection.php'); // DB connection

// Example: store username in session (you probably already set this on login)
if (!isset($_SESSION['username'])) {
  $_SESSION['username'] = "roy"; // change to logged-in username
}

// Handle upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_pic'])) {
    $username = $_SESSION['username'];
    $targetDir = "uploads/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = time() . "_" . basename($_FILES['profile_pic']['name']);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFilePath)) {
        $sql = "UPDATE accounts SET profile_image = '$targetFilePath' WHERE username = '$username'";
        mysqli_query($conn, $sql);
    }
}

// Fetch profile image
$username = $_SESSION['username'];
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
  <title>User Shipment History</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --bg-color: #f8f9fa;
      --text-color: #000;
      --container-bg: #fff;
      --table-header-bg: #007bff;
      --table-header-text: #fff;
      --hover-color: #f1f1f1;
    }
    body.dark {
      --bg-color: #121212;
      --text-color: #f8f9fa;
      --container-bg: #1e1e1e;
      --table-header-bg: #0056b3;
      --table-header-text: #fff;
      --hover-color: #2a2a2a;
    }
    body { background: var(--bg-color); color: var(--text-color); }
    .sidebar { height: 100vh; background: #2c3e50; padding: 20px; position: fixed; width: 240px; color: white; }
    .sidebar a { display: block; padding: 12px; color: white; text-decoration: none; }
    .sidebar a:hover, .sidebar a.active { background: #0056b3; border-radius: 5px; }
    .main { margin-left: 240px; padding: 20px; }
    .topbar { display: flex; justify-content: flex-end; gap: 15px; }
    .container { background: var(--container-bg); padding: 25px; border-radius: 10px; margin-top: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: center; }
    th { background: var(--table-header-bg); color: var(--table-header-text); }
    tr:hover { background: var(--hover-color); }
    .pending { color: orange; font-weight: bold; }
    .intransit { color: green; font-weight: bold; }
    .delivered { color: blue; font-weight: bold; }
    .cancelled { color: red; font-weight: bold; }
  </style>
</head>
<body>

<div class="sidebar">
  <div class="text-center mb-4">
    <img src="logo.png" alt="Logo" class="img-fluid mb-2" style="max-width:120px;">
    <h5>Freight System</h5>
  </div>
  <a href="user-acct.php">🏠 Dashboard</a>
  <a href="user-shipment.php">📦 Track Shipment</a>
  <a href="user-book-shipment.php">📝 Book Shipment</a>
  <a href="user-shipment-history.php" class="active">📜 Shipment History</a>
</div>

<div class="main">
  <div class="topbar">
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" id="theme-toggle">
      <label for="theme-toggle">🌙</label>
    </div>

    <!-- Profile dropdown -->
    <div class="dropdown">
      <img src="<?php echo $profileImage; ?>" 
           class="rounded-circle" 
           style="width:55px; height:55px; object-fit:cover; border:2px solid #0d6efd; cursor:pointer;"
           id="profileDropdown" data-bs-toggle="dropdown">
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <!-- Upload form inside dropdown -->
          <form method="post" enctype="multipart/form-data" class="px-3 py-2">
            <input type="file" name="profile_pic" class="form-control mb-2" required>
            <button type="submit" class="btn btn-sm btn-primary w-100">Upload</button>
          </form>
        </li>
        <li><a class="dropdown-item" href="settings.php">⚙️ Settings</a></li>
        <li><a class="dropdown-item" href="logout.php">🚪 Logout</a></li>
      </ul>
    </div>
  </div>

  <div class="container">
    <h2>📜 User Shipment History</h2>
    <table>
      <thead>
        <tr>
          <th>Tracking No</th>
          <th>Origin</th>
          <th>Destination</th>
          <th>Weight (kg)</th>
          <th>Status</th>
          <th>Booked Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $shipments = [
          ["FRT12345", "Manila", "Cebu", "25", "In Transit", "2025-09-01"],
          ["FRT67890", "Davao", "Manila", "10", "Delivered", "2025-08-28"],
          ["FRT54321", "Cebu", "Iloilo", "15", "Pending", "2025-08-25"],
        ];
        foreach ($shipments as $s) {
          $statusClass = strtolower(str_replace(" ", "", $s[4]));
          echo "<tr>
                  <td>{$s[0]}</td>
                  <td>{$s[1]}</td>
                  <td>{$s[2]}</td>
                  <td>{$s[3]}</td>
                  <td class='{$statusClass}'>{$s[4]}</td>
                  <td>{$s[5]}</td>
                </tr>";
        }
        ?>
      </tbody>
    </table>
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
