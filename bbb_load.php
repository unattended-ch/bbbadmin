<?php
//********************************************************************
//* Description: Load modules and functions for bbbadmin
//* Author: Automatix <github@unattended.ch>
//* Created at: Tue Aug 31 16:02:22 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//********************************************************************
$version = "0.0.0.4";
require_once('./BigBlueButton.php');
require_once('./Core/ApiMethod.php');
require_once('./Exceptions/BadResponseException.php');
require_once('./Parameters/BaseParameters.php');
require_once('./Parameters/MetaParameters.php');
require_once('./Parameters/UserDataParameters.php');
require_once('./Parameters/CreateMeetingParameters.php');
require_once('./Parameters/DeleteRecordingsParameters.php');
require_once('./Parameters/EndMeetingParameters.php');
require_once('./Parameters/GetMeetingInfoParameters.php');
require_once('./Parameters/GetRecordingsParameters.php');
require_once('./Parameters/HooksCreateParameters.php');
require_once('./Parameters/HooksDestroyParameters.php');
require_once('./Parameters/IsMeetingRunningParameters.php');
require_once('./Parameters/JoinMeetingParameters.php');
require_once('./Parameters/PublishRecordingsParameters.php');
require_once('./Parameters/UpdateRecordingsParameters.php');
require_once('./Responses/BaseResponse.php');
require_once('./Responses/ApiVersionResponse.php');
require_once('./Responses/CreateMeetingResponse.php');
require_once('./Responses/DeleteRecordingsResponse.php');
require_once('./Responses/EndMeetingResponse.php');
require_once('./Responses/GetDefaultConfigXMLResponse.php');
require_once('./Responses/GetMeetingInfoResponse.php');
require_once('./Responses/GetMeetingsResponse.php');
require_once('./Responses/GetRecordingsResponse.php');
require_once('./Responses/HooksCreateResponse.php');
require_once('./Responses/HooksDestroyResponse.php');
require_once('./Responses/HooksListResponse.php');
require_once('./Responses/IsMeetingRunningResponse.php');
require_once('./Responses/JoinMeetingResponse.php');
require_once('./Responses/PublishRecordingsResponse.php');
require_once('./Responses/SetConfigXMLResponse.php');
require_once('./Responses/UpdateRecordingsResponse.php');
require_once('./Util/UrlBuilder.php');
require_once('./bbb_config.php');
if (!isset($language))
    $language='en';
if (file_exists('./locale/'.$language.'.php'))
    require_once('./locale/'.$language.'.php');
else
    require_once('./locale/en.php');

//----------------------------------------------------------------------
// Function    : RandomString($len='25')
// Created at  : Tue Aug 31 16:05:50 UTC 2021
// Description : Create random string
// Parameters  : $len = Length of string (default=25)
// Variables   : 
// Return      : Random string
//----------------------------------------------------------------------
function RandomString($len='25')
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $len; $i++) {
        $randstring = $randstring . $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}

//----------------------------------------------------------------------
// Function    : ServerName($id)
// Created at  : Fri Sep  3 20:23:21 UTC 2021
// Description : Get selected servername
// Parameters  : $sid = ID of selected server
// Variables   : 
// Return      : Servername
//----------------------------------------------------------------------
function ServerName($id)
{
    $cfg = $GLOBALS['cfg'];
    $i = 1;
    $servername = '';
    foreach($cfg->server as $serv)
    {
        if ($id == $i)
            $servername = $serv;
        $i++;
    }
    //$servername = $cfg->server->${$serverid};
    return($servername);
}

//----------------------------------------------------------------------
// Function    : ServerSelect($sel1='', $sel2='')
// Created at  : Tue Aug 31 16:05:55 UTC 2021
// Description : Create server select list for html
// Parameters  : $sel1 = 
//               $sel2 = 
// Variables   : 
// Return      : Select list
//----------------------------------------------------------------------
function ServerSelect($sel1='', $sel2='')
{
    $serverselect = '<form><select name="sid" id="sid" size="1" onchange="this.form.submit()">';
    $i = 1;
    $cfg = $GLOBALS['cfg'];
    foreach($cfg->server as $serv)
    {
        if ($i == 1) 
            $sel = $sel1;
        if ($i == 2) 
            $sel = $sel2;
        $serverselect = $serverselect .'<option value="'.$i.'" '.$sel.'>'.$serv.'</option>';
        $i++;
    }
    $serverselect = $serverselect .'</select></form>';
    return $serverselect;
}

