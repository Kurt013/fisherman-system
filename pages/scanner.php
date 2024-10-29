<!DOCTYPE html>
<html>

<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: ../../login.php"); 
} else {
    ob_start();
    include('C:\xampp\htdocs\fisherman-system\pages\head_css.php'); 
?>
<body class="skin-blue">
    <?php include ('C:\xampp\htdocs\fisherman-system\pages\connection.php'); ?>
    <?php include('C:\xampp\htdocs\fisherman-system\pages\header.php'); ?>

    <div class="wrapper row-offcanvas row-offcanvas-left">
        <?php include('C:\xampp\htdocs\fisherman-system\pages\sidebar-left.php'); ?>

        <aside class="right-side">
            <section class="content-header">
                <h1>QR Scanner</h1>
            </section>
<video id="preview" style="width: 100%; max-width: 600px;"></video>
<br>
<label for="cameraSelect">Select Camera:</label>
<select id="cameraSelect"></select>

<button id="open">Open Camera</button>
<button id="close">Close Camera</button>

<script type="text/javascript">
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    let cameras = [];
    let isScanning = false;

    // Listener for QR code content
    scanner.addListener('scan', function (content) {
        console.log("Scanned content:", content);
        
        // Handle the scanned content (e.g., redirect to a URL)
        if (content) {
            window.location.href = content; // Redirect to the scanned URL
        } else {
            console.error('No content scanned.');
        }
    });

    // Fetch available cameras and populate the dropdown
    Instascan.Camera.getCameras().then(function (availableCameras) {
        if (availableCameras.length > 0) {
            cameras = availableCameras;
            let cameraSelect = document.getElementById('cameraSelect');
            cameraSelect.innerHTML = ''; // Clear existing options

            cameras.forEach((camera, index) => {
                let option = document.createElement('option');
                option.value = index;
                option.text = camera.name || `Camera ${index + 1}`;
                cameraSelect.appendChild(option);
            });
        } else {
            console.error('No cameras found.');
            alert('No cameras found. Please connect a camera and reload the page.');
        }
    }).catch(function (e) {
        console.error("Error accessing camera:", e);
        alert('Error accessing camera: ' + e);
    });

    // Function to start the selected camera
    function startCamera() {
        let cameraIndex = document.getElementById('cameraSelect').value;
        if (cameras[cameraIndex]) {
            scanner.start(cameras[cameraIndex]).then(() => {
                isScanning = true;
                console.log(`Camera ${cameraIndex} started.`);
            }).catch(e => {
                console.error("Error starting camera:", e);
                alert('Error starting camera: ' + e);
            });
        } else {
            console.error('Selected camera not found.');
            alert('Selected camera not found.');
        }
    }

    // Function to stop the camera
    function stopCamera() {
        if (isScanning) {
            scanner.stop();
            isScanning = false;
            console.log("Camera stopped.");
        }
    }

    // Event listeners for open and close buttons
    document.getElementById('open').addEventListener('click', startCamera);
    document.getElementById('close').addEventListener('click', stopCamera);
</script>
<?php include('C:/xampp/htdocs/fisherman-system/pages/footer.php'); ?>

</body>
</html>
<?php } ?>
