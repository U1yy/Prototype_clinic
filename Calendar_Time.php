<?php
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Appointment Schedule</title>
<link rel="stylesheet" href="Calandar_Time_style.css">
</head>
<body>

<div class="container">
  <h2>Choose a Date</h2>
  <div class="date-row">
    <?php foreach ($week_days as $d): ?>
      <div class="date-box" onclick="selectDate(this)" data-date="<?= $d['full'] ?>">
        <div class="day-name"><?= $d['name'] ?></div>
        <div class="day-number"><?= $d['day'] ?></div>
      </div>
    <?php endforeach; ?>
  </div>
      
  <div class="time-grid">
    <?php foreach ($time_slots as $t): ?>
      <div class="time-slot" onclick="selectTime(this)" data-time="<?= $t ?>"><?= $t ?></div>
    <?php endforeach; ?>
  </div>
</div>

<script>
let selectedDate = null;
let selectedTime = null;

function selectDate(el) {
  document.querySelectorAll('.date-box').forEach(box => box.classList.remove('selected'));
  el.classList.add('selected');
  selectedDate = el.dataset.date;
}

function selectTime(el) {
  document.querySelectorAll('.time-slot').forEach(slot => slot.classList.remove('selected'));
  el.classList.add('selected');
  selectedTime = el.dataset.time;
  if (selectedDate) {
    alert(`You selected: ${selectedDate} at ${selectedTime}`);
  } else {
    alert("Please select a date first.");
  }
}
</script>

</body>
</html>
