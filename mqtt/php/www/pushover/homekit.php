<?php


$output = shell_exec('sudo node /home/pi/HAP-NodeJS/Core.js < /dev/null &');
echo $output;
sleep(1);


?>