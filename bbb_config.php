<?php
//********************************************************************
//* Description: Configuration file for bbbadmin
//* Author: Automatix <github@unattended.ch>
//* Created at: Tue Aug 31 14:15:10 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//********************************************************************
    global $cfg;
    $cfg = LoadConfigFile();
    $language = $cfg->language;
    $debug = $cfg->debug;
    $bbburl = '';
    $bbbsalt = '';
    //
    // Load BBB values from Apache environment variable
    // For every server you must define Apache environment variable BBB_SECRET1 and BBB_SERVER1_BASE_URL
    // Replace 1 with the index in äserver
    //
    if ($serverid == '1')
    {
        if ($cfg->setenv == '1')
        {
            apache_setenv('BBB_SECRET', apache_getenv('BBB_SECRET1'));
            apache_setenv('BBB_SERVER_BASE_URL', apache_getenv('BBB_SERVER1_BASE_URL'));
        }
        else
        {
            $bbburl = ServerUrl($serverid);
            $bbbsalt = ServerSalt($serverid);
        }
        $sel1 = 'selected';
        $sel2 = '';
    }
    else
    {
        if ($cfg->setenv == '1')
        {
            apache_setenv('BBB_SECRET', apache_getenv('BBB_SECRET2'));
            apache_setenv('BBB_SERVER_BASE_URL', apache_getenv('BBB_SERVER2_BASE_URL'));
        }
        else
        {
            $bbburl = ServerUrl($serverid);
            $bbbsalt = ServerSalt($serverid);
        }
        $sel1 = '';
        $sel2 = 'selected';
    }
    $servername = ServerName($serverid);
    if ($cfg->debug !== '0')
    {
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        ini_set("display_errors", 1);
    }
    date_default_timezone_set('UTC');
?>
