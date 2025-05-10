<?php 
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $name = trim($_POST['name']);
    $message = trim($_POST['message']);
    $date = $_POST['date'];

    if (!empty($name) && !empty($message) && !empty($date)) {
        $stmt = $conn->prepare("INSERT INTO events (event_title, event_description, event_date) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $message, $date);

        if ($stmt->execute()) {
            echo "<script>alert('Event added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding event.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}

$sql = "SELECT event_title, event_description, event_date FROM events ORDER BY event_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Society Events</title>
   
    <style> 
.home-section .home-content {
    margin-left: 250px; 
    position: relative;
}

.year-box .year {
    margin-left: 250px; 
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
    height: 100px;
    min-width: 190px;
    background: white;
    border: 2px solid red;
    border-radius: 10px;
    margin-left: 250px;
    transition: all 0.3s ease-in;
    color: black;
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
    color: red;
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
    padding: 3px;
    border-radius: 5px;
    width: 125px;
    color: white;
    font-weight: bold;
    text-align: center;
}

.event:hover {
    background: red;
    color: white;
    transform: scale(1.02);
    cursor: pointer;
}

.add-event-box {
    margin: 10px 20px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 5px;
    text-align: center;
}

.add-event-btn {
    background-color: red;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s;
}

.add-event-btn:hover {
    background-color: white;
    color: red;
    border: 2px solid red;
}
</style>

     <?php include('Sidebar.php'); ?>
     <link rel="stylesheet" href="css/styleMaster.css">
</head>
<body>
    <div class="home-content">
     
        <div class="year-box">
            <div class="year">2025</div>
            <br>
            <div class="add-event-box">
                <button class="btn btn-success add-event-btn" onclick="openModal()">+ Add Event</button>
            </div>
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
                        <p><?php echo nl2br(htmlspecialchars($row['event_description'])); ?></p>
                    </div>
                </div>
                <br>
            <?php endwhile; ?>
        </div>
    </div>

    
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
