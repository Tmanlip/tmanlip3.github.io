<?php
session_start();

// Check if session variables are set
if(isset($_SESSION['trackingNumber']) && isset($_SESSION['pickupTime'])) {
    $trackingNumber = $_SESSION['trackingNumber'];
    $pickupTime = $_SESSION['pickupTime'];
} else {
    // If session variables are not set, redirect to tracking.php or any other appropriate page
    header("Location: tracking.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcel Tracking System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="index.html">
                UTM TrackParc
            </a>
        </div>
        <div class="navbar-nav">
            <a href="track-options.html">Services</a>
        </div>
    </div>
    <div class="container">
        <div class="overlay">
            <section class="pickup-info">
                <h2>Pickup Information</h2>
                <p>Tracking Number: <?php echo $trackingNumber; ?></p>
                <p>Pickup Time: <?php echo $pickupTime; ?></p>
            </section>
        </div>
    </div>

    <footer>
        <p>Customer Service: +60 11-1868 7083 | Email: onestoputm@gmail.com</p>
        <p>&copy; 2024 Parcel Management Center. All rights reserved.</p>
    </footer>
    
    <script>
        function logout() {
            alert('Logging out...');
        }
    </script>
</body>
</html>
