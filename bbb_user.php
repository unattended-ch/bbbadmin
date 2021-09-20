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
$exitURL = '';
$userName = '';
if (isset($_GET['sid']))
    $serverid = $_GET['sid'];
if (isset($_GET['mID']))
    $meetingID = $_GET['mID'];
if (isset($_GET['usr']))
    $userName = $_GET['usr'];
if (isset($_GET['exit']))
    $exitURL = $_GET['exit'];
if (isset($_GET['join']))
    $joinDirekt = $_GET['join'];
require_once('./bbb_load.php');
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\JoinMeetingParameters;
$server = ServerSelect($sel1, $sel2);

function printMessage($msg)
{
    $ret = '<html>';
    $ret = $ret . '    <head>';
    $ret = $ret . '        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
    $ret = $ret . '        <title>'.$msg.'</title>';
    $ret = $ret . '        <link rel="stylesheet" href="css/style.css">';
    $ret = $ret . '        <link rel="stylesheet" href="css/bootstrap.min.css">';
    $ret = $ret . '        <script src="js/bootstrap.min.js"></script>';
    $ret = $ret . '        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
    $ret = $ret . '    </head>';
    $ret = $ret . '    <body>';
    $ret = $ret . '<div class="dim" runat="server"><span class="msg"><h1>'.$msg.'</h1></span><br></div>';
    $ret = $ret . '    </body>';
    $ret = $ret . '</html>';
    printf($ret);
}

if ($exitURL !== '')
{
    printMessage(lang('SEEYOU'));
    die();
}

try {
        $bbb = new BigBlueButton($bbburl, $bbbsalt);
    }
catch (Exception $e) {
        // Tell nothing and stop
        die();
    }
finally
    {
        $response = $bbb->getMeetings();
        $meeting = LoadMeeting($response, $meetingID);
    }

if ($meeting == '')
{
    // Tell nothing and stop
    die();
}
if (!is_object($meeting))
{
    // Tell nothing and stop
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
        printMessage(lang('NOUSER'));
    }
}
else if(isset($_GET['join']))
{
    if ($userName !== '')
    {
        $joinMeetingParams = new JoinMeetingParameters($meetingID, $userName, $meeting->attendeePW->__toString());
        $joinMeetingParams->setRedirect(true);
        $url = $bbb->getJoinMeetingURL($joinMeetingParams);
        header( "Location: $url" );
    } else {
        printMessage(lang('NOUSER'));
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
        printMessage(lang('NOUSER'));
    }
}
else
{
    // Yep meeting exists !
    $meetingName = $meeting->meetingName;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo lang('JOINMEETING'); ?></title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/bootstrap.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
    <div id="topUsers">
	<center><table class="mainbig"><tr><td>
		<div class="chartWrapper">
			<div class="chartLabelBig"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;$meetingName&nbsp;&nbsp;&nbsp;&nbsp;" ?></div>
			<div class="chartHolder">
			    <table class="mainbig"><tr><form action=""  method="POST"><center><table style="text-align:center;" width="100%"><tr><br>
		                <td style="text-align:right;"><label for="userName" id="app_name_label" class="inputbig"><?php echo lang('USERNAME'); ?></label></td>
		                <td><input class="inputbig" type="text" name="userName" id="userName" size="25" value="<?php echo $userName ?>"></td></tr><tr>
	                        </table></center><br>
		                <center><input class="inputbig btn btn-primary btn-lg" type="submit" name="Submit" value="<?php echo lang('JOINMEETING'); ?>"></center>
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
