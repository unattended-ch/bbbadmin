<?php
//********************************************************************
//* Description: Configuration file for bbbadmin
//* Author: Automatix <github@unattended.ch>
//* Created at: Tue Aug 31 14:15:10 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//********************************************************************
global $debug;
global $copyright;
global $server;
global $rooms;
global $logout;
global $access;
global $refresh;

$database = "";
if ($database == "")
{
    // Configuration without database
    //
    // Debug mode
    // 0=Off 1=On
    $debug = 1;
    // Time in seconds for refresh
    $refresh = 30;
    // copyright
    $copyright = "© 2021 unattended.ch";
    // BBB servers
    $server = array(1 => "room.domain.com", 2 => "room2.domain.com");
    // Logout URLs
    $logout = array(1 => "http://localhost/bbb/bbb_index.php?serverid=".$serverid, 2 => "https://room.domain.com/", 3 => "https://room2.domain.com/");
    // Logo URLs
    $logos  = array(1 => "https://room.domain.com/favicon.ico", 2 => "https://room2.domain.com/favicon.ico");
    // Passwords 1=Moderator 2=Attendee
    // This is the default when no room password is defined
    $access = array(1 => "ModeratorPassword", 2 => "AttendeePassword");
    // Rooms 
    // name = Name of room with copyright
    // id   = Room id for BBB
    // acc  = Attendee password
    $rooms[1] = array("name" => "Bastelraum ".$copyright, "id" => "Bastelraum", "acc" => "AttendeePassword");
    $rooms[2] = array("name" => "Startraum ".$copyright, "id" => "Startraum", "acc" => "AttendeePassword");
    $rooms[3] = array("name" => "Gastraum ".$copyright, "id" => "Gastraum", "acc" => "AttendeePassword");
    // Load BBB values from Apache environment variable
    // For every server you must define Apache environment variable BBB_SECRET1 and BBB_SERVER1_BASE_URL
    // Replace 1 with the index in äserver
    if ($serverid == '1')
    {
        apache_setenv('BBB_SECRET', apache_getenv('BBB_SECRET1'));
        apache_setenv('BBB_SERVER_BASE_URL', apache_getenv('BBB_SERVER1_BASE_URL'));
        $servername = $server[1];
        $sel1 = 'selected';
        $sel2 = '';
    }
    else
    {
        apache_setenv('BBB_SECRET', apache_getenv('BBB_SECRET2'));
        apache_setenv('BBB_SERVER_BASE_URL', apache_getenv('BBB_SERVER2_BASE_URL'));
        $servername = $server[2];
        $sel1 = '';
        $sel2 = 'selected';
    }
}
else
{
    // Configuration with database
    // mySql script can be found in [./sql/bbbadmin.sql]
    //
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    // mysqli('servername', 'username', 'password', 'database')
    $mysqli = new mysqli("localhost", "bbbadmin", "bbbadmin_password", "bbbadmin");
    if ($mysqli->connect_errno)
        die("Connection failed: " . $mysqli->connect_error);
    $mysqli->set_charset("utf8");

    // Load configuration
    $result = $mysqli->query("SELECT * FROM config");
    if($result)
    {
        while ($row = $result->fetch_object()){
            //printf("$%s=%s<br>", $row->name, $row->val);
            if (strpos($row->name, "."))
            {
                $newrow = preg_split("/[.]/", $row->name);
                ${$newrow[0]}[$newrow[1]] = $row->val;
            }
            else
                ${$row->name} = $row->val;
        }
        // Free result set
        $result->close();
    }

    // Load servers
    // With mysql database the Apache environment variables are loaded from the database
    // There is no need to define it in Apache
    //
    $result = $mysqli->query("SELECT * FROM server");
    if($result)
    {
        while ($row = $result->fetch_object()){
            if ($serverid == $row->id)
            {
                apache_setenv('BBB_SECRET', $row->secret);
                apache_setenv('BBB_SERVER_BASE_URL', $row->url);
                $servername = $row->name;
                ${'sel'.$row->id} = 'selected';
            }
            $server[$row->id] = $row->name;
        }
        // Free result set
        $result->close();
    }

    // Load rooms
    $result = $mysqli->query("SELECT * FROM rooms");
    if($result)
    {
        while ($row = $result->fetch_object()){
            $rooms[$row->id]['name'] = $row->name.' '.$copyright;
            $rooms[$row->id]['id'] = $row->roomid;
            $rooms[$row->id]['acc'] = $row->access;
        }
        // Free result set
        $result->close();
    }

    // Load logout urls
    $result = $mysqli->query("SELECT * FROM logouturl");
    if($result)
    {
        while ($row = $result->fetch_object()){
            $logout[$row->id] = str_replace("\$serverid", $serverid, $row->url);
        }
        // Free result set
        $result->close();
    }

    // Load logo urls
    $result = $mysqli->query("SELECT * FROM logos");
    if($result)
    {
        while ($row = $result->fetch_object()){
            $logos[$row->id] = $row->url;
        }
        // Free result set
        $result->close();
    }
}
error_reporting($debug);
date_default_timezone_set('UTC');
?>
