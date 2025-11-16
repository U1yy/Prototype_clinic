<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Appointment</title>
    <link rel="stylesheet" href="Message_style.css">
</head>
<body>
    <form action="Appointment_Message.php" method="POST">
    <div class="appointment-container">
        <input type="hidden" name="category" id="selectedCategory">

        <div class="message-box">
        <label for="message"><b>Message / Symptoms / Request:</b></label>
        <br>
        <br>
        <textarea name="message" id="message" rows="4" placeholder="Describe your concern or request..."></textarea>
        </div>

        <button type="submit" class="submit-btn">Submit Appointment</button>
        </form>
    </div>
</body>
</html>