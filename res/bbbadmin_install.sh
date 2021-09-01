#!/bin/bash
WEB=bbbadmin
WWW=/var/www/$WEB
DST=~

pushd $DST
    # Clone needed repositorys
    git clone https://github.com/unattended-ch/bbbadmin
    git clone https://github.com/bigbluebutton/bigbluebutton-api-php
    # Copy BBB-API to /var/www
    sudo rsync -avr ~/bigbluebutton-api-php/src/* $WWW/
    # Copy bbbadmin to /var/www
    sudo rsync --exclude="res/*" --exclude="sql/*" -avr ~/bbbadmin/* $WWW/
    # Create symbolic link in apache root folder
    sudo ln -s $WWW /var/www/html/$WEB
    # Change owner of your page
    sudo chown -R www-data.www-data $WWW
    # Install needed PHP modules for BBB-API
    sudo apt install php-curl php-mbstring php-xml -y
    # Restart apache
    sudo systemctl restart apache2
popd
