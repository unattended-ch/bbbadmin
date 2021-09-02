<?php
//********************************************************************
//* Description: French language file
//* Author: Automatix <github@unattended.ch>
//* Created at: Wed Sep  1 19:12:37 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//********************************************************************
function lang($phrase)
{
    static $lang = array(
        'MEETINGS' => 'Meetings',
        'USERNAME' => 'Username',
        'USERS' => 'Users',
        'JOIN' => 'Join',
        'MODERATOR' => 'Moderator',
        'CREATEMEETING' => 'Create meeting',
        'JOINMEETING' => 'Join meeting',
        'STOPMEETING' => 'Stop meeting',
        'RECORDINGS' => 'Recordings',
        'RECORDING' => 'Recording',
        'RECORDDATE' => 'Record date',
        'VIEWRECORDING' => 'View recording',
        'DELETERECORDING' => 'Delete recording',
        'MEETINGNAME' => 'Room name',
        'MEETINGINFO' => 'Meeting informations',
        'MEETINGID' => 'Room ID',
        'MEETING' => 'Room',
        'INTERNALID' => 'Internal ID',
        'STARTDATE' => 'Start date',
        'FUNCTIONS' => 'Functions',
        'MODERATORPW' => 'Moderator password',
        'ATTENDEEPW' => 'Attendee password',
        'PARTICIPANTS' => 'Participants',
        'LISTENERS' => 'Listeners',
        'VIDEOS' => 'Videos',
        'DURATION' => 'Duration in minutes',
        'LOGOUTURL' => 'Logout URL',
        'LOGOURL' => 'Logo URL',
        'JOINURLS' => 'Join URLs',
        'PRESENTATION' => 'Presentation PDF',
        'MUTEONSTART' => 'Mute audio on start',
        'EXPORTJOIN' => 'Export join URL',
        'DISPLAYONLY' => 'Display only URL',
        'SERVER' => 'Server',
        'BACK' => 'Back',
        'NOUSER' => 'ERROR : No username specified !',
        'CONNECTIONFAILED' => 'Connection failed: '
    );
    return $lang[$phrase];
}
?>