//----------------------------------------------------------------------
// Function    : ServerRoomId()
// Created at  : Tue Aug 31 16:06:01 UTC 2021
// Description : Create meeting ID select list for html
// Parameters  : none
// Variables   : 
// Return      : Select list
//----------------------------------------------------------------------
function ServerRoomId()
{
    $cfg = $GLOBALS['cfg'];
    $UIDD = md5(uniqid(rand(), true));
    $roomselect = '<select name="meetingIDSel" id="meetingIDSel" class="meeting" onchange="setMetID()">';
    $sel = 'selected';
    foreach($cfg->rooms as $room) {
        $roomselect = $roomselect . '<option value="'.$room->id.'" '.$sel.'>'.$room->id.'</option>';
        $sel = '';
    }
    $roomselect = $roomselect . '<option value="'.$UIDD.'">'.$UIDD.'</option>';
    $roomselect = $roomselect . '</select>';
    return $roomselect;
}

//----------------------------------------------------------------------
// Function    : ServerRoomName()
// Created at  : Tue Aug 31 16:06:07 UTC 2021
// Description : Create meeting name select list for html
// Parameters  : none
// Variables   : 
// Return      : Select list
//----------------------------------------------------------------------
function ServerRoomName()
{
    $cfg = $GLOBALS['cfg'];
    $roomselect = '<select name="meetingNameSel" id="meetingNameSel" class="meeting" onchange="setMetName()">';
    foreach($cfg->rooms as $room) {
        $roomselect = $roomselect . '<option value="'.$room->name.'">'.$room->name.'</option>';
    }
    $roomselect = $roomselect . '</select>';
    return $roomselect;
}

//----------------------------------------------------------------------
// Function    : ServerRoomAccess()
// Created at  : Tue Aug 31 16:06:12 UTC 2021
// Description : Create meeting attendee password select list for html
// Parameters  : none
// Variables   : 
// Return      : Select list
//----------------------------------------------------------------------
function ServerRoomAccess()
{
    $cfg = $GLOBALS['cfg'];
    $roomselect = '<select name="meetingAccSel" id="meetingAccSel" class="meeting" onchange="setMetAcc()">';
    foreach($cfg->rooms as $room) {
        $roomselect = $roomselect . '<option value="'.$room->acc.'">'.$room->acc.'</option>';
    }
    $roomselect = $roomselect . '</select>';
    return $roomselect;
}

//----------------------------------------------------------------------
// Function    : ReturnURL()
// Created at  : Tue Aug 31 16:06:18 UTC 2021
// Description : Create meeting return url select list for html
// Parameters  : none
// Variables   : 
// Return      : Select list
//----------------------------------------------------------------------
function ReturnURL()
{
    $cfg = $GLOBALS['cfg'];
    $urlselect = '<select name="urlLogoutSel" id="urlLogoutSel" class="meeting" onchange="setMetLogout()">';
    $urlselect = $urlselect . '<option value="" selected></option>';
    foreach($cfg->logout as $logout) {
        $urlselect = $urlselect . '<option value="'.$logout.'">'.$logout.'</option>';
    }
    $urlselect = $urlselect . '</select>';
    return $urlselect;
}

//----------------------------------------------------------------------
// Function    : RoomLogos()
// Created at  : Tue Aug 31 16:06:24 UTC 2021
// Description : Create meeting logo url select list for html
// Parameters  : none
// Variables   : 
// Return      : Select list
//----------------------------------------------------------------------
function RoomLogos()
{
    $cfg = $GLOBALS['cfg'];
    $urlselect = '<select name="logonameSel" id="logonameSel" class="meeting" onchange="setMetLogo()">';
    $urlselect = $urlselect . '<option value="" selected></option>';
    foreach($cfg->logos as $logo) {
        $urlselect = $urlselect . '<option value="'.$logo.'">'.$logo.'</option>';
    }
    $urlselect = $urlselect . '</select>';
    return $urlselect;
}

