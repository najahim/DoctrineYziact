#!/bin/sh
ifconfig $dev up
brctl addif br-wifi $dev
