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
            <div class="header">Enter Parcel Details</div>
            <form id="parcelForm" method="post" action="">
                <label for="trackingNumber">Tracking Number</label>
                <input type="text" id="trackingNumber" name="trackingNumber" required>
                
                <label for="receiverName">Receiver Name</label>
                <input type="text" id="receiverName" name="receiverName" required>
                
                <label for="telephone">Telephone No.</label>
                <input type="tel" id="telephone" name="telephone" required>
                
                <label for="arrivalDate">Arrival Date</label>
                <input type="date" id="arrivalDate" name="arrivalDate" required>
                
                <label for="lastDate">Last Date to Collect</label>
                <input type="date" id="lastDate" name="lastDate" required>
                
                <div class="checkbox-container">
                    <input type="checkbox" id="cashOnDelivery" name="cashOnDelivery">
                    <label for="cashOnDelivery">Cash On Delivery</label>
                </div>
                
                <label for="location">Location to Pick Up</label>
                <select id="location" name="location" required>
                    <option value="OPC">OPC</option>
                    <option value="CPP">CPP</option>
                </select>
                
                <button type="submit">Submit</button>
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
    $trackingNumber = $_POST['trackingNumber'];
    $receiverName = $_POST['receiverName'];
    $telephone = $_POST['telephone'];
    $arrivalDate = $_POST['arrivalDate'];
    $lastDate = $_POST['lastDate'];
    $cashOnDelivery = isset($_POST['cashOnDelivery']) ? 1 : 0;
    $location = $_POST['location'];

    // Determine the correct database
    $dbname = $location == 'OPC' ? $dbname_opc : $dbname_cpp;

    // Select the database
    if (!$conn->select_db($dbname)) {
        die("Failed to select database: " . $conn->error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO parcels (tracking_number, receiver_name, telephone, arrival_date, last_date_to_collect, cash_on_delivery, location) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssssis", $trackingNumber, $receiverName, $telephone, $arrivalDate, $lastDate, $cashOnDelivery, $location);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<p>New record created successfully</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
</body>
</html>
