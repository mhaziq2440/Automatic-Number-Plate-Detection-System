<?php
// Check if image data is received
if (isset($_POST['image_data'])) {
    $image_data = $_POST['image_data'];

    // Remove the "data:image/jpeg;base64," prefix from the base64 data
    $image_data = str_replace('data:image/jpeg;base64,', '', $image_data);
    $image_data = str_replace(' ', '+', $image_data);

    // Decode the base64 image data
    $decoded_image = base64_decode($image_data);

    // Set the file path for saving the image
    $upload_folder = 'uploads/';
    $image_file = $upload_folder . uniqid() . '.jpg';

    // Save the image to the server
    file_put_contents($image_file, $decoded_image);

    // Output a success message
    echo "Image saved successfully at $image_file";
} else {
    // Output an error message if image data is not received
    echo "Error: No image data received";
}
?>