//----------------------------------------------------------------------
// Function    : LinkFunctions($mode='0', $serverid, $meeting)
// Created at  : Tue Aug 31 16:06:30 UTC 2021
// Description : 
// Parameters  : $mode = 0=default buttons 1=Function buttons
//               $serverid = Server id
//               $meeting = Meeting informations
// Variables   : 
// Return      : Button list
//----------------------------------------------------------------------
function LinkFunctions($mode='0', $serverid, $meeting)
{
    if ($mode == '1') 
    {
        $join = './bbb_join.php?sid='.$serverid.'&meetingID='.$meeting->meetingID.'&meetingName='.$meeting->meetingName.'&moderator_password='.$meeting->moderatorPW.'&attendee_password='.$meeting->attendeePW;
        $info = './bbb_info.php?sid='.$serverid.'&meetingID='.$meeting->meetingID.'&moderator_password='.$meeting->moderatorPW.'&Submit=1';
        $send = './bbb_send.php?sid='.$serverid.'&mID='.$meeting->meetingID;
        $stop = './bbb_stop.php?sid='.$serverid.'&meetingID='.$meeting->meetingID.'&moderator_password='.$meeting->moderatorPW;
        $functions = '';
        if (file_exists('./bbb_join.php'))
            $functions = $functions . '<a href="' . $join . '" title="'.lang('JOINMEETING').'"><img src="./icons/favicon.ico" width="16" height="16"></a> ';
        if (file_exists('./bbb_info.php'))
            $functions = $functions . '<a href="' . $info . '" title="'.lang('MEETINGINFO').'"><img src="./icons/about.ico" width="16" height="16"></a> ';
        if (file_exists('./bbb_send.php'))
            $functions = $functions . '<a href="' . $send . '" title="'.lang('SENDMEETING').'"><img src="./icons/mail.ico" width="16" height="16"></a>';
        if (file_exists('./bbb_stop.php'))
            $functions = $functions . '<a href="' . $stop . '" title="'.lang('STOPMEETING').'"><img src="./icons/exit.ico" width="16" height="16"></a>';
    }
    if ($mode == '0') 
    {
        $create = './bbb_create.php?sid='.$serverid;
        $recs = './bbb_record.php?sid='.$serverid;
        if (file_exists('./bbb_create.php'))
            $functions = '<a href="'.$create.'" class="button"><button class="bigbutton">'.lang('CREATEMEETING').'</button></a>';
        if (file_exists('./bbb_record.php'))
            $functions = $functions . ' <a href="'.$recs.'"><button class="bigbutton">'.lang('RECORDINGS').'</button></a>';
    }
    return $functions;
}

//----------------------------------------------------------------------
// Function    : Show($array)
// Created at  : Tue Aug 31 16:06:37 UTC 2021
// Description : Display array in html
// Parameters  : $array = Array to display
// Variables   : 
// Return      : none
//----------------------------------------------------------------------
function Show($array)
{
    if ($cfg['debug'] == '1')
        printf('<pre>%s</pre>', print_r($array,true));
}

//----------------------------------------------------------------------
// Function    : LoadMeeting($meetingid)
// Created at  : Wed Sep  1 19:44:55 UTC 2021
// Description : Search meeting ID and load informations
// Parameters  : $meetingid = BBB meeting ID
// Variables   : 
// Return      : $meeting array or empty if not found
//----------------------------------------------------------------------
function LoadMeeting($response, $meetingid)
{
    if (isset($response)) {
        if ($response->getReturnCode() == 'SUCCESS')
        {
            if(!empty($response->getRawXml()->meetings->meeting))
            {
                foreach ($response->getRawXml()->meetings->meeting as $meeting)
                {
                    if ($meeting->meetingID == $meetingid)
                    {
                        return($meeting);
                    }
                }
            }
        }
        else
            return($response->getMessage());
    }
    return('');
}

//----------------------------------------------------------------------
// Function    : LoadConfig
// Created at  : Fri Sep  3 15:33:41 UTC 2021
// Description : Load bbbadmin configuration from JSON
// Parameters  : none
// Variables   : 
// Return      : $cfg array
//----------------------------------------------------------------------
function LoadConfigFile()
{
    $json = file_get_contents('./bbb_admin.json', true);
    $json = json_decode($json);
    //Show(json_last_error_msg().'<br>'.$json);
    return($json);
}

