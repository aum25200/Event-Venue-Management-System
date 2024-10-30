<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Receipt - Ramgeet Event Venues</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .receipt-container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .receipt-details {
            margin-top: 20px;
        }

        .receipt-details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .receipt-details th, .receipt-details td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .receipt-details th {
            background-color: floralwhite;
        }
    </style>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "userform";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM bookings1 WHERE id = 4"; // Change '1' to the actual booking ID
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No booking found";
        exit;
    }
    ?>

    <div class="receipt-container">
        <h2>Ramgeet Event Venues - Booking Receipt</h2>

        <div class="receipt-details">
            <table>
                <tr>
                    <th>ID</th>
                    <td><?php echo $row['id']; ?></td>
                </tr>
                <tr>
                    <th>Full Name</th>
                    <td><?php echo $row['fullName']; ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo $row['email']; ?></td>
                </tr>
                <tr>
                    <th>Catering</th>
                    <td><?php echo $row['catering']; ?></td>
                </tr>
                <tr>
                    <th>Plate Count</th>
                    <td><?php echo $row['plateCount']; ?></td>
                </tr>
                <tr>
                    <th>Parking</th>
                    <td><?php echo $row['parking']; ?></td>
                </tr>
                <tr>
                    <th>Lighting Decoration</th>
                    <td><?php echo $row['lightingDecoration']; ?></td>
                </tr>
                <tr>
                    <th>Room Services</th>
                    <td><?php echo $row['roomServices']; ?></td>
                </tr>
                <tr>
                    <th>Event Managers</th>
                    <td><?php echo $row['eventManagers']; ?></td>
                </tr>
                <tr>
                    <th>Music Orchestra</th>
                    <td><?php echo $row['musicOrchestra']; ?></td>
                </tr>
                <tr>
                    <th>Photography</th>
                    <td><?php echo $row['photography']; ?></td>
                </tr>
                <tr>
                    <th>Event Type</th>
                    <td><?php echo $row['event']; ?></td>
                </tr>
                <tr>
                    <th>Total Cost</th>
                    <td>₹<?php echo $row['totalCost']; ?></td>

                </tr>
                <tr>
                    <th>Payment Method</th>
                    <td><?php echo $row['paymentMethod']; ?></td>
                    
                </tr>
            </table>
        </div>
    </div>
</body>
</html>