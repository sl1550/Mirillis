<?php
 $m0 = imagecreatefromjpeg('my.jpg');
$whitebg = imagecolorallocate($m0, 255, 255, 255);
$m1 = imagerotate($m0, 45, $whitebg);
imagejpeg($m1, 'myrr.jpg', 100);
?>
<img src="myrr.jpg">
