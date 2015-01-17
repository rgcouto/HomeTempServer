import datetime
import time
import os

prev_year = datetime.datetime.now().year 
prev_month = datetime.datetime.now().month
prev_day = datetime.datetime.now().day

while True:
 
	tfile = open("/sys/bus/w1/devices/28-0000058dcbf0/w1_slave")
	text = tfile.read()
	tfile.close()

	secondline = text.split("\n")[1]
	temperaturedata = secondline.split(" ")[9]
	temperature = float(temperaturedata[2:])
	temperature = temperature / 1000

	year = datetime.datetime.now().year
	month = datetime.datetime.now().month
	day = datetime.datetime.now().day

	folder =  '/home/pi/temps/temps/'+str(year)+'/'+str(month)
	file = folder+'/'+str(day)+'.temp'

	#Checks if folder exists
	if not os.path.exists(folder):
		os.makedirs(folder)

	#Write history file
	ofile = open (file, "a")
	text = "%s %.3f\n"  % (datetime.datetime.now(), temperature)
	ofile.write(text)
	ofile.close()

	#Write realtime file
	ofile = open('/home/pi/temps/realtime.temp', "w")
	ofile.write(text[:-1])
	ofile.close()
	
	if (prev_day != day):
	
		i=0
		factor = 10
		
		resampleFilename = '/home/pi/temps/temps/'+str(prev_year)+'/'+str(prev_month)+'/'+str(prev_day)+'_resampled.temp'
		dailyFilename = '/home/pi/temps/temps/'+str(prev_year)+'/'+str(prev_month)+'/'+str(prev_day)+'.temp'
		
		resampleFile = open (resampleFilename, "w")
				
		for line in open(dailyFilename):
			if (i%factor==0):
				text = "%s"  % (line)
				resampleFile.write(text)
			i+=1

		resampleFile.close()
		
		#Remove old file and rename the new one
		os.remove(dailyFilename)
		os.rename(resampleFilename, dailyFilename)
		
		prev_year = year
		prev_month = month
		prev_day = day

	time.sleep(60)
