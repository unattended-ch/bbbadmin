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
if (isset($_GET['mID']))
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
        if (is_array($meeting))
            $meeting = array_to_xml($meeting);
        if (!isset($meeting->meetingID))
        {
            if (isset($_GET['mID']))
                $meeting->meetingID = $_GET['mID'];
            if (isset($_GET['mName']))
                $meeting->meetingName = $_GET['mName'];
        }
    }

if (isset($_POST['Back']))
{
    $returl = "./index.php?sid=".$serverid;
    printf('<script type="text/javascript">location.replace("%s")</script>', $returl);
}
else if (isset($_POST['Submit']))
{
    if (isset($_POST['emailAddress']) && ($_POST['emailAddress'] !== ''))
    {
        $info = ServerRoomMsg($meeting->meetingID);
        $srv = $cfg->invite;
        $cfg = $GLOBALS['cfg'];
        $url = 'https://'.$srv.'?sid='.$serverid.'&mID='.$meetingID;
        $userName = '';
        if (isset($_POST['userName']) && ($_POST['userName'] !== ''))
        {
            $userName = $_POST['userName'];
            $url =  $url . '&usr='. $userName;
        }
        if (isset($_POST['direktLink']) && ($_POST['direktLink'] == 'yes') && ($userName !== ''))
            $url = $url . '&join='.$_POST['direktLink'];
        $recipient = $_POST['emailAddress'];
        $subject = "Meeting [".$meeting->meetingName."] ". $info;
        $header  = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=utf-8\r\n";
        $header .= "From: ".$cfg->email."\r\n";
        $header .= "Reply-To: none\r\n";
        $mailtext = file_get_contents('./res/bbb_invite.tmpl', true);
        $mailtext = str_replace("<SENDER>", $cfg->email, $mailtext);
        $mailtext = str_replace("<MEETING>", $meeting->meetingName , $mailtext);
        $mailtext = str_replace("<MSG>", $info , $mailtext);
        $mailtext = str_replace("<URL>", $url , $mailtext);
        mail($recipient, $subject, $mailtext, $header);
        $returl = "./bbb_send.php?sid=".$serverid.'&mID='.$messageID.'&mName='.$messageName;
        printf('<script type="text/javascript">location.replace("%s")</script>', $returl);
    }
    else
    {
        printf(lang('ERRMAILADR'));
    }
}
else if (isset($_POST['View']))
{
    $info = ServerRoomMsg($meeting->meetingID);
    $srv = $cfg->invite;
    $cfg = $GLOBALS['cfg'];
    $url = 'https://'.$srv.'?sid='.$serverid.'&mID='.$meetingID;
    $userName = '';
    $direkt = false;
    if (isset($_POST['userName']) && ($_POST['userName'] !== ''))
    {
        $userName = $_POST['userName'];
        $url =  $url . '&usr='. $userName;
    }
    if (isset($_POST['direktLink']) && ($_POST['direktLink'] == 'yes') && ($userName !== ''))
    {
        $url = $url . '&join='.$_POST['direktLink'];
        $direkt = true;
    }
    $recipient = $_POST['emailAddress'];
    $subject = "Meeting [".$meeting->meetingName."] ". $info;
    $header  = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset=utf-8\r\n";
    $header .= "From: ".$cfg->email."\r\n";
    $header .= "Reply-To: none\r\n";
    $mailtext = file_get_contents('./res/bbb_invite.tmpl', true);
    $mailtext = str_replace("<SENDER>", $cfg->email, $mailtext);
    $mailtext = str_replace("<MEETING>", $meeting->meetingName , $mailtext);
    $mailtext = str_replace("<MSG>", $info , $mailtext);
    $mailtext = str_replace("<URL>", $url , $mailtext);
    $usermail = '<a href="mailto:'.$recipient.'?subject=Meeting ['.$meeting->meetingName.']">'.$recipient.'</a>';
    if ($direkt)
        $usermail = $usermail . '<br>Join meeting as ['.$userName.']';
    else
        $usermail = $usermail . '<br>Join over ['.$srv.']';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo lang('SENDMAIL'); ?></title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <div id="topChart"><br><br>
    <?php printf('<center><input class="inputbig" type=button value="%s" onclick="javascript:history.back()"></center><br>', lang('BACK')); ?>
    <center><table border="1" padding="5">

        <tr><td style="text-align: center;"><?php echo $usermail; ?></td></tr>
        <tr><td style="padding: 30px;"><?php Show($mailtext); ?></td></tr>
    </table><center</div></body></html>
<?php
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
    <script>
        function setLinkCheck() {
            document.getElementById("direktLink").checked = true;
        }
    </script>
    <div id="topUsers">
	<center><table class="mainbig"><tr><td>
		<div class="chartWrapper">
			<div class="chartLabelBig"><?php echo lang('SENDMAIL'); ?></div>
			<div class="chartHolder">
			    <table class="mainbig"><tr><form action=""  method="POST"><center><table style="text-align:center;" width="100%"><tr><br>
		                <td style="text-align:right;"><label for="emailAddress" class="inputbig"><?php echo lang('EMAIL'); ?></label></td>
		                <td><input class="inputbig" type="text" name="emailAddress" id="emailAddress" size="25"></td></tr><tr>
			        <td style="text-align:right;"><label for="userName" class="inputbig"><?php echo lang('USERNAME'); ?></label></td>
			        <td><input class="inputbig" type="text" name="userName" id="userName" size="25" onclick="setLinkCheck()"></td></tr><tr>
		                <td style="text-align:right;"><label class="inputbig" for="directLink"><?php echo lang('DIRECTLINK'); ?></label></td>
		                <td style="text-align:left;"><input class="inputbig" type="checkbox" id="direktLink" name="direktLink" value="yes"></td></tr><tr>
	                        </table></center><br>
		                <center>
					<input class="inputbig" type="submit" name="Submit" value="<?php echo lang('SEND'); ?>"> 
					<input class="inputbig" type="submit" name="View" value="<?php echo lang('VIEW'); ?>"> 
					<input class="inputbig" type="submit" name="Back" value="<?php echo lang('BACK'); ?>">
				</center>
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
