<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userform";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the booking ID is provided in the URL
if (isset($_GET['id'])) {
    $bookingId = $_GET['id'];

    // Delete the booking record
    $sql = "DELETE FROM bookings WHERE id = $bookingId";

    if ($conn->query($sql) === TRUE) {
        header("Location: eventadmin.php"); // Redirect to the display page after successful deletion
        exit();
    } else {
        echo "Error deleting booking: " . $conn->error;
    }
} else {
    echo "Booking ID not provided.";
}

// Close the database connection
$conn->close();
?>
