<?php
//********************************************************************
//* Description: List recordings on server
//* Author: Automatix <github@unattended.ch>
//* Created at: Tue Aug 31 16:02:44 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//********************************************************************
namespace BigBlueButton;
if (isset($_POST['sid'])) {
    $serverid = $_POST['sid'];
}
if (isset($_GET['sid'])) {
    $serverid = $_GET['sid'];
}
if (isset($_POST['Back'])) {
    $serverid = $_GET['sid'];
    $url = './index.php?sid='.$serverid;
    printf('<script type="text/javascript">location.replace("%s")</script>', $url);
}

require_once('./bbb_load.php');
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\GetRecordingsParameters;

$server = ServerSelect($sel1, $sel2);
$returl = 'javascript:history.back();';
$cfg = $GLOBALS['cfg'];
$recordingParams = new GetRecordingsParameters();
$bbb = new BigBlueButton();
$response = $bbb->getRecordings($recordingParams);

if ($response->getReturnCode() == 'SUCCESS') {
    $recording_data = '';
    foreach ($response->getRawXml()->recordings->recording as $recording) {
        $meetingID = $recording->meetingID;
        $meetingName = $recording->name;
        $internalID = $recording->recordID;
        $createDate = gmdate("Y-m-d H:i:s", (int)($recording->startTime/1000));
        $duration = gmdate("H:i:s", (int)((($recording->endTime) - ($recording->startTime)) / 1000));
        $participants = $recording->participants;
        $recurl = $recording->playback->format->url;
        $functions = '<a href="'.$recurl.'" title="'.lang('VIEWRECORDING').'"><img src="./icons/explorer.ico" width="16" height="16"></a>';
        $functions = $functions . '<a href="./bbb_delrec.php?sid='.$serverid.'&rid='.$internalID.'" title="'.lang('DELETERECORDING').'"><img src="./icons/exit.ico" width="16" height="16"></a>';
        $recording_data = $recording_data . '<td>'.$meetingName.'</td><td>'.$createDate.'</td><td>'.$duration.'</td><td>'.$functions.'</td><tr>';
    }
    if ($recording_data == '')
        $recording_data = '<td colspan="4" style="text-align:center;">'.lang('NORECORDING').'</td>';
}
else
{
    die(sprintf("%s<br>", $response->getMessage()));
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo lang('RECORDINGS'); ?> [<?php echo $servername; ?>]</title>
    <meta http-equiv="refresh" content="<?php printf($cfg->refresh); ?>">
    <link rel="stylesheet" href="css/style.css">
</head>
<body><center>
<div id="topStats">
	<table cellspacing="0" cellpadding="0" class="main"><tr><td>
		<div class="chartWrapper">
			<div class="chartLabel"><?php echo lang('RECORDINGS'); ?><?php echo $server ?></div>
			<div class="chartHolder">
			    <table class="chartHolder" border="1"><tr><th><?php echo lang('MEETINGNAME'); ?></th><th><?php echo lang('RECORDDATE'); ?></th><th><?php echo lang('DURATION'); ?></th><th><?php echo lang('FUNCTIONS'); ?></th></tr><tr>
				<?php printf($recording_data); ?>
			    </tr></table>
			    <br><center><form action="" method="POST"><input type="submit" name="Back" value="<?php echo lang('BACK'); ?>" class="bigbutton"/></form></center>
			</div>
		</div>
	</td>
	</tr></table>
</div>
</font>
</center>
</body>
</html>
