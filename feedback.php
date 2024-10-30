<?php
// Database connection parameters
$servername = "localhost"; // Update with your MySQL server name
$username = "root";        // Update with your MySQL username
$password = "";            // Update with your MySQL password
$dbname = "userform";   // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);

    // Insert data into the database
    $sql = "INSERT INTO feedback (name, email, ratings, comments) VALUES ('$name', '$email', '$rating', '$comments')";

    if ($conn->query($sql) === TRUE) {
        //echo "Feedback submitted successfully";
    } else {
        echo "Error: " ;
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="feedbackicon.png" type="image/x-icon">
    <title>Feedback Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .additional-info {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #e6f7ff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .additional-info h3 {
            color: #007bff;
            font-size: 24px;
        }

        .additional-info p {
            color: #555;
            font-size: 16px;
            line-height: 1.5;
        }

        form {
            max-width: 400px;
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

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: purple;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: maroon;
        }

        .error-message {
            color: #ff0000;
            margin-top: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="additional-info">
        <h3>Express Your Feedback Freely</h3>
        <p>We highly value your opinion! Your feedback is crucial in helping us understand your experience and make necessary improvements to our services. Feel free to express your thoughts and suggestions in the comments section above.</p>
        <p>Thank you for being a part of making our services even better!</p>
    </div>

    <form id="feedbackForm" method="post" onsubmit="return validateForm()">
        <h2>Events Feedback</h2>

        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="rating">Rate your experience (1-5):</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required>

        <label for="comments">Comments:</label>
        <textarea id="comments" name="comments" rows="4" required></textarea>

        <input type="submit" value="Submit Feedback">
    </form>

    <script>
        function validateForm() {
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var rating = document.getElementById('rating').value;

            // Name validation: should not be empty and should contain only letters and spaces
            if (name === '' || !/^[a-zA-Z\s]+$/.test(name)) {
                alert('Please enter a valid name (only letters and spaces allowed)');
                return false;
            }

            // Email validation: should not be empty and should have a valid email format
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === '' || !emailPattern.test(email)) {
                alert('Please enter a valid email address');
                return false;
            }

            // Rating validation: should not be empty and should be a number between 1 and 5
            if (rating === '' || isNaN(rating) || rating < 1 || rating > 5) {
                alert('Please enter a valid rating between 1 and 5');
                return false;
            }

            // You can add more complex validation here if needed

            return true;
        }
    </script>
</body>
</html>

