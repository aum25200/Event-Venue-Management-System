<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $catering = $_POST['catering'];
    $plateCount = $_POST['plateCount'];
    $parking = $_POST['parking'];
    $lightingDecoration = $_POST['lightingDecoration'];
    $roomServices = $_POST['roomServices'];
    $eventManagers = $_POST['eventManagers'];
    $musicOrchestra = $_POST['musicOrchestra'];
    $photography = $_POST['photography'];
    $event = $_POST['event'];
    $totalCost = $_POST['hiddenTotalCost'];
    $paymentMethod = $_POST['paymentMethod'];
    $selectedSlot = $_POST['selectedSlot']; // Add this line to get the selected slot

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "userform";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use a prepared statement to avoid SQL injection
    $sql = "INSERT INTO bookings1 (fullName, email, catering, plateCount, parking, lightingDecoration, roomServices, eventManagers, musicOrchestra, photography, event,  totalCost, paymentMethod, selectedSlot) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters with appropriate data types
        $stmt->bind_param("ssiiiiiiiiiiss", $fullName, $email, $catering, $plateCount, $parking, $lightingDecoration, $roomServices, $eventManagers, $musicOrchestra, $photography, $event, $totalCost, $paymentMethod, $selectedSlot);

        if ($stmt->execute()) {
            echo "Booking successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Booking Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        form {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
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

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-size: 16px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            padding: 10px;
            border: none;
            border-radius: 4px;
        }

        button:hover {
            background-color: #0056b3;
        }

        #onlinePaymentOptions,
        #offlinePaymentOptions {
            display: none;
            margin-top: 10px;
        }

        #onlinePaymentOptions p,
        #offlinePaymentOptions p {
            margin: 5px 0;
        }

        a.checkSlots {
            background-color: #ffa500;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            padding: 10px;
            border: none;
            border-radius: 4px;
            margin-top: 10px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            display: block;
            width: 20%;
            text-align: center;
        }

        a.checkSlots:hover {
            background-color: #ff8c00;
        }
        .blink {
    color: #ff0000; /* Change the color to your desired color */
    animation: blink-animation 1s steps(5, start) infinite;
}

@keyframes blink-animation {
    to {
        visibility: hidden;
    }
}


    </style>
</head>
<body>
    <form id="bookingForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Booking Form</h2>

        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="catering">Catering Services:</label>
        <select id="catering" name="catering" oninput="calculateTotal()">
            <option value="0">None</option>
            <option value="100">Breakfast (₹100 per person)</option>
            <option value="150">Lunch (₹150 per person)</option>
            <option value="200">Dinner (₹200 per person)</option>
        </select>

        <label for="plateCount">Number of Persons:</label>
        <input type="number" id="plateCount" name="plateCount" min="0" value="0" oninput="calculateTotal()">

        <label for="parking">Parking Slot:</label>
        <select id="parking" name="parking" oninput="calculateTotal()">
            <option value="0">None</option>
            <option value="500">20 Vehicle Package (₹500)</option>
            <option value="1000">40 Vehicle Package (₹1000)</option>
        </select>

        <label for="lightingDecoration">Lighting and Decoration:</label>
        <select id="lightingDecoration" name="lightingDecoration" oninput="calculateTotal()">
            <option value="0">None</option>
            <option value="2000">Standard Package (₹2000)</option>
            <option value="4000">Premium Package (₹4000)</option>
        </select>

        <label for="roomServices">Room Services:</label>
        <select id="roomServices" name="roomServices" oninput="calculateTotal()">
            <option value="0">None</option>
            <option value="1500">AC Room Package (3 Rooms) (₹1500)</option>
            <option value="1000">Non-AC Room Package (5 Rooms) (₹1000)</option>
        </select>

        <label for="eventManagers">Event Managers Package:</label>
        <select id="eventManagers" name="eventManagers" oninput="calculateTotal()">
            <option value="0">None</option>
            <option value="3000">Basic Package (₹3000)</option>
            <option value="5000">Premium Package (₹5000)</option>
        </select>

        <label for="musicOrchestra">Music Orchestra:</label>
        <select id="musicOrchestra" name="musicOrchestra" oninput="calculateTotal()">
            <option value="0">None</option>
            <option value="2000">Live Band (₹2000)</option>
            <option value="4000">DJ Night (₹4000)</option>
        </select>

        <label for="photography">Photography Services:</label>
        <select id="photography" name="photography" oninput="calculateTotal()">
            <option value="0">None</option>
            <option value="3000">Standard Package (₹3000)</option>
            <option value="5000">Premium Package (₹5000)</option>
        </select>

        <label for="event">Party Type:</label>
        <select id="event" name="event" oninput="calculateTotal()">
            <option value="0">None</option>
            <option value="1000">Birthday Party (₹1000)</option>
            <option value="2500">Corporate Party (₹2500)</option>
            <option value="3500">Weekly Party (₹3500)</option>
            <option value="4500">Farewell Party (₹4500)</option>
        </select>
       <?php
     $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "userform";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
