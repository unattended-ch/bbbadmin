<?php
//********************************************************************
//* Description: Create meeting
//* Author: Automatix <github@unattended.ch>
//* Created at: Tue Aug 31 16:00:47 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//********************************************************************
namespace BigBlueButton;
$serverid = $_GET['sid'];
require_once('./bbb_load.php');
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
$cfg = $GLOBALS['cfg'];
$invite = 'https://'.$cfg->invite.'?sid='.$serverid.'&exit=1';
foreach($cfg->access as $val)
{
    $moderatorPW = $val;
    break;
}
if(isset($_POST['Submit']))
{
    $bbb = new BigBlueButton();

    $meetingName = $_POST['meetingName'];
    $meetingID = $_POST['meetingID'];
    $moderator_password = $_POST['moderator_password'];
    $attendee_password = $_POST['attendee_password'];
    $urlLogout = $_POST['urlLogout'];
    $duration = $_POST['duration'];
    $pdffile = $_FILES['filename'];
    $logofile = $_POST['logoname'];
    printf("Create meeting [%s] [%s]<br>", $meetingName, $meetingID);
    $createMeetingParams = new CreateMeetingParameters($meetingID, $meetingName);
    $createMeetingParams->setAttendeePassword($attendee_password);
    $createMeetingParams->setModeratorPassword($moderator_password);
    $createMeetingParams->setDuration($duration);
    $createMeetingParams->setLogoutUrl($urlLogout);
    $createMeetingParams->setLogo($logofile);

    $createMeetingParams->setMuteOnStart(false);
    if ($_POST['muteonstart'] == 'yes') {
        $createMeetingParams->setMuteOnStart(true);
    }

    if ($pdffile['name'] !== '') {
        $createMeetingParams->addPresentation($pdffile['name'], file_get_contents($pdffile['tmp_name']));
    }

    $isRecordingTrue = false;
    if ($_POST['recording'] == 'yes') {
        $isRecordingTrue = true;
    }
    if ($isRecordingTrue) {
        $createMeetingParams->setRecord(true);
        $createMeetingParams->setAllowStartStopRecording(true);
        $createMeetingParams->setAutoStartRecording(false);
    }
    $createMeetingParams->setCopyright($GLOBALS['copyright']);

    $response = $bbb->createMeeting($createMeetingParams);
    if ($response->getReturnCode() == 'FAILED') {
        die(sprintf("%s<br>", $response->getMessage()));
    } else {
        printf("%s<br>", $response->getMessage());
    }

    $url = './bbb_join.php?sid='.$serverid;
    $url = $url . '&mID='.$meetingID;
    $url = $url . '&userName=Automatix';
    $url = $url . '&moderator_password='.$moderator_password;
    $url = $url . '&attendee_password='.$attendee_password;
    $url = $url . '&Submit=send';
    echo '<br><a href="'.$url.'">"'.$url.'</a>';
    header( "Location: $url" );
}
else
{
?>
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo lang('CREATEMEETING'); ?> [<?php echo $servername; ?>]</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body onload="setMetName(); setMetID(); setMetLogo();">
    <script>
        function setMetName() {
            document.getElementById('meetingName').setAttribute('value', document.getElementById('meetingNameSel').value);
            document.getElementById('meetingIDSel').selectedIndex = document.getElementById('meetingNameSel').selectedIndex;
            document.getElementById('meetingAccSel').selectedIndex = document.getElementById('meetingNameSel').selectedIndex;
            document.getElementById('meetingID').setAttribute('value', document.getElementById('meetingIDSel').value);
        }
        function setMetID() {
            document.getElementById('meetingID').setAttribute('value', document.getElementById('meetingIDSel').value);
        }
        function setMetAcc() {
            //document.getElementById('meetingAccSel').setAttribute('selectedIndex', document.getElementById('meetingNameSel').selectedIndex);
        }
        function setMetLogout() {
            document.getElementById('urlLogout').setAttribute('value', document.getElementById('urlLogoutSel').value);
        }
        function setMetLogo() {
            document.getElementById('logoname').setAttribute('value', document.getElementById('logonameSel').value);
        }
        function setModPass() {
            document.getElementById('moderator_password').setAttribute('value', '<?php echo $moderatorPW ?>');
        }
        function setAttPass() {
            var acc = document.getElementById('meetingAccSel').value;
            if (acc === '') {
                document.getElementById('attendee_password').setAttribute('value', '<?php echo $GLOBALS["access"][2] ?>');
            } else {
                document.getElementById('attendee_password').setAttribute('value', acc);
            }
        }
    </script>
    <div id="topStats">
	<center><table class="main"><tr><td>
		<div class="chartWrapper">
			<div class="chartLabel"><?php echo lang('CREATEMEETING'); ?></div>
			<div class="chartHolder">
			    <form action="" method="POST" enctype="multipart/form-data"><table><tr>
		                <td><label for="servername" id="srv_id_label">Server </label></td>
		                <td><input type="text" name="servername" id="servername" value="<?php echo $servername?>" size="30" readonly></td></tr><tr>
		                <td><br><label for="meetingName" id="app_name_label"><?php echo lang('MEETINGNAME'); ?></label></td>
		                <td><?php printf(ServerRoomName())?><br>
		                <input type="text" name="meetingName" id="meetingName" size="35"></td></tr><tr>
		                <td><br><label for="meetingID" id="app_id_label"><?php echo lang('MEETINGID'); ?></label></td>
		                <td><?php printf(ServerRoomId())?><br>
		                <input type="text" name="meetingID" id="meetingID" size="35"></td></tr><tr>
		                <td><label for="moderator_password" id="mod_pass_label"><?php echo lang('MODERATORPW'); ?></label></td>
		                <td><input type="text" name="moderator_password" id="moderator_password" value="<?php echo RandomString()?>" size="30"><input type="button" value="Default password" onclick="setModPass()"></td></tr><tr>
		                <td><br><label for="attendee_password" id="mod_pass_label"><?php echo lang('ATTENDEEPW'); ?></label></td>
		                <td><?php printf(ServerRoomAccess())?><br>
		                <input type="text" name="attendee_password" id="attendee_password" value="<?php echo RandomString()?>" size="30"><input type="button" value="Default password" onclick="setAttPass()"></td></tr><tr>
		                <td><label for="duration" id="mod_dur_label" ><?php echo lang('DURATIONMIN'); ?></label></td>
		                <td><input type="text" name="duration" id="duration" value="0"></td></tr><tr>
		                <td><br><label for="urlLogout" id="mod_pass_label"  ><?php echo lang('LOGOUTURL'); ?></label></td>
		                <td><?php printf(ReturnURL())?><br>
		                <input type="text" name="urlLogout" id="urlLogout" size="35" value="<?php echo $invite?>"></td></tr><tr>
		                <td><label for="filename"><?php echo lang('PRESENTATION'); ?></label>
		                <td><input type="file" id="filename" name="filename" accept=".pdf"></td></tr><tr>
		                <td><br><label for="logoname"><?php echo lang('LOGOURL'); ?></label>
		                <td><?php printf(RoomLogos())?><br>
		                <input type="text" id="logoname" name="logoname" size="35"></td></tr><tr>
		                <td><label for="muteonstart"><?php echo lang('MUTEONSTART'); ?></label></td>
		                <td><input type="checkbox" id="muteonstart" name="muteonstart" value="yes" checked></td></tr><tr>
		                <td><label for="recording"><?php echo lang('RECORDING'); ?></label></td>
		                <td><input type="checkbox" id="recording" name="recording" value="yes"></td></tr><tr>
		                </table>
		        	<br><center><input type="submit" name="Submit" value="<?php echo lang('CREATEMEETING'); ?>" class="bigbutton"> <input type="button" class="bigbutton" value="<?php echo lang('BACK'); ?>" onclick="javascript:history.back()"></center>
	    	    	    </form>
	            </div>
    		</div>
        </td></tr></table></center>
    </div>
    </body>
    </html>
<?php
    //Show($cfg);
}
