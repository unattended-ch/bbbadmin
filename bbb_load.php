<?php
$version = "0.0.0.1";
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

function RandomString($len='25')
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $len; $i++) {
        $randstring = $randstring . $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}

function ServerSelect($sel1='', $sel2='')
{
    $serverselect = '<form><select name="server_id" id="server_id" size="1" onchange="this.form.submit()">';
    $i = 1;
    foreach($GLOBALS['server'] as $serv) {
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

function ServerRoomId()
{
    $UIDD = md5(uniqid(rand(), true));
    $roomselect = '<select name="meetingIDSel" id="meetingIDSel" class="meeting" onchange="setMetID()">';
    $sel = 'selected';
    foreach($GLOBALS['rooms'] as $room) {
        $roomselect = $roomselect . '<option value="'.$room['id'].'" '.$sel.'>'.$room['id'].'</option>';
        $sel = '';
    }
    $roomselect = $roomselect . '<option value="'.$UIDD.'">'.$UIDD.'</option>';
    $roomselect = $roomselect . '</select>';
    return $roomselect;
}

function ServerRoomName()
{
    $roomselect = '<select name="meetingNameSel" id="meetingNameSel" class="meeting" onchange="setMetName()">';
    foreach($GLOBALS['rooms'] as $room) {
        $roomselect = $roomselect . '<option value="'.$room['name'].'">'.$room['name'].'</option>';
    }
    $roomselect = $roomselect . '</select>';
    return $roomselect;
}

function ServerRoomAccess()
{
    $roomselect = '<select name="meetingAccSel" id="meetingAccSel" class="meeting" onchange="setMetAcc()">';
    foreach($GLOBALS['rooms'] as $room) {
        $roomselect = $roomselect . '<option value="'.$room['acc'].'">'.$room['acc'].'</option>';
    }
    $roomselect = $roomselect . '</select>';
    return $roomselect;
}

function ReturnURL()
{
    $urlselect = '<select name="urlLogoutSel" id="urlLogoutSel" class="meeting" onchange="setMetLogout()">';
    $urlselect = $urlselect . '<option value="" selected></option>';
    foreach($GLOBALS['logout'] as $logout) {
        $urlselect = $urlselect . '<option value="'.$logout.'">'.$logout.'</option>';
    }
    $urlselect = $urlselect . '</select>';
    return $urlselect;
}

function RoomLogos()
{
    $urlselect = '<select name="logonameSel" id="logonameSel" class="meeting" onchange="setMetLogo()">';
    $urlselect = $urlselect . '<option value="" selected></option>';
    foreach($GLOBALS['logos'] as $logo) {
        $urlselect = $urlselect . '<option value="'.$logo.'">'.$logo.'</option>';
    }
    $urlselect = $urlselect . '</select>';
    return $urlselect;
}

function LinkFunctions($mode='0', $serverid, $meeting)
{
    if ($mode == '1') 
    {
        $join = './bbb_join.php?meetingID='.$meeting->meetingID.'&meetingName='.$meeting->meetingName.'&moderator_password='.$meeting->moderatorPW.'&attendee_password='.$meeting->attendeePW.'&serverid='.$serverid;
        $info = './bbb_info.php?meetingID='.$meeting->meetingID.'&moderator_password='.$meeting->moderatorPW.'&serverid='.$serverid.'&Submit=1';
        $stop = './bbb_stop.php?meetingID='.$meeting->meetingID.'&moderator_password='.$meeting->moderatorPW.'&serverid='.$serverid;
        $functions = '';
        if (file_exists('./bbb_join.php'))
            $functions = $functions . '<a href="' . $join . '" title="Join meeting"><img src="./icons/favicon.ico" width="16" height="16"></a> ';
        if (file_exists('./bbb_info.php'))
            $functions = $functions . '<a href="' . $info . '" title="Meeting info"><img src="./icons/about.ico" width="16" height="16"></a> ';
        if (file_exists('./bbb_stop.php'))
            $functions = $functions . '<a href="' . $stop . '" title="Stop meeting"><img src="./icons/exit.ico" width="16" height="16"></a>';
    }
    if ($mode == '0') 
    {
        $create = './bbb_create.php?serverid='.$serverid;
        $recs = './bbb_record.php?&serverid='.$serverid;
        if (file_exists('./bbb_create.php'))
            $functions = '<a href="'.$create.'" class="button"><button class="bigbutton">Create meeting</button></a>';
        if (file_exists('./bbb_record.php'))
            $functions = $functions . ' <a href="'.$recs.'"><button class="bigbutton">Recordings</button></a>';
    }
    return $functions;
}

function Show($array)
{
    if ($GLOBALS['debug'] == '1')
        printf('<pre>%s</pre>', print_r($array,true));
}
