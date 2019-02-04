<?php

$connection = mysqli_connect('localhost','root','12345678','website');

if($connection) ;//echo 'connected';
else echo 'connection failed';

$sql_query;

mysqli_query($connection, $sql_query);

?>