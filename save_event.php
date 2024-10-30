<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the request
    $date = $_POST['date'];
    $time = $_POST['time'];
    $description = $_POST['description'];
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    // Database connection
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "userform";

    $mysqli = new mysqli($hostname, $username, $password, $database);

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    if ($action === 'delete') {
        // Delete the event
        $deleteQuery = "DELETE FROM events WHERE event_date = '$date' AND event_time = '$time'";
        $mysqli->query($deleteQuery);

        echo json_encode(['message' => 'Event deleted successfully!', 'date' => $date, 'time' => $time]);
    } else {
        // Check if an event already exists for the date and time
        $result = $mysqli->query("SELECT * FROM events WHERE event_date = '$date' AND event_time = '$time'");

        if ($result->num_rows > 0) {
            // Update the existing event
            $updateQuery = "UPDATE events SET event_description = '$description' WHERE event_date = '$date' AND event_time = '$time'";
            $mysqli->query($updateQuery);

            // Fetch updated events for the date
            $updatedResult = $mysqli->query("SELECT * FROM events WHERE event_date = '$date'");
            $updatedEvents = [];
            while ($row = $updatedResult->fetch_assoc()) {
                $updatedEvents[] = [
                    'time' => $row['event_time'],
                    'description' => $row['event_description']
                ];
            }

            echo json_encode(['message' => 'Event updated successfully!', 'events' => $updatedEvents, 'date' => $date, 'time' => $time]);
        } else {
            // Insert a new event
            $insertQuery = "INSERT INTO events (event_date, event_time, event_description) VALUES ('$date', '$time', '$description')";
            $mysqli->query($insertQuery);

            // Fetch events for the date
            $newResult = $mysqli->query("SELECT * FROM events WHERE event_date = '$date'");
            $newEvents = [];
            while ($row = $newResult->fetch_assoc()) {
                $newEvents[] = [
                    'time' => $row['event_time'],
                    'description' => $row['event_description']
                ];
            }

            echo json_encode(['message' => 'Event saved successfully!', 'events' => $newEvents, 'date' => $date, 'time' => $time]);
        }
    }

    // Close the database connection
    $mysqli->close();
}
?>
