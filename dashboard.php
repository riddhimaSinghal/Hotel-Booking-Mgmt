<?php
include 'config.php';

if(!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Hotel Booking</a>
            <div>
                <span class="text-white me-3">Welcome, <?php echo $_SESSION['name']; ?></span>
                <a class="btn btn-light btn-sm" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>My Bookings</h2>
        <a href="book.php" class="btn btn-primary mb-3">New Booking</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Room Type</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Guests</th>
                    <th>Status</th>
                    <th>Booked On</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($bookings as $booking): ?>
                <tr>
                    <td><?php echo $booking['id']; ?></td>
                    <td><?php echo $booking['room_type']; ?></td>
                    <td><?php echo $booking['check_in']; ?></td>
                    <td><?php echo $booking['check_out']; ?></td>
                    <td><?php echo $booking['guests']; ?></td>
                    <td>
                        <span class="badge bg-<?php echo $booking['status'] == 'confirmed' ? 'success' : ($booking['status'] == 'cancelled' ? 'danger' : 'warning'); ?>">
                            <?php echo ucfirst($booking['status']); ?>
                        </span>
                    </td>
                    <td><?php echo date('d-m-Y', strtotime($booking['created_at'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
