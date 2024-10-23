<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BFARMC - Sinalhan</title>
  <link rel="icon" href="images/villa-gilda-logo3.png">
  <link rel="stylesheet" type="text/css" href="css/general.css">
  <link rel="stylesheet" type="text/css" href="css/login.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
<form method="post" class="login-form">
    <div><img src="images/villa-gilda-logo2.png" class="logo" alt="Villa Gilda Resort Logo"></div>   
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
                    header('Location: pages/officials/officials.php');
                    exit();
                } elseif ($role === 'staff') {
                    header('Location: pages/resident/resident.php');
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
      <input class="username" placeholder="Enter your username" type="text" name="username" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','');" required>
    </div>
    <div class="password-field">
      <input placeholder="Enter your password" class="password" id="password" type="password" name="password" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','');" required>
    </div>
    <div class="login"><input class="submit-btn" type="submit" name="btn_login" value="LOGIN"></div>
    <div class="forgot"><a class="forgot-redirect" href="forget_password.php">FORGOT YOUR PASSWORD?</a></div>

    <div class="sun"></div>
    <div class="custom-shape-divider-bottom-1717433957">
      <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
          <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
      </svg>
    </div>
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
