<?php

/**
 * It should be accesible like this:
 * http://artbek.co.uk/source.php?path=/var/www/mysourcecode/file.php
 */

$allowed = array(
    '127.0.0.1'
);

if (isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], $allowed)) {

    $f = '';

    if (isset($_GET['path'])) {
        $filename = $_GET['path'];

        if ($filename) {
            $f = file_get_contents($filename);
        }
    }

    header('Content-type: text/plain');
    echo $f;

} else {

    echo 'Permission denied!';

}
