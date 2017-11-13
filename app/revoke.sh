#!/bin/bash
cd /home/smile/mvc/app
mv controller/install_old.php controller/install.php
> database.php
cd ..
mysql -u root -p -D szabadsagolas -e "drop database szabadsagolas"