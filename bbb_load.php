<?php
//********************************************************************
//* Description: Load modules and functions for bbbadmin
//* Author: Automatix <github@unattended.ch>
//* Created at: Tue Aug 31 16:02:22 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//********************************************************************
$version = "0.0.0.9";
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
if ($cfg->browserlang == '1')
    $language = BrowserLanguage();
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
// Parameters  : $id = ID of selected server
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
        {
            $servername = $serv;
            break;
        }
        $i++;
    }
    return($servername);
}

//----------------------------------------------------------------------
// Function    : ServerUrl($id)
// Created at  : Sat Sep 11 14:11:27 UTC 2021
// Description : Get server url
// Parameters  : $id = ID of selected server
// Variables   : 
// Return      : $serverurl
//----------------------------------------------------------------------
function ServerUrl($id)
{
    $cfg = $GLOBALS['cfg'];
    $i = 1;
    $serverurl = '';
    foreach($cfg->bbb as $serv)
    {
        if ($id == $i)
        {
            $serverurl = $serv->url;
            break;
        }
        $i++;
    }
    return($serverurl);
}

//----------------------------------------------------------------------
// Function    : ServerSalt($id)
// Created at  : Sat Sep 11 14:13:14 UTC 2021
// Description : Get server salt
// Parameters  : $id = ID of selected server
// Variables   : 
// Return      : $serversalt
//----------------------------------------------------------------------
function ServerSalt($id)
{
    $cfg = $GLOBALS['cfg'];
    $i = 1;
    $serversalt = '';
    foreach($cfg->bbb as $serv)
    {
        if ($id == $i)
        {
            $serversalt = $serv->salt;
            break;
        }
        $i++;
    }
    return($serversalt);
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
function ServerRoomId($vis=true)
{
    $cfg = $GLOBALS['cfg'];
    $UIDD = md5(uniqid(rand(), true));
    $visible = '';
    if ($vis == false)
        $visible = 'style="visibility: hidden" ';
    $roomselect = '<select '.$visible.'name="meetingIDSel" id="meetingIDSel" class="meeting" onchange="setMetID()">';
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
// Function    : ServerRoomMsg($meetingID)
// Created at  : Sat Sep  4 01:18:44 UTC 2021
// Description : Get message for server
// Parameters  : $meetingID
// Variables   : 
// Return      : Message
//----------------------------------------------------------------------
function ServerRoomMsg($meetingID)
{
    $cfg = $GLOBALS['cfg'];
    foreach($cfg->rooms as $room) {
        if ($room->id == $meetingID)
        {
            return($room->msg);
        }
    }
    return('');
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
        $join = './bbb_join.php?sid='.$serverid.'&mID='.$meeting->meetingID.'&meetingName='.$meeting->meetingName.'&moderator_password='.$meeting->moderatorPW.'&attendee_password='.$meeting->attendeePW;
        $info = './bbb_info.php?sid='.$serverid.'&mID='.$meeting->meetingID.'&moderator_password='.$meeting->moderatorPW.'&Submit=1';
        $send = './bbb_send.php?sid='.$serverid.'&mID='.$meeting->meetingID;
        $stop = './bbb_stop.php?sid='.$serverid.'&mID='.$meeting->meetingID.'&moderator_password='.$meeting->moderatorPW;
        $functions = '';
        if (file_exists('./bbb_join.php'))
            $functions = $functions . ' <a href="' . $join . '" title="'.lang('JOINMEETING').'"><img src="./icons/favicon.ico" width="16" height="16"></a>';
        if (file_exists('./bbb_info.php'))
            $functions = $functions . ' <a href="' . $info . '" title="'.lang('MEETINGINFO').'"><img src="./icons/about.ico" width="16" height="16"></a>';
        if (file_exists('./bbb_send.php'))
            $functions = $functions . ' <a href="' . $send . '" title="'.lang('SENDMEETING').'"><img src="./icons/mail.ico" width="16" height="16"></a>';
        if (file_exists('./bbb_stop.php'))
            $functions = $functions . ' <a href="' . $stop . '" title="'.lang('STOPMEETING').'"><img src="./icons/exit.ico" width="16" height="16"></a>';
    }
    if ($mode == '0') 
    {
        $create = './bbb_create.php?sid='.$serverid;
        $invite = './bbb_invite.php?sid='.$serverid;
        $recs = './bbb_record.php?sid='.$serverid;
        $refresh = './index.php?sid='.$serverid;
        if (file_exists('./bbb_create.php'))
            $functions = '<a href="'.$create.'" class="button"><button class="bigbutton">'.lang('CREATEMEETING').'</button></a>';
        if (file_exists('./bbb_invite.php'))
            $functions = $functions . ' <a href="'.$invite.'" class="button"><button class="bigbutton">'.lang('INVITATION').'</button></a>';
        if (file_exists('./bbb_record.php'))
            $functions = $functions . ' <a href="'.$recs.'"><button class="bigbutton">'.lang('RECORDINGS').'</button></a>';
        $functions = $functions . ' <a href="'.$refresh.'"><button class="bigbutton">'.lang('REFRESH').'</button></a>';
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
    $cfg = $GLOBALS['cfg'];
    if ($cfg->debug == '1')
        printf('<pre>%s</pre>', print_r($array,true));
}

//----------------------------------------------------------------------
// Function    : ArrayToXML($array)
// Created at  : Sat Sep  4 12:31:37 UTC 2021
// Description : Convert array to xml object
// Parameters  : 
// Variables   : 
// Return      : 
//----------------------------------------------------------------------
function arrayToXML($array, $rootElement = null, $xml = null) {
    $_xml = $xml;
      
    // If there is no Root Element then insert root
    if ($_xml === null) {
        $_xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<root/>');
    }
      
    // Visit all key value pair
    foreach ($array as $k => $v) {
          
        // If there is nested array then
        if (is_array($v)) { 
              
            // Call function for nested array
            arrayToXml($v, $k, $_xml->addChild($k));
            }
              
        else {
              
            // Simply add child element. 
            $_xml->addChild($k, $v);
        }
    }
    $_xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<root/>');
      
    return $_xml;
}

function array_to_xml($data) {
    $_xml = new SimpleXMLElement('<root/>');
    foreach( $data as $key => $value ) {
        if( is_array($value) ) {
            if( is_numeric($key) ){
                $key = 'item'.$key; //dealing with <0/>..<n/> issues
            }
            $subnode = $_xml->addChild($key);
            array_to_xml($value, $subnode);
        } else {
            $_xml->addChild("$key",htmlspecialchars("$value"));
        }
     }
    return($_xml);
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
    $empty = array();
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
        {
            $empty['err'] = $response->getMessage();
            return(array_to_xml($empty));
        }
    }
    return(array_to_xml($empty));
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
    $json = file_get_contents('./res/bbb_admin.json', true);
    $json = json_decode($json);
    //Show(json_last_error_msg().'<br>'.$json);
    return($json);
}

//----------------------------------------------------------------------
// Function    : BrowserLanguage()
// Created at  : Sat Sep  4 21:03:34 UTC 2021
// Description : Get browser language
// Parameters  : none
// Variables   : 
// Return      : Language short code
//----------------------------------------------------------------------
function BrowserLanguage()
{
//    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    $acceptLang = ['fr', 'de', 'en']; 
    $lang = in_array($lang, $acceptLang) ? $lang : 'en';
    return($lang);
}
