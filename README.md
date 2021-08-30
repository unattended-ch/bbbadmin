### NAME

       bbbadmin - BBB PHP API Frontend

### DESCRIPTION

       bbbadmin is a minimalistic BBB PHP API Frontend


### SYNOPSIS

       - Create webpage for administrators to manage BBB via the PHP API

### OPTIONS

       - Create meetings

       - List running meeting

       - Join meeting

       - Stop meeting

       - Show recordings

### FILES

       bbb_config.php                        Configuration file for application
       bbb_load.php                          Loading needed addons and additional scripts
       bbb_index.php                         Index page for application
       bbb_create.php                        Create meeting on server
       bbb_join.php                          Join meeting on server
       bbb_info.php                          Display meeting informations
       bbb_record.php                        Show recordings on server
       bbb_delrec.php                        Delete recordings on server
       bbb_stop.php                          Stop meeting on server

### INSTALLATION

    - Clone the BBB PHP API to /var/www with "git clone https://github.com/bigbluebutton/"

    - Rename the folder /var/www/bigbluebutton-api-php for your needs

    - Copy all bbb_*.php files to the new folder

    - You can use the arrays in bbb_config.php as standalone configuration,
      or you can use a mySql-Database for configuration

    - For standalone use configure bbb_config.php

    - For database use configure and import the dump from sql/bbbadmin.sql

### CONFIGURATION

- [bbb_config.php](bbb_config.php)

- [sql/bbbadmin.sql](sql/bbbadmin.sql)