//----------------------------------------------------------------------
// Function    : LoadApp
// Created at  : Fri Sep  3 20:24:51 UTC 2021
// Description : 
// Parameters  : 
// Variables   : 
// Return      : 
//----------------------------------------------------------------------
function LoadConfig($serverid)
{
if ($database == '')
{
    $cfg = LoadConfigFile();
    //
    // Load BBB values from Apache environment variable
    // For every server you must define Apache environment variable BBB_SECRET1 and BBB_SERVER1_BASE_URL
    // Replace 1 with the index in äserver
    //
    if ($serverid == '1')
    {
        apache_setenv('BBB_SECRET', apache_getenv('BBB_SECRET1'));
        apache_setenv('BBB_SERVER_BASE_URL', apache_getenv('BBB_SERVER1_BASE_URL'));
        //$servername = $server['1'];
        $sel1 = 'selected';
        $sel2 = '';
    }
    else
    {
        apache_setenv('BBB_SECRET', apache_getenv('BBB_SECRET2'));
        apache_setenv('BBB_SERVER_BASE_URL', apache_getenv('BBB_SERVER2_BASE_URL'));
        //$servername = $server['2'];
        $sel1 = '';
        $sel2 = 'selected';
    }
    $servername = ServerName($serverid);
}
else
{
    // Configuration with database
    // mySql script can be found in [./sql/bbbadmin.sql]
    //
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    // mysqli('servername', 'username', 'password', 'database')
    $mysqli = new mysqli("localhost", "bbbadmin", "Support1", "bbbadmin");
    if ($mysqli->connect_errno)
        die('Connection failed: ' . $mysqli->connect_error);
    $mysqli->set_charset("utf8");

    // Load configuration
    $result = $mysqli->query("SELECT * FROM config");
    if($result)
    {
        while ($row = $result->fetch_object()){
          if ($row->name !== '')
          {
            //printf("$%s=%s<br>", $row->name, $row->val);
            if (strpos($row->name, "."))
            {
                $newrow = preg_split("/[.]/", $row->name);
                $cfg->${$newrow[0]}[$newrow[1]] = $row->val;
            }
            else
                $cfg[$row->name] = $row->val;
          }
        }
        // Free result set
        $result->close();
    }

    // Load servers
    // With mysql database the Apache environment variables are loaded from the database
    // There is no need to define it in Apache
    //
    $result = $mysqli->query("SELECT * FROM server");
    if($result)
    {
        while ($row = $result->fetch_object()){
            if ($serverid == $row->id)
            {
                apache_setenv('BBB_SECRET', $row->secret);
                apache_setenv('BBB_SERVER_BASE_URL', $row->url);
                $servername = $row->name;
                ${'sel'.$row->id} = 'selected';
            }
            $server[$row->id] = ''.$row->name.'';
        }
        $cfg['server'] = $server;
        // Free result set
        $result->close();
    }

    // Load rooms
    $result = $mysqli->query("SELECT * FROM rooms");
    if($result)
    {
        while ($row = $result->fetch_object()){
            $rooms[$row->id]['name'] = $row->name.' '.$copyright;
            $rooms[$row->id]['id'] = $row->roomid;
            $rooms[$row->id]['acc'] = $row->access;
        }
        // Free result set
        $cfg['rooms'] = $rooms;
        $result->close();
    }

    // Load logout urls
    $result = $mysqli->query("SELECT * FROM logouturl");
    if($result)
    {
        while ($row = $result->fetch_object()){
            $logout[$row->id] = str_replace("\$serverid", $serverid, $row->url);
        }
        // Free result set
        $cfg['logout'] = $logout;
        $result->close();
    }

    // Load logo urls
    $result = $mysqli->query("SELECT * FROM logos");
    if($result)
    {
        while ($row = $result->fetch_object()){
            $logos[$row->id] = $row->url;
        }
        $cfg['logo'] = $logos;
        // Free result set
        $result->close();
    }
    if ($serverid == '1')
    {
        $servername = $server[1];
        $sel1 = 'selected';
        $sel2 = '';
    }
    else
    {
        $servername = $server[2];
        $sel1 = '';
        $sel2 = 'selected';
    }
}
}
