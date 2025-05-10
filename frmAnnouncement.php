<?php 
session_start();
include("db.php");
// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: Login1/login.php");
    exit();
}



if (isset($_POST["submit"])) {
    $name = trim($_POST['name']);
    $message = trim($_POST['message']);
    $date = $_POST['date'];

    if (!empty($name) && !empty($message) && !empty($date)) {
        $stmt = $conn->prepare("INSERT INTO announcement (announcement_subject, announcement_text, created_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $message, $date);

        if ($stmt->execute()) {
            echo "<script>alert('Announcement added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding announcement.');</script>";
        }

        $stmt->close();
        // **Redirect to avoid form resubmission**
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>

 
    <style>
    /* Announcement Box */
    .home-content .content-box .day {
      width: 100%;
      border-radius: 12px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
      background: #fff;
      padding: 20px;
      margin-bottom: 20px;
      transition: all 0.3s ease-in-out;
      background: black !important; /* To make sure it's visible */
    }

    .day:hover {
      transform: scale(1.02);
    }

    .day .title {
      font-size: 24px;
      font-weight: bold;
      color: white;
      margin-bottom: 10px;
    }

    .day .annou-title {
      font-size: 22px;
      font-weight: bold;
      color: white;
     
    }

    .day .announce {
      border-radius: 12px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
      background: #fff;
      padding: 15px 14px;
      transition: transform 0.3s;
      color:white;
      background-color: red;

       /* To make sure it's visible */
    }

    .announce:hover {
      transform: scale(1.05);
      background-color: black;
    }
    
    </style>
    <?php include('Sidebar.php'); ?>  <!-- Sidebar should be here -->
    <link rel="stylesheet" href="css/styleMaster.css">
 
</head>
<body>


<section class="home-section">
    
<nav class="custom-navbar d-flex justify-content-between align-items-center">
        <h1>Announcement</h1>
        <?php
            include 'AdminDropDown.php';
        ?>
      </nav>

    <div class="home-content">
    <style>
    .add-announcement-box {
        margin: 10px 20px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 5px;
        text-align: center;
    }

    .add-announcement-btn {
        
        background-color: #f00;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s;
    }

    .add-announcement-btn:hover {
      background-color: #fff;
      color: #f00;
      border: 2px solid #f00;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: white;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
    }




    </style>


         <!-- Add Announcement Button Box -->
         <div class="add-announcement-box">
            <button class="btn btn-success add-announcement-btn" onclick="openModal()">+ Add Announcement</button>
        </div>
      
   
        <?php
          // Run the query again to reset the result set
          $sql = "SELECT announcement_subject, announcement_text, created_at FROM announcement ORDER BY created_at DESC";
          $result = $conn->query($sql);
        ?>
        <div class="content-box">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="day">
                    <div class="title"><?php echo date("F j, Y", strtotime($row['created_at'])); ?></div>
                    <div class="announce">
                        <div class="annou-title"><?php echo htmlspecialchars($row['announcement_subject']); ?></div>
                        <p><?php echo nl2br(htmlspecialchars($row['announcement_text'])); ?></p>
                    </div>
                </div>
                <br>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Modal for Adding Announcement -->
<div id="modalDialog" class="modal">
    <div class="modal-content animate-top">
        <div class="modal-header">
            <h5 class="modal-title">Add Announcement</h5>
            <button type="button" class="close" onclick="closeModal()">×</button>
        </div>
        <form action="" method="post" id="contactFrm">
            <div class="modal-body">
                <div class="response"></div>
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter the Title" required>
                </div>
                <div class="form-group">
                    <label>Message:</label>
                    <textarea name="message" class="form-control" placeholder="Your message here" rows="6" required></textarea>
                </div>
                <div class="form-group">
                    <label>Date:</label>
                    <input type="date" name="date" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        }
    </script>

<script>
function openModal() {
    document.getElementById("modalDialog").style.display = "block";
}

function closeModal() {
    document.getElementById("modalDialog").style.display = "none";
}

document.querySelector(".close").addEventListener("click", closeModal);
</script>

</body>

</html>