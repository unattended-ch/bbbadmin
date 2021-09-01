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
if (isset($_POST['server_id'])) {
    $serverid = $_POST['server_id'];
}
if (isset($_GET['server_id'])) {
    $serverid = $_GET['server_id'];
} else {
    $serverid = 1;
}
require_once('./bbb_load.php');
$server = ServerSelect($sel1, $sel2);

try {
        $bbb = new BigBlueButton();
    }
catch (Exception $e) {
	printf('ERROR: %s',$e->getMessage());
	exit(99);
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
			<div class="chartLabel">Meetings<?php echo $server ?></div>
			<div class="chartHolder">
			    <table class="chartHolder" border="1"><tr><th>Username</th><th>Room name</th><th>Meeting ID</th><th>Start date</th><th>Users</th><th>Functions</th></tr>
<?php
			    if (isset($response)) {
			    if ($response->getReturnCode() == 'SUCCESS') {
			        if(!empty($response->getRawXml()->meetings->meeting)) {
				    foreach ($response->getRawXml()->meetings->meeting as $meeting) {
					printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $meeting->attendees->attendee->fullName ,$meeting->meetingName, $meeting->meetingID ,$meeting->createDate, $meeting->participantCount, LinkFunctions('1', $serverid, $meeting));
				    }
			        }
				else
				    printf('<tr><td colspan="6" style="text-align:center;">No running meetings found !</td></tr>');
			    }
			    else
			    {
				printf("<br><center>%s</center><br>", $response->getMessage());
			    }
			    }
			    else
				printf("<br><center>%s</center><br>", 'Server not found !');
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
