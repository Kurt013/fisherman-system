<?php if (isset($_SESSION['edited'])): ?>
    <script>
        $(document).ready(function () {
            $('#editNotification').fadeIn().delay(3000).fadeOut(); // Show and auto-hide the edit notification
        });
    </script>
    <?php unset($_SESSION['edited']); ?>
<?php endif; ?>
<div id="editNotification" class="alert alert-success alert-autocloseable-success" style="position: fixed; top: 1em; right: 1em; z-index: 9999; display: none;">
    Edit Successfully Saved!
</div>