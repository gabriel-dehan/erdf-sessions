<?php

// BOOK SESSION PARTICIPANT
function book_refused_participant_subject($user, $event, $email) {
    return "Votre inscription au stage « Communication en situation d’urgence médiatique » n'a pas été validée";
}

function book_refused_participant_template($user, $event, $email) {
  $event_start_date = new DateTime(get_post_meta($event->ID, '_EventStartDate', true));
  $date = date_i18n("l d F Y", $event_start_date->getTimestamp());

  $user_meta =  get_user_meta( $user->ID );
  $full_name = $user_meta["first_name"][0] . " " . $user_meta["last_name"][0];

  ob_start();
?>

<p>
    Bonjour, nous sommes au regret de vous informer qu’en l’absence de validation de votre responsable vous ne pourrez participer au stage « Communication en situation d’urgence médiatique | communication de crise » du <em><?php echo $date ?></em>.
</p>

<p>
    Nous vous invitons à vous rapprocher de lui pour convenir ensemble d’une autre session à laquelle vous inscrire.
</p>

<p>
    Pour choisir une autre session, <a href="<?php echo home_url() . "/events" ?>">cliquez ici</a>.
<p>
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
