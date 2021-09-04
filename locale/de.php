<?php
//********************************************************************
//* Description: German language file
//* Author: Automatix <github@unattended.ch>
//* Created at: Wed Sep  1 19:12:37 UTC 2021
//*
//* Copyright (c) 2021 Automatix  All rights reserved.
//*
//********************************************************************
function lang($phrase)
{
    static $lang = array(
        'MEETINGS' => 'Sitzungen',
        'USERNAME' => 'Benutzername',
        'USERS' => 'Benutzer',
        'JOIN' => 'Verbinden',
        'MODERATOR' => 'Moderator',
        'CREATEMEETING' => 'Sitzung erstellen',
        'JOINMEETING' => 'Sitzung verbinden',
        'STOPMEETING' => 'Sitzung stoppen',
        'RECORDINGS' => 'Aufnahmen',
        'RECORDING' => 'Aufnahme',
        'RECORDDATE' => 'Aufnahmedatum',
        'NORECORDING' => 'Keine Aufnahmen gefunden !',
        'VIEWRECORDING' => 'Aufnahme anzeigen',
        'DELETERECORDING' => 'Aufnahme löschen',
        'MEETINGNAME' => 'Raumname',
        'MEETINGINFO' => 'Sitzungsinformationen',
        'MEETINGID' => 'Raum ID',
        'MEETING' => 'Raum',
        'INTERNALID' => 'Interne ID',
        'STARTDATE' => 'Startdatum',
        'FUNCTIONS' => 'Funktionen',
        'MODERATORPW' => 'Moderator passwort',
        'ATTENDEEPW' => 'Teilnehmer passwort',
        'PARTICIPANTS' => 'Teilnehmer',
        'LISTENERS' => 'Zuhörer',
        'VIDEOS' => 'Videos',
        'DURATION' => 'Dauer',
        'DURATIONMIN' => 'Dauer in minuten',
        'LOGOUTURL' => 'Abmelde URL',
        'LOGOURL' => 'Logo URL',
        'JOINURLS' => 'Verbindungs URLs',
        'PRESENTATION' => 'Presentation PDF',
        'MUTEONSTART' => 'Mikrofon stumm beim start',
        'EXPORTJOIN' => 'Export Verbindungs URL',
        'DISPLAYONLY' => 'Nur URL anzeigen',
        'SERVER' => 'Server',
        'BACK' => 'Zurück',
        'NOMEETINGS' => 'Keine laufenden Sitzungen gefunden !',
        'NOUSER' => 'FEHLER : Kein Benutzername angegeben !',
        'NOSERVER' => 'Server nicht gefunden !',
        'EMAIL' => 'Email adresse',
        'SENDMAIL' => 'Sende email',
        'SEND' => 'Senden',
        'INVITE' => 'Sitzungs-Einlandung',
        'SEEYOU' => 'Bis zum nächsten mal...',
        'VIEW' => 'Anzeigen',
        'ERRMAILADR' => 'FEHLER: Keine email Adresse angegeben!',
        'CONNECTIONFAILED' => 'Verbindungsfehler: '
    );
    return $lang[$phrase];
}
?>
