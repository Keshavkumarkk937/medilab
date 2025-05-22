<?php
  session_start();
  $cn = mysqli_connect("localhost", "root", "", "Medilab");
  if (!$cn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  // Fetch logged-in user data
  $userData = [];
  if (isset($_SESSION['user']['id'])) {
      $userId = (int)$_SESSION['user']['id'];
      $query = mysqli_query($cn, "SELECT * FROM users WHERE id = $userId");
      if ($query && mysqli_num_rows($query) > 0) {
          $userData = mysqli_fetch_assoc($query);
      }
  } else {
      die("User not logged in.");
  }

  // Fetch doctors list to populate doctor dropdown
  $doctors = [];
  $query2 = mysqli_query($cn, "SELECT * FROM doctors");
  while ($row = mysqli_fetch_assoc($query2)) {
      $doctors[] = $row;
  }

  // Handle AJAX request for available slots
  if (isset($_GET['action']) && $_GET['action'] === 'get_slots') {
      // Parameters sent via GET
      $doctorId = isset($_GET['doctor_id']) ? (int)$_GET['doctor_id'] : 0;
      $date = isset($_GET['date']) ? $_GET['date'] : '';

      if (!$doctorId || !$date) {
          echo json_encode(['error' => 'Invalid parameters']);
          exit;
      }

      // Fetch doctor's appointment duration in minutes
      $doctorQuery = mysqli_query($cn, "SELECT appointment_duration FROM doctors WHERE id = $doctorId");
      if (!$doctorQuery || mysqli_num_rows($doctorQuery) == 0) {
          echo json_encode(['error' => 'Doctor not found']);
          exit;
      }
      $doctor = mysqli_fetch_assoc($doctorQuery);
      $duration = (int)$doctor['appointment_duration'];

      // Get day of week for the requested date (0=Sunday, 6=Saturday)
      $dayOfWeek = date('w', strtotime($date));

      // Fetch doctor's schedule for that day
      $scheduleQuery = mysqli_query($cn, "SELECT start_time, end_time FROM doctor_schedule WHERE doctor_id = $doctorId AND day_of_week = $dayOfWeek");
      if (!$scheduleQuery || mysqli_num_rows($scheduleQuery) == 0) {
          echo json_encode(['slots' => []]); // no schedule means no slots
          exit;
      }

      // Gather all available slots
      $slots = [];

      // Fetch existing booked appointments for this doctor and date
      $bookedQuery = mysqli_query($cn, "SELECT start_time FROM appointment WHERE doctor_id = $doctorId AND date = '$date'");
      $bookedSlots = [];
      while ($row = mysqli_fetch_assoc($bookedQuery)) {
          $bookedSlots[] = $row['start_time'];
      }

      while ($schedule = mysqli_fetch_assoc($scheduleQuery)) {
          $start = strtotime($schedule['start_time']);
          $end = strtotime($schedule['end_time']);

          // Generate slots between start and end time
          for ($time = $start; $time + $duration * 60 <= $end; $time += 15 * 60) { // 15 min interval steps
              $slotTime = date('H:i:s', $time);

              // Exclude already booked slots
              if (!in_array($slotTime, $bookedSlots)) {
                  $slots[] = $slotTime;
              }
          }
      }

      // Return slots as JSON
      echo json_encode(['slots' => $slots]);
      exit;
  }

  // Handle form submission for appointment booking
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['doctor'], $_POST['date'], $_POST['time'], $_POST['end_time'])) {
      // Sanitize and validate inputs
      $title = mysqli_real_escape_string($cn, $_POST['title']);
      $message = mysqli_real_escape_string($cn, $_POST['message'] ?? '');
      $doctorId = (int)$_POST['doctor'];
      $appointmentDate = mysqli_real_escape_string($cn, $_POST['date']);
      $start_time = mysqli_real_escape_string($cn, $_POST['time']);
      $end_time = mysqli_real_escape_string($cn, $_POST['end_time']);

      // Check for appointment conflict
      $checkQuery = "SELECT * FROM appointment WHERE doctor_id = $doctorId AND date = '$appointmentDate' AND start_time = '$start_time'";
      $checkResult = mysqli_query($cn, $checkQuery);

      if (mysqli_num_rows($checkResult) > 0) {
          // Conflict found - prepare message and show alert
          echo "<script>alert('Sorry, this time slot is already booked for the selected doctor. Please choose another slot.');</script>";
      } else {
          // Insert new appointment
          $insertQuery = "INSERT INTO appointment (user_id, doctor_id, date, start_time, end_time, title, message, status, slot_id)
                          VALUES ($userId, $doctorId, '$appointmentDate', '$start_time', '$end_time', '$title', '$message', 0, NULL)";
          if (mysqli_query($cn, $insertQuery)) {
              echo "<script>alert('Appointment booked successfully.'); window.location.href='appointment.php';</script>";
              exit;
          } else {
              echo "Error: " . mysqli_error($cn);
          }
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Book Appointment - Medilab</title>
  <?php include('head.php'); ?>
</head>
<body>

<?php include('header.php'); ?>

<section id="appointment" class="appointment section">
  <div class="container section-title" data-aos="fade-up">
    <h2>Appointment</h2>
    <p>Book your appointment with ease and convenience — anytime, anywhere.
       Get timely care from our trusted medical professionals.</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <form action="appointment.php" method="post" role="form" class="form" id="appointmentForm">
      <div class="row">
        <!-- User details prefilled and readonly -->
        <div class="col-md-3 form-group">
          <input type="text" name="name" class="form-control" placeholder="Your Name" value="<?= htmlspecialchars($userData['name']) ?>" required readonly disabled>
        </div>
        <div class="col-md-3 form-group mt-3 mt-md-0">
          <input type="email" class="form-control" name="email" placeholder="Your Email" value="<?= htmlspecialchars($userData['email']) ?>" required readonly>
        </div>
        <div class="col-md-3 form-group mt-3 mt-md-0">
          <input type="tel" class="form-control" name="phone" placeholder="Your Phone" value="<?= htmlspecialchars($userData['contact']) ?>" required readonly>
        </div>
        <div class="col-md-3 form-group mt-3 mt-md-0">
          <input type="date" class="form-control" name="dob" placeholder="Your DOB" value="<?= htmlspecialchars($userData['dob']) ?>" required readonly>
        </div>
      </div>

      <div class="row mt-3">
        <!-- Doctor selection dropdown -->
        <div class="col-md-3 form-group">
          <select name="doctor" id="doctor" class="form-select" required>
            <option value="">Select Doctor</option>
            <?php foreach ($doctors as $doctor): ?>
              <option value="<?= (int)$doctor['id'] ?>" data-duration="<?= (int)$doctor['appointment_duration'] ?>">
                <?= htmlspecialchars(ucwords($doctor['name'])) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Date picker -->
        <div class="col-md-3 form-group">
          <input type="date" name="date" id="date" class="form-control" required min="<?= date('Y-m-d') ?>">
        </div>

        <!-- Time slots dropdown - dynamically populated -->
        <div class="col-md-3 form-group">
          <select name="time" id="time" class="form-select" required>
            <option value="">Select Time Slot</option>
            <!-- Options added dynamically -->
          </select>
        </div>

        <!-- End time auto-calculated and readonly -->
        <div class="col-md-3 form-group">
          <input type="time" name="end_time" id="end_time" class="form-control" readonly required>
        </div>
      </div>

      <!-- Appointment title and message -->
      <div class="form-group mt-3">
        <input type="text" name="title" class="form-control" placeholder="Disease" required>
      </div>

      <div class="form-group mt-3">
        <textarea class="form-control" name="message" rows="5" placeholder="Message (Optional)"></textarea>
      </div>

      <div class="mt-3 text-center">
        <button type="submit" class="btn btn-primary">Make an Appointment</button>
      </div>
    </form>
  </div>
</section>

<?php include('footer.php'); ?>

<!-- JS: Fetch available slots and auto-calculate end time -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const doctorSelect = document.getElementById('doctor');
  const dateInput = document.getElementById('date');
  const timeSelect = document.getElementById('time');
  const endTimeInput = document.getElementById('end_time');

  let appointmentDuration = 0; // in minutes

  // When doctor changes, update appointment duration and clear slots/time
  doctorSelect.addEventListener('change', function() {
    appointmentDuration = parseInt(this.options[this.selectedIndex].getAttribute('data-duration')) || 0;
    timeSelect.innerHTML = '<option value="">Select Time Slot</option>';
    endTimeInput.value = '';
  });

  // When date changes, fetch available slots if doctor selected
  dateInput.addEventListener('change', fetchSlots);
  doctorSelect.addEventListener('change', fetchSlots);

  // Fetch available slots via AJAX
  function fetchSlots() {
    const doctorId = doctorSelect.value;
    const date = dateInput.value;

    // Clear previous slots and end time
    timeSelect.innerHTML = '<option value="">Select Time Slot</option>';
    endTimeInput.value = '';

    if (!doctorId || !date) {
      return; // don't fetch if missing data
    }

    fetch(`appointment.php?action=get_slots&doctor_id=${doctorId}&date=${date}`)
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          alert('Error fetching slots: ' + data.error);
          return;
        }
        if (data.slots.length === 0) {
          timeSelect.innerHTML = '<option value="">No available slots</option>';
          return;
        }

        // Populate time slots dropdown with formatted times
        data.slots.forEach(slot => {
          const displayTime = formatTime(slot);
          const option = document.createElement('option');
          option.value = slot;
          option.textContent = displayTime;
          timeSelect.appendChild(option);
        });
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Could not fetch available slots. Please try again later.');
      });
  }

  // When a slot is selected, auto-fill the end time based on duration
  timeSelect.addEventListener('change', function() {
    if (!appointmentDuration || !this.value) {
      endTimeInput.value = '';
      return;
    }
    const [hours, minutes, seconds] = this.value.split(':').map(Number);
    const startDate = new Date();
    startDate.setHours(hours, minutes, seconds);

    // Add appointment duration in minutes
    startDate.setMinutes(startDate.getMinutes() + appointmentDuration);

    const endHours = String(startDate.getHours()).padStart(2, '0');
    const endMinutes = String(startDate.getMinutes()).padStart(2, '0');

    endTimeInput.value = `${endHours}:${endMinutes}`;
  });

  // Helper: Convert 24h time string HH:MM:SS to 12h AM/PM format
  function formatTime(timeStr) {
    const [hours, minutes, seconds] = timeStr.split(':').map(Number);
    let period = 'AM';
    let h = hours;
    if (hours === 0) {
      h = 12;
    } else if (hours >= 12) {
      period = 'PM';
      if (hours > 12) h = hours - 12;
    }
    return `${h}:${minutes.toString().padStart(2, '0')} ${period}`;
  }
});
</script>

</body>
</html>
