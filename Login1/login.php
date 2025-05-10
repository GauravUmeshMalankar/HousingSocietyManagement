<?php
session_start();
if (isset($_SESSION['username'])) {
   header("Location: ../index.php"); 
   exit();
}
include('db.php');



if (isset($_POST['login'])) {
    $userType = $_POST['txtUsertype']; 
    $userName = $_POST['txtName']; 
    $password = $_POST['txtPass']; 
    
    if (empty($userType) || empty($userName) || empty($password)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
    
        $query = "SELECT * FROM users WHERE username = ? AND user_type = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            die("Query failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $userName, $userType);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
 
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_type'] = $row['user_type'];
                echo "<script>window.history.pushState();</script>";
                echo "<script>alert('Login successful!'); window.location.href='../index.php';</script>";
                exit();
            } else {
                echo "<script>alert('Invalid password!');</script>";
            }
        } else {
            echo "<script>alert('Invalid username or user type!');</script>";
        }
        
        $stmt->close();
    }
}
?>

<link rel="stylesheet" href="style.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="login.js"></script>
<div class="materialContainer">


   <div class="box">

      <div class="title">LOGIN</div>
      <form method="post">
         <div class="input">
            <label for="txtUsertype">UserType</label>
            <select name="txtUsertype" id="type">
               <option value="admin">Admin</option>
               <option value="user">User</option>
      
            </select>
            <span class="spin"></span>
         </div>

         <div class="input">
            <label for="txtName">Username</label>
            <input type="text" name="txtName" id="name">
            <span class="spin"></span>
         </div>

         <div class="input">
            <label for="pass">Password</label>
            <input type="password" name="txtPass" id="pass">
            <span class="spin"></span>
         </div>

         <div class="button login">
            <button type="submit" name="login"><span>GO</span> <i class="fa fa-check"></i></button>
         </div>
         <a href="Register.php" class="pass-forgot">Don't have an account? Register</a>

      </form>

   </div>


</div> 
