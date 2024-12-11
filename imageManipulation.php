<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $uploadedFile = $_FILES['image']['tmp_name'];
    $outputFormat = $_POST['format'];
    $resizeWidth = intval($_POST['resize_width']);
    $resizeHeight = intval($_POST['resize_height']);
    $cropX = intval($_POST['crop_x']);
    $cropY = intval($_POST['crop_y']);
    $cropWidth = intval($_POST['crop_width']);
    $cropHeight = intval($_POST['crop_height']);
    $watermarkFile = "watermark.png";

    // Load the image
    $imageInfo = getimagesize($uploadedFile);
    $mime = $imageInfo['mime'];
    $image = null;

    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($uploadedFile);
            break;
        case 'image/png':
            $image = imagecreatefrompng($uploadedFile);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($uploadedFile);
            break;
        default:
            die("Unsupported image format!");
    }

    // Resize the image
    if ($resizeWidth > 0 && $resizeHeight > 0) {
        $resizedImage = imagecreatetruecolor($resizeWidth, $resizeHeight);
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $resizeWidth, $resizeHeight, imagesx($image), imagesy($image));
        imagedestroy($image);
        $image = $resizedImage;
    }

    // Crop the image
    if ($cropWidth > 0 && $cropHeight > 0) {
        $croppedImage = imagecreatetruecolor($cropWidth, $cropHeight);
        imagecopy($croppedImage, $image, 0, 0, $cropX, $cropY, $cropWidth, $cropHeight);
        imagedestroy($image);
        $image = $croppedImage;
    }

    // Add watermark
    if (file_exists($watermarkFile)) {
        $watermark = imagecreatefrompng($watermarkFile);
        $wmWidth = imagesx($watermark);
        $wmHeight = imagesy($watermark);
        $wmX = imagesx($image) - $wmWidth - 10; // 10px padding
        $wmY = imagesy($image) - $wmHeight - 10;

        imagecopy($image, $watermark, $wmX, $wmY, 0, 0, $wmWidth, $wmHeight);
        imagedestroy($watermark);
    }

    // Output the image in the specified format
    header("Content-Type: image/$outputFormat");
    switch ($outputFormat) {
        case 'jpeg':
            imagejpeg($image);
            break;
        case 'png':
            imagepng($image);
            break;
        case 'gif':
            imagegif($image);
            break;
    }

    // Free memory
    imagedestroy($image);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Image Manipulation</title>
</head>
<body>
    <h1>PHP Image Manipulation</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="image">Upload an image:</label><br>
        <input type="file" name="image" id="image" accept="image/*" required><br><br>

        <h3>Resize Image</h3>
        <label for="resize_width">Width:</label>
        <input type="number" name="resize_width" id="resize_width" min="0" placeholder="Enter width"><br>
        <label for="resize_height">Height:</label>
        <input type="number" name="resize_height" id="resize_height" min="0" placeholder="Enter height"><br><br>

        <h3>Crop Image</h3>
        <label for="crop_x">X:</label>
        <input type="number" name="crop_x" id="crop_x" min="0" placeholder="Crop from X"><br>
        <label for="crop_y">Y:</label>
        <input type="number" name="crop_y" id="crop_y" min="0" placeholder="Crop from Y"><br>
        <label for="crop_width">Width:</label>
        <input type="number" name="crop_width" id="crop_width" min="0" placeholder="Enter crop width"><br>
        <label for="crop_height">Height:</label>
        <input type="number" name="crop_height" id="crop_height" min="0" placeholder="Enter crop height"><br><br>

        <h3>Output Format</h3>
        <select name="format" required>
            <option value="jpeg">JPEG</option>
            <option value="png">PNG</option>
            <option value="gif">GIF</option>
        </select><br><br>

        <button type="submit">Process Image</button>
    </form>
</body>
</html>