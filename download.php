<?php
// Generate file content (you can modify this part according to your needs)
$fileContent = "Hello, this is the content of the downloaded file.";

// Set the content type and headers for download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="downloaded_file.txt"');

// Output the file content
echo $fileContent;
?>