<?php
namespace BigBlueButton;
$serverid = $_GET['serverid'];
$recordid = $_GET['recordid'];
require_once('./bbb_load.php');
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\DeleteRecordingsParameters;

$server = ServerSelect($sel1, $sel2);
$recordingParams = new DeleteRecordingsParameters($recordid);
$bbb = new BigBlueButton();
$response = $bbb->deleteRecordings($recordingParams);

if ($response->getReturnCode() == 'SUCCESS') {
    Show($response);
}
else
{
    printf("%s<br>", $response->getMessage());
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>