<?php  
include('db.php');  

if (isset($_POST['register'])) {
    $userType = $_POST['txtUsertype'];
    $userName = $_POST['txtName'];
    $email = $_POST['txtEmail'];
    $password = $_POST['txtPass'];
    $confpassword = $_POST['txtConfirmPass'];

    if ($password != $confpassword) {
        echo "<script>alert('Password must be the same!');</script>";
    } else {
        $query = "SELECT * FROM users
         WHERE username = '{$userName}' OR email = '{$email}'";
        $result = executeQuery($query);

        if ($result->num_rows == 0) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // ** Handle Profile Image Upload **
            $targetDir = "uploads/";  // Directory where images will be stored
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true); // Create uploads directory if not exists
            }

            $fileName = basename($_FILES["profile_image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            // Allowed file types
            $allowedTypes = ["jpg", "jpeg", "png", "gif"];
            $profileImage = '';

            if (!empty($_FILES["profile_image"]["name"]) && in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFilePath)) {
                    $profileImage = $targetFilePath; // Store image path in database
                } else {
                    echo "<script>alert('Error uploading the image!');</script>";
                }
            }

            // Insert user data into the database
            $query = "INSERT INTO users(user_type, username, email, password, profile_image) 
                      VALUES('{$userType}', '{$userName}', '{$email}', '{$hashedPassword}', '{$profileImage}')";
            
            $result = executeQuery($query);
            
            if ($result) {
            
                echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error storing user details!');</script>";
            }
        } else {
            echo "<script>alert('This username or email is already taken!');</script>";
        }
    }
}
?>

<link rel="stylesheet" href="style.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="login.js"></script>

<div class="materialContainer">
    <div class="box">
        <div class="title">REGISTER</div>
        <form method="post" enctype="multipart/form-data">
            <div class="input">
                <label for="type">User Type</label>
                <select name="txtUsertype" id="type">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="manager">Manager</option>
                </select>
            </div>

            <div class="input">
                <label for="name">Username</label>
                <input type="text" name="txtName" id="name">
            </div>

            <div class="input">
                <label for="email">Email</label>
                <input type="email" name="txtEmail" id="email">
            </div>

            <div class="input">
                <label for="pass">Password</label>
                <input type="password" name="txtPass" id="pass">
            </div>

            <div class="input">
                <label for="confirm_pass">Confirm Password</label>
                <input type="password" name="txtConfirmPass" id="confirm_pass">
            </div>

            <div class="input">
                <label for="profile_image">Profile Image</label>
                <input type="file" name="profile_image" id="profile_image" accept="image/*">
            </div>

            <div class="button register">
                <button type="submit" name="register"><span>Register</span> <i class="fa fa-check"></i></button>
            </div>

            <a href="login.php" class="pass-forgot">Already have an account? Login</a>
        </form>
    </div>
</div>
