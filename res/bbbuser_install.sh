#!/bin/bash
WEB=bbbuser
WWW=/opt/$WEB
DST=~

pushd $DST
    # Clone needed repositorys
    git clone https://github.com/bigbluebutton/bigbluebutton-api-php $DST/bigbluebutton-api-php
    # Copy BBB-API to /var/www
    sudo rsync -avr $DST/bigbluebutton-api-php/src/* $WWW/
    # Copy bbbadmin to /var/www
    sudo rsync --exclude="res" --exclude="sql" --exclude="releases" --exclude="build" -avr $DST/bbbadmin/* $WWW/
    if [ ! -d "$WWW/res" ]; then
        sudo mkdir -p $WWW/res
    fi
    sudo cp $DST/bbbadmin/res/*.json $WWW/res/
    # Rename bbb_user.php to index.php
    sudo mv -v $WWW/bbb_user.php $WWW/index.php
    # Remove admin modules from page
    sudo rm -f $WWW/bbb_create.php
    sudo rm -f $WWW/bbb_delrec.php
    sudo rm -f $WWW/bbb_index.php
    sudo rm -f $WWW/bbb_invite.php
    sudo rm -f $WWW/bbb_info.php
    sudo rm -f $WWW/bbb_join.php
    sudo rm -f $WWW/bbb_record.php
    sudo rm -f $WWW/bbb_send.php
    sudo rm -f $WWW/bbb_stop.php
    sudo rm -f $WWW/*.md
    sudo rm -f $WWW/CNAME
    sudo rm -f $WWW/CHANGELOG
    sudo rm -f $WWW/LICENSE
    sudo rm -f $WWW/icons/*.png
    # Create symbolic link in apache root folder
    if [ -f "$APACHE/$WEB" ]; then
        sudo rm -f $APACHE
    fi
    sudo ln -s $WWW $APACHE
    # Change owner of your page
    sudo chown -R www-data.www-data $WWW
    # Install needed PHP modules for BBB-API
    sudo apt install php-curl php-mbstring php-xml -y
    # Restart apache
    sudo systemctl restart apache2
popd
