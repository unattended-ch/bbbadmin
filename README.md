<div align="center">

# BigBlueButton Admin- & User-Frontend

[![PHP 7.1](https://img.shields.io/badge/php-7.1-f33.svg?style=flat-square)](https://php.net/)
[![PHP 7.2](https://img.shields.io/badge/php-7.2-f33.svg?style=flat-square)](https://php.net/)
[![PHP 7.3](https://img.shields.io/badge/php-7.3-f93.svg?style=flat-square)](https://php.net/)
[![PHP 7.4](https://img.shields.io/badge/php-7.4-9c9.svg?style=flat-square)](https://php.net/)
[![PHP 7.4](https://img.shields.io/badge/php-8.0-9c9.svg?style=flat-square)](https://php.net/)
#### [[BigBlueButton Homepage][bbb]] [[BigBlueButton PHP API][bbbapi]]
#### [[Discussion][discussion]] [[Issues][issues]] [[Changelog][changelog]]

</div>

<a name="toc"></a>

<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary><h2 style="display: inline-block">TABLE OF CONTENTS</h2></summary>
  <ol>
    <li><a href="#">About bbbadmin</a>
      <ul>
        <li><a href="#php">Built with PHP</a></li>
      </ul>
    </li>
    <li><a href="#description">Description</a></li>
    <li><a href="#synopsis">Synopsis</a><ul>
        <li><a href="#options">Options</a></li>
        <li><a href="#php-files">PHP files</a></li>
        <li><a href="#configuration-files">Configuration files</a></li>
        <li><a href="#configuration">Configuration</a></li>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#releases">Releases</a></li>
        <li><a href="#debian-packages">Create debian packages</a></li>
        <li><a href="#installation-scripts">Installation Scripts</a></li>
        <li><a href="#installation-admin-frontend">Installation Admin Frontend</a></li>
        <li><a href="#htpasswd">Admin access security with .htpasswd</a></li>
        <li><a href="#popups">Allow popup windows for bbbadmin</a></li>
        <li><a href="#installation-user-frontend">Installation User Frontend</a></li>
        <li><a href="#htpasswd">User access security with .htpasswd</a></li>
        <li><a href="#workaround">Workaround for hostings without apache_setenv()</a></li>
        <li><a href="#curl-timeout">Workaround curl timeout url not reached</a></li>
        <li><a href="#language-support">Language support</a></li>
        <li><a href="#styling">Styling with bootstrap.css</a></li>
      </ul></li>
    <li><a href="#userurl">User URL for joining meeting</a></li>
    <li><a href="#styling">Change page style</a></li>
    <li><a href="#screenshots">Screenshots</a><ul>
        <li><a href="#bbb_index.png">index.php</a></li>
        <li><a href="#bbb_creat>bbb_create.php></li>
        <li><a href="#bbb_join.png">bbb_join.php</a></li>
        <li><a href="#bbb_info.png">bbb_info.php</a></li>
        <li><a href="#bbb_record.png">bbb_record.php</a></li>
        <li><a href="#bbb_send.png">bbb_send.php</a></li>
        <li><a href="#bbb_invite.png">bbb_invite.php</a></li>
        <li><a href="#bbb_user.png">bbb_user.php</a></li>
    </ul></li>
    <li><a href="#todo">Todo</a></li>
  </ol>
</details>


## NAME

#### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;bbbadmin - BigBlueButton Admin- & User-Frontend

## DESCRIPTION

#### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;bbbadmin is a minimalistic BBB PHP API Frontend

## SYNOPSIS

   * 	Create webpage for administrators to manage BigBlueButton servers via the BBB PHP API
   * 	Create webpage for users only to join BigBlueButton server
   * 	Manage all running meetings on the server
   * 	Manage all recordings on the server
   * 	Provide central user join page for meetings
   * 	Send invitation email to users
   * 	Use JSON as configuration file
   * 	Create your own debian packages
   * 	Create your own language files
   * 	Detect client browser language or set default to "en"
   * 	Final release, now it's on you to make [issues] or participate on [discussion] 

   [goto TOC](#toc)

## OPTIONS

   * List running meeting
   * List recordings
   * Create meetings
   * Join meeting
   * Stop meeting
   * Show meeting information
   * Show recordings
   * Delete recordings

   [goto TOC](#toc)

## PHP FILES

   Filename|Description
   --------|-----------
   [bbb_admin.json]|Configuration file for application
   [index.php]|Index page for application
   [bbb_config.php]|Load configuration
   [bbb_load.php]|Loading needed addons and additional scripts
   [bbb_create.php]|Create meeting on server
   [bbb_join.php]|Join meeting on server
   [bbb_info.php]|Display meeting informations
   [bbb_record.php]|Show recordings on server
   [bbb_delrec.php]|Delete recordings on server
   [bbb_send.php]|Send invitation mail to user
   [bbb_stop.php]|Stop meeting on server
   [bbb_user.php]|Join user to meeting

   [goto TOC](#toc)

## CONFIGURATION FILES

- Configuration file [bbb_admin.json]

- Email template file [bbb_admin.tmpl]

- Folder protection file [.htaccess]

- Access password file [.htpasswd]

   [goto TOC](#toc)

## CONFIGURATION

- Edit file [bbb_admin.json]
<pre><code>
{
    "debug": "1",
    "refresh": "30",
    "language": "en",
    "email": "bbbadmin@domain.com",
    "invite": "https://room.domain.com",
    "copyright": "© 2021 unattended.ch",
    "server": {
        "1": "room1.domain.com",
        "2": "room2.domain.com"
    },
    "logout": {
        "1": "https://room1.domain.com",
        "2": "https://room2.domain.com"
    },
    "logos":  {
        "1": "https://room1.domain.com/favicon.ico",
        "2": "https://room2.domain.com/favicon.ico"
    },
    "access": {
        "1": "ModeratorPasswordDefault" ,
        "2": "AttendeePasswordDefault" 
    },
    "rooms":  { 
        "1": { "name": "Bastelraum © 2021 unattended.ch", "id": "Bastelraum" ,  "acc": "Password", "msg": "Monday 20:00 - 22:00" },
        "2": { "name": "Startraum © 2021 unattended.ch", "id": "Startraum" ,  "acc": "Password", "msg": "" }
    }
}
</code></pre>
   Parameter|Description
   ---------|-----------
   debug|0=Off 1=On
   refresh|Screen refresh in secords for main and recording page
   language|en=English, de=German, fr=French other languages are wanted
   email|Admin email for sending invitation links
   invite|URL to users join page for invitations
   copyright|Copyright


     "server":
   Parameter|Description
   ---------|-----------
   unique id|Unique number for server
   name|Name of server (only descriptive)


     "logout":
   Parameter|Description
   ---------|-----------
   unique id|Unique number for logout URL
   name|Logout URL for meeting (default invitation url &exit=1)


     "logos":
   Parameter|Description
   ---------|-----------
   unique id|Unique number for Logo
   name|Logo URL for meetings


     "access":
   Parameter|Description
   ---------|-----------
   1|Moderator password default
   2|Attendee password default if no room password was specified


     "rooms":
   Parameter|Description
   ---------|-----------
   unique id|Unique number for room
   name|Room name fully descriptive for BigBlueButton
   id|Room ID for BigBlueButton
   acc|Room password for BigBlueButton


   [goto TOC](#toc)

## LANGUAGE SUPPORT

- Change ["language": "en",] in [bbb_admin.json] to your language shortcode
  
  en=English de=German fr=French

- See [res/locale/][bbb_lang] for .PO translation files
  and translation scripts

- See [locale/][bbb_locale] for translated .PHP files

   [goto TOC](#toc)

## STYLING

- Use bootstrap.css for styling of bbb_user.php

   [goto TOC](#toc)

## RELEASES

- See [releases] for more informations

   [goto TOC](#toc)

## DEBIAN PACKAGES

- Create your own bbbadmin.deb and bbb_users.deb for delivery

- Use [bbb_build.sh] for package creation

   [goto TOC](#toc)

## INSTALLATION SCRIPTS

- Admin Frontend installation script [bbbadmin_install.sh]

- User Frontend installation script [bbbuser_install.sh]

- Or you can use our debian packages in [releases]

   [goto TOC](#toc)

## PREREQUISITES

1. Install PHP modules php-curl php-mbstring php-xml
   ```sh
     sudo apt install php-curl php-mbstring php-xml php-intl -y
   ```

   [goto TOC](#toc)

## INSTALLATION ADMIN FRONTEND

1. Clone bbbadmin to your home folder
   ```sh
     git clone https://github.com/unattended-ch/bbbadmin ~/bbbadmin
   ```
2. Clone the BBB PHP API to your home folder
   ```sh
     git clone https://github.com/bigbluebutton/bigbluebutton-api-php ~/bigbluebutton-api-php
   ```
3. Copy BBB contents of folder src/ to /opt/yourpage
   ```sh
     sudo rsync -avr ~/bigbluebutton-api-php/src/* /opt/yourpage/
   ```
4. Copy bbbadmin *.php, *.css and icons/*.ico files to /opt/yourpage
   ```sh
     sudo rsync --exclude="res/*" -avr ~/bbbadmin/* /opt/yourpage/
   ```
5. Create a symbolic link to the apache root folder
   ```sh
     sudo ln -s /opt/yourpage /var/www/html/
   ```
6. Set owner of yourpage to www-data
   ```sh
     sudo chown -R www-data.www-data /opt/yourpage
   ```
7. For configuration you can use [bbb_admin.json]
   - You must specify BBB_* Apache environment variables for every server in apache configuration
     ```
       SetEnv BBB_SECRET1 XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
       SetEnv BBB_SERVER1_BASE_URL https://server1.domain.com/bigbluebutton/
       SetEnv BBB_SECRET2 XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
       SetEnv BBB_SERVER2_BASE_URL https://server2.domain.com/bigbluebutton/
     ```
8. Enable access security over .htpasswd file as a basic protection
   <a name="htpasswd"></a>
   8.1 Add th following to the default apache configuration
   ```
     <Directory "/var/www/html/yourpage">
       AllowOverride All
       Options SymLinksIfOwnerMatch IncludesNoExec
       Order allow,deny
       Allow from all
     </Directory>
   ```
   8.2 Copy .htacces file to your webpage
   ```sh
     sudo cp -v ~/bbbadmin/res/.htaccess /opt/youpage/
   ```
   8.3 Edit the path of password file in [.htaccess], always use document root of apache
   ```sh
     sudo mcedit /opt/yourpage/.htaccess
     
     AuthUserFile "/var/www/html/yourpage/.htpasswd"
   ```
   8.4 Add user to .htpasswd
   ```sh
     sudo htpasswd -c /opt/youpage/.htpasswd [username]
   ```
   8.5 Restart apache server
   ```sh
     sudo systemctl restart apache2
   ```
9. Firefox allow bbbadmin for popup windows to join meeting in new window
   <a name="popups"></a>
   - Enable popup windows for bbbadmin (see [popupblocker])

   [goto TOC](#toc)

## INSTALLATION USER FRONTEND

1. Clone bbbadmin to your home folder
   ```sh
     git clone https://github.com/unattended-ch/bbbadmin ~/bbbadmin
   ```
2. Clone the BBB PHP API to your home folder
   ```sh
     git clone https://github.com/bigbluebutton/bigbluebutton-api-php ~/bigbluebutton-api-php
   ```
3. Copy BBB contents of folder src/ to /opt/youruserpage
   ```sh
     sudo rsync -avr ~/bigbluebutton-api-php/src/* /opt/youruserpage/
   ```
4. Copy bbbadmin *.php, *.css and icons/*.ico files to /opt/youruserpage
   ```sh
     sudo rsync --exclude="res/*" -avr ~/bbbadmin/* /opt/youruserpage/
     sudo mv -v /opt/youruserpage/bbb_user.php /opt/youruserpage/index.php
   ```
5. Remove not needed files
   ```sh
     sudo rm -f /opt/youruserpage/index.php
     sudo rm -f /opt/youruserpage/bbb_create.php
     sudo rm -f /opt/youruserpage/bbb_delrec.php
     sudo rm -f /opt/youruserpage/bbb_info.php
     sudo rm -f /opt/youruserpage/bbb_join.php
     sudo rm -f /opt/youruserpage/bbb_record.php
     sudo rm -f /opt/youruserpage/bbb_stop.php
   ```
6. Create a symbolic link to the apache root folder
   ```sh
     sudo ln -s /opt/yourpage /var/www/html/
   ```
7. Set owner of your user page to www-data
   ```sh
     sudo chown -R www-data.www-data /opt/youruserpage
   ```
8. For configuration you must edit [bbb_admin.json]
   - Remove all sub sections except "server": from bbb_admin.json
   - And you MUST specify BBB_* Apache environment variables for every server
   ```
     SetEnv BBB_SECRET1 XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
     SetEnv BBB_SERVER1_BASE_URL https://server1.domain.com/bigbluebutton/
     SetEnv BBB_SECRET2 XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
     SetEnv BBB_SERVER2_BASE_URL https://server2.domain.com/bigbluebutton/
   ```
<a name="workaround"></a>
9. Servers with no apache_setenv() and apache_getenv() support edit [bbb_admin.json]

    - Edit section "bbb":

10. User can now join the meeting with the following parameters (sid and mID is needed the rest is optional) :
<a name="userurl"></a>
     ```
       https://server.domain.com/bbbuser/?sid=X&mID=XXXXXXXXXXXXXXXXXX[&usr=Username][&join=1]
     ```
     ```
       https://server.domain.com?sid=X&mID=XXXXXXXXXXXXXXXXXX[&usr=Username][&join=1]
     ```
   - If the meeting is running the mask for username will be displayed
   - If not, nothing will be diplayed

   [goto TOC](#toc)

## CURL TIMEOUT
     If you get a lot curl errrors, change the following lines in [BigBlueButton.php]
   ```
            $data = curl_exec($ch);
   ```
     Replace with
   ```
            $retry = 3;
            $attempts = 0;
            do {
                try
                    {
                        $data = curl_exec($ch);
                    }
                catch (Exception $e)
                    {
                        $attempts++;
                        continue;
                    }
                }
            while(($data === false) && ($attempts < $retry));
   ```

   [goto TOC](#toc)

## SCREENSHOTS
<a name="bbb_index.png"></a>
   - index.php
   ![Home page](res/bbb_index.png)
   [goto TOC](#toc)

   - index.php
   ![List meetings](res/bbb_meetings.png)
      > ![favicon](icons/favicon.png) Join meeting 
      > ![About](icons/about.png) Show meeting 
      > ![Mail](icons/mail.png) Send invitation 
      > ![Exit](icons/exit.png) Stop meeting

   [goto TOC](#toc)

<a name="bbb_create.png"></a>
   - bbb_create.php
   ![Create meeting](res/bbb_create.png)
   [goto TOC](#toc)

<a name="bbb_join.png"></a>
   - bbb_join.php
   ![Join meeting](res/bbb_join.png)
   [goto TOC](#toc)

<a name="bbb_info.png"></a>
   - bbb_info.php
   ![Meeting info](res/bbb_info.png)
   [goto TOC](#toc)

<a name="bbb_stop.png"></a>
   - bbb_stop.php
   ![Stp meeting](res/bbb_stop.png)
   [goto TOC](#toc)

<a name="bbb_record.png"></a>
   - bbb_record.php
   ![Recordings](res/bbb_record.png)
      > ![Explorer](icons/explorer.png) View recorded meeting 
      > ![Exit](icons/exit.png) Delete recording 


   [goto TOC](#toc)

<a name="bbb_invite.png"></a>
   - bbb_invite.php
   ![Send](res/bbb_invite.png)
   [goto TOC](#toc)

<a name="bbb_send.png"></a>
   - bbb_send.php
   ![Send](res/bbb_send.png)
   [goto TOC](#toc)

<a name="bbb_sendview.png"></a>
   - bbb_send.php
   ![Send](res/bbb_sendview.png)
   [goto TOC](#toc)

<a name="bbb_user.png"></a>
   - bbb_user.php
   ![Users](res/bbb_user.png)
   [goto TOC](#toc)

<a name="todo"></a>
## TODO

   1. Enjoy
   2. Display 1st page of presentation as background on users join page (would be nice...and i am willing)
   3. Create download location for .MP4 meeting recording files in BBB (a lot of scripts...but i [need help][discussion])
   4. Create cron srcipt to start meeting in timely fashion for a specific time period (we need this really ?)

   - You can take part of [discussion][discussion]
   - Or you can send us [issue reports][issues]

   [goto TOC](#toc)

[bbbadmin_install.sh]: res/bbbadmin_install.sh
[bbbuser_install.sh]: res/bbbuser_install.sh
[bbb_admin.json]: res/bbb_admin.json
[bbb_admin.tmpl]: res/bbb_admin.tmpl
[index.php]: index.php
[bbb_config.php]: bbb_config.php
[bbb_load.php]: bbb_load.php
[bbb_create.php]: bbb_create.php
[bbb_join.php]: bbb_join.php
[bbb_info.php]: bbb_info.php
[bbb_record.php]: bbb_record.php
[bbb_delrec.php]: bbb_delrec.php
[bbb_send.php]: bbb_send.php
[bbb_stop.php]: bbb_stop.php
[bbb_user.php]: bbb_user.php
[bbb_lang]: res/locale/
[bbb_locale]: locale/
[releases]: releases/
[changelog]: CHANGELOG
[bbb_build.sh]: build/bbb_build.sh
[bbb]: https://bigbluebutton.org/
[bbbapi]: https://github.com/bigbluebutton/bigbluebutton-api-php
[.htaccess]: res/.htaccess
[style.css]: css/style.css
[discussion]: https://github.com/unattended-ch/bbbadmin/discussions
[issues]: https://github.com/unattended-ch/bbbadmin/issues
[webmin]: https://www.webmin.com/
[favicon]: icons/favicon.ico
[about]: icons/about.png
[mail]: icons/mail.png
[exit]: icons/exit.png
[save]: icons/save.png
[popupblocker]: https://support.mozilla.org/en-US/kb/pop-blocker-settings-exceptions-troubleshooting
[new]: icons/new.png
