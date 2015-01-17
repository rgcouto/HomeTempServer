$(function() {
	
    var options = {
         yaxis: {
			tickFormatter: tempFormatter,
			min: 0,
			max: 35,
		},
		xaxis: {
		    mode: "time",
			minTickSize: [1, "hour"],
			tickSize: [1, "hour"],
			timezone: "browser"
		}
    }
    
    var optionsMonth = {
         yaxis: {
			tickFormatter: tempFormatter,
			min: 0,
			max: 35,
		},
		xaxis: {
		    mode: "time",
			minTickSize: [1, "day"],
			tickSize: [1, "day"],
			timezone: "browser"
		}
    }
    
	function tempFormatter(v, axis) {
		return v.toFixed(axis.tickDecimals) + "ºC";
	}

	var updateInterval = 60000;

    function get30dData() {
   
        function onDataReceived(series) {
			data = [ series ];
            $.plot("#insidetemp30d", data, optionsMonth);
			document.getElementById("insidetemp30dTitle").innerHTML = monthTitle;
        }

        $.ajax({
            url: "reader/getmonthtemps.php",
            dataType: "json",
		    cache: false,
            success: onDataReceived
        });
                
    }
    
    function getYesterdayData() {
    	
        function onDataReceived(series) {
			data = [ series ];
            $.plot("#insidetempyesterday", data, options);
            document.getElementById("insidetempYesterdayTitle").innerHTML = yesterdayTitle;
        }

        $.ajax({
            url: "reader/getyesterdaytemps.php",
            dataType: "json",
		    cache: false,
            success: onDataReceived
        });
             
    }
    
    function get24hData() {
    	
        function onDataReceived(series) {
			data = [ series ];
            $.plot("#insidetemp24h", data, options);
			document.getElementById("insidetemp24hTitle").innerHTML = dayTitle;
        }

        $.ajax({
            url: "reader/getdaytemps.php",
            dataType: "json",
			cache: false,
            success: onDataReceived
        });
        
        
		setTimeout(get24hData, updateInterval);
        
    }
    
    function get60sData() {
    
		$.ajax({
		    url: "reader/gettemps.php",
		    cache: false,
		    dataType: "json",
		    success: function(response){
				var dateArray = response[0].split("/");
				var timeArray = response[1].substr(0,response[1].length-2).split(":");
				
				document.getElementById("time").innerHTML = '&nbsp;&nbsp;<b>Time</b>: '+response[0]+' '+response[1];
				document.getElementById("currenttemp").innerHTML = '&nbsp;&nbsp;<b>Inside temp.</b>: '+response[2]+ ' ºC';
				
				setTimeout(get60sData, updateInterval);
		    }
		});
	}
	
    function getAverage() {
		$.ajax({
		    url: "reader/getaverage.php",
		    cache: false,
		    dataType: "json",
		    success: function(response){
    			document.getElementById("yesterdayAverage").innerHTML = '&nbsp;&nbsp;<b>Yesterday average</b>: '+response[0]+ ' ºC';
				document.getElementById("monthAverage").innerHTML = '&nbsp;&nbsp;<b>Month average</b>: '+response[1]+ ' ºC';
		    }
		});
	}
	
    function getTrend() {
		$.ajax({
		    url: "reader/gettrend.php",
		    cache: false,
		    success: function(response){
		    	response = parseFloat(response).toFixed(3);
    			document.getElementById("currenttrend").innerHTML = '&nbsp;&nbsp;<b>Day trend</b>: '+(response > 0 ? 'Increasing' : (response == 0 ? 'Stabilized' : 'Decreasing'));
		    }
		});
	}

    function getCurrentTrend() {
		$.ajax({
		    url: "reader/gethourtrend.php",
		    cache: false,
		    success: function(response){
		    	response = parseFloat(response).toFixed(3);
    			document.getElementById("currenthourtrend").innerHTML = '&nbsp;&nbsp;<b>Current trend</b>: '+(response > 0 ? 'Increasing' : (response == 0 ? 'Stabilized' : 'Decreasing'));
		    }
		});
	}

    function getOutsideTemps() {
		$.ajax({
		    url:"http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22covilha%2C%20pt%22)%20and%20u%3D'c'&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys",
		    cache: false,
		    dataType: "json",
		    success: function(response){
				document.getElementById("currenttempoutside").innerHTML = '&nbsp;&nbsp;<b>Outside temp.</b>: '+response.query.results.channel.item.condition.temp+ ' ºC';
				document.getElementById("currenthumidityoutside").innerHTML = '&nbsp;&nbsp;<b>Outside humidity</b>: '+response.query.results.channel.atmosphere.humidity+ ' %';
		    }
		});
	}


	
	var monthTitle = document.getElementById("insidetemp30dTitle").innerHTML				
	var dayTitle = document.getElementById("insidetemp24hTitle").innerHTML				
	var yesterdayTitle = document.getElementById("insidetempYesterdayTitle").innerHTML
	
	document.getElementById("insidetemp30dTitle").innerHTML = monthTitle+' Loading...';				
	document.getElementById("insidetemp24hTitle").innerHTML = dayTitle+' Loading...';				
	document.getElementById("insidetempYesterdayTitle").innerHTML = yesterdayTitle+' Loading...';
	
	get60sData();	
    get24hData();
    getYesterdayData();
    get30dData();
	getAverage();
	getTrend();
	getCurrentTrend();
	getOutsideTemps();



});

