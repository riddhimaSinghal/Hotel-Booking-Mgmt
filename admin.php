<?php
include 'config.php';

if(!isLoggedIn() || !isAdmin()) {
    header('Location: login.php');
    exit;
}

// Handle status update
if(isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = $_GET['action'];
    
    if(in_array($status, ['pending', 'confirmed', 'cancelled'])) {
        $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }
    header('Location: admin.php');
    exit;
}

$stmt = $conn->query("SELECT bookings.*, users.name as user_name, users.email 
                      FROM bookings 
                      JOIN users ON bookings.user_id = users.id 
                      ORDER BY bookings.created_at DESC");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin.php">Admin Panel</a>
            <div>
                <span class="text-white me-3">Admin</span>
                <a class="btn btn-light btn-sm" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>All Bookings</h2>
        
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Room Type</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Guests</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($bookings as $booking): ?>
                <tr>
                    <td><?php echo $booking['id']; ?></td>
                    <td><?php echo $booking['user_name']; ?></td>
                    <td><?php echo $booking['email']; ?></td>
                    <td><?php echo $booking['room_type']; ?></td>
                    <td><?php echo $booking['check_in']; ?></td>
                    <td><?php echo $booking['check_out']; ?></td>
                    <td><?php echo $booking['guests']; ?></td>
                    <td>
                        <span class="badge bg-<?php echo $booking['status'] == 'confirmed' ? 'success' : ($booking['status'] == 'cancelled' ? 'danger' : 'warning'); ?>">
                            <?php echo ucfirst($booking['status']); ?>
                        </span>
                    </td>
                    <td>
                        <?php if($booking['status'] != 'confirmed'): ?>
                            <a href="?action=confirmed&id=<?php echo $booking['id']; ?>" class="btn btn-success btn-sm">Confirm</a>
                        <?php endif; ?>
                        <?php if($booking['status'] != 'cancelled'): ?>
                            <a href="?action=cancelled&id=<?php echo $booking['id']; ?>" class="btn btn-danger btn-sm">Cancel</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
