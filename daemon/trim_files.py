#!/usr/bin/python

import sys
import os

fileLocation = '/home/pi/temps/temps/2014/11/'
file = str(sys.argv[1])

resampleFilename = fileLocation+file+'_resampled.temp'
dailyFilename = fileLocation+file+'.temp'

resampleFile = open (resampleFilename, "w")

i = 0
factor = 10
	
for line in open(dailyFilename):
	if (i%factor==0):
		text = "%s"  % (line)
		resampleFile.write(text)
	i+=1

resampleFile.close()

#Remove old file and rename the new one
os.remove(dailyFilename)
os.rename(resampleFilename, dailyFilename)