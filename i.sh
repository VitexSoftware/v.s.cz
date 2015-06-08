#!/bin/bash

wget -O - http://v.s.cz/info@vitexsoftware.cz.gpg.key| apt-key add -
echo deb http://v.s.cz/ stable main > /etc/apt/sources.list.d/ease.list
wget -O - http://debmon.org/debmon/repo.key 2>/dev/null | apt-key add -
echo deb http://debmon.org/debmon debmon-jessie main > /etc/apt/sources.list.d/debmon.list
aptitude update
aptitude upgrade
aptitude install icinga-web icinga-editor pnp4icinga-web nsca icinga-web-config-icinga

IECFG="/usr/share/icinga-editor/includes/Configure.php"
IWCFG="/etc/dbconfig-common/icinga-web.conf"
IW_SERVER_USERNAME=`cat $IWCFG | grep dbc_dbuser= | awk -F\' '{print $2}'`
IW_SERVER_PASSWORD=`cat $IWCFG | grep dbc_dbpass= | awk -F\' '{print $2}'`
IW_DATABASE=`cat $IWCFG | grep dbc_dbname= | awk -F\' '{print $2}'`

echo "define('DB_IW_SERVER_USERNAME', '$IW_SERVER_USERNAME');" >> $IECFG 
echo "define('DB_IW_SERVER_PASSWORD', '$IW_SERVER_PASSWORD');" >> $IECFG 
echo "define('DB_IW_DATABASE', '$IW_DATABASE');" >> $IECFG 
