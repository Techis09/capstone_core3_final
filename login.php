<?php
session_start();
include("connection.php");

$error = "";
$success = "";
$showRegister = false; // for staying in register form
$alert = ""; // for sweetalert

// Handle AJAX requests for live check
if (isset($_GET['check'])) {
  $field = $_GET['check'];
  $value = trim($_GET['value']);
  $response = '';

  if ($field === 'username') {
    $stmt = $conn->prepare("SELECT id FROM accounts WHERE username=?");
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) $response = 'Username already taken!';
    $stmt->close();
  }

  if ($field === 'email') {
    $stmt = $conn->prepare("SELECT id FROM accounts WHERE email=?");
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) $response = 'Email already registered!';
    $stmt->close();
  }

  echo $response;
  exit();
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, role FROM accounts WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
      $stmt->bind_result($id, $db_username, $db_password, $role);
      $stmt->fetch();

      if (password_verify($password, $db_password)) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $db_username;
        $_SESSION['role'] = $role;

        $redirect = ($role === 'admin') ? 'admin.php' : 'user-acct.php';
        $alert = "<script>
          Swal.fire({
            icon: 'success',
            title: 'Login successful!',
            text: 'Welcome, $db_username',
            confirmButtonColor: '#3085d6'
          }).then(() => {
            window.location.href = '$redirect';
          });
        </script>";
      } else {
        $alert = "<script>
          Swal.fire({ icon: 'error', title: 'Oops...', text: 'Invalid password!' });
        </script>";
      }
    } else {
      $alert = "<script>
        Swal.fire({ icon: 'error', title: 'Oops...', text: 'No account found with that username.' });
      </script>";
    }
    $stmt->close();
  } elseif (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Password validation
    if (!preg_match("/^(?=.*[a-z])(?=.*\d).{8,}$/", $password)) {
      $alert = "<script>
        Swal.fire({ icon: 'warning', title: 'Weak Password', text: 'Password must be at least 8 characters, include a lowercase letter and a number.' });
      </script>";
    } elseif ($password !== $confirm) {
      $alert = "<script>
        Swal.fire({ icon: 'error', title: 'Password Mismatch', text: 'Passwords do not match!' });
      </script>";
    } else {
      $check = $conn->prepare("SELECT id FROM accounts WHERE username=? OR email=?");
      $check->bind_param("ss", $username, $email);
      $check->execute();
      $check->store_result();

      if ($check->num_rows > 0) {
        $alert = "<script>
          Swal.fire({ icon: 'error', title: 'Account Exists', text: 'Username or Email already exists!' });
        </script>";
      } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO accounts (username, email, password, role) VALUES (?, ?, ?, 'user')");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
          $alert = "<script>
            Swal.fire({
              icon: 'success',
              title: 'Registration Successful',
              text: 'You can now login with your account.',
              confirmButtonColor: '#3085d6'
            }).then(() => { showLogin(); });
          </script>";
        } else {
          $alert = "<script>
            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong: " . $stmt->error . "' });
          </script>";
        }
        $stmt->close();
      }
      $check->close();
    }

    if (!empty($alert)) $showRegister = true;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SLATE System</title>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    /* Your CSS (unchanged) */
    /* Base and layout styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', system-ui, sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      color: white;
      line-height: 1.6;
    }

    .main-container {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }

    .login-container {
      width: 100%;
      max-width: 75rem;
      display: flex;
      background: rgba(31, 42, 56, 0.8);
      border-radius: .75rem;
      overflow: hidden;
      box-shadow: 0 .625rem 1.875rem rgba(0, 0, 0, .3);
    }

    .welcome-panel {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2.5rem;
      background: linear-gradient(135deg, rgba(0, 114, 255, .2), rgba(0, 198, 255, .2));
    }

    .welcome-panel h1 {
      font-size: 2.25rem;
      font-weight: 700;
      color: #fff;
      text-shadow: .125rem .125rem .5rem rgba(0, 0, 0, .6);
      text-align: center;
    }

    .form-panel {
      width: 25rem;
      padding: 3.75rem 2.5rem;
      background: rgba(22, 33, 49, .95);
    }

    .form-box {
      text-align: center;
      width: 100%;
    }

    .form-box img {
      width: 6.25rem;
      margin-bottom: 1.25rem;
    }

    .form-box h2 {
      margin-bottom: 1.5625rem;
      color: #fff;
      font-size: 1.75rem;
    }

    .login-form input,
    .register-form input {
      width: 100%;
      padding: .75rem;
      margin-bottom: .5rem;
      border: 1px solid rgba(255, 255, 255, .1);
      border-radius: .375rem;
      background: rgba(255, 255, 255, .1);
      color: #fff;
      font-size: 1rem;
      transition: .3s;
    }

    .login-form input:focus,
    .register-form input:focus {
      outline: none;
      border-color: #00c6ff;
      box-shadow: 0 0 0 .125rem rgba(0, 198, 255, .2);
    }

    .login-form button,
    .register-form button {
      width: 100%;
      padding: .75rem;
      background: linear-gradient(to right, #0072ff, #00c6ff);
      border: none;
      border-radius: .375rem;
      font-weight: 600;
      font-size: 1rem;
      color: #fff;
      cursor: pointer;
      transition: .3s;
      margin-top: .5rem;
    }

    .login-form button:hover,
    .register-form button:hover {
      background: linear-gradient(to right, #0052cc, #009ee3);
      transform: translateY(-.125rem);
      box-shadow: 0 .3125rem .9375rem rgba(0, 0, 0, .2);
    }

    .inline-message {
      font-size: .9rem;
      margin-top: -.25rem;
      margin-bottom: .5rem;
    }

    .inline-message.error {
      color: #ff6b6b;
    }

    .inline-message.success {
      color: #4caf50;
    }

    .switch-link {
      margin-top: 1rem;
      font-size: .9rem;
    }

    .switch-link a {
      color: #00c6ff;
      cursor: pointer;
      text-decoration: none;
    }

    .switch-link a:hover {
      text-decoration: underline;
    }

    footer {
      text-align: center;
      padding: 1.25rem;
      background: rgba(0, 0, 0, .2);
      color: rgba(255, 255, 255, .7);
      font-size: .875rem;
    }

    @media (max-width:48rem) {
      .login-container {
        flex-direction: column;
      }

      .welcome-panel,
      .form-panel {
        width: 100%;
      }

      .welcome-panel {
        padding: 1.875rem 1.25rem;
      }

      .welcome-panel h1 {
        font-size: 1.75rem;
      }

      .form-panel {
        padding: 2.5rem 1.25rem;
      }

      .form-box h2 {
        font-size: 1.5rem;
      }
    }

    @media (max-width:30rem) {
      .main-container {
        padding: 1rem;
      }

      .welcome-panel h1 {
        font-size: 1.5rem;
      }

      .form-box h2 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>

<body>
  <div class="main-container">
    <div class="login-container">
      <div class="welcome-panel">
        <h1>FREIGHT MANAGEMENT SYSTEM</h1>
      </div>
      <div class="form-panel">
        <div class="form-box">
          <img src="rem.png" alt="SLATE Logo">
          <h2 id="formTitle">SLATE Login</h2>

          <!-- Login Form -->
          <form id="loginForm" class="login-form" method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Log In</button>
          </form>

          <!-- Register Form -->
          <form id="registerForm" class="register-form" method="POST" action="login.php" style="display:none;">
            <input type="text" name="username" placeholder="Username" required oninput="checkAvailability('username', this.value)">
            <div id="usernameMessage" class="inline-message error"></div>

            <input type="email" name="email" placeholder="Email" required oninput="checkAvailability('email', this.value)">
            <div id="emailMessage" class="inline-message error"></div>

            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <div id="matchMessage" class="inline-message"></div>

            <button type="submit" name="register">Register</button>
          </form>

          <div class="switch-link" id="switchToRegister">Don’t have an account? <a onclick="showRegister()">Register</a></div>
          <div class="switch-link" id="switchToLogin" style="display:none;">Already have an account? <a onclick="showLogin()">Login</a></div>
        </div>
      </div>
    </div>
  </div>

  <footer>&copy; <span id="currentYear"></span> SLATE Freight Management System. All rights reserved.</footer>

  <script>
    document.getElementById('currentYear').textContent = new Date().getFullYear();

    function showRegister() {
      document.getElementById('loginForm').style.display = 'none';
      document.getElementById('registerForm').style.display = 'block';
      document.getElementById('formTitle').textContent = 'SLATE Register';
      document.getElementById('switchToRegister').style.display = 'none';
      document.getElementById('switchToLogin').style.display = 'block';
    }

    function showLogin() {
      document.getElementById('loginForm').style.display = 'block';
      document.getElementById('registerForm').style.display = 'none';
      document.getElementById('formTitle').textContent = 'SLATE Login';
      document.getElementById('switchToRegister').style.display = 'block';
      document.getElementById('switchToLogin').style.display = 'none';
    }

    // Password match check
    const passwordInput = document.querySelector('#registerForm input[name="password"]');
    const confirmInput = document.querySelector('#registerForm input[name="confirm_password"]');
    confirmInput.addEventListener('input', () => {
      let messageBox = document.getElementById('matchMessage');
      if (confirmInput.value === "") {
        messageBox.textContent = "";
        return;
      }
      if (passwordInput.value !== confirmInput.value) {
        messageBox.textContent = "Passwords do not match!";
        messageBox.style.color = "#ff6b6b";
      } else {
        messageBox.textContent = "Passwords match!";
        messageBox.style.color = "#4caf50";
      }
    });

    // Live check for username/email
    function checkAvailability(field, value) {
      if (value === "") {
        document.getElementById(field + 'Message').textContent = "";
        return;
      }
      fetch(`login.php?check=${field}&value=${encodeURIComponent(value)}`)
        .then(res => res.text())
        .then(data => {
          document.getElementById(field + 'Message').textContent = data;
        });
    }

    // Stay in register form if error
    <?php if ($showRegister): ?>
      showRegister();
    <?php endif; ?>
  </script>

  <!-- Show SweetAlert after PHP actions -->
  <?= $alert ?? '' ?>
</body>
</html>
