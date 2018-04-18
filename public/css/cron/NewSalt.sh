#!/bin/bash
salt1=$(date +%s|sha256sum|base64|head -c 32);
salt2=$(tr -dc "[:alpha:]" < /dev/urandom | head -c 32);
mysql -uroot -proot -D szabadsagolas -e "insert into salts(salt1,salt2) values('$salt1','$salt2')";