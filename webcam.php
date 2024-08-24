<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webcam Scanner</title>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Include the necessary scripts for webcam scanning -->
    <script src="js/webcam.min.js"></script>
    <script src="js/qr-code-scanner.min.js"></script>
    <!-- Add any other necessary scripts here -->
</head>

<body>
    <h1>Webcam Scanner</h1>

    <div id="camera-container"></div>
    <button onclick="capture()">Capture</button>

    <script>
        // Add your JavaScript code for webcam scanning here

        // Example using webcam.js
        Webcam.set({
            width: 640,
            height: 480,
            dest_width: 640,
            dest_height: 480,
            image_format: 'jpeg',
            jpeg_quality: 90,
            force_flash: false,
            flip_horiz: false,
            fps: 45
        });

        Webcam.attach('#camera-container');

        function capture() {
            Webcam.snap(function (data_uri) {
                // Send the captured image data to the server for processing
                $.post("save_scan.php", { image_data: data_uri }, function (response) {
                    alert(response); // Display the response from save_scan.php
                    Webcam.off(); // Turn off the webcam
                    Webcam.on();  // Turn on the webcam again
                });
            });
        }
    </script>
</body>

</html>