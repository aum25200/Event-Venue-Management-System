<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="signup-user.php" method="POST" autocomplete="" onsubmit="return validateForm()">
                    <h2 class="text-center">Registration Form</h2>
                    <p class="text-center">It's quick and easy.</p>
                    <?php
                    if(count($errors) == 1){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }elseif(count($errors) > 1){
                        ?>
                        <div class="alert alert-danger">
                            <?php
                            foreach($errors as $showerror){
                                ?>
                                <li><?php echo $showerror; ?></li>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="text" name="name" id="name" placeholder="Full Name" required value="<?php echo $name ?>">
                        <span id="name-error" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" id="email" placeholder="Email Address" required value="<?php echo $email ?>">
                        <span id="email-error" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
                        <span id="password-error" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="cpassword" id="cpassword" placeholder="Confirm password" required>
                        <span id="cpassword-error" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="signup" value="Signup">
                    </div>
                    <div class="link login-link text-center">Already a member? <a href="login-user.php">Login here</a></div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function validateForm() {
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var cpassword = document.getElementById('cpassword').value;

            var namePattern = /^[a-zA-Z\s]+$/;
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            var valid = true;

            if (!name.match(namePattern)) {
                document.getElementById('name-error').innerHTML = 'Please enter a valid name';
                valid = false;
            } else {
                document.getElementById('name-error').innerHTML = '';
            }

            if (!email.match(emailPattern)) {
                document.getElementById('email-error').innerHTML = 'Please enter a valid email address';
                valid = false;
            } else {
                document.getElementById('email-error').innerHTML = '';
            }

            if (password.length < 6) {
                document.getElementById('password-error').innerHTML = 'Password must be at least 6 characters long';
                valid = false;
            } else {
                document.getElementById('password-error').innerHTML = '';
            }

            if (password !== cpassword) {
                document.getElementById('cpassword-error').innerHTML = 'Passwords do not match';
                valid = false;
            } else {
                document.getElementById('cpassword-error').innerHTML = '';
            }

            return valid;
        }
    </script>
</body>
</html>
