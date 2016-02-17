<?php

// BOOK SESSION PARTICIPANT
function book_session_participant_subject($user, $event, $email) {
    return "Inscription formation « Communication en situation d’urgence médiatique »";
}

function book_session_participant_template($user, $event, $email) {
  $event_start_date = new DateTime(get_post_meta($event->ID, '_EventStartDate', true));
  $date = date_i18n("l d F Y", $event_start_date->getTimestamp());

  $user_meta =  get_user_meta( $user->ID );
  $full_name = $user_meta["first_name"][0] . " " . $user_meta["last_name"][0];

  ob_start();
?>

<p>
    Bonjour <?php echo $full_name ?>, nous avons le plaisir de vous confirmer votre inscription au stage «Communication en situation d’urgence médiatique | Communication de crise » du <strong><?php echo $date ?></strong>.
</p>
<p>
    Cette inscription sera définitive lorsque votre responsable l’aura validée par retour de mail auprès du service communication.
</p>

<p>
    Cordialement,
</p>

<p>
<?php echo es_mail_sign(); ?>
</p>

<?php

  $mail = ob_get_contents();
  ob_clean();
  return $mail;
}

// BOOK SESSION RESPONSABLE
function book_session_responsable_subject($user, $event, $email) {
    return "Inscription formation « Communication en situation d’urgence médiatique »";
};
function book_session_responsable_template($user, $event, $email) {
  $event_start_date = new DateTime(get_post_meta($event->ID, '_EventStartDate', true));
  $date = date_i18n("l d F Y", $event_start_date->getTimestamp());

  $user_meta =  get_user_meta( $user->ID );
  $full_name = $user_meta["first_name"][0] . " " . $user_meta["last_name"][0];

  ob_start();
?>

<p>
    Bonjour,<br>
    Nous vous informons que M/Mme <?php echo $full_name ?> s’est inscrit(e) pour participer au stage « Communication en situation d’urgence médiatique | Communication de crise » le <strong><?php echo $date ?></strong>.
</p>
<p>
    Son inscription sera définitive lorsque vous l’aurez validée en répondant à ce mail.
</p>
<p>
    En raison du nombre de places très limité (4-5) par session, de la qualité et de son coût, merci de veiller à la présence de votre collaborateur à cette date !
</p>

<p>
    Par avance nous vous en remercions.
</p>

<p>
<?php echo es_mail_sign(); ?>
</p>

<?php
  $mail = ob_get_contents();
  ob_clean();
  return $mail;
}

// BOOK SESSION ADMIN
function book_session_admin_subject($user, $event, $email) {
    return "Inscription formation « Communication en situation d’urgence médiatique »";
};
function book_session_admin_template($user, $event, $email) {
  $event_start_date = new DateTime(get_post_meta($event->ID, '_EventStartDate', true));
  $date = date_i18n("l d F Y", $event_start_date->getTimestamp());

  $admin_url = admin_url( 'post.php?post=' . $event->ID ) . '&action=edit';

  ob_start();
?>
<p>
    Bonjour,<br>
    Un nouveau participant s’est inscrit au stage « Communication en situation d’urgence médiatique de crise » le <strong><?php echo $date ?></strong>.
</p>
<p>
    Cette inscription sera définitive lorsque son responsable l’aura validée par retour de mail.
    Vous pourrez alors rendre cette inscription visible sur le site en cliquant <a href="<?php echo $admin_url ?>">ici</a>.
</p>
<?php
  $mail = ob_get_contents();
  ob_clean();
  return $mail;
}
