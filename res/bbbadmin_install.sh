#!/bin/bash
WEB=bbbadmin
WWW=/opt/$WEB
APACHE=/var/www/html
DST=~

pushd $DST
    # Clone needed repositorys
    git clone https://github.com/unattended-ch/bbbadmin $DST/bbbadmin
    git clone https://github.com/bigbluebutton/bigbluebutton-api-php $DST/bigbluebutton-api-php
    # Copy BBB-API to /var/www
    sudo rsync -avr $DST/bigbluebutton-api-php/src/* $WWW/
    # Copy bbbadmin to /var/www
    sudo rsync --exclude="res/*" --exclude="sql/*"  --exclude="releases/*"-avr $DST/bbbadmin/* $WWW/
    if [ ! -d "$WWW/res" }; then
        sudo mkdir -p $WWW/res
    fi
    cp $DST/bbbadmin/res/*.json $WWW/res/
    cp $DST/bbbadmin/res/*.tmpl $WWW/res/
    # Create symbolic link in apache root folder
    if [ -f "$APACHE/$WEB" }; then
        sudo rm -f $APACHE/$WEB
    fi
    sudo ln -s $WWW $APACHE/$WEB
    # Change owner of your page
    sudo chown -R www-data.www-data $WWW
    # Install needed PHP modules for BBB-API
    sudo apt install php-curl php-mbstring php-xml -y
    # Restart apache
    sudo systemctl restart apache2
popd
