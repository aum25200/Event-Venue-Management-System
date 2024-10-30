
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

// Fetch booking records from the database
$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <title>Event Booking Records</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .delete-btn {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Booking Records</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Total Cost</th>
            <th>Catering</th>
            <th>Plate Count</th>
            <th>Parking</th>
            <th>Lighting/Decoration</th>
            <th>Room Services</th>
            <th>Event Managers</th>
            <th>Music/Orchestra</th>
            <th>Photography</th>
            <th>Advance Payment</th>
            <th>Payment Method</th>
            <th>Selected Slot</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["fullName"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["totalCost"] . "</td>";
                echo "<td>" . $row["catering"] . "</td>";
                echo "<td>" . $row["plateCount"] . "</td>";
                echo "<td>" . $row["parking"] . "</td>";
                echo "<td>" . $row["lightingDecoration"] . "</td>";
                echo "<td>" . $row["roomServices"] . "</td>";
                echo "<td>" . $row["eventManagers"] . "</td>";
                echo "<td>" . $row["musicOrchestra"] . "</td>";
                echo "<td>" . $row["photography"] . "</td>";
                echo "<td>" . $row["advancePayment"] . "</td>";
                echo "<td>" . $row["paymentMethod"] . "</td>";
                echo "<td>" . $row["selectedSlot"] . "</td>";
                echo "<td><button class='delete-btn' onclick='deleteBooking(" . $row["id"] . ")'>Delete</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='16'>No records found</td></tr>";
        }
        ?>
    </table>

    <script>
        function deleteBooking(bookingId) {
            var confirmation = confirm("Are you sure you want to delete this booking?");
            if (confirmation) {
                window.location.href = "delete_event.php?id=" + bookingId;
            }
        }
    </script>
</body>
</html>