<?php
	$config = parse_ini_file("config.ini", true);	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $config['web_platform']['site']; ?> - Monitor</title>
	<link href="lib/css/examples.css" rel="stylesheet" type="text/css">
	<script language="javascript" type="text/javascript" src="lib/js/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="lib/js/jquery.flot.js"></script>
	<script language="javascript" type="text/javascript" src="lib/js/jquery.flot.time.js"></script>
	<script language="javascript" type="text/javascript" src="lib/js/getHomeData.js"></script>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>

	<div id="content-left">
		<div id="content-left-top">
			<h2><?php echo $config['web_platform']['site']; ?> </h2>
			<h4>Current conditions</h4>
			<div id="currenttemp" style="font-size: 12pt;">&nbsp;&nbsp;<b>Inside temp.:</b> ºC</div>
			<div id="currenthumidity" style="font-size: 12pt;">&nbsp;&nbsp;<b>Inside humidity:</b> - %</div>
			<div id="currenthourtrend" style="font-size: 12pt;">&nbsp;&nbsp;<b>Current trend:</b> - </div>
			<hr>
			<div id="currenttempoutside" style="font-size: 12pt;">&nbsp;&nbsp;<b>Outside temp.:</b> ºC</div>
			<div id="currenthumidityoutside" style="font-size: 12pt;">&nbsp;&nbsp;<b>Outside humidity:</b> %</div>
			<h4>Last reading</h4>
			<div id="time" style="font-size: 12pt;"></div>
			<h4>Statistical Data</h4>
			<div id="currenttrend" style="font-size: 12pt;">&nbsp;&nbsp;<b>Day trend:</b> - </div>
			<div id="yesterdayAverage" style="font-size: 12pt">&nbsp;&nbsp;Yesterday average:</div>
			<div id="monthAverage" style="font-size: 12pt">&nbsp;&nbsp;Month average:</div>
		</div>
		<div id="content-left-bottom">
			<a href="https://www.facebook.com/rafael.goncalves.couto" target="_blank"><i class="fa fa-facebook-square" style="font-size:30px"></i></a>&nbsp;
			<a href="https://www.linkedin.com/in/rafaelgcouto" target="_blank"><i class="fa fa-linkedin" style="font-size:30px"></i></a>&nbsp;
			<a href="https://www.xing.com/profile/Rafael_Couto" target="_blank"><i class="fa fa-xing-square" style="font-size:30px"></i></a>&nbsp;
			<a href="https://github.com/rgcouto" target="_blank"><i class="fa fa-github" style="font-size:30px"></i></a>&nbsp;
			<a href="http://www.rgcouto.net" target="_blank"><i class="fa fa-home" style="font-size:30px"></i></a>
		</div>
	</div>
	<div id="content">
		<h4 id="insidetemp24hTitle">Daily temperatures (precision 60 sec.)</h4>
		<div class="demo-container">
			<div id="insidetemp24h" class="demo-placeholder">
			</div>
		</div>
		<h4 id="insidetempYesterdayTitle" style="display:none">Yesterday temperatures (precision 10 min.)</h4>
		<div class="demo-container" style="display:none">
			<div id="insidetempyesterday" class="demo-placeholder">
			</div>
		</div>
		<h4 id="insidetemp30dTitle">Current month temperatures (precision 10 min.)</h4>
		<div class="demo-container">
			<div id="insidetemp30d" class="demo-placeholder">
			</div>
		</div>
	</div>
</body>
</html>

<?php
	$ip = $_SERVER['REMOTE_ADDR'];
	$details = file_get_contents("http://ipinfo.io/{$ip}/json");

	$file = fopen("visits.log", "a");
		fwrite($file, '{"timestamp":"'.date("d/m/Y H:i:s").'", "data":'.$details.'},');
	fclose($file);

?>
