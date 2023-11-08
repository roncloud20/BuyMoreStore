<?php
    // Creating the page title and adding the header page 
    $pagetitle = "Create an Account with us";
    require_once "assets/header.php";

    // Creating a connection to the database
    require_once 'assets/db_connect.php';

    // Capturing error messages
    $fnerr = $lnerr = $pherr = $emerr = $userr = $paerr = $cperr = $adderr = "";
    $firstname = $lastname = $phone = $email = $username = $password = $cpassword = $address = $postal = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Sanitize the input parameters pass by users to avoid XSS vulnerabilities
        function sanitizeInput($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Collecting user information
        $firstname = sanitizeInput($_POST['firstname']);
        $lastname = sanitizeInput($_POST['lastname']);
        $phone = sanitizeInput($_POST['phone']);
        $email = sanitizeInput($_POST['email']);
        $username = sanitizeInput($_POST['username']);
        $password = sanitizeInput($_POST['password']);
        $cpassword = sanitizeInput($_POST['cpassword']);
        $address = sanitizeInput($_POST['address']);
        $role = sanitizeInput($_POST['role']);
        $postal = sanitizeInput($_POST['postal']);

        // Phone number verification
        if (preg_match('/^0[789][01]\d{8}$|^\+234[789][01]\d{8}$/', $phone)){
            // Check if the phone is taken
            $sql = "SELECT * FROM users WHERE phone_number = '$phone'";
            $result = mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($result) > 0) {
                $pherr = "{$phone} already exists";
            }
        } else {
            $pherr = "{$phone} is invalid";
        }

        // Email verification
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Check if the email is taken
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($result) > 0) {
                $emerr = "{$email} already exists";
            }
        } else {
            $emerr = "{$email} is invalid";
        }

        // Check if the username is taken
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0) {
            $userr = "{$username} already exists";
        }

        // Password validation
        if($password == $cpassword) {
            $hashpass = password_hash($password, PASSWORD_DEFAULT);
            // $hashpass = sha1($password);
        } else {
            $paerr = $cperr = "Passwords do not match";
        }

        // Populating the database
        if (empty($fnerr) && empty($lnerr) && empty($pherr) && empty($emerr) && empty($userr) && empty($paerr) && empty($cperr) && empty($adderr)) {
            $sql = "INSERT INTO users(first_name, last_name, phone_number, email, username, password, address, postal_code, user_role) VALUES ('$firstname','$lastname','$phone','$email','$username','$hashpass', '$address','$postal','$role')";
            if(mysqli_query($conn, $sql)) {
                echo "<h1>Registration Successfully</h1>";
                $firstname = $lastname = $phone = $email = $username = $password = $cpassword = $address = $postal = "";
            } else {
                echo "<h1>Registration Failure</h1>";
            }
        }
       

    }
?>
<form action="" method="post">
    <p>Already have an account? <a href="login.php">Sign in</a></p>
    <h1>Register your new account</h1>
    <input type="text" maxlength="50" placeholder="Firstname" name="firstname" value="<?php echo $firstname ?>" required/>
    <span><?php echo $fnerr; ?></span>
    <input type="text" maxlength="50" placeholder="Lastname" name="lastname" value="<?php echo $lastname ?>" required/>
    <span><?php echo $lnerr; ?></span>
    <br/>
    <input type="tel" maxlength="20" placeholder="Phone Number" name="phone" value="<?php echo $phone ?>" required/>
    <span><?php echo $pherr; ?></span>
    <input type="email" maxlength="100" placeholder="Email Address" name="email" value="<?php echo $email ?>" required/>
    <span><?php echo $emerr; ?></span>
    <input type="text" maxlength="50" placeholder="Username" name="username" value="<?php echo $username ?>" required/>
    <span><?php echo $userr; ?></span>
    <br/>
    <input type="password" placeholder="Password" name="password" required/>
    <span id='error'><?php echo $paerr; ?></span>
    <input type="password" placeholder="Confirm Password" name="cpassword" required/>
    <span><?php echo $cperr; ?></span>
    <br/>
    <input type="text" placeholder="Home Address" name="address" value="<?php echo $address ?>" required/>
    <span><?php echo $adderr; ?></span>
    <select name="role">
        <option value="user">User</option>
        <option value="vendor">Vendor</option>
    </select>
    <input type="text" placeholder="Postal Code" name="postal" value="<?php echo $postal ?>"/> 
    <br/>
    <input type="submit" value="Register">
</form>