<?php
//********************************************************************
//* Description: Join meeting for users only
//* Author: Automatix <github@unattended.ch>
//* Created at: Tue Aug 31 16:02:08 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//* Usercall : http://server.dom?sid=N&mID=XXXXXXXXXXX&usr=Test
//*
//********************************************************************
namespace BigBlueButton;
if (isset($_GET['sid']))
    $serverid = $_GET['sid'];
if (isset($_GET['mID']))
    $meetingID = $_GET['mID'];
if (isset($_GET['usr']))
    $userName = $_GET['usr'];
$debug = "0";
require_once('./bbb_load.php');
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\JoinMeetingParameters;
$server = ServerSelect($sel1, $sel2);

try {
        $bbb = new BigBlueButton();
    }
catch (Exception $e) {
        //die('ERROR: %s'.$e->getMessage());
        // die() silently for user
        die();
    }
finally
    {
        $response = $bbb->getMeetings();
        $meeting = LoadMeeting($response, $meetingID);
    }

if ($meeting == '') {
    //die('Meeting ID ['.$meetingID.'] not found on server ['.$serverid.'] !');
    // die() silently for user
    die();
}
if (!is_object($meeting)) {
    //die('ERROR: '.Show($meeting));
    // die() silently for user
    die();
}
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
    <div id="topUsers">
	<center><table class="mainbig"><tr><td>
		<div class="chartWrapper">
			<div class="chartLabelBig"><?php echo lang('JOINMEETING'); ?></div>
			<div class="chartHolderBig">
			    <table class="mainbig"><tr><form action=""  method="POST"><table class="mainbig"><tr>
		                <td><label for="meetingName" id="app_id_label"  ><?php echo lang('MEETING'); ?></label></td>
		                <td><input class="mainbig" type="text" name="meetingName" id="meetingName" size="40" value="<?php echo $meetingName ?>"></td></tr><tr>
		                <td><label for="userName" id="app_name_label"  ><?php echo lang('USERNAME'); ?></label></td>
		                <td><input class="inputbig" type="text" name="userName" id="userName" size="30" value="<?php echo $userName ?>"></td></tr><tr>
	                        </table>
		                <br><center><input class="inputbig" type="submit" name="Submit" value="<?php echo lang('JOINMEETING'); ?>"></center><br>
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
