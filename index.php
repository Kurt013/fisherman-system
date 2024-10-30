<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BFARMC - Sinalhan</title>
  <link rel="icon" href="img/bfarmc-sinalhan-logo.png">
  <link rel="stylesheet" type="text/css" href="css/general.css">
  <link rel="stylesheet" type="text/css" href="css/login.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
<form method="post" class="login-form">
    <div><img src="img/bfarmc-sinalhan-logo.png" class="logo" alt="BFARMC - SINALHAN Logo"></div>   
    <h1>BFARMC - Sinalhan Record and Identification System </h1>
    <p class='error-message visibility' id="error">The password or username you entered is incorrect. Please try again. </p>
    
    <?php
    include "pages/connection.php";

    if (isset($_POST['btn_login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare the query
        $query = "SELECT id, username, password, role FROM tbluser WHERE username = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $username, $db_password_hash, $role);
            $stmt->fetch();

            // Debugging: Check fetched values
            // echo "Username: $username, Password Hash: $db_password_hash, Role: $role";

            // Verify the password
            if (password_verify($password, $db_password_hash)) {
                $_SESSION['userid'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;

                // Redirect based on the role
                if ($role === 'administrator') {
                    header('Location: pages/home/home.php');
                    exit();
                } elseif ($role === 'staff') {
                    header('Location: pages/home/home.php');
                    exit();
                }
            } else {
                // Incorrect password
                echo "<script>
                    document.getElementById('error').textContent = 'The password or username you entered is incorrect. Please try again.';
                    document.getElementById('error').classList.remove('visibility');
                </script>";
            }
        } else {
            // User not found
            echo "<script>
                document.getElementById('error').textContent = 'Invalid Account';
                document.getElementById('error').classList.remove('visibility');
            </script>";
        }

        // Close the statement
        $stmt->close();
    }
    ?>
    <div class="username-field">
      <label for="username">Username</label>
      <input class="username" placeholder="Enter your username" type="text" name="username" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','');" required>
    </div>
    <div class="password-field">
      <label for="password">Password</label>
      <input placeholder="Enter your password" class="password" id="password" type="password" name="password" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','');" required>
    </div>
    <div class="login"><input class="submit-btn" type="submit" name="btn_login" value="Login"></div>
    <div class="forgot"><a class="forgot-redirect" href="forget_password.php">Forgot Password?</a></div>
  </form>
  <?php
  //$conn = new mysqli('localhost', 'root', '', 'db_barangay');

  
   //$password = 'staff123';
   //$encryptedPass = password_hash($password, PASSWORD_BCRYPT);
   //$sql = "INSERT INTO tbluser (username, password, role) VALUES ('bfarmcstaff', '{$encryptedPass}', 'staff')";
 
    //$conn->query($sql);
 ?>
  <script src="login.js"></script>
</body>
</html>
