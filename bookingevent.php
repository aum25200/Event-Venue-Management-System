<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
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
    $advancePayment = $_POST['advancePayment'];
    $totalCost = $_POST['totalCost'];
    $paymentMethod = $_POST['paymentMethod'];
    $selectedSlot = $_POST['selectedSlot'];

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

    // Prepare and execute the SQL statement to insert data into the database
    $sql = "INSERT INTO bookings (fullName, email, catering, plateCount, parking, lightingDecoration, roomServices, eventManagers, musicOrchestra, photography, advancePayment, totalCost, paymentMethod, selectedSlot) VALUES ('$fullName', '$email', '$catering', '$plateCount', '$parking', '$lightingDecoration', '$roomServices', '$eventManagers', '$musicOrchestra', '$photography', '$advancePayment', '$totalCost', '$paymentMethod', '$selectedSlot')";

    if ($conn->query($sql) === TRUE) {
        // Send confirmation email
        $to = $email;
        $subject = "Event Booking Confirmation";
        $message = "Dear $fullName,\n\nThank you for booking your event with us!\n\nYour booking details:\n\nFull Name: $fullName\nEmail: $email\nTotal Cost: ₹$totalCost\n\nPlease proceed to pay the advance amount of ₹$advancePayment to confirm your booking.\n\nPayment Method: $paymentMethod\n\nSlot: $selectedSlot\n\nIf you have chosen online payment, use the UPI ID provided during the booking process.\n\nIf you have chosen offline payment, please visit the venue for payment.\n\nBest regards,\nYour Event Management Team";
        $headers = "From: your-email@example.com"; // Replace with your actual email

        mail($to, $subject, $message, $headers);

        // Close the database connection
        $conn->close();

        // Display attractive confirmation message and JavaScript to redirect
        echo "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Booking Confirmation</title>
                    <style>
                        body {
                            font-family: 'Arial', sans-serif;
                            background-color: #f4f4f4;
                            margin: 0;
                            padding: 0;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            height: 100vh;
                            text-align: center;
                        }
                        .confirmation-container {
                            background-color: #fff;
                            padding: 20px;
                            border-radius: 8px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            max-width: 400px;
                            width: 100%;
                        }
                        h2 {
                            color: #333;
                            font-size: 28px;
                            margin-bottom: 20px;
                        }
                        p {
                            color: #555;
                            font-size: 16px;
                        }
                    </style>
                </head>
                <body>
                    <div class='confirmation-container'>
                        <h2>Details Submitted Successfully!</h2>
                        <p>Please proceed to pay ₹$advancePayment advancePayment for confirmation.</p>
                        <script>
                            setTimeout(function() {
                                window.location.href = 'payment_page.php'; // Redirect to payment page after 5 seconds
                            }, 5000);
                        </script>
                    </div>
                </body>
                </html>";
        exit; // Ensure no further execution of the script
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>


    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <title>Event Booking Form</title>
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

        .result {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }

        /* Add styling for payment options */
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
    </style>
</head>
<body>
    <form id="bookingForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Event Booking Form</h2>

        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
       
        <label for="catering">Catering Services:</label>
        <select id="catering" name="catering" oninput="calculateTotal()">
            <option value="0">None</option>
            <option value="225">Package (₹225 per person) - Breakfast, Lunch, and Dinner</option>
        </select>

        <label for="plateCount">Number of Persons:</label>
        <input type="number" id="plateCount" name="plateCount" min="1" value="1" oninput="calculateTotal()">

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
            <option value="2500">Standard Package (₹2500)</option>
            <option value="4000">Live Band Package (₹4000)</option>
        </select>

        <label for="photography">Photography Package:</label>
        <select id="photography" name="photography" oninput="calculateTotal()">
            <option value="0">None</option>
            <option value="2000">Basic Package (₹2000)</option>
            <option value="3500">Professional Package (₹3500)</option>
        </select>

        <label for="advancePayment">Advance Payment:</label>
        <input type="number" id="advancePayment" name="advancePayment" min="0" value="5000" readonly>
        <input type="hidden" id="hiddenTotalCost" name="totalCost">
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
        <input type="text" id="totalCost" readonly>

        

        <label for="paymentMethod">Payment Method:</label>
        <select id="paymentMethod" name="paymentMethod" onchange="togglePaymentOptions()">
            <option value="online">Online</option>
            <option value="offline">Offline</option>
        </select>

        <div id="onlinePaymentOptions">
            <p>Upi ID: vishalshinde@icic.</p>
            <div id="qrcodeContainer"></div>
        </div>

        <div id="offlinePaymentOptions">
            <p>Visit the venue for offline payment.</p>
            <p>Address: Ramgeet Office</p>
        </div>
                

<button type="submit" name="submit">Book Now</button>
        <a href="availability.php" class="checkSlots">Check Availability</a>

    </form>

    <script>
        function togglePaymentOptions() {
            var paymentMethod = document.getElementById('paymentMethod').value;

            var onlinePaymentOptions = document.getElementById('onlinePaymentOptions');
            var offlinePaymentOptions = document.getElementById('offlinePaymentOptions');

            if (paymentMethod === 'online') {
                onlinePaymentOptions.style.display = 'block';
                offlinePaymentOptions.style.display = 'none';
                generateQRCode(); // Automatically generate QR code for online payments
            } else {
                onlinePaymentOptions.style.display = 'none';
                offlinePaymentOptions.style.display = 'block';
            }
        }

        function calculateTotal() {
            var catering = parseInt(document.getElementById('catering').value) || 0;
            var plateCount = parseInt(document.getElementById('plateCount').value) || 1;
            var parking = parseInt(document.getElementById('parking').value) || 0;
            var lightingDecoration = parseInt(document.getElementById('lightingDecoration').value) || 0;
            var roomServices = parseInt(document.getElementById('roomServices').value) || 0;
            var eventManagers = parseInt(document.getElementById('eventManagers').value) || 0;
            var musicOrchestra = parseInt(document.getElementById('musicOrchestra').value) || 0;
            var photography = parseInt(document.getElementById('photography').value) || 0;
            var advancePayment = parseInt(document.getElementById('advancePayment').value) || 0;

            var totalCost = catering + (plateCount * catering) + parking +
                            lightingDecoration + roomServices + eventManagers + musicOrchestra + photography + advancePayment;

            
            document.getElementById('totalCost').value = "₹" + totalCost.toFixed(2);
            document.getElementById('hiddenTotalCost').value = totalCost.toFixed(2);
        }

        function generateQRCode() {
            var qrcodeContainer = document.getElementById('qrcodeContainer');
            var paymentLink = "YourPaymentLink"; // Replace with your actual payment link

            qrcodeContainer.innerHTML = ""; // Clear previous content
            var qr = new QRCode(qrcodeContainer, paymentLink);
        }

    </script>
</body>
</html>
