<?php
session_start();

// Check if doctor is logged in
if (!isset($_SESSION['doctor'])) {
    header('Location: login.php');
    exit;
}

$doctor_id = $_SESSION['doctor']['id'];

// Database connection (update with your credentials)
$mysqli = new mysqli('localhost', 'root', '', 'medilab');
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

// Handle form submission for add/update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $day = $_POST['day_of_week'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $schedule_id = $_POST['schedule_id'] ?? null;

    // Basic validation
    if ($start >= $end) {
        $error = "End time must be after start time.";
    } else {
        if ($schedule_id) {
            // Update existing schedule
            $stmt = $mysqli->prepare("UPDATE doctor_schedules SET day_of_week=?, start_time=?, end_time=? WHERE id=? AND doctor_id=?");
            $stmt->bind_param('sssii', $day, $start, $end, $schedule_id, $doctor_id);
            $stmt->execute();
            $stmt->close();
            $success = "Schedule updated successfully.";
        } else {
            // Insert new schedule
            $stmt = $mysqli->prepare("INSERT INTO doctor_schedules (doctor_id, day_of_week, start_time, end_time) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('isss', $doctor_id, $day, $start, $end);
            $stmt->execute();
            $stmt->close();
            $success = "Schedule added successfully.";
        }
    }
}

// Handle deletion
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM doctor_schedules WHERE id=? AND doctor_id=?");
    $stmt->bind_param('ii', $del_id, $doctor_id);
    $stmt->execute();
    $stmt->close();
    header("Location: schedule.php");
    exit;
}

// Fetch existing schedules
$stmt = $mysqli->prepare("SELECT id, day_of_week, start_time, end_time FROM doctor_schedule WHERE doctor_id=? ORDER BY FIELD(day_of_week, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'), start_time");
$stmt->bind_param('i', $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$schedules = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// For editing, load schedule if ?edit=ID is set
$edit_schedule = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $stmt = $mysqli->prepare("SELECT id, day_of_week, start_time, end_time FROM doctor_schedules WHERE id=? AND doctor_id=? LIMIT 1");
    $stmt->bind_param('ii', $edit_id, $doctor_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $edit_schedule = $res->fetch_assoc();
    $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Manage Schedule</title>
<style>
  table { border-collapse: collapse; width: 100%; margin-bottom: 1rem; }
  th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
  th { background-color: #f2f2f2; }
  form { margin-bottom: 2rem; }
  label { display: block; margin: 0.5rem 0 0.2rem; }
  input[type="time"], select { padding: 0.3rem; width: 100%; max-width: 150px; }
  button { margin-top: 1rem; padding: 0.5rem 1rem; }
  .error { color: red; }
  .success { color: green; }
  a.button-link { text-decoration: none; padding: 4px 8px; background: #007bff; color: white; border-radius: 3px; }
  a.button-link:hover { background: #0056b3; }
</style>
<?php include('head.php'); ?>

</head>
<body>
<?php include('header.php'); ?>

    <div style="padding:50px;">

<h2>Manage Your Schedule</h2>

<?php if (!empty($error)): ?>
  <p class="error"><?= htmlspecialchars($error) ?></p>
<?php elseif (!empty($success)): ?>
  <p class="success"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<form method="post" action="schedule.php">
  <input type="hidden" name="schedule_id" value="<?= $edit_schedule ? (int)$edit_schedule['id'] : '' ?>" />

  <label for="day_of_week">Day of Week:</label>
  <select id="day_of_week" name="day_of_week" required>
    <?php
    $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
    foreach ($days as $day) {
        $selected = ($edit_schedule && $edit_schedule['day_of_week'] === $day) ? 'selected' : '';
        echo "<option value=\"$day\" $selected>$day</option>";
    }
    ?>
  </select>

  <label for="start_time">Start Time:</label>
  <input type="time" id="start_time" name="start_time" required value="<?= $edit_schedule ? htmlspecialchars($edit_schedule['start_time']) : '' ?>" />

  <label for="end_time">End Time:</label>
  <input type="time" id="end_time" name="end_time" required value="<?= $edit_schedule ? htmlspecialchars($edit_schedule['end_time']) : '' ?>" />

  <button type="submit"><?= $edit_schedule ? 'Update Schedule' : 'Add Schedule' ?></button>
  <?php if ($edit_schedule): ?>
    <a href="schedule.php" class="button-link" style="background:#6c757d;">Cancel</a>
  <?php endif; ?>
</form>

<h3>Existing Schedules</h3>
<?php if (empty($schedules)): ?>
  <p>No schedules found.</p>
<?php else: ?>
  <table>
    <thead>
      <tr>
        <th>Day</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($schedules as $sched): ?>
        <tr>
          <td><?= htmlspecialchars($sched['day_of_week']) ?></td>
          <td><?= htmlspecialchars(substr($sched['start_time'], 0, 5)) ?></td>
          <td><?= htmlspecialchars(substr($sched['end_time'], 0, 5)) ?></td>
          <td>
            <a href="schedule.php?edit=<?= (int)$sched['id'] ?>" class="button-link" style="background:#28a745;">Edit</a>
            <a href="schedule.php?delete=<?= (int)$sched['id'] ?>" class="button-link" style="background:#dc3545;" onclick="return confirm('Are you sure you want to delete this schedule?');">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>
      </div>
      <?php include('footer.php'); ?>

</body>
</html>
