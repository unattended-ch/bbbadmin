# Binary releases of bbbadmin for admin and users

## NOTE

   - This packages are including not always the latest branch
   - There will be recompiled once a day after finishing work

### DESCRIPTION

   - This packages are installing to /var/www/[bbbadmin|bbbusers]
   - Default folder for admin package is bbbadmin
   - Default folder for users package is bbbusers
   - Symbolic links to /var/www/html/[bbbadmin|bbbusers] are create for apache
   - BBB PHP API is included
   - You have to configure /var/www/[bbbadmin|bbbusers]bbb_config.php manually
   - During an update bbb_config.php will be saved and restored
   - bbb_index.php and bbb_users.php are renamed to inedx.php in the package

### TODO

   - Add parameters for packages to setup and configure
