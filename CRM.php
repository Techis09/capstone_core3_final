<?php
include 'connection.php';
include('session.php');
requireRole('admin');

/* Add New User */
if (isset($_POST['add'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $email    = $conn->real_escape_string($_POST['email']);
    $role     = $conn->real_escape_string($_POST['role']);

    $sql = "INSERT INTO accounts (username, email, role) VALUES ('$username', '$email', '$role')";

    if ($conn->query($sql) === TRUE) {
        $activity = "Added new user: $username";
        $conn->query("INSERT INTO admin_activity (module, activity, status) VALUES ('CRM', '$activity', 'Success')");
        header("Location: CRM.php?success=1");
        exit();
    } else {
        $errorMsg = $conn->error;
        $conn->query("INSERT INTO admin_activity (module, activity, status) VALUES ('CRM', 'Add user failed: $username', 'Failed')");
        echo "Error: " . $errorMsg;
    }
}

/* Update User */
if (isset($_POST['update'])) {
    $id       = (int) $_POST['id'];
    $username = $conn->real_escape_string($_POST['username']);
    $email    = $conn->real_escape_string($_POST['email']);
    $role     = $conn->real_escape_string($_POST['role']);

    $sql = "UPDATE accounts SET username='$username', email='$email', role='$role' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $activity = "Updated user: $username";
        $conn->query("INSERT INTO admin_activity (module, activity, status) VALUES ('CRM', '$activity', 'Success')");
        header("Location: CRM.php?updated=1");
        exit();
    } else {
        $errorMsg = $conn->error;
        $conn->query("INSERT INTO admin_activity (module, activity, status) VALUES ('CRM', 'Update failed for ID $id', 'Failed')");
        echo "Error: " . $errorMsg;
    }
}

/* Delete User */
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $res = $conn->query("SELECT username FROM accounts WHERE id=$id");
    $row = $res->fetch_assoc();
    $username = $row ? $row['username'] : '';

    if ($conn->query("DELETE FROM accounts WHERE id=$id") === TRUE) {
        $activity = "Deleted user: $username";
        $conn->query("INSERT INTO admin_activity (module, activity, status) VALUES ('CRM', '$activity', 'Success')");
    } else {
        $conn->query("INSERT INTO admin_activity (module, activity, status) VALUES ('CRM', 'Delete failed for user ID $id', 'Failed')");
    }

    header("Location: CRM.php?deleted=1");
    exit;
}

/* Fetch Users */
$result = $conn->query("SELECT id, username, email, role, profile_image, created_at FROM accounts ORDER BY id DESC");

