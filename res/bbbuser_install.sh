#!/bin/bash
WEB=bbbuser
WWW=/var/www/$WEB
DST=~

pushd $DST
    # Clone needed repositorys
    git clone https://github.com/unattended-ch/bbbadmin $DST/bbbadmin
    git clone https://github.com/bigbluebutton/bigbluebutton-api-php $DST/bigbluebutton-api-php
    # Copy BBB-API to /var/www
    sudo rsync -avr ~/bigbluebutton-api-php/src/* $WWW/
    # Copy bbbadmin to /var/www
    sudo rsync --exclude="res/*" --exclude="sql/*" -avr ~/bbbadmin/* $WWW/
    # Rename bbb_user.php to index.php
    sudo mv -v $WWW/bbb_user.php $WWW/index.php
    # Remove admin modules from page
    sudo rm -f $WWW/bbb_create.php
    sudo rm -f $WWW/bbb_delrec.php
    sudo rm -f $WWW/bbb_index.php
    sudo rm -f $WWW/bbb_info.php
    sudo rm -f $WWW/bbb_join.php
    sudo rm -f $WWW/bbb_record.php
    sudo rm -f $WWW/bbb_stop.php
    # Create symbolic link in apache root folder
    sudo ln -s $WWW /var/www/html/$WEB
    # Change owner of your page
    sudo chown -R www-data.www-data $WWW
    # Install needed PHP modules for BBB-API
    sudo apt install php-curl php-mbstring php-xml -y
    # Restart apache
    sudo systemctl restart apache2
popd
