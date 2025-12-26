<?php
include 'config.php';

if(!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_type = $_POST['room_type'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $guests = $_POST['guests'];
    
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, room_type, check_in, check_out, guests) VALUES (?, ?, ?, ?, ?)");
    if($stmt->execute([$_SESSION['user_id'], $room_type, $check_in, $check_out, $guests])) {
        $success = "Booking created successfully!";
    } else {
        $error = "Booking failed!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Hotel Booking</a>
            <a class="nav-link text-white" href="dashboard.php">My Dashboard</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Book a Room</h2>
        
        <?php if($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label>Room Type</label>
                <select name="room_type" class="form-control" required>
                    <option value="Standard">Standard - ₹2000/night</option>
                    <option value="Deluxe">Deluxe - ₹3500/night</option>
                    <option value="Suite">Suite - ₹5000/night</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Check-in Date</label>
                <input type="date" name="check_in" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Check-out Date</label>
                <input type="date" name="check_out" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Number of Guests</label>
                <input type="number" name="guests" class="form-control" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Book Now</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
