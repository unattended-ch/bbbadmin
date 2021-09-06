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
        'MEETINGS' => 'Réunions',
        'USERNAME' => 'Nom d`utilisateur',
        'USERS' => 'Utilisateurs',
        'JOIN' => 'Rejoindre',
        'MODERATOR' => 'Modérateur',
        'CREATEMEETING' => 'Créer une réunion',
        'JOINMEETING' => 'Rejoindre la réunion',
        'STOPMEETING' => 'Arrêter la réunion',
        'RECORDINGS' => 'Enregistrements',
        'RECORDING' => 'Enregistrement',
        'RECORDDATE' => 'Date d`enregistrement',
        'VIEWRECORDING' => 'Voir l`enregistrement',
        'DELETERECORDING' => 'Supprimer l`enregistrement',
        'MEETINGNAME' => 'Nom de la salle',
        'MEETINGINFO' => 'Informations sur la réunion',
        'MEETINGID' => 'Identifiant de la salle',
        'MEETING' => 'Salle',
        'INTERNALID' => 'Identifiant interne',
        'STARTDATE' => 'Date de début',
        'FUNCTIONS' => 'Les fonctions',
        'MODERATORPW' => 'Mot de passe modérateur',
        'ATTENDEEPW' => 'Mot de passe participant',
        'PARTICIPANTS' => 'Participants',
        'LISTENERS' => 'Les auditeurs',
        'VIDEOS' => 'Vidéos',
        'DURATION' => 'Durée en minutes',
        'LOGOUTURL' => 'URL de déconnexion',
        'LOGOURL' => 'URL du logo',
        'JOINURLS' => 'Joindre des URL',
        'PRESENTATION' => 'Présentation PDF',
        'MUTEONSTART' => 'Couper le son au démarrage',
        'EXPORTJOIN' => 'Exporter l`URL de jointure',
        'DISPLAYONLY' => 'Afficher uniquement l`URL',
        'SERVER' => 'Serveur',
        'BACK' => 'Retourner',
        'NOUSER' => 'ERREUR : Aucun nom d`utilisateur spécifié !',
        'EMAIL' => 'Adresse e-mail',
        'SENDMAIL' => 'Envoyer un e-mail',
        'SENDMEETING' => 'Envoyer une invitation',
        'SEND' => 'Envoyer',
        'INVITE' => 'Invitation de réunion',
        'INVITATION' => 'Invitation',
        'SEEYOU' => 'À la prochaine...',
        'VIEW' => 'Vue',
        'DIRECTLINK' => 'Lien direct',
        'ERRMAILADR' => 'ERREUR : Aucun e-mail spécifié !',
        'CONNECTIONFAILED' => 'La connexion a échoué: '
    );
    return $lang[$phrase];
}
?>
