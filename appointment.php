<?php
include 'connection.php';
date_default_timezone_set('Asia/Manila');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST["category"] ?? '';
    $message = $_POST["message"] ?? '';
    $date = $_POST["date"] ?? '';
    $time = $_POST["time"] ?? '';

    // Optional: replace with real patient_id or worker_id later
    $patient_id = 1; 
    $worker_id = 1;  

    if (!empty($category) && !empty($date) && !empty($time) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO appointment (patient_id, worker_id, category, date, time, message) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $patient_id, $worker_id, $category, $date, $time, $message);
        $stmt->execute();
        echo "<script>alert('✅ Appointment confirmed successfully!');</script>";
    } else {
        echo "<script>alert('⚠️ Please complete all fields before submitting.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Barangay Health Center Appointment</title>
  <link rel="stylesheet" href="Homepage_style.css">
  <link rel="stylesheet" href="appointment_style.css">
  <link rel="stylesheet" href="Category_style.css">  
  <link rel="stylesheet" href="Calandar_Time_style.css">
  <link rel="stylesheet" href="Message_style.css">  
</head>
<body>
<header>
  <div class="item1">
      <a href="Homepage.php"><img src="Asset/Img/Logo.png" alt="Barangay Logo" class="logo"></a>
  </div>
  <div class="title item2">
      <h1>FULL NAME OF THE BARANGAY CENTER</h1>
  </div>
  <div class="search-section item3">
      <input type="text" placeholder="Search...">
  </div>
  <hr class="divider">
  <nav class="navbar item4">
      <a href="Homepage.php">Health Services</a>
      <a href="AboutUs.php">About Us</a>
      <a href="Appointment.php" class="active">Appointment</a>
      <a href="ContactUs.php">Contact Us</a>
  </nav>
</header>

<br><br>

<form action="" method="POST" id="appointmentForm">
<div class="grid-content">
    <!-- CATEGORY SECTION -->
    <div class="grid-item item-container1">
        <h2>Choose Category:</h2>
        <div class="category-grid">
            <?php
            $categories = [
              'Vaccine', 'Check up', 'Reschedule', 'Pediatric Care',
              'Follow up check up', 'Emergency', 'Screening', 'Other'
            ];
            foreach ($categories as $cat) {
                echo "<button type='button' class='category-button' onclick=\"selectCategory('$cat', this)\">$cat</button>";
            }
            ?>
        </div>
        <input type="hidden" name="category" id="selectedCategory">
    </div>

    <!-- MESSAGE SECTION -->
    <div class="grid-item item-container2">
        <h2>Message / Symptoms / Request:</h2>
        <textarea name="message" id="message" rows="5" placeholder="Describe your concern or request..."></textarea>
    </div>

    <!-- DATE & TIME SECTION -->
    <div class="grid-item item-container3">
        <?php
        // Week computation
        $today = date('Y-m-d');
        $day_of_week = date('N', strtotime($today));
        $monday = date('Y-m-d', strtotime($today . ' -' . ($day_of_week - 1) . ' days'));

        $week_days = [];
        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', strtotime("$monday +$i days"));
            $week_days[] = [
                'name' => date('D', strtotime($date)),
                'day' => date('j', strtotime($date)),
                'full' => $date
            ];
        }

        // Time slots
        $query = "SELECT DISTINCT time FROM appointment ORDER BY time ASC";
        $result = $conn->query($query);
        $time_slots = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $time_slots[] = date("h:ia", strtotime($row['time']));
            }
        } else {
            $time_slots = ["08:00am", "09:00am", "10:00am", "11:00am", "12:00pm", "01:30pm", "02:30pm", "03:30pm", "04:30pm", "05:30pm"];
        }
        ?>

        <h2>Choose a Date:</h2>
        <div class="date-row">
            <?php foreach ($week_days as $d): ?>
              <div class="date-box" onclick="selectDate(this)" data-date="<?= $d['full'] ?>">
                <div class="day-name"><?= $d['name'] ?></div>
                <div class="day-number"><?= $d['day'] ?></div>
              </div>
            <?php endforeach; ?>
        </div>

        <h2>Choose a Time:</h2>
        <div class="time-grid">
            <?php foreach ($time_slots as $t): ?>
              <div class="time-slot" onclick="selectTime(this)" data-time="<?= $t ?>"><?= $t ?></div>
            <?php endforeach; ?>
        </div>

        <input type="hidden" name="date" id="selectedDate">
        <input type="hidden" name="time" id="selectedTime">

        <button type="submit" class="submit-btn">Submit Appointment</button>
    </div>
</div>
</form>

<script>
function selectCategory(category, btn) {
  document.getElementById('selectedCategory').value = category;
  document.querySelectorAll('.category-button').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}

function selectDate(el) {
  document.getElementById('selectedDate').value = el.dataset.date;
  document.querySelectorAll('.date-box').forEach(box => box.classList.remove('selected'));
  el.classList.add('selected');
}

function selectTime(el) {
  document.getElementById('selectedTime').value = el.dataset.time;
  document.querySelectorAll('.time-slot').forEach(slot => slot.classList.remove('selected'));
  el.classList.add('selected');
}
</script>

</body>
</html>
