<?php

/*
Participants:
- Accusé reception demande d’inscription (P)
- Si utilisateur change de statut, mail qui va avec
- Reminder Mois - 1
- Reminder S - 1 + Indications logistiques

Responsable & Gestionnaire:
- Informations users apres inscription pour confirmation participation
- Si utilisateur passe en OK -> Mail avec informations
*/

// USE call_user_func

// Accusé de reception demande d'inscription TO participant
add_action( 'book_session_participant', 'notify', 10 , 3 );
// Accusé de reception demande de val au responsable
add_action( 'book_session_responsable', 'notify', 10 , 3 );
