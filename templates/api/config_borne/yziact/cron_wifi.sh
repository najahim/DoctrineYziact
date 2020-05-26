#!/bin/bash

#===============#
# Check ntpdate #
#===============#


if [ ! -f "/usr/sbin/ntpdate" ]
then
    echo 'nameserver 8.8.8.8' > /etc/resolv.conf

    uci set    system.@system[0].zonename="Europe/Paris"
    uci set    system.@system[0].timezone="CET-1CEST,M3.5.0,M10.5.0/3"
    uci commit system;

    opkg update
    opkg install ntpdate bash
fi
