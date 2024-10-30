<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userform";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $date = $_POST['date'];
        $time = $_POST['time'];
        
        $sql = "INSERT INTO slots (slot_date, slot_time) VALUES ('$date', '$time')";
        $conn->query($sql);
    } elseif ($_POST['action'] === 'update') {
        $id = $_POST['id'];
        $status = $_POST['status'];
        
        $sql = "UPDATE slots SET status = '$status' WHERE id = $id";
        $conn->query($sql);
    } elseif ($_POST['action'] === 'delete') {
        $id = $_POST['id'];
        
        $sql = "DELETE FROM slots WHERE id = $id";
        $conn->query($sql);
    }
}

$sql = "SELECT * FROM slots";
$result = $conn->query($sql);
$slots = array();

while ($row = $result->fetch_assoc()) {
    $slots[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Slots</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        h2 {
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        form {
            margin-top: 20px;
        }

        select, button {
            margin-bottom: 10px;
            padding: 8px;
        }

        
    </style>
</head>
<body>

<h1>Available Slots</h1>

<!-- Display available slots -->
<h2>Available Slots</h2>
<table>
    <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        
    </tr>
    <?php foreach ($slots as $slot): ?>
        <tr>
            <td><?= $slot['slot_date'] ?></td>
            <td><?= $slot['slot_time'] ?></td>
            <td><?= $slot['status'] ?></td>
            
                
                
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
