<?php
namespace BigBlueButton;
if (isset($_GET['server_id'])) {
    $serverid = $_GET['server_id'];
}
if (isset($_GET['serverid'])) {
    $serverid = $_GET['serverid'];
}
if (isset($_POST['server_id'])) {
    $serverid = $_POST['server_id'];
}
require_once('./bbb_load.php');
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\GetRecordingsParameters;

$server = ServerSelect($sel1, $sel2);
$recordingParams = new GetRecordingsParameters();
$bbb = new BigBlueButton();
$response = $bbb->getRecordings($recordingParams);

if ($response->getReturnCode() == 'SUCCESS') {
    //printf("%s<br>", $response->getMessage());
    $recording_data = '';
    foreach ($response->getRawXml()->recordings->recording as $recording) {
        //print_r($recording);
        $meetingID = $recording->meetingID;
        $meetingName = $recording->name;
        $internalID = $recording->recordID;
        $createDate = gmdate("Y-m-d H:i:s", (int)($recording->startTime/1000));
        $participants = $recording->participants;
        $recurl = $recording->playback->format->url;
        $functions = '<a href="'.$recurl.'" title="View recording"><img src="./explorer.ico" width="16" height="16"></a>';
        $functions = $functions . '<a href="./bbb_delrec.php?recordid='.$internalID.'" title="Delete recording"><img src="./exit.ico" width="16" height="16"></a>';
        $recording_data = $recording_data . '<td>'.$meetingName.'</td><td>'.$createDate.'</td><td>'.$functions.'</td><tr>';
    }
    if ($recording_data == '')
        $recording_data = '<td colspan="3" style="text-align:center;">No recordings found !</td>';
}
else
{
    printf("%s<br>", $response->getMessage());
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Recordings [<?php echo $servername; ?>]</title>
    <meta http-equiv="refresh" content="<?php printf($GLOBALS['refresh']); ?>">
    <link rel="stylesheet" href="style.css">
</head>
<body><center>
<div id="topStats">
	<table cellspacing="0" cellpadding="0" class="main"><tr><td>
		<div class="chartWrapper">
			<div class="chartLabel">Recordings<?php echo $server ?></div>
			<div class="chartHolder">
			    <table class="chartHolder" border="1"><tr><th>Meeting Name</th><th>Record Date</th><th>Functions</th></tr><tr>
				<?php printf($recording_data); ?>
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