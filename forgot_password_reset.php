<?php
session_start();
$message = "";
$modal = false;
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_barangay'; // Adjusted to remove the space
$dbconfig = mysqli_connect($host, $username, $password, $database);

if (!$dbconfig) {
    die("An error occurred when connecting to the database: " . mysqli_connect_error());
}

// Handle verification code submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_verification_code'])) {
    $key = $_POST['verification_code'];
    $email = $_SESSION['email'];
    $check = mysqli_query($dbconfig, "SELECT * FROM forget_password WHERE email='$email' and temp_key='$key'");

    if (!$check) {
        $message = "Database query failed: " . mysqli_error($dbconfig);
    } else if (mysqli_num_rows($check) != 1) {
        header('Location: forget_password.php');
        exit;
      } else {
        $_SESSION['verification_code'] = $key;
        $message_success = "Verification code accepted. Please enter your new password.";
    }
}

function is_valid_password($password1) {
    // Length check
    if (strlen($password1) < 8) {
        return false;
    }
    
    // Character types check
    if (!preg_match('/[A-Za-z]/', $password1) || // contains at least one letter
        !preg_match('/\d/', $password1) ||      // contains at least one number
        !preg_match('/[^A-Za-z\d]/', $password1) // contains at least one special character
    ) {
        return false;
    }
    
    return true;
}
// Handle password reset submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
  if (isset($_SESSION['email']) && isset($_SESSION['verification_code'])) {
      $email = $_SESSION['email'];
      $key = $_SESSION['verification_code'];

      $password1 = mysqli_real_escape_string($dbconfig, $_POST['password1']);
      $password2 = mysqli_real_escape_string($dbconfig, $_POST['password2']);

      if ($password1 == $password2) {
        if(is_valid_password($password1)){
            $result = mysqli_query($dbconfig, "SELECT * FROM `tbluser` WHERE `email`='$email'");
            if ($result && mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                // Verify if the entered password matches the stored hashed password
                if (password_verify($password1, $row['password'])) {
                    $message = "You cannot reuse the same password.";
                } else {
                    // Proceed with updating the password
                    $password_hash = password_hash($password1, PASSWORD_DEFAULT);
                    $delete_query = mysqli_query($dbconfig, "DELETE FROM forget_password WHERE email='$email' AND temp_key='$key'");
                    $update_query = mysqli_query($dbconfig, "UPDATE `tbluser` SET `password`='$password_hash' WHERE `email`='$email'");

                    if ($update_query) {
                        $modal = true;
                        $message_success = "New password has been set for " . $email;
                        session_unset();
                        session_destroy();
                    } else {
                        $message = "Error updating password: " . mysqli_error($dbconfig);
                    }
                }
         } else {
              $message = "Error fetching user data.";
          }
      } else {
            $message = "Password must be 8 characters or more, and include letters, numbers, and special characters";
      } 
      }
      else {
          $message = "Passwords do not match.";
      }
  } else {
      header('Location: index.php');
  }
}
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BFARMC - Sinalhan || Reset Password</title>

<!-- Favicon -->
<link rel="icon" href="img/bfarmc-sinalhan-logo.png">

<!-- Stylesheets -->
<link rel="stylesheet" type="text/css" href="css/general.css">
<link rel="stylesheet" type="text/css" href="css/forgot_password_reset.css">

<!-- Boxicon Link -->
<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

<!-- Remixicon Link -->
<link
  href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
  rel="stylesheet"
/>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<style>
    .feedback {
        font-size: 12px;
        margin-top: 5px;
    }
    .feedback.success {
        color: #28a745; /* Optional: Green color for success messages */
        background-color: transparent; /* Transparent background for success as well */
        font-size: 12px;
        margin-top: 5px;
    }
    .feedback.error {
        color: red; /* Sets the text color to red */
        background-color: transparent; /* Makes the background transparent */
        font-size: 12px; /* Optional: Adjust font size */
        margin-top: 5px;
    }
</style>
</head>
<body>

<div class="container">
    <form class="password-form" role="form" method="POST">
        <h1>Reset Password</h1>
        <div class="group-wrapper">
            <p>You can now choose a new password for this user account. This password will replace the old one; everything about the user account will remain unchanged.</p>
            <div class="form-group">
                <label for="pwd">New Password:</label>
                <input type="password" class="form-control" id="pwd" name="password1" placeholder="Enter new password" required oninput="validatePassword()">
                <div id="password-feedback" class="feedback"></div>
            </div>
            <div class="form-group">
                <label for="confirm-pwd">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm-pwd" name="password2" placeholder="Confirm new password" required>
                <div id="confirm-feedback" class="feedback"></div>
            </div>
        </div>
        <?php if ($message != "") {
            echo "<div class='error-message'>" . $message . "</div>";
        } ?>
        <?php if (isset($message_success)) {
            echo "<div class='success-message'>" . $message_success . "</div>";
        } ?>
        <div class="bottom-part-3"><button type="submit" class="btn-save" name="submit" id="submit-button" disabled>Save Password</button></div>
    </form>
</div>
<?php
if ($modal) {
    echo '<dialog class="field">
                <div class="icon-wrapper"><i class="ri-verified-badge-fill"></i></div>
                <div class="text-group">
                    <h1>Success</h1>
                    <p>Your password has been reset successfully. You can now use your new password to login!</p>
                </div>
                <div class="bottom-part">
                    <a class="btn" href="index.php">Back to Login Page</a>
                </div>
        </dialog>
            
            <script> 
                dialog = document.querySelector("dialog");
                dialog.showModal();
            </script>';
}
?>

<script>
    function validatePassword() {
        const passwordField = document.getElementById('pwd');
        const confirmPasswordField = document.getElementById('confirm-pwd');
        const feedback = document.getElementById('password-feedback');
        const confirmFeedback = document.getElementById('confirm-feedback');
        const submitButton = document.getElementById('submit-button');

        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;

        const regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        if (regex.test(password)) {
            feedback.textContent = "";
            feedback.classList.remove('error');
            feedback.classList.add('success');
            passwordField.style.borderColor = '#28a745';
        } else {
            feedback.textContent = "Password must be at least 8 characters long, contain letters, numbers, and special characters.";
            feedback.classList.remove('success');
            feedback.classList.add('error');
            passwordField.style.borderColor = 'red';
        }

        if (password && confirmPassword) {
            if (password === confirmPassword) {
                confirmFeedback.textContent = "";
                confirmFeedback.classList.remove('error');
                confirmFeedback.classList.add('success');
                confirmPasswordField.style.borderColor = '#28a745';
            } else {
                confirmFeedback.textContent = "Passwords do not match.";
                confirmFeedback.classList.remove('success');
                confirmFeedback.classList.add('error');
                confirmPasswordField.style.borderColor = 'red';
            }
        } else {
            confirmFeedback.textContent = "";
        }

        submitButton.disabled = !(regex.test(password) && password === confirmPassword);
    }

    document.getElementById('confirm-pwd').addEventListener('input', validatePassword);
</script>

</body>
</html>
