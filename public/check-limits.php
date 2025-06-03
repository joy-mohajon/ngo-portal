<?php
// Display PHP upload limits
echo "<h2>PHP Upload Limits</h2>";
echo "<p>upload_max_filesize: " . ini_get('upload_max_filesize') . "</p>";
echo "<p>post_max_size: " . ini_get('post_max_size') . "</p>";
echo "<p>memory_limit: " . ini_get('memory_limit') . "</p>";
echo "<p>max_execution_time: " . ini_get('max_execution_time') . "</p>";
echo "<p>max_file_uploads: " . ini_get('max_file_uploads') . "</p>";

// Convert to bytes for comparison
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    $val = (int)$val;
    switch($last) {
        case 'g': $val *= 1024;
        case 'm': $val *= 1024;
        case 'k': $val *= 1024;
    }
    return $val;
}

$upload_max_filesize = return_bytes(ini_get('upload_max_filesize'));
$post_max_size = return_bytes(ini_get('post_max_size'));
$memory_limit = return_bytes(ini_get('memory_limit'));

echo "<h2>Values in Bytes</h2>";
echo "<p>upload_max_filesize: " . $upload_max_filesize . " bytes (" . round($upload_max_filesize / (1024*1024), 2) . " MB)</p>";
echo "<p>post_max_size: " . $post_max_size . " bytes (" . round($post_max_size / (1024*1024), 2) . " MB)</p>";
echo "<p>memory_limit: " . ($memory_limit == -1 ? "Unlimited" : $memory_limit . " bytes (" . round($memory_limit / (1024*1024), 2) . " MB)") . "</p>";

// Check if any .user.ini or .htaccess files are being used
echo "<h2>Custom Configuration Files</h2>";
$user_ini_exists = file_exists(__DIR__ . '/.user.ini');
$htaccess_exists = file_exists(__DIR__ . '/.htaccess');
$php_ini_exists = file_exists(__DIR__ . '/php.ini');

echo "<p>.user.ini exists: " . ($user_ini_exists ? "Yes" : "No") . "</p>";
echo "<p>.htaccess exists: " . ($htaccess_exists ? "Yes" : "No") . "</p>";
echo "<p>php.ini exists: " . ($php_ini_exists ? "Yes" : "No") . "</p>";

// Display PHP info
echo "<h2>PHP Info</h2>";
echo "<pre>";
echo "PHP Version: " . phpversion() . "\n";
echo "Server API: " . php_sapi_name() . "\n";
echo "Loaded Configuration File: " . php_ini_loaded_file() . "\n";
echo "Additional .ini files: " . implode(", ", php_ini_scanned_files() ?: array('None')) . "\n";
echo "</pre>";
?> 