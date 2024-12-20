<!DOCTYPE html>
<html>

<head>
    <?php
    session_start();
    if(!isset($_SESSION['role']))
    {
        header("Location: ../../index.php"); 
    }
    else
    {
        ob_start();
        include('../head_css.php'); ?>
        <!-- Include Instascan Library -->
        <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
        <link href="../../css/scanner.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="skin-blue">
        <?php 
        include "../connection.php";
        ?>
        <?php include('../header.php'); ?>

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?php include('../sidebar-left.php'); ?>

            <aside class="right-side">
                <section class="content-header">
                    <h1>
                    <i class="fa-solid fa-qrcode"></i> <span>Qr Scanner</span>
                    </h1>
                </section>
                <div class="content-wrapper">
                    <!-- Video preview on the left -->
                    <div class="video-overlay-container">
            <h2 class="overlay-text">BFARMC Member Profile Access</h2>
            <video id="preview"></video>
        </div>

                    <!-- Content on the right -->
                    <section class="content">
                        <h2 class="scan">Scan Here</h2>
                        <label for="cameraSelect">Select Camera:</label>
                        <select id="cameraSelect"></select>
                        
                        <div class="button-group">
                        <button id="close"> <span><i class="bx bx-camera-off"></i> </span> Camera Off</button>
                            <button id="open">  <span><i class="bx bx-camera"></i></span>Camera On</button>
                        </div>
                    </section>
                </div>

                <script type="text/javascript">
                    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
                    let cameras = [];
                    let isScanning = false;

                    // Listener for QR code content
                    scanner.addListener('scan', function (content) {
        console.log("Scanned content:", content);
        
        let link = document.createElement("a");
        link.href = content;
        link.target = "_blank";
        link.click();
      });
                    // Fetch available cameras and populate the dropdown
                    async function getCameras() {
                        try {
                            cameras = await Instascan.Camera.getCameras();
                            if (cameras.length > 0) {
                                const cameraSelect = document.getElementById('cameraSelect');
                                cameraSelect.innerHTML = ''; // Clear existing options

                                cameras.forEach((camera, index) => {
                                    const option = document.createElement('option');
                                    option.value = index;
                                    option.text = camera.name || `Camera ${index + 1}`;
                                    cameraSelect.appendChild(option);
                                });
                            } else {
                                alert('No cameras found. Please connect a camera and reload the page.');
                            }
                        } catch (e) {
                            console.error("Error accessing cameras:", e);
                            alert('Error accessing camera: ' + e);
                        }
                    }

                    // Start the selected camera
                    async function startCamera() {
                        const cameraIndex = document.getElementById('cameraSelect').value;
                        if (cameras[cameraIndex]) {
                            try {
                                await scanner.start(cameras[cameraIndex]);
                                isScanning = true;
                                console.log(`Camera ${cameraIndex} started.`);

                                const preview = document.getElementById('preview');
                                preview.style.backgroundColor = ''; 
                            } catch (e) {
                                console.error("Error starting camera:", e);
                                alert('Error starting camera: ' + e);
                            }
                        } else {
                            alert('Selected camera not found.');
                        }
                    }

                    // Stop the camera
                    function stopCamera() {
                        if (isScanning) {
                            scanner.stop();
                            isScanning = false;
                            console.log("Camera stopped.");
                        }
                        const preview = document.getElementById('preview');
                        preview.style.backgroundColor = '#FFDE59';
                    }

                    // Event listeners for open and close buttons
                    document.getElementById('open').addEventListener('click', startCamera);
                    document.getElementById('close').addEventListener('click', stopCamera);

                    // Load cameras on page load
                    getCameras();
                </script>
                <?php }
                include "../footer.php"; 
                ?>
                        </section>

            </aside>
        </div>
    </body>
</html>
