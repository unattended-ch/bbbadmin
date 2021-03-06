<?php
//********************************************************************
//* Description: Stop meeting
//* Author: Automatix <github@unattended.ch>
//* Created at: Tue Aug 31 16:03:00 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//********************************************************************
namespace BigBlueButton;
$serverid = $_GET['sid'];
$meetingID = $_GET['mID'];
require_once('./bbb_load.php');
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\EndMeetingParameters;

$moderator_password = $_GET['moderator_password'];

if(isset($_GET['Submit']))
{
    $bbb = new BigBlueButton();
    $meetingID = $_GET['meetingID'];
    $moderator_password = $_GET['moderator_password'];
    $endMeetingParams = new EndMeetingParameters($meetingID, $moderator_password);
    $response = $bbb->endMeeting($endMeetingParams);
    if ($response->getReturnCode() == 'FAILED') {
        die("%s<br>".$response->getMessage());
    } else {
        printf("%s<br>", $response->getMessage());
    }
    $url = "./index.php?sid=".$serverid;
    header('Location:' . $url);
}
else if(isset($_POST['Submit']))
{
    $bbb = new BigBlueButton();
    $meetingID = $_POST['meetingID'];
    $moderator_password = $_POST['moderator_password'];
    $endMeetingParams = new EndMeetingParameters($meetingID, $moderator_password);
    $response = $bbb->endMeeting($endMeetingParams);
    if ($response->getReturnCode() == 'FAILED') {
        die("%s<br>".$response->getMessage());
    } else {
        printf("%s<br>", $response->getMessage());
    }
    $url = "./index.php?sid=".$serverid;
    header('Location:' . $url);
}
else
{
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo lang('STOPMEETING'); ?> [<?php echo $servername; ?>]</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <div id="topStats">
	<center><table class="main"><tr><td>
		<div class="chartWrapper">
			<div class="chartLabel"><?php echo lang('STOPMEETING'); ?></div>
			<div class="chartHolder">
			    <table><tr>
		            <form action=""  method="POST"><table><tr>
		                <td><label for="servername" id="srv_id_label"><?php echo lang('SERVER'); ?></label></td>
		                <td><input type="text" name="servername" id="servername" value="<?php echo $servername?>" size="30" readonly></td></tr><tr>
		                <td><label for="meetingID" id="app_id_label"  ><?php echo lang('MEETINGID'); ?></label></td>
		                <td><input type="text" name="meetingID" id="meetingID" size="30" value="<?php printf($meetingID); ?>"></td></tr><tr>
		                <td><label for="moderator_password" id="mod_pass_label"  ><?php echo lang('MODERATORPW'); ?></label></td>
		                <td><input type="text" name="moderator_password" id="moderator_password" size="30" value="<?php printf($moderator_password); ?>"></td></tr><tr>
				<td colspan="2"></td></tr><tr>
		                <td colspan="2"><center><input type="submit" name="Submit" value="<?php echo lang('STOPMEETING'); ?>" class="bigbutton"> <input type="button" value="<?php echo lang('BACK'); ?>" onclick="javascript:history.back()" class="bigbutton"></center></td></tr><tr>
				<td colspan="2"></td></tr>
		            </table></form>
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
