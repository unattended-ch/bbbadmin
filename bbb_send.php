<?php
//********************************************************************
//* Description: Send invitation link to user
//* Author: Automatix <github@unattended.ch>
//* Created at: Tue Aug 31 16:01:06 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//********************************************************************
namespace BigBlueButton;
$serverid = $_GET['sid'];
$meetingID = $_GET['mID'];
require_once('./bbb_load.php');
use BigBlueButton\BigBlueButton;
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

    $info = ServerRoomMsg($meeting->meetingID);

function prepareMessage($cfg, $url, $meeting, $info) {
    printf($info);
    $mailtext = file_get_contents('./bbb_invite.tmpl', true);
    $mailtext = str_replace("<SENDER>", $cfg->email, $mailtext);
    $mailtext = str_replace("<MEETING>", $meeting->meetingName , $mailtext);
    $mailtext = str_replace("<MSG>", $info , $mailtext);
    $mailtext = str_replace("<URL>", $url , $mailtext);
    return($mailtext);
}

if (isset($_POST['Submit']))
{
    $info = ServerRoomMsg($meeting->meetingID);
    $srv = $cfg->invite;
    $url = 'https://'.$srv.'?sid='.$serverid.'&mID='.$meetingID;
    $cfg = $GLOBALS['cfg'];
    $recipient = $_POST['emailAddress'];
    $subject = "Meeting [".$meeting->meetingName."] ". $info;
    $header  = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset=utf-8\r\n";

    $header .= "From: ".$cfg->email."\r\n";
    $header .= "Reply-To: none\r\n";
    $text = prepareMessage($cfg, $url, $meeting, $info);
    mail($recipient, $subject, $text, $header);
    $returl = "./bbb_index.php?sid=".$serverid;
    printf('<script type="text/javascript">location.replace("%s")</script>', $returl);
}
else
{
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo lang('SENDMAIL'); ?></title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <div id="topUsers">
	<center><table class="mainbig"><tr><td>
		<div class="chartWrapper">
			<div class="chartLabelBig"><?php echo lang('SENDMAIL'); ?></div>
			<div class="chartHolder">
			    <table class="mainbig"><tr><form action=""  method="POST"><center><table style="text-align:center;" width="100%"><tr><br>
		                <td style="text-align:right;"><label for="userName" id="app_name_label" class="inputbig"><?php echo lang('EMAIL'); ?></label></td>
		                <td><input class="inputbig" type="text" name="emailAddress" id="emailAddress" size="25" value="<?php echo $userName ?>"></td></tr><tr>
	                        </table></center><br>
		                <center><input class="inputbig" type="submit" name="Submit" value="<?php echo lang('SEND'); ?>"></center>
				<br>
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
