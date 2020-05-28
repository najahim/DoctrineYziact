#!/bin/sh

LED_BLUE="/sys/devices/platform/leds-gpio/leds/ubnt:blue:dome"
LED_ROSE="/sys/devices/platform/leds-gpio/leds/ubnt:white:dome"

echo 0 > $LED_ROSE/brightness
echo 0 > $LED_BLUE/brightness

echo 'timer' > $LED_BLUE/trigger
echo 100 > $LED_BLUE/delay_on
echo 100 > $LED_BLUE/delay_off

COMPTEUR=$(cat /etc/yziact/test_co_flag)

ping -I tap0 -c 5 172.18.0.1
if [ $? == 0 ]
then
	echo 'default-on' > $LED_BLUE/trigger
	echo 0 > $LED_ROSE/brightness
	/sbin/wifi up
	sleep 2
	/usr/sbin/brctl addif br-wifi wlan0
	echo 0 > /etc/yziact/test_co_flag
	exit 1
else
	echo 'default-on' > $LED_ROSE/trigger
	echo  0 > $LED_BLUE/brightness
	/sbin/wifi down
	let "COMPTEUR=$COMPTEUR+1"
	echo $COMPTEUR > /etc/yziact/test_co_flag
	if [ $COMPTEUR -eq 5 ]
	then
		reboot
	fi
fi
