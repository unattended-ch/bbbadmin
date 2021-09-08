#!/bin/bash
WEB=bbbadmin
WWW=/opt/$WEB
APACHE=/var/www/html
DST=~

pushd $DST
    # Clone needed repositorys
    git clone https://github.com/bigbluebutton/bigbluebutton-api-php $DST/bigbluebutton-api-php
    # Copy BBB-API to /var/www
    sudo rsync -avr $DST/bigbluebutton-api-php/src/* $WWW/
    # Copy bbbadmin to /var/www
    sudo rsync --exclude="res" --exclude="sql"  --exclude="releases" --exclude="build" -avr $DST/bbbadmin/* $WWW/
    if [ ! -d "$WWW/res" ]; then
        sudo mkdir -p $WWW/res
    fi
    sudo cp $DST/bbbadmin/res/*.json $WWW/res/
    sudo cp $DST/bbbadmin/res/*.tmpl $WWW/res/
    sudo rm -f $WWW/*.md
    sudo rm -f $WWW/CNAME
    sudo rm -f $WWW/CHANGELOG
    sudo rm -f $WWW/LICENSE
    sudo rm -f $WWW/icons/*.png
    # Create symbolic link in apache root folder
    if [ -f "$APACHE/$WEB" ]; then
        sudo rm -f $APACHE/$WEB
    fi
    sudo ln -s $WWW $APACHE
    # Change owner of your page
    sudo chown -R www-data.www-data $WWW
    # Install needed PHP modules for BBB-API
    sudo apt install php-curl php-mbstring php-xml -y
    # Restart apache
    sudo systemctl restart apache2
popd
