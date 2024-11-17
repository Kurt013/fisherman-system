<?php if (isset($_SESSION['password_mismatch'])): ?>
    <script>
        $(document).ready(function () {
            $('#passwordMismatchNotification').fadeIn().delay(3000).fadeOut(); // Show and auto-hide the notification
        });
    </script>
    <?php unset($_SESSION['password_mismatch']); ?>
<?php endif; ?>

<div id="passwordMismatchNotification" class="alert alert-danger" style="position: fixed; top: 1em; right: 1em; z-index: 9999; display: none;">
    Passwords do not match. Please try again.
</div>

<?php if (isset($_SESSION['error'])): ?>
    <script>
        $(document).ready(function () {
            $('#updateErrorNotification').fadeIn().delay(3000).fadeOut(); // Show and auto-hide the notification
        });
    </script>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div id="updateErrorNotification" class="alert alert-danger" style="position: fixed; top: 4em; right: 1em; z-index: 9999; display: none;">
    Error updating password.
</div>

<?php if (isset($_SESSION['invalid_password'])): ?>
    <script>
        $(document).ready(function () {
            $('#invalidPasswordNotification').fadeIn().delay(3000).fadeOut(); // Show and auto-hide the notification
        });
    </script>
    <?php unset($_SESSION['invalid_password']); ?>
<?php endif; ?>

<div id="invalidPasswordNotification" class="alert alert-danger" style="position: fixed; top: 10em; right: 1em; z-index: 9999; display: none;">
    Password must be at least 8 characters long, including letters, numbers, and special characters.
</div>


<?php if (isset($_SESSION['old_mismatch'])): ?>
    <script>
        $(document).ready(function () {
            $('#oldPasswordMismatchNotification').fadeIn().delay(3000).fadeOut(); // Show and auto-hide the notification
        });
    </script>
    <?php unset($_SESSION['old_mismatch']); ?>
<?php endif; ?>

<div id="oldPasswordMismatchNotification" class="alert alert-danger" style="position: fixed; top: 7em; right: 1em; z-index: 9999; display: none;">
    Old password is incorrect. Please try again.
</div>
