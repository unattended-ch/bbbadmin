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
require_once('./bbb_load.php');
use BigBlueButton\BigBlueButton;
if (isset($_POST['Back']))
{
    $url = './index.php?sid='.$serverid;
    printf('<script type="text/javascript">location.replace("%s")</script>', $url);
}
else if (isset($_POST['Submit']))
{
    $cfg = $GLOBALS['cfg'];
    $meetingID = $_POST['meetingID'];
    $meetingName = $_POST['meetingName'];
    $url = './bbb_send.php?sid='.$serverid.'&mID='.$meetingID.'&mName='.$meetingName;
    printf('<script type="text/javascript">location.replace("%s")</script>', $url);
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
    <body onload="setMetName(); setMetID();">
    <script>
        function setMetName() {
            document.getElementById('meetingName').setAttribute('value', document.getElementById('meetingNameSel').value);
            document.getElementById('meetingIDSel').selectedIndex = document.getElementById('meetingNameSel').selectedIndex;
            document.getElementById('meetingID').setAttribute('value', document.getElementById('meetingIDSel').value);
        }
        function setMetID() {
            document.getElementById('meetingID').setAttribute('value', document.getElementById('meetingIDSel').value);
        }
    </script>
    <div id="topStats">
        <center><table class="mainbig"><tr><td>
		<div class="chartWrapper">
			<div class="chartLabel"><?php echo lang('INVITE'); ?></div>
			<div class="chartHolder">
			    <table class="mainbig"><tr><form action=""  method="POST"><center><table><tr>
		                <td><label for="servername" id="srv_id_label">Server </label></td>
		                <td><input type="text" name="servername" id="servername" value="<?php echo $servername?>" size="30" readonly></td></tr><tr>
		                <td><br><label for="meetingName" id="app_name_label"><?php echo lang('MEETINGNAME'); ?></label></td>
		                <td><?php printf(ServerRoomName())?><br>
		                <input type="text" name="meetingName" id="meetingName" size="35"></td></tr><tr>
		                <td><br><label for="meetingID" id="app_id_label"><?php echo lang('MEETINGID'); ?></label></td>
		                <td><?php printf(ServerRoomId())?><br>
		                <input type="text" name="meetingID" id="meetingID" size="35"></td></tr><tr>
	                        </table></center><br>
		                <center>
				    <input class="inputbig" type="submit" name="Submit" value="<?php echo lang('SEND'); ?>"> 
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
