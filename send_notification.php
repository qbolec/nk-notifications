<?php
require 'includes/autoload.php';
$task = new SendNotification($_SERVER['argv']);
$task->run();
?>
