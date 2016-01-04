<?php
$connect_error = 'Sorry we\'re experiencing connection problems';
//need to remove mysql error bad practice mysql_error() instead $connect_error
mysql_connect('localhost', 'root', '') or die($connect_error);

mysql_select_db('lr')or die($connect_error);
?>