<?php

$name = $_POST['name'];
$image = $_POST['image'];
$directory = $_POST['directory'];

$decode = base64_decode("$image");
file_put_contents("meetmeup/uploads/" . $directory .  "/" . $name . ".JPG", $decode);


?>