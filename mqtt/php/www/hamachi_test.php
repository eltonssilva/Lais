<?php

$pin = $_GET['pin'];

		$shell_hamachi1 = "sudo systemctl stop logmein-hamachi";
		$shell_hamachi2 = "cd /var/lib/logmein-hamachi";
		$shell_hamachi3 = "sudo rm *";
		$shell_hamachi4 = "sudo systemctl start logmein-hamachi";
		$shell_hamachi5 = "sudo hamachi login";
		$shell_hamachi6 = "sudo hamachi attach eltonss.eng@gmail.com";
		$shell_hamachi7 = "sudo hamachi set-nick {$pin}";
		
		$output = exec($shell_hamachi1);
		echo $output;
		$output = exec($shell_hamachi2);
		echo $output;
		$output = exec($shell_hamachi3);
		echo $output;
		$output = exec($shell_hamachi4);
		echo $output;
		$output = exec($shell_hamachi5);
		echo $output;
		$output = exec($shell_hamachi6);
		echo $output;
		$output = exec($shell_hamachi7);
		echo $output;

?>