include("darkmode.php"); // for darkmode functionality
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --dark-bg: #1a1a2e;
            --dark-card: #16213e;
            --text-light: #f8f9fa;
            --text-dark: #212529;
            --border-radius: 0.35rem;
            --shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            margin: 0;
            background-color: var(--secondary-color);
            color: var(--text-dark);
        }

        body.dark-mode {
            background-color: var(--dark-bg);
            color: var(--text-light);
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #2c3e50;
            color: white;
            padding: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            transform: translateX(0);
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .sidebar .logo img {
            max-width: 100%;
            height: auto;
        }

        .system-name {
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1rem;
        }

        .sidebar a {
            display: block;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 3px solid white;
        }

        /* Main content */
        .content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: 0.3s;
        }

        .content.expanded {
            margin-left: 0;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        body.dark-mode .header {
            background-color: var(--dark-card);
            color: var(--text-light);
        }

        .hamburger {
            font-size: 1.5rem;
            cursor: pointer;
        }

        .theme-toggle-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th,
        td {
            padding: 0.75rem;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        thead {
            background-color: var(--primary-color);
            color: white;
        }

        body.dark-mode th,
        body.dark-mode td {
            border-bottom-color: #3a4b6e;
        }

        .dark-mode .card table{
            background-color: var(--dark-card);
            color: var(--text-light);
        }
        .dark-mode  {
            background-color: #3a4b6e;
            color: var(--text-light);
        }
        /* Theme Switch */
        .theme-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .theme-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: var(--primary-color);
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }
    </style>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <img src="rem.png" alt="SLATE Logo">
        </div>
        <h4 class="mb-3" style="text-align: center;">CORE TRANSACTION 3</h4>
        <a href="admin.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="CRM.php" class="active"><i class="bi bi-people me-2"></i> CRM</a>
        <a href="CSM.php"><i class="bi bi-file-text me-2"></i> Contract & SLA</a>
        <a href="E-Doc.php"><i class="bi bi-folder2-open me-2"></i> E-Docs</a>
        <a href="BIFA.php"><i class="bi bi-graph-up me-2"></i> BI & Freight</a>
        <a href="CPN.php"><i class="bi bi-globe me-2"></i> Customer Portal</a>
        <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
    </div>

    <div class="content" id="mainContent">
        <div class="header">
            <div class="hamburger" id="hamburger">☰</div>
            <h2>Customer Relationship Management</h2>
            <div class="theme-toggle-container">
                <span>Dark Mode</span>
                <label class="theme-switch">
                    <input type="checkbox" id="adminThemeToggle">
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0">Users</h5>
            
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                    <th class="text-center">Username</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="text-center"><?= htmlspecialchars($row['username']); ?></td>
                        <td class="text-center"><?= htmlspecialchars($row['email']); ?></td>
                        <td class="text-center">
                        <span class="badge bg-<?= $row['role'] === 'admin' ? 'danger' : ($row['role'] === 'manager' ? 'info' : 'secondary'); ?>">
                            <?= htmlspecialchars(ucfirst($row['role'])); ?>
                        </span>
                        </td>
                        <td class="text-center">
                        <button class="btn btn-info btn-sm view-btn"
                            data-username="<?= htmlspecialchars($row['username']); ?>"
                            data-email="<?= htmlspecialchars($row['email']); ?>"
                            data-role="<?= htmlspecialchars($row['role']); ?>"
                            data-profile="<?= !empty($row['profile_image']) ? $row['profile_image'] : 'default-avatar.png'; ?>"
                            data-created="<?= isset($row['created_at']) ? htmlspecialchars($row['created_at']) : ''; ?>">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-warning btn-sm edit-btn"
                            data-id="<?= $row['id']; ?>"
                            data-username="<?= htmlspecialchars($row['username']); ?>"
                            data-email="<?= htmlspecialchars($row['email']); ?>"
                            data-role="<?= htmlspecialchars($row['role']); ?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $row['id']; ?>">
                            <i class="bi bi-trash"></i>
                        </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                </table>
            </div>
            </div>
        </div>

        <!-- Add User Modal -->
        
        <!-- View Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewUsername"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p id="viewEmail"></p>
                        <p id="viewRole"></p>
                        <p id="viewJoined"></p>
                        <img id="viewProfile" src="" width="100" class="img-thumbnail">
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="editId" name="id">
                            <div class="mb-2">
                                <label>Username</label>
                                <input type="text" id="editUsername" name="username" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Email</label>
                                <input type="email" id="editEmail" name="email" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Role</label>
                                <select id="editRole" name="role" class="form-control" required>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                    <option value="manager">Manager</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="update" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div> <!-- content end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Darkmode init
        initDarkMode("adminThemeToggle", "adminDarkMode");

        // Sidebar toggle
        document.getElementById('hamburger').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('mainContent').classList.toggle('expanded');
        });

        // View Modal
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('viewUsername').textContent = btn.dataset.username;
                document.getElementById('viewEmail').textContent = 'Email: ' + btn.dataset.email;
                document.getElementById('viewRole').textContent = 'Role: ' + btn.dataset.role;
                document.getElementById('viewJoined').textContent = 'Joined: ' + btn.dataset.created;
                document.getElementById('viewProfile').src = btn.dataset.profile;
                new bootstrap.Modal(document.getElementById('viewModal')).show();
            });
        });

        // Edit Modal
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('editId').value = btn.dataset.id;
                document.getElementById('editUsername').value = btn.dataset.username;
                document.getElementById('editEmail').value = btn.dataset.email;
                document.getElementById('editRole').value = btn.dataset.role;
                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
        });

        // Delete SweetAlert
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                let id = btn.dataset.id;
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This user will be deleted!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'CRM.php?delete=' + id;
                    }
                });
            });
        });

        // Success alerts
        const params = new URLSearchParams(window.location.search);
        if (params.has('success')) Swal.fire('Added!', 'User added successfully.', 'success');
        if (params.has('updated')) Swal.fire('Updated!', 'User updated successfully.', 'success');
        if (params.has('deleted')) Swal.fire('Deleted!', 'User deleted successfully.', 'success');
    </script>
</body>

</html>