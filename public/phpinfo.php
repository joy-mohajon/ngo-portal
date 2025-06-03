<?php
// Show only the upload_max_filesize and post_max_size settings
echo 'Upload max filesize: ' . ini_get('upload_max_filesize') . '<br>';
echo 'Post max size: ' . ini_get('post_max_size') . '<br>';
?> 