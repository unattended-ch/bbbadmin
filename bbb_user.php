<?php
//********************************************************************
//* Description: Join meeting for users only
//* Author: Automatix <github@unattended.ch>
//* Created at: Tue Aug 31 16:02:08 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//********************************************************************
namespace BigBlueButton;
$serverid = $_GET['serverid'];
$meetingID = $_GET['meetingID'];
if (isset($_GET['userName']))
    $userName = $_GET['userName'];
require_once('./bbb_load.php');
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\JoinMeetingParameters;
$server = ServerSelect($sel1, $sel2);

try {
        $bbb = new BigBlueButton();
    }
catch (Exception $e) {
        die('ERROR: %s'.$e->getMessage());
    }
finally
    {
        $response = $bbb->getMeetings();
        $meeting = LoadMeeting($response, $meetingID);
    }

if ($meeting == '')
    die('Meeting ID ['.$meetingID.'] not found on server ['.$serverid.'] !');
if (!is_object($meeting))
    die('ERROR: '.Show($meeting));

if(isset($_GET['Submit']))
{
    if ($userName !== '')
    {
        $joinMeetingParams = new JoinMeetingParameters($meetingID, $userName, $meeting->attendeePW->__toString());
        $joinMeetingParams->setRedirect(true);
        $url = $bbb->getJoinMeetingURL($joinMeetingParams);
        header( "Location: $url" );
    } else {
        printf(lang('NOUSER'));
    }
}
else if(isset($_POST['Submit']))
{
    $userName = $_POST['userName'];
    if ($userName !== '')
    {
        $joinMeetingParams = new JoinMeetingParameters($meetingID, $userName, $meeting->attendeePW->__toString());
        $joinMeetingParams->setRedirect(true);
        $url = $bbb->getJoinMeetingURL($joinMeetingParams);
        header( "Location: $url" );
    } else {
        printf(lang('NOUSER'));
    }
}
else
{
    $meetingName = $meeting->meetingName;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo lang('JOINMEETING'); ?></title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <div id="topStats">
	<center><table class="main"><tr><td>
		<div class="chartWrapper">
			<div class="chartLabel"><?php echo lang('JOINMEETING'); ?></div>
			<div class="chartHolder">
			    <table><tr><form action=""  method="POST"><table><tr>
		                <td><label for="meetingName" id="app_id_label"  ><?php echo lang('MEETING'); ?></label></td>
		                <td><input type="text" name="meetingName" id="meetingName" size="50" value="<?php echo $meetingName ?>"></td></tr><tr>
		                <td><label for="userName" id="app_name_label"  ><?php echo lang('USERNAME'); ?></label></td>
		                <td><input type="text" name="userName" id="userName" size="30"></td></tr><tr>
	                        </table>
		                <br><center><input type="submit" name="Submit" value="<?php echo lang('JOINMEETING'); ?>" class="bigbutton"> <input type="button" value="<?php echo lang('BACK'); ?>" onclick="javascript:history.back()" class="bigbutton"></center><br>
		            </form>
			    </tr></table>
			</div>
		</div>
	</td>
	</tr></table></center>
    </div>
    </body>
</html>
<?php
}
