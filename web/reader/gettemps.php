<?php

		$contents = file_get_contents('/home/pi/temps/realtime.temp');
		$contents = str_replace("-", "/", $contents);
        $pecas = explode(' ',$contents);
        
        $data = explode('/', $pecas[0]);
        $pecas[0] = $data[2]."/".$data[1]."/".$data[0];
		$tempo = explode('.', $pecas[1]);
		$pecas[1] = $tempo[0];
        $pecas[2] = round(floatval($pecas[2]), 2);
        
        echo json_encode($pecas);
?>
