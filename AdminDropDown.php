<?php
// Start session only if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('db.php'); // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Get the logged-in username
$username = $_SESSION['username'];

// Fetch user details from the database
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Set profile image
$profileImage = (!empty($user['profile_image']) && file_exists("Login1/" . $user['profile_image'])) 
    ? "Login1/" . $user['profile_image'] 
    : 'images/1.png';

// User data
$admin_data = [
    'id' => $user['id'],
    'username' => $user['username'],
    'full_name' => ucfirst($user['username']), 
    'email' => $user['email'],
    'role' => ucfirst($user['user_type']),
    'join_date' => date("Y-m-d", strtotime($user['created_at'])),
    'profile_photo' =>  $profileImage
];
?>
<div class="dropdown  me-3">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo htmlspecialchars($admin_data['profile_photo']); ?>" 
                        alt="Profile Photo" class="rounded-circle" width="20" height="20">
                    <?php echo htmlspecialchars($admin_data['full_name']); ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li class="dropdown-header text-center">
                        <img src="<?php echo htmlspecialchars($admin_data['profile_photo']); ?>" 
                            alt="Profile Photo" class="rounded-circle" width="80" height="80">
                        <h6 class="mt-2"><?php echo htmlspecialchars($admin_data['full_name']); ?></h6>
                        <span class="badge bg-primary"><?php echo htmlspecialchars($admin_data['role']); ?></span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item"><i class="fas fa-user me-2"></i> <?php echo htmlspecialchars($admin_data['username']); ?></a></li>
                    <li><a class="dropdown-item"><i class="fas fa-envelope me-2"></i> <?php echo htmlspecialchars($admin_data['email']); ?></a></li>
                    <li><a class="dropdown-item"><i class="fas fa-calendar me-2"></i> Joined: <?php echo htmlspecialchars($admin_data['join_date']); ?></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                </ul>
            </div>
      