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

add_action( 'book_session', 'notify', 10 , 2 );
