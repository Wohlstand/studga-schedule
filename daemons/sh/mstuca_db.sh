#!/bin/bash
export TERM=dumb
sudo -u mstuca /usr/bin/timeout 300 /Server/Server_Files/WebHosting/studga.ru/daemons/xls2db "$1"
