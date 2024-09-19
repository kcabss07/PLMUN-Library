<?php
session_start();

// Generate a random CAPTCHA code
$captcha_code = '';
$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
$characters_length = strlen($characters);
for ($i = 0; $i < 6; $i++) {
    $captcha_code .= $characters[rand(0, $characters_length - 1)];
}
$_SESSION['captcha_code'] = $captcha_code;

// Create a larger CAPTCHA image (wider and taller)
$im = imagecreatetruecolor(180, 40);

// Check if the GD library is working
if (!$im) {
    die("Error: Could not initialize image creation. Make sure the GD library is installed.");
}

// Set background and text colors
$bg = imagecolorallocate($im, 1, 200, 1); // Background color 
$fg = imagecolorallocate($im, 255, 255, 255); // Text color 
imagefill($im, 0, 0, $bg);

// Use a built-in font and adjust character spacing
$font_size = 5; // Largest built-in font
$font_width = imagefontwidth($font_size); // Calculate the width of one character in the built-in font
$font_height = imagefontheight($font_size); // Calculate the height of the font

// Adjust the positioning (X and Y) for each character
$spacing = 20; // Space between characters
$start_x = 10; // Starting X position for the first character
$start_y = ($font_height / 2) + 10; // Centered Y position (adjust to vertically align text)

// Loop through each character and display it with spacing
for ($i = 0; $i < strlen($captcha_code); $i++) {
    $x = $start_x + ($i * ($font_width + $spacing)); // Calculate X position with spacing
    imagestring($im, $font_size, $x, $start_y, $captcha_code[$i], $fg);
}

// Output the image as a PNG
header('Content-type: image/png');
imagepng($im);

// Free memory
imagedestroy($im);
?>
