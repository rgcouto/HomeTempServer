<?php
		date_default_timezone_set('UTC');
		$year = date("Y");
		$month = date("m");
		$month = ($month < 10 ? $month[1] : $month);
		$day = date("d");
		$day = ($day < 10 ? $day[1] : $day);
		$day = $day - 1;
		$contents = file_get_contents('/home/pi/temps/temps/'.$year.'/'.$month.'/'.$day.'.temp');
		$contents = str_replace("-", "/", $contents);
		$contents = explode("\n",$contents);
		
		$i=0;
		foreach ($contents as $content) {
			
			if ($content ==null) break;
			
			$pecas = explode(' ', $content);
			//$data = explode('/', $pecas[0]);
	        //$pecas[0] = $data[2]."/".$data[1]."/".$data[0];
			$pecas[1] = explode('.', $pecas[1])[0];
			$final[$i++] = array(strtotime($pecas[0].' '.$pecas[1].' Europe/Lisbon')*1000, floatval($pecas[2]));
		}

        echo json_encode($final);
?>
