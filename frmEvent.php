<?php
session_start();
include('db.php');

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: Login1/login.php");
    exit();
}


if (isset($_POST["submit"])) {
    $name = trim($_POST['name']);
    $message = trim($_POST['message']);
    $date = $_POST['date'];
    $time = $_POST['time'];

    if (!empty($name) && !empty($message) && !empty($date) && !empty($time)) {
        $stmt = $conn->prepare("INSERT INTO events (event_title, event_description, event_date, event_time, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $name, $message, $date, $time);

        if ($stmt->execute()) {
            echo "<script>alert('Event added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding event.');</script>";
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
    <title>Society Event</title>
    <style>
.home-section .home-content {
    margin-left: 250px; /* Same width as sidebar */
    position: relative;
}

.year-box .year {
    margin-left: 250px; /* Same width as sidebar */
    width: calc(100% - 60px);
    font-weight: bolder;
    font-size: x-large;
    text-align: center;
    color: black;
    border-bottom: 1px solid black;
}

.year-box .event {
    display: flex;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    height: 120px;
    min-width: 190px;
    background: black;
    border: 2px solid red;
    border-radius: 10px;
    margin-left: 250px;
    transition: all 0.3s ease-in;
    color: white;
}

.event .event-left {
    background: black;
    color: white;
    width: 100px;
    border-radius: 10px 0px 0px 10px;
}

.event-left .event-day {
    align-items: center;
    text-align: center;
    padding: 20px 10px;
}

.event-day .event-date {
    font-size: 30px;
    font-weight: 700;
    font-family: Arial, Helvetica, sans-serif;
    color: white;
}

.event-day .event-month {
    font-size: 20px;
    font-family: Arial, Helvetica, sans-serif;
    color: white;
}

.event-right {
    padding: 20px 30px;
}

.event-right .event-title {
    font-size: 25px;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: 800;
}

.event-right .event-time {
    background-color: red;
    color: white;
    padding: 3px;
    border-radius: 5px;
    width: 125px;
    text-align: center;
    font-weight: bold;
}

.event:hover {
    background: red;
    color: black;
    transform: scale(1.02);
    cursor: pointer;
}
.event-time:hover{
    background: black;
    color: white;


}
</style>
    <?php include('Sidebar.php'); ?>
    <link rel="stylesheet" href="css/styleMaster.css">

 
</head>
<body>

<div class="home-content">
    <!-- Navbar -->
    <nav class="custom-navbar d-flex justify-content-between align-items-center">
        <h1>Society Events</h1>
        <?php
            include 'AdminDropDown.php';
        ?>
      </nav>
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
       </div>
    
        <!-- Add Announcement Button Box -->
        <div class="add-announcement-box" >
           <button class="btn btn-success add-announcement-btn" onclick="openModal()" style="margin-left:240px;">+ Add Events</button>
       </div>

    
    <div class="year-box">
    <div class="year">2025</div>
    <br>
    <?php
        // Fetch events from database
        $sql = "SELECT event_title, event_description, event_date, event_time 
                FROM events 
                WHERE event_date >= CURDATE() 
                ORDER BY event_date ASC";
        $result = $conn->query($sql);
    ?>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="event">
            <div class="event-left">
                <div class="event-day">
                    <div class="event-date"><?php echo date("d", strtotime($row['event_date'])); ?></div>
                    <div class="event-month"><?php echo date("M", strtotime($row['event_date'])); ?></div>
                </div>
            </div>
            <div class="event-right">
                <h3 class="event-title"><?php echo htmlspecialchars($row['event_title']); ?></h3> 
                <div class="event-time">
                    <i class="bx bxs-time"></i>
                    <span class="time-text"><?php echo date("g:i A", strtotime($row['event_time'])); ?></span>
                </div>
                <p><?php echo nl2br(htmlspecialchars($row['event_description'])); ?></p>
            </div>
        </div>
        <br>
    <?php endwhile; ?>
</div>
   



<!-- Modal for Adding Event -->
<div id="modalDialog" class="modal">
    <div class="modal-content animate-top">
        <div class="modal-header">
            <h5 class="modal-title">Add Event</h5>
            <button type="button" class="close" onclick="closeModal()">×</button>
        </div>
        <form action="" method="post" id="contactFrm">
            <div class="modal-body">
                <div class="response"></div>

                <div class="form-group">
                    <label>Event Title:</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter the Title" required>
                </div>

                <div class="form-group">
                    <label>Event Description:</label>
                    <textarea name="message" class="form-control" placeholder="Your message here" rows="6" required></textarea>
                </div>

                <div class="form-group">
                    <label>Event Date:</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Event Time:</label>
                    <input type="time" name="time" class="form-control" required>
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