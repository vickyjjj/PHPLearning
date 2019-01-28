# Nano Pidev API

## Use
 ```http://nano-pidev.mit.edu/api/data/METHOD_NAME.php?PARAMETER=VALUE&PARAMETER=VALUE```

## Methods
### read_day
Returns data measurements from the whole day of a specific past date

**Parameters**
  * **measure**: humid, temp, accel
  * **date**: YYYY-MM-DD
  * **raw**: TRUE, FALSE (default FALSE)
  
**Returns**: a `2 x 1438` JSON array, MM DD YYYY hh:mm:ss in the first column, measurement in the second column


### read_days
Returns data measurements from the whole day of multiple past dates

**Parameters**
  * **measure**: humid, temp, accel
  * **start**: YYYY-MM-DD
  * **end**: YYYY-MM-DD, end > start (default yesterday)
  * **raw**: TRUE, FALSE (default FALSE)
  
**Returns**: a `2 x ?` JSON array, MM DD YYYY hh:mm:ss in the first column, measurement in the second column, with number rows equivalent to number minutes captured by indicated time frame


### read_day_time
Returns data measurements from the requested time period of a specific past date

**Parameters**
  * **measure**: humid, temp, accel
  * **date**: YYYY-MM-DD
  * **start**: hh:mm 24-hour clock (default 00:00)
  * **end**: hh:mm 24-hour clock (default 23:59)
  * **raw**: TRUE, FALSE (default FALSE)
  
**Returns**: a `2 x 1438` JSON array, MM DD YYYY hh:mm:ss in the first column, measurement in the second column



### read_days_time
Returns data measurements from the requested time period of a multiple past dates

**Parameters**
  * **measure**: humid, temp, accel
  * **sdate**: YYYY-MM-DD
  * **edate**: YYYY-MM-DD (default yesterday)
  * **start**: hh:mm 24-hour clock (default 00:00)
  * **end**: hh:mm 24-hour clock (default 23:59)
  * **raw**: TRUE, FALSE (default FALSE)
  
**Returns**: a `2 x ?` JSON array, MM DD YYYY hh:mm:ss in the first column, measurement in the second column, with number rows equivalent to number minutes captured by indicated time frame times number days captured by date frame
