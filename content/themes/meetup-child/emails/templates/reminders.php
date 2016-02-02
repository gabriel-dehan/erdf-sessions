<?php

function reminder_week_earlier_subject($user, $event, $email) {
    return "Stage « Communication en situation d’urgence médiatique » : c’est dans 1 mois !";
}

function reminder_week_earlier_template($user, $event, $email) {
  $event_start_date = new DateTime(get_post_meta($event->ID, '_EventStartDate', true));
  $date = date_i18n("l d F Y", $event_start_date->getTimestamp());

  $user_meta =  get_user_meta( $user->ID );
  $full_name = $user_meta["first_name"][0] . " " . $user_meta["last_name"][0];

  $link = get_permalink( $event->ID );

  ob_start();
?>

<p>
    Cher participant, vous êtes attendu le <?php echo $date ?> à 9h15 au 22-30 Avenue de Wagram, 75008, dans la salle régie au rez-de-chaussée.
</p>

<p>
    <a href="<?php echo $link ?>">Cliquez-ici pour voir les informations de votre session.</a>
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

function reminder_month_earlier_subject($user, $event, $email) {
    return "Stage « Communication en situation d’urgence médiatique » : c’est la semaine prochaine !";
}

function reminder_month_earlier_template($user, $event, $email) {
  $event_start_date = new DateTime(get_post_meta($event->ID, '_EventStartDate', true));
  $date = date_i18n("l d F Y", $event_start_date->getTimestamp());

  $user_meta =  get_user_meta( $user->ID );
  $full_name = $user_meta["first_name"][0] . " " . $user_meta["last_name"][0];

  $link = get_permalink( $event->ID );

  ob_start();
?>

<p>
    Cher participant, vous êtes attendu le <?php echo $date ?> à 9h15 au 22-30 Avenue de Wagram, 75008, dans la salle régie au rez-de-chaussée.
</p>

<p>
    <a href="<?php echo $link ?>">Cliquez-ici pour voir les informations de votre session.</a>
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
