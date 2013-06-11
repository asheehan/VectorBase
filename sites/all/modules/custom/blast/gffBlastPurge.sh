#!/bin/bash

# Please be sure to '>>' the output of this script to /vectorbase/web/logs/xgridCron.log

days="+"
if [ $# -eq 0 ]
then
	days+=7
else
	days+=$1
fi

echo "Removing `find /vectorbase/web/root/data/* -maxdepth 1 -type f -mtime $days | wc -l` files older than $days days on `date`"
echo `find /vectorbase/web/root/data/* -maxdepth 1 -type f -mtime $days -exec rm {} \;`

