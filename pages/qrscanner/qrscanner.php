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
                        <i class="bx bx-qr-scan"></i> <span>QR Scanner</span>
                    </h1>
                </section>
                <section class="content">
                    <video id="preview" style="width: 100%; max-width: 600px; height: auto;"></video>
                    <br>
                    <label for="cameraSelect">Select Camera:</label>
                    <select id="cameraSelect"></select>

                    <button id="open">Open Camera</button>
                    <button id="close">Close Camera</button>

                    <!-- Element to display scanned data -->
                    <div id="scannedData" style="margin-top: 20px; font-size: 18px;"></div>

                    <script type="text/javascript">
                        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
                        let cameras = [];
                        let isScanning = false;

                        // Listener for QR code content
                        scanner.addListener('scan', function (content) {
                            console.log("Scanned content:", content);

                            // Display the scanned content in the HTML element
                            document.getElementById('scannedData').innerText = content;
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
                    <?php }
                    include "../footer.php"; 
                    ?>
                </section>

            </aside>
        </div>
    </body>
</html>
