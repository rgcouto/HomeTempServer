<?php

		$year = date("Y");
		$month = date("m");
		$month = ($month < 10 ? $month[1]: $month);
		$day = date("d");
		$day = ($day < 10 ? $day[1] : $day);

		
		//Yesterday Average
		$final[0] = 0;
		$contents = file_get_contents('/home/pi/temps/temps/'.$year.'/'.$month.'/'.($day-1).'.temp');
		$contents = explode("\n",$contents);
		
		$i=0;
		foreach ($contents as $content) {
			if ($content ==null) break;
			$pecas = explode(' ', $content);
			$final[0] = $final[0]+floatval($pecas[2]);
			++$i;
		}
		
		$final[0] = round($final[0]/$i, 2);
		
		//Month Average
		$final[1] = 0;
		$i=0;
		for ($d=1; $d<=$day; $d++) {
				
			if (!file_exists('/home/pi/temps/temps/'.$year.'/'.$month.'/'.$d.'.temp')) {
				continue;
			}
			
			$contents = file_get_contents('/home/pi/temps/temps/'.$year.'/'.$month.'/'.$d.'.temp');
			$contents = explode("\n",$contents);
		
			foreach ($contents as $content) {
				if ($content ==null) break;
				$pecas = explode(' ', $content);
				$final[1] = $final[1] + floatval($pecas[2]);
				++$i;
			}
		}
		
		$final[1] = round($final[1]/$i, 2);
		
		

        echo json_encode($final);
?>
