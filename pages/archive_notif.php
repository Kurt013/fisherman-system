<?php if (isset($_SESSION['archive'])): ?>
    <script>
        $(document).ready(function () {
            $('#archiveNotification').fadeIn().delay(3000).fadeOut(); // Show and auto-hide the archive notification
        });
    </script>
    <?php unset($_SESSION['archive']); ?>
<?php endif; ?>
<div id="archiveNotification" class="alert alert-success alert-autocloseable-success" style="position: fixed; top: 1em; right: 1em; z-index: 9999; display: none;">
    Archived Successfully!
</div>

<?php if (isset($_SESSION['unarchive'])): ?>
    <script>
        $(document).ready(function () {
            $('#unarchiveNotification').fadeIn().delay(3000).fadeOut(); // Show and auto-hide the archive notification
        });
    </script>
    <?php unset($_SESSION['unarchive']); ?>
<?php endif; ?>
<div id="unarchiveNotification" class="alert alert-success alert-autocloseable-success" style="position: fixed; top: 1em; right: 1em; z-index: 9999; display: none;">
    Unarchived Successfully!
</div>