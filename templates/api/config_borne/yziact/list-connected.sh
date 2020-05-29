#!/bin/bash

# Enregistre dans le fichier en entrée ($1) les appareils connectés à une fréquence ($2)

PID=$$
PID_FILE="/var/run/list-connected.pid"

# On verifie si le process juste avant s'est termine
if [ -f $PID_FILE ]
then
	# Le fichier existe, un autre process tourne deja, on recupere son PID
	PID_OLD=$(cat $PID_FILE)
	# Et on le kille
	kill -9 "$PID_OLD" 2&>1 > /dev/null
fi

# On logue les péripheriques connectes
while true
do
    CMD="/usr/sbin/iw dev wlan0 station dump"
    RES=`$CMD`
    # Remise en forme pour avoir une ligne par station :
	RES=`echo $RES | sed 's/ Station/\nStation/g'`
	echo "$RES" > /tmp/temp-connected.txt
    NB_STATIONS=0
    NB_ALL_STATIONS=`cat /tmp/temp-connected.txt | wc -l`

    # On crée un fichier temporaire vide qui contiendra les data
    touch /tmp/connected.txt
    > /tmp/connected.txt

    # On parcours pour chaque station
    while [ $NB_STATIONS -lt $NB_ALL_STATIONS ]
    do
        NB_STATIONS=`expr $NB_STATIONS + 1`
        CMD_STR="sed -n '"$NB_STATIONS"p' /tmp/monwifi.log"
        INFO_STATION=`eval $CMD_STR`
        MAC_ADDR=`echo $INFO_STATION | cut -d' ' -f2`
        RXB=`echo $INFO_STATION | cut -d' ' -f11`
        TXB=`echo $INFO_STATION | cut -d' ' -f17`
        if [ "$MAC_ADDR" != "" ]
        then
            echo $MAC_ADDR" "$RXB" "$TXB >> /tmp/connected.txt
        fi
    done

    # On actualise le fichier des connectes
    mv /tmp/connected.txt $1

    sleep $2
done

# On supprime notre fichier pid
rm $PID_FILE
