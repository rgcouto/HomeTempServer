<?php
		date_default_timezone_set('UTC');
		$year = date("Y");
		$month = date("m");
		$month = ($month < 10 ? $month[1]: $month);
		$day = date("d");
		$day = ($day < 10 ? $day[1] : $day);
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
		
		
		$n = count($final);
		
		//Calculate a
			$i = 1;
			$sum = 0;
			foreach($final as $elem) {
				$sum += $i++ * $elem[1];
			}
			$a = $n * $sum;
			
		//Calculate b
			$i=1;
			$x = $y = 0;
			foreach($final as $elem) {
				$sumx += $i++;
				$sumy += $elem[1];
			}
			$b = $sumx * $sumy;
			
		//Calculate c
			$i = 1;
			$sum = 0;
			foreach($final as $elem) {
				$sum += pow($i++, 2);			}
			$c =  $n * $sum;
		
		//Calculate d
			$i = 1;
			$sum = 0;
			foreach($final as $elem) {
				$sum += $i++;
			}
			$d = pow($sum,2);
			
		//Calculate slope
			$slope = ($a-$b)/($c-$d);
			
		echo $slope;

?>