// Fetch available slots from the database
$sqlSlots = "SELECT * FROM slots WHERE status = 'available'";
$resultSlots = $conn->query($sqlSlots);

// Create a dropdown list with available slots
echo '<label for="selectedSlot">Select Slot:</label>';
echo '<select id="selectedSlot" name="selectedSlot">';
echo '<option value="0">Select Slot</option>';

while ($rowSlot = $resultSlots->fetch_assoc()) {
    $slotDateTime = $rowSlot['slot_date'] . ' ' . $rowSlot['slot_time'];
    echo "<option value='$slotDateTime'>$slotDateTime</option>";
}

echo '</select>';
?>

        

        <label for="totalCost">Total Cost:</label>
        <input type="text" id="totalCost" name="totalCost" readonly>

        <input type="hidden" id="hiddenTotalCost" name="hiddenTotalCost" value="">
        
        <label for="paymentMethod">Payment Method:</label>
        <select id="paymentMethod" name="paymentMethod" onchange="showPaymentOptions()">
            <option value="online">Online Payment</option>
            <option value="offline">Offline Payment</option>
        </select>

        <div id="onlinePaymentOptions">
    <p>Pay online using the following methods:</p>
    <ul>
        <li id="onlinePaymentLink">Net Banking</li>
    </ul>
    <p><h4>Note:Online payment link will be provided in the Gmail.<h4></p>
</div>


        <div id="offlinePaymentOptions">
            <p>Pay offline through:</p>
            <ul>
                <li>Cash</li>
                <li>Cheque</li>       
                
                Address Visit:RAMGEET VENUE OFFICE GROUND FLOOR,NASHIK
            </ul>
        </div>
         <div class="blink">
    <p>Note: Your booking will only be confirmed if the payment is done within 24 hours. Otherwise, it will be cancelled.</p>
</div>

        <button type="submit" name="submit">Book Now</button>
        <a href="availability.php" class="checkSlots">Check Availability</a>

        <script>

            

            document.addEventListener("DOMContentLoaded", function() {
                calculateTotal();
            });

            function calculateTotal() {
                var catering = parseInt(document.getElementById('catering').value) || 0;
                var plateCount = parseInt(document.getElementById('plateCount').value) || 1;
                var parking = parseInt(document.getElementById('parking').value) || 0;
                var lightingDecoration = parseInt(document.getElementById('lightingDecoration').value) || 0;
                var roomServices = parseInt(document.getElementById('roomServices').value) || 0;
                var eventManagers = parseInt(document.getElementById('eventManagers').value) || 0;
                var musicOrchestra = parseInt(document.getElementById('musicOrchestra').value) || 0;
                var photography = parseInt(document.getElementById('photography').value) || 0;
                var eventCost = parseInt(document.getElementById('event').value) || 0;
                var totalCost = catering + (plateCount * catering) + parking +
                                lightingDecoration + roomServices + eventManagers + musicOrchestra + photography + eventCost;

                document.getElementById('totalCost').value = "₹" + totalCost.toFixed(2);
                document.getElementById('hiddenTotalCost').value = totalCost.toFixed(2);
            }

            function showPaymentOptions() {
                var paymentMethod = document.getElementById('paymentMethod').value;

                if (paymentMethod === 'online') {
                    document.getElementById('onlinePaymentOptions').style.display = 'block';
                    document.getElementById('offlinePaymentOptions').style.display = 'none';
                } else {
                    document.getElementById('onlinePaymentOptions').style.display = 'none';
                    document.getElementById('offlinePaymentOptions').style.display = 'block';
                }
            }

            function checkAvailableSlots() {
                // Your logic to check and display available slots goes here
                alert("Functionality to check available slots will be implemented here.");
            }
        </script>
    </form>
</body>
</html>
