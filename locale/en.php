<?php
//********************************************************************
//* Description: English language file
//* Author: Automatix <github@unattended.ch>
//* Created at: Wed Sep  1 19:12:37 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//********************************************************************
function lang($phrase){
    static $lang = array(
        'MEETINGS' => 'Meetings',
        'USERNAME' => 'Username',
        'USERS' => 'Users',
        'MEETINGNAME' => 'Room name',
        'MEETINGID' => 'Room ID',
        'STARTDATE' => 'Start date',
        'FUNCTIONS' => 'Functions',
        'CREATEMEETING' => 'Create meeting',
        'SERVER' => 'Server'
    );
    return $lang[$phrase];
}
?>