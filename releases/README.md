# Binary releases of bbbadmin for admin and users

## NOTE

   - This packages will be recompiled after finishing work

### DESCRIPTION

   - This packages are installing to /opt/[bbbadmin|bbbusers]
   - Default folder for admin package is bbbadmin
   - Default folder for users package is bbbusers
   - Symbolic links to /var/www/html/[bbbadmin|bbbusers] are create for apache
   - BBB PHP API is included
   - You have to configure /opt/[bbbadmin|bbbusers]bbb_admin.json manually
   - During an update bbb_admin.json will be saved and restored
   - bbb_index.php and bbb_users.php are renamed to index.php in the package

### TODO

   - Since we use JSON for configuration it would be nice to have a LAN download location for this JSON files
   - With LAN download location it is possible to download a host specific JSON during installation
