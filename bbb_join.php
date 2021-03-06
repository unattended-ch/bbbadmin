<?php
//********************************************************************
//* Description: Join meeting
//* Author: Automatix <github@unattended.ch>
//* Created at: Tue Aug 31 16:02:08 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//********************************************************************
namespace BigBlueButton;
$serverid = $_GET['sid'];
//if (isset($_GET['mID']))
    $meetingID = $_GET['mID'];
require_once('./bbb_load.php');
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\JoinMeetingParameters;
$userName = '';
if (isset($_GET['userName']))
    $userName = $_GET['userName'];
$meetingName = $_GET['meetingName'];
$moderator_password = $_GET['moderator_password'];
$attendee_password = $_GET['attendee_password'];
$bbb = new BigBlueButton();
if(isset($_GET['Submit']))
{
    if ($userName !== '') {
        $joinMeetingParams = new JoinMeetingParameters($meetingID, $userName, $moderator_password);
        $joinMeetingParams->setRedirect(true);
        $url = $bbb->getJoinMeetingURL($joinMeetingParams);
        printf("Join meeting [%s] [%s]<br>", $meetingName, $meetingID);
        printf('<br><a href="'.$url.'" target="_blank">'.$url.'</a>');
        printf('<script type="text/javascript">window.open( "%s" )</script>', $url);
        $returl = "./index.php?sid=".$serverid;
        printf('<script type="text/javascript">location.replace("%s")</script>', $returl);
    } else {
        printf('ERROR : No username specified !');
    }
}
else if(isset($_POST['Submit']))
{
    $userName = $_POST['userName'];
    $asmoderator = '';
    $displayonly = '';
    if (isset($_POST['asmoderator']))
        $asmoderator = $_POST['asmoderator'];
    if (isset($_POST['displayonly']))
        $displayonly = $_POST['displayonly'];
    $join_password = $attendee_password;
    if ($asmoderator == 'yes') {
        $join_password = $moderator_password;
    }
    if ($userName !== '') {
        $joinMeetingParams = new JoinMeetingParameters($meetingID, $userName, $join_password);
        $joinMeetingParams->setRedirect(true);
        $url = $bbb->getJoinMeetingURL($joinMeetingParams);
        if ($displayonly == 'yes') {
            printf('<br><a href="'.$url.'" target="_blank">'.$url.'</a>');
        } else {
            printf("Join meeting [%s] [%s]<br>", $userName, $meetingID);
            printf('<script type="text/javascript">window.open( "%s" )</script>', $url);
            $returl = "./index.php?sid=".$serverid;
            printf('<script type="text/javascript">location.replace("%s")</script>', $returl);
        }
    } else {
        printf('ERROR : No username specified !');
    }
}
else
{
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title> [<?php echo $servername; ?>]</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <div id="topStats">
	<center><table class="main"><tr><td>
		<div class="chartWrapper">
			<div class="chartLabel"><?php echo lang('JOINMEETING'); ?></div>
			<div class="chartHolder">
			    <table><tr><form action=""  method="POST"><table><tr>
		                <td><label for="servername" id="srv_id_label">Server </label></td>
		                <td><input type="text" name="servername" id="servername" value="<?php echo $servername?>" size="30" readonly></td></tr><tr>
		                <td><label for="meetingName" id="app_id_label"  ><?php echo lang('MEETINGNAME'); ?></label></td>
		                <td><input type="text" name="meetingName" id="meetingName" size="50" value="<?php echo $meetingName ?>"></td></tr><tr>
		                <td><label for="userName" id="app_name_label"  ><?php echo lang('USERNAME'); ?></label></td>
		                <td><input type="text" name="userName" id="userName" size="30"></td></tr><tr>
		                <td><label for="asmoderator"><?php echo lang('MODERATOR'); ?></label></td>
		                <td><input type="checkbox" id="asmoderator" name="asmoderator" value="yes"></td></tr><tr>
		                <td><label for="displayonly"><?php echo lang('DISPLAYONLY'); ?></label></td>
		                <td><input type="checkbox" id="displayonly" name="displayonly" value="yes"></td></tr>
	                        </table>
		                <br><center><input type="hidden" name="meetingID" id="meetingID" value="<?php echo $meetingID ?>"> <input type="submit" name="Submit" value="Join meeting" class="bigbutton"> <input type="button" value="<?php echo lang('BACK'); ?>" onclick="javascript:history.back()" class="bigbutton"></center><br>
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
