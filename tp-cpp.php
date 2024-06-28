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
            <h2>Track Your Parcel From CPP</h2>
            <form id="track-form" method="POST">
                <label for="trackingNumber">Enter Tracking Number:</label>
                <input type="text" id="trackingNumber" name="trackingNumber" required>
                <button type="submit">Check Status</button>
            </form>
            <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcel Tracking System</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function validatePickupTime() {
            const pickupTimeInput = document.getElementById('pickupTime');
            const lastDateToCollectInput = document.getElementById('lastDateToCollect');
            const errorMessage = document.getElementById('error-message');
            
            const pickupTime = new Date(pickupTimeInput.value);
            const lastDateToCollect = new Date(lastDateToCollectInput.value);
            
            if (pickupTime > lastDateToCollect) {
                errorMessage.textContent = "Pick-up time cannot exceed the last date to collect. Please choose a valid time.";
                return false;
            }
            
            errorMessage.textContent = "";
            return true;
        }
    </script>
</head>
<body>
    <div class="navbar">
        <div class="logo">UTM TrackParcel</div>
            <div class="navbar-nav">
                <a href="index.html">Home</a>
                <a href="track-options.html">Services</a>
            </div>
    </div>
    </div>
    <div class="container">
        <div class="overlay">
            <h2>Track Your Parcel From CPP</h2>
            <form id="track-form" method="POST">
                <label for="trackingNumber">Enter Tracking Number:</label>
                <input type="text" id="trackingNumber" name="trackingNumber" required>
                <button type="submit">Check Status</button>
            </form>

            <div id="result">
                <?php
                session_start();
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "cpp_parcel_tracking";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['schedulePickup'])) {
                    $trackingNumber = $_POST['trackingNumber'];
                    $sql = "SELECT * FROM parcels WHERE tracking_number='$trackingNumber'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $parcel = $result->fetch_assoc();

                        // Calculate if the current date is within last_date_to_collect
                        $lastDateToCollect = strtotime($parcel['last_date_to_collect']);
                        $today = strtotime(date("Y-m-d"));

                        if ($today <= $lastDateToCollect) {
                            // Display last_date_to_collect and pick-up form
                            echo "<p>Last date to collect: " . $parcel['last_date_to_collect'] . "</p>";
                            echo '<form id="pickup-form" method="POST" action="" onsubmit="return validatePickupTime()">
                                    <label for="pickupTime">Choose Pick-Up Time:</label>
                                    <input type="datetime-local" id="pickupTime" name="pickupTime" required>
                                    <input type="hidden" id="lastDateToCollect" name="lastDateToCollect" value="' . $parcel['last_date_to_collect'] . '">
                                    <input type="hidden" name="trackingNumber" value="' . $trackingNumber . '">
                                    <button type="submit" name="schedulePickup">Schedule Pick-Up</button>
                                  </form>';
                            echo '<p id="error-message" style="color:red;"></p>';
                        } else {
                            echo "<p>Cannot schedule pick-up. Last date to collect has passed.</p>";
                        }
                    } else {
                        echo "<p>Tracking number not found.</p>";
                    }
                }

                if (isset($_POST['schedulePickup'])) {
                    $pickupTime = $_POST['pickupTime'];
                    $trackingNumber = $_POST['trackingNumber'];
                    $lastDateToCollect = $_POST['lastDateToCollect'];

                    // Validate if the pickup time is before the last date to collect
                    if (strtotime($pickupTime) <= strtotime($lastDateToCollect)) {
                        // Update pickup_time in the parcels table
                        $stmt = $conn->prepare("UPDATE parcels SET pickup_time = ? WHERE tracking_number = ?");
                        $stmt->bind_param("ss", $pickupTime, $trackingNumber);

                        if ($stmt->execute()) {
                            // Store pick-up information in session variables
                            $_SESSION['trackingNumber'] = $trackingNumber;
                            $_SESSION['pickupTime'] = $pickupTime;

                            // Redirect to new page to display information
                            header("Location: pi.php");
                            exit();
                        } else {
                            echo "<p>Error scheduling pick-up. Please try again.</p>";
                        }

                        $stmt->close();
                    } else {
                        echo "<p>Pick-up time cannot exceed the last date to collect. Please choose a valid time.</p>";
                    }
                }

                $conn->close();
                ?>
            </div>
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

            <div id="result">
                <?php
                session_start();
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "cpp_parcel_tracking";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['schedulePickup'])) {
                    $trackingNumber = $_POST['trackingNumber'];
                    $sql = "SELECT * FROM parcels WHERE tracking_number='$trackingNumber'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $parcel = $result->fetch_assoc();

                        // Calculate if the current date is within last_date_to_collect
                        $lastDateToCollect = strtotime($parcel['last_date_to_collect']);
                        $today = strtotime(date("Y-m-d"));

                        if ($today <= $lastDateToCollect) {
                            // Display last_date_to_collect and pick-up form
                            echo "<p>Last date to collect: " . $parcel['last_date_to_collect'] . "</p>";
                            echo '<form id="pickup-form" method="POST" action="">
                                    <label for="pickupTime">Choose Pick-Up Time:</label>
                                    <input type="datetime-local" id="pickupTime" name="pickupTime" required>
                                    <input type="hidden" name="trackingNumber" value="' . $trackingNumber . '">
                                    <input type="hidden" name="lastDateToCollect" value="' . $parcel['last_date_to_collect'] . '">
                                    <button type="submit" name="schedulePickup">Schedule Pick-Up</button>
                                  </form>';
                        } else {
                            echo "<p>Cannot schedule pick-up. Last date to collect has passed.</p>";
                        }
                    } else {
                        echo "<p>Tracking number not found.</p>";
                    }
                }

                if (isset($_POST['schedulePickup'])) {
                    $pickupTime = $_POST['pickupTime'];
                    $trackingNumber = $_POST['trackingNumber'];
                    $lastDateToCollect = $_POST['lastDateToCollect'];

                    // Validate if the pickup time is before the last date to collect
                    if (strtotime($pickupTime) <= strtotime($lastDateToCollect)) {
                        // Update pickup_time in the parcels table
                        $stmt = $conn->prepare("UPDATE parcels SET pickup_time = ? WHERE tracking_number = ?");
                        $stmt->bind_param("ss", $pickupTime, $trackingNumber);

                        if ($stmt->execute()) {
                            // Store pick-up information in session variables
                            $_SESSION['trackingNumber'] = $trackingNumber;
                            $_SESSION['pickupTime'] = $pickupTime;

                            // Redirect to new page to display information
                            header("Location: pi.php");
                            exit();
                        } else {
                            echo "<p>Error scheduling pick-up. Please try again.</p>";
                        }

                        $stmt->close();
                    } else {
                        echo "<p>Pick-up time cannot exceed the last date to collect. Please choose a valid time.</p>";
                    }
                }

                $conn->close();
                ?>
            </div>
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
