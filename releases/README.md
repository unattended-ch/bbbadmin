# Binary releases of bbbadmin for admin and users

## NOTE

   - This packages including not always the latest branch
   - There will be recompiled once a day

### DESCRIPTION

   - This packages are installing to /var/www/[bbbadmin|bbbusers]
   - Default folder for admin package is bbbadmin
   - Default folder for users package is bbbusers
   - Symbolic links to /var/www/html/[bbbadmin|bbbusers] are create for apache
   - BBB PHP API is included
   - You have to configure /var/www/[bbbadmin|bbbusers]bbb_config.php manually
   - During an update bbb_config.php will be saved and restored
   - bbb_index.php and bbb_users.php are renamed to inedx.php in the package

### FILES

   Filename|Descriprion
   --------|-----------
   bbbadmin_0.0.0.3-generic.deb|BBB Admin Frontend Debian package
   bbbusers_0.0.0.3-generic.deb|BBB Users Frontend Debian package

### CHECKSUMS

   Filename|Descriprion
   --------|-----------
   bbbadmin_0.0.0.3-generic.deb.md5|BBB Admin Frontend MD5 checksum
   bbbadmin_0.0.0.3-generic.deb.sha1|BBB Admin Frontend SHA1 checksum
   bbbadmin_0.0.0.3-generic.deb.sha256|BBB Admin Frontend SHA256 checksum
   bbbusers_0.0.0.3-generic.deb.md5|BBB Users Frontend MD5 checksum
   bbbusers_0.0.0.3-generic.deb.sha1|BBB Users Frontend SHA1 checksum
   bbbusers_0.0.0.3-generic.deb.sha256|BBB Users Frontend SHA256 checksum

### TODO

   - Add parameters for packages to setup and configure
