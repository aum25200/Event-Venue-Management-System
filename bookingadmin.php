<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userform";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete operation (unchanged)
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    $deleteSql = "DELETE FROM bookings1 WHERE id = $idToDelete";

    if ($conn->query($deleteSql) === TRUE) {
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch existing bookings data (unchanged)
$sql = "SELECT * FROM bookings1";
$result = $conn->query($sql);

if (!$result) {
    echo "Error fetching records: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        /* Table styles */
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto; /* Center the table on the page */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px; /* Increased padding for better readability */
            text-align: left;
        }

        th {
            background-color: lightskyblue;
        }

        .delete-link {
            color: red;
            cursor: pointer;
        }

        .delete-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Existing Bookings</h2>
    <table>
        <thead>
                  <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Catering</th>
                <th>Plate Count</th>
                <th>Parking</th>
                <th>Lighting Decoration</th>
                <th>Room Services</th>
                <th>Event Managers</th>
                <th>Music Orchestra</th>
                <th>Photography</th>
                <th>Event Type</th>
                <th>Total Cost</th>
                
                <th>Action</th>
                ...
<th>Action</th>


            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through each row of the bookings data
            
// Loop through each row of the bookings data
// Loop through each row of the bookings data
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    // Display booking details (unchanged)
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['fullName'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['catering'] . "</td>";
    echo "<td>" . $row['plateCount'] . "</td>";
    echo "<td>" . $row['parking'] . "</td>";
    echo "<td>" . $row['lightingDecoration'] . "</td>";
    echo "<td>" . $row['roomServices'] . "</td>";
    echo "<td>" . $row['eventManagers'] . "</td>";
    echo "<td>" . $row['musicOrchestra'] . "</td>";
    echo "<td>" . $row['photography'] . "</td>";
    echo "<td>" . $row['event'] . "</td>";
    echo "<td>₹" . $row['totalCost'] . "</td>";
    
    // Add delete button for each booking
    echo "<td><a class='delete-link' href='" . $_SERVER['PHP_SELF'] . "?delete=" . $row['id'] . "'>Delete</a></td>";
    
    // Add "Generate Bill" button for each booking
    echo "<td><a class='generate-bill-link' href='generateBill.php?id=" . $row['id'] . "' target='_blank'>Generate Bill</a></td>";
    
    echo "</tr>";
}


?>

                
            
        </tbody>
    </table>
</body>
</html>
