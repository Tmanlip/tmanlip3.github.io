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
            <a href="index.html">Home</a>
            <a href="track-options.html">Services</a>
            <a href="contact.html">Contact</a>
            <a href="about.html">About</a>
        </div>
    </div>

    <div class="container">
        <div class="overlay">
            <div class="header">Delete Picked Up Parcel</div>
            <form id="deleteParcelForm" method="post" action="">
                <label for="deleteTrackingNumber">Tracking Number</label>
                <input type="text" id="deleteTrackingNumber" name="deleteTrackingNumber" required>
                <button type="submit">Delete</button>
            </form>
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

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost"; // Change to your server details
    $username = "root"; // Change to your database username
    $password = ""; // Change to your database password
    $dbname_opc = "opc_parcel_tracking";
    $dbname_cpp = "cpp_parcel_tracking";

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect POST data
    $deleteTrackingNumber = $_POST['deleteTrackingNumber'];

    // Determine the correct database (assuming tracking numbers are unique across both databases)
    $found = false;

    // Check OPC database
    if ($conn->select_db($dbname_opc)) {
        $stmt = $conn->prepare("SELECT tracking_number FROM parcels WHERE tracking_number = ?");
        $stmt->bind_param("s", $deleteTrackingNumber);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $found = true;
            $stmt = $conn->prepare("DELETE FROM parcels WHERE tracking_number = ?");
            $stmt->bind_param("s", $deleteTrackingNumber);
            echo "<p>Record deleted successfully from OPC</p>";
            $stmt->execute();
        }

        $stmt->close();
    }

    // Check CPP database if not found in OPC
    if (!$found && $conn->select_db($dbname_cpp)) {
        $stmt = $conn->prepare("SELECT tracking_number FROM parcels WHERE tracking_number = ?");
        $stmt->bind_param("s", $deleteTrackingNumber);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt = $conn->prepare("DELETE FROM parcels WHERE tracking_number = ?");
            $stmt->bind_param("s", $deleteTrackingNumber);
            $stmt->execute();
            echo "<p>Record deleted successfully from CPP</p>";
        } else {
            echo "<p>No record found for the given tracking number</p>";
        }

        $stmt->close();
    }

    // Close the connection
    $conn->close();
}
?>

</body>
</html>
