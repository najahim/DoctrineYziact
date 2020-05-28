#!/bin/sh
/sbin/wifi up
sleep 2
/usr/sbin/brctl addif br-wifi wlan0