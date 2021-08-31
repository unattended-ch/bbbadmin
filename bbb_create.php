<?php
//********************************************************************
//* Description: Create meeting
//* Author: Support <github@unattended.ch>
//* Created at: Tue Aug 31 14:16:04 UTC 2021
//*
//* Copyright (c) 2021 Support  All rights reserved.
//*
//********************************************************************
namespace BigBlueButton;
$serverid = $_GET['serverid'];
require_once('./bbb_load.php');
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;

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

    $exportURL = false;
    if ($_POST['exporturl'] == 'yes') {
        $exportURL = true;
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
        printf("%s<br>", $response->getMessage());
    } else {
        printf("%s<br>", $response->getMessage());
    }

    $url = './bbb_join.php?meetingID='.$meetingID;
    $url = $url . '&userName=Automatix';
    $url = $url . '&moderator_password='.$moderator_password;
    $url = $url . '&attendee_password='.$attendee_password;
    $url = $url . '&exportURL='.$exportURL;
    $url = $url . '&serverid='.$serverid;
    $url = $url . '&Submit=send';
    echo '<br><a href="'.$url.'">"'.$url.'</a>';
    header( "Location: $url" );
}
else
{
    //Show($rooms);
?>
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Create meeting [<?php echo $servername; ?>]</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body onload="setMetName(); setMetID(); setMetLogout(); setMetLogo();">
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
            document.getElementById('moderator_password').setAttribute('value', '<?php echo $GLOBALS["access"][1] ?>');
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
			<div class="chartLabel">Create Meeting</div>
			<div class="chartHolder">
			    <form action="" method="POST" enctype="multipart/form-data"><table><tr>
		                <td><label for="servername" id="srv_id_label">Server </label></td>
		                <td><input type="text" name="servername" id="servername" value="<?php echo $servername?>" size="30" readonly></td></tr><tr>
		                <td><br><label for="meetingName" id="app_name_label">Meeting Name </label></td>
		                <td><?php printf(ServerRoomName())?><br>
		                <input type="text" name="meetingName" id="meetingName" size="35"></td></tr><tr>
		                <td><br><label for="meetingID" id="app_id_label">Meeting ID </label></td>
		                <td><?php printf(ServerRoomId())?><br>
		                <input type="text" name="meetingID" id="meetingID" size="35"></td></tr><tr>
		                <td><label for="moderator_password" id="mod_pass_label">Moderator password </label></td>
		                <td><input type="text" name="moderator_password" id="moderator_password" value="<?php echo RandomString()?>" size="30"><input type="button" value="Default password" onclick="setModPass()"></td></tr><tr>
		                <td><br><label for="attendee_password" id="mod_pass_label">Attendee password </label></td>
		                <td><?php printf(ServerRoomAccess())?><br>
		                <input type="text" name="attendee_password" id="attendee_password" value="<?php echo RandomString()?>" size="30"><input type="button" value="Default password" onclick="setAttPass()"></td></tr><tr>
		                <td><label for="duration" id="mod_dur_label" >Duration minutes</label></td>
		                <td><input type="text" name="duration" id="duration" value="0"></td></tr><tr>
		                <td><br><label for="urlLogout" id="mod_pass_label"  >Logout URL </label></td>
		                <td><?php printf(ReturnURL())?><br>
		                <input type="text" name="urlLogout" id="urlLogout" size="35"></td></tr><tr>
		                <td><label for="filename">Presentation PDF</label>
		                <td><input type="file" id="filename" name="filename" accept=".pdf"></td></tr><tr>
		                <td><br><label for="logoname">Logo URL</label>
		                <td><?php printf(RoomLogos())?><br>
		                <input type="text" id="logoname" name="logoname" size="35"></td></tr><tr>
		                <td><label for="muteonstart">Mute audio on start </label></td>
		                <td><input type="checkbox" id="muteonstart" name="muteonstart" value="yes" checked></td></tr><tr>
		                <td><label for="recording">Recording </label></td>
		                <td><input type="checkbox" id="recording" name="recording" value="yes"></td></tr><tr>
		                <td><label for="exporturl">Export join URL </label></td>
		                <td><input type="checkbox" id="exporturl" name="exporturl" value="yes"></td></tr>
		                </table>
		        	<br><center><input type="submit" name="Submit" value="Create meeting" class="bigbutton"> <input type="button" class="bigbutton" value="Back" onclick="javascript:history.back()"></center>
	    	    	    </form>
	            </div>
    		</div>
        </td></tr></table></center>
    </div>
    </body>
    </html>
<?php
}
