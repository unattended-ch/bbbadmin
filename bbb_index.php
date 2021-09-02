<?php
//********************************************************************
//* Description: Index page of bbbadmin
//* Author: Automatix <github@unattended.ch>
//* Created at: Tue Aug 31 16:01:24 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//********************************************************************
namespace BigBlueButton;
if (isset($_GET['sid']))
    $serverid = $_GET['sid'];
if (isset($_POST['sid']))
    $serverid = $_POST['sid'];
if (!isset($serverid))
    $serverid = 1;
require_once('./bbb_load.php');
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
    }
?>
<html>
<head>
    <title>BBB Admin <?php printf($copyright); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <meta http-equiv="refresh" content="<?php printf($GLOBALS['refresh']); ?>">
</head>
<body>
<div id="topStats">
	<center><table class="main"><tr><td>
		<div class="chartWrapper">
			<div class="chartLabel"><?php echo lang('MEETINGS'); ?><?php echo $server ?></div>
			<div class="chartHolder">
			    <table class="chartHolder" border="1"><tr><th><?php echo lang('USERNAME'); ?></th><th><?php echo lang('MEETINGNAME'); ?></th><th><?php echo lang('MEETINGID'); ?></th><th><?php echo lang('STARTDATE'); ?></th><th><?php echo lang('USERS'); ?></th><th><?php echo lang('FUNCTIONS'); ?></th></tr>
<?php
			    if (isset($response)) {
			    if ($response->getReturnCode() == 'SUCCESS') {
			        if(!empty($response->getRawXml()->meetings->meeting)) {
				    foreach ($response->getRawXml()->meetings->meeting as $meeting) {
					printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $meeting->attendees->attendee->fullName ,$meeting->meetingName, $meeting->meetingID ,$meeting->createDate, $meeting->participantCount, LinkFunctions('1', $serverid, $meeting));
				    }
			        }
				else
				    printf('<tr><td colspan="6" style="text-align:center;">'.lang('NOMEETINGS').'</td></tr>');
			    }
			    else
			    {
				printf("<br><center>%s</center><br>", $response->getMessage());
			    }
			    }
			    else
				printf("<br><center>%s</center><br>", lang('NOSERVER'));
?>
			    </tr></table class="chartHolder">
			    <?php printf("<br><center>%s</center><br>", LinkFunctions('0', $serverid, $meeting)); ?>
			</div>
		</div>
	</td>
	</tr></table></center>
</div>
</font>
</body>
</html>
