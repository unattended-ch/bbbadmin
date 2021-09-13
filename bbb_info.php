<?php
//********************************************************************
//* Description: Display meeting informations
//* Author: Automatix <github@unattended.ch>
//* Created at: Tue Aug 31 16:01:49 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//********************************************************************
namespace BigBlueButton;
$serverid = $_GET['sid'];
$meetingID = $_GET['mID'];
require_once('./bbb_load.php');
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\GetMeetingInfoParameters;


if(isset($_GET['Submit']))
{
    $bbb = new BigBlueButton();

    $moderator_password = $_GET['moderator_password'];
    $getMeetingInfoParams = new GetMeetingInfoParameters($meetingID, $moderator_password);
    $response = $bbb->getMeetingInfo($getMeetingInfoParams);
    if ($response->getReturnCode() == 'FAILED') {
        // meeting not found or already closed
        die(sprintf("%s<br>", $response->getMessage()));
    } else {
        // process $response->getRawXml();
        $meeting = $response->getRawXml();
        $meetingName = $meeting->meetingName;
        $meetingID = $meeting->meetingID;
        $internalID = $meeting->internalMeetingID;
        $createDate = $meeting->createDate;
        $moderatorPW = $meeting->moderatorPW;
        $attendeePW = $meeting->attendeePW;
        $participants = $meeting->participantCount;
        $listeners = $meeting->listenerCount;
        $videos = $meeting->videoCount;
    }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo lang('MEETING'); ?> [<?php echo $servername; ?>]</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body><center>
<div id="topStats">
	<table cellspacing="0" cellpadding="0" class="main"><tr><td>
		<div class="chartWrapper">
			<div class="chartLabel"><?php echo lang('MEETINGINFO'); ?></div>
			<div class="chartHolder">
			    <table><tr>
				<td><label for="servername" id="srv_id_label"><?php echo lang('SERVER'); ?></label></td>
				<td><input type="text" name="servername" id="servername" value="<?php echo $servername?>" size="30" readonly></td></tr><tr>
				<td><label for="meetingName" id="app_id_label"  ><?php echo lang('MEETINGNAME'); ?></label></td>
				<td><input type="text" name="meetingName" id="meetingName" size="55" value="<?php echo $meetingName; ?>"></td></tr><tr>
				<td><label for="meetingID" id="app_id_label"  ><?php echo lang('MEETINGID'); ?></label></td>
				<td><input type="text" name="meetingID" id="meetingID" size="55" value="<?php echo $meetingID; ?>"></td></tr><tr>
				<td><label for="create_date" id="mod_creat_label"  ><?php echo lang('STARTDATE'); ?></label></td>
				<td><input type="text" name="create_date" id="create_date" size="55" value="<?php echo $createDate; ?>"></td></tr><tr>
				<td><label for="internalID" id="int_id_label"  ><?php echo lang('INTERNALID'); ?></label></td>
				<td><input type="text" name="internalID" id="internalID" size="55" value="<?php echo $internalID; ?>"></td></tr><tr>
				<td><label for="moderator_password" id="mod_pass_label"  ><?php echo lang('MODERATORPW'); ?></label></td>
				<td><input type="text" name="moderator_password" id="moderator_password" size="55" value="<?php echo $moderatorPW; ?>"></td></tr><tr>
				<td><label for="attendee_password" id="mod_pass_label"  ><?php echo lang('ATTENDEEPW'); ?></label></td>
				<td><input type="text" name="attendee_password" id="attendee_password" size="55" value="<?php echo $attendeePW; ?>"></td></tr><tr>
				<td><label for="participant_count" id="mod_pass_label"  ><?php echo lang('PARTICIPANTS'); ?></label></td>
				<td><input type="text" name="participant_count" id="participant_count" size="55" value="<?php echo $participants; ?>"></td></tr><tr>
				<td><label for="listener_count" id="mod_pass_label"  ><?php echo lang('LISTENERS'); ?></label></td>
				<td><input type="text" name="listener_count" id="listener_count" size="55" value="<?php echo $listeners; ?>"></td></tr><tr>
				<td><label for="video_count" id="mod_pass_label"  ><?php echo lang('VIDEOS'); ?></label></td>
				<td><input type="text" name="video_count" id="video_count" size="55" value="<?php echo $videos; ?>"></td></tr><tr>
<?php
			        $option = '';
			        $i = 0;
			        foreach ($meeting->attendees->attendee as $attendee) {
			            $i++;
			            $option = $option . '<option>'.$i.'. '.$attendee->fullName.' as '.$attendee->role.'</option>';
			        }
			        printf('<td>'.lang('USERS').'</td><td><select name="Users" size="5" style="width:347px;">'.$option.'</select></td></tr><tr>');
?>
			    </tr></table>
			    <br><center><form action="javascript:history.back()"><input type="submit" value="<?php echo lang('BACK'); ?>" class="bigbutton"/></form></center>
			</div>
		</div>
	</td>
	</tr></table>
</div>
</font>
</center>
</body>
</html>
