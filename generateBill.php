<?php
// Check if booking ID is provided in the URL
if(isset($_GET['id'])) {
    $bookingID = $_GET['id'];
    
    // Database connection parameters
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
    
    // SQL query to fetch booking details
    $sql = "SELECT * FROM bookings1 WHERE id = $bookingID";
    $result = $conn->query($sql);

    // Check if result has rows
    if ($result->num_rows > 0) {
        // Fetch row data
        $row = $result->fetch_assoc();
        
        // Generate bill in table format with attractive design
        $billContent = "
        <style>
            /* CSS styles for table (you can modify this as needed) */
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
            }
            h2 {
                text-align: center;
                color: #333;
                font-size: 28px;
                margin-bottom: 20px;
            }
            table {
                width: 60%;
                border-collapse: collapse;
                margin: 20px auto;
                background-color: #fff;
                box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            }
            th, td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: left;
            }
            th {
                background-color: lightskyblue;
                color: #fff;
            }
            .payment-link {
                display: block;
                text-align: center;
                margin-top: 20px;
                font-size: 18px;
                color: #007bff;
                text-decoration: none;
            }
            .payment-link:hover {
                text-decoration: underline;
            }
        </style>
        <h2>Ramgeet Event Venues - Booking Bill</h2>
        <table>
            <tr>
                <th>Attribute</th>
                <th>Value</th>
            </tr>";
        
        // Loop through booking details and add to the bill content
        foreach ($row as $key => $value) {
            $billContent .= "
            <tr>
                <td>" . ucwords(str_replace("_", " ", $key)) . "</td>
                <td>" . $value . "</td>
            </tr>";
        }
        
        // Add fake payment link
        $billContent .= "
        </table>
        <a class='payment-link' href='#'>Click here to make payment</a>
        ";
        
        // Output the bill content
        echo $billContent;
    } else {
        echo "Booking not found.";
    }
    // Close database connection
    $conn->close();
} else {
    echo "Booking ID not provided.";
}
?>
