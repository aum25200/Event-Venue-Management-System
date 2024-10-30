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
    <title>Admin Panel</title>
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

        label {
            display: block;
            margin-bottom: 5px;
        }

        input, select, button {
            margin-bottom: 10px;
            padding: 8px;
        }

        button {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h1>Admin Panel</h1>

<!-- Display available slots -->
<h2>Available Slots</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php foreach ($slots as $slot): ?>
        <tr>
            <td><?= $slot['id'] ?></td>
            <td><?= $slot['slot_date'] ?></td>
            <td><?= $slot['slot_time'] ?></td>
            <td><?= $slot['status'] ?></td>
            <td>
                <form action="admin.php" method="post">
                    <input type="hidden" name="id" value="<?= $slot['id'] ?>">
                    <select name="status">
                        <option value="available">Available</option>
                        <option value="booked">Booked</option>
                    </select>
                    <button type="submit" name="action" value="update">Update</button>
                    <button type="submit" name="action" value="delete">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Add new slot form -->
<h2>Add New Slot</h2>
<form action="admin.php" method="post">
    <label>Date:</label>
    <input type="date" name="date" required>
    <label>Time:</label>
    <input type="time" name="time" required>
    <button type="submit" name="action" value="add">Add Slot</button>
</form>

</body>
</html>
