<?php
namespace BigBlueButton;
$serverid = $_GET['serverid'];
require_once('./bbb_load.php');
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\GetMeetingInfoParameters;


if(isset($_GET['Submit']))
{
    $bbb = new BigBlueButton();

    $meetingID = $_GET['meetingID'];
    $moderator_password = $_GET['moderator_password'];
    $getMeetingInfoParams = new GetMeetingInfoParameters($meetingID, $moderator_password);
    $response = $bbb->getMeetingInfo($getMeetingInfoParams);
    if ($response->getReturnCode() == 'FAILED') {
        // meeting not found or already closed
        printf("%s<br>", $response->getMessage());
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
    //print_r($response);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Meeting [<?php echo $servername; ?>]</title>
<link rel="stylesheet" href="style.css">
</head>
<body><center>
<div id="topStats">
	<table cellspacing="0" cellpadding="0" class="main"><tr><td>
		<div class="chartWrapper">
			<div class="chartLabel">Meeting Information</div>
			<div class="chartHolder">
			    <table><tr>
				<td><label for="servername" id="srv_id_label">Server </label></td>
				<td><input type="text" name="servername" id="servername" value="<?php echo $servername?>" size="30" readonly></td></tr><tr>
				<td><label for="meetingName" id="app_id_label"  >Meeting Name </label></td>
				<td><input type="text" name="meetingName" id="meetingName" size="50" value="<?php echo $meetingName; ?>"></td></tr><tr>
				<td><label for="meetingID" id="app_id_label"  >Meeting ID </label></td>
				<td><input type="text" name="meetingID" id="meetingID" size="50" value="<?php echo $meetingID; ?>"></td></tr><tr>
				<td><label for="create_date" id="mod_creat_label"  >Started at </label></td>
				<td><input type="text" name="create_date" id="create_date" size="50" value="<?php echo $createDate; ?>"></td></tr><tr>
				<td><label for="internalID" id="int_id_label"  >Internal ID </label></td>
				<td><input type="text" name="internalID" id="internalID" size="50" value="<?php echo $internalID; ?>"></td></tr><tr>
				<td><label for="moderator_password" id="mod_pass_label"  >Moderator password </label></td>
				<td><input type="text" name="moderator_password" id="moderator_password" size="50" value="<?php echo $moderatorPW; ?>"></td></tr><tr>
				<td><label for="attendee_password" id="mod_pass_label"  >Attendee password </label></td>
				<td><input type="text" name="attendee_password" id="attendee_password" size="50" value="<?php echo $attendeePW; ?>"></td></tr><tr>
				<td><label for="participant_count" id="mod_pass_label"  >Participants </label></td>
				<td><input type="text" name="participant_count" id="participant_count" size="50" value="<?php echo $participants; ?>"></td></tr><tr>
				<td><label for="listener_count" id="mod_pass_label"  >Listeners </label></td>
				<td><input type="text" name="listener_count" id="listener_count" size="50" value="<?php echo $listeners; ?>"></td></tr><tr>
				<td><label for="video_count" id="mod_pass_label"  >Videos </label></td>
				<td><input type="text" name="video_count" id="video_count" size="50" value="<?php echo $videos; ?>"></td></tr><tr>
<?php
    $option = '';
    $i = 0;
    foreach ($meeting->attendees->attendee as $attendee) {
        $i++;
        $option = $option . '<option>'.$i.'. '.$attendee->fullName.' as '.$attendee->role.'</option>';
    }
    printf('<td>Users</td><td><select name="Users" size="5" style="width:315px;">'.$option.'</select></td></tr><tr>');
?>
			    </tr></table>
			    <br><center><form action="javascript:history.back()"><input type="submit" value="Back" class="bigbutton"/></form></center>
			</div>
		</div>
	</td>
	</tr></table>
</div>
</font>
</center>
</body>
</html>
