<?php


$conn = mysqli_connect('localhost', 'root', 'root', 'test');

if (!$conn) {
    echo "Connection failed" . mysqli_connect_error();
}

?>