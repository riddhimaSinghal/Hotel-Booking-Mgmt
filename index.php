<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Hotel Booking</a>
            <div class="navbar-nav ms-auto">
                <?php if(isLoggedIn()): ?>
                    <?php if(isAdmin()): ?>
                        <a class="nav-link" href="admin.php">Admin Panel</a>
                    <?php else: ?>
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    <?php endif; ?>
                    <a class="nav-link" href="logout.php">Logout</a>
                <?php else: ?>
                    <a class="nav-link" href="login.php">Login</a>
                    <a class="nav-link" href="register.php">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="jumbotron text-center">
            <h1 class="display-4">Welcome to Our Hotel</h1>
            <p class="lead">Book your perfect stay with us</p>
            <?php if(isLoggedIn()): ?>
                <a href="book.php" class="btn btn-primary btn-lg">Book Now</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary btn-lg">Login to Book</a>
            <?php endif; ?>
        </div>

        <div class="row mt-5">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Standard Room</h5>
                        <p class="card-text">Comfortable rooms with basic amenities</p>
                        <p class="text-primary fw-bold">₹2000/night</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Deluxe Room</h5>
                        <p class="card-text">Spacious rooms with premium facilities</p>
                        <p class="text-primary fw-bold">₹3500/night</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Suite</h5>
                        <p class="card-text">Luxury suites with all amenities</p>
                        <p class="text-primary fw-bold">₹5000/night</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
