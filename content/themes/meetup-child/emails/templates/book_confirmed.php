<?php

// BOOK SESSION PARTICIPANT
function book_confirmed_participant_subject($user, $event, $email) {
    return "Validation d'inscription au stage « Communication en situation d’urgence médiatique »";
}

function book_confirmed_participant_template($user, $event, $email) {
  $event_start_date = new DateTime(get_post_meta($event->ID, '_EventStartDate', true));
  $date = date_i18n("l d F Y", $event_start_date->getTimestamp());

  $user_meta =  get_user_meta( $user->ID );
  $full_name = $user_meta["first_name"][0] . " " . $user_meta["last_name"][0];

  $link = get_permalink( $event->ID );

  ob_start();
?>

<p>
  Bonjour <?php echo $full_name ?>, et toutes nos félicitations ! <br>
  Vous participerez bien au stage «Communication en situation d’urgence médiatique | communication de crise» du <strong><?php echo $date ?></strong>.
</p>

<p>
    Votre inscription est désormais définitive.
</p>

<p>
    En raison du nombre de place très limité merci de réserver cette disponibilité dans votre agenda.
</p>

<p>
    Toutes les informations sur votre session du <strong><?php echo $date; ?></strong> sont disponibles <a href="<?php echo $link; ?>">ici</a>.
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

// BOOK SESSION RESPONSABLE
function book_confirmed_responsable_subject($user, $event, $email) {
    return "Validation d'inscription au stage « Communication en situation d’urgence médiatique »";
};
function book_confirmed_responsable_template($user, $event, $email) {
  $event_start_date = new DateTime(get_post_meta($event->ID, '_EventStartDate', true));
  $date = date_i18n("l d F Y", $event_start_date->getTimestamp());

  $user_meta =  get_user_meta( $user->ID );
  $full_name = $user_meta["first_name"][0] . " " . $user_meta["last_name"][0];

  ob_start();
?>

<p>
    Bonjour, merci d’avoir validé la participation au stage « Communication en situation d’urgence médiatique | Communication de crise » du <strong><?php echo $date ?></strong> de M/Mme <?php echo $full_name ?>.
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
function book_confirmed_admin_subject($user, $event, $email) {
    return "Validation d'inscription au stage « Communication en situation d’urgence médiatique »";
};
function book_confirmed_admin_template($user, $event, $email) {
  $event_start_date = new DateTime(get_post_meta($event->ID, '_EventStartDate', true));
  $date = date_i18n("l d F Y", $event_start_date->getTimestamp());

  $admin_url = admin_url( 'post.php?post=' . $event->ID ) . '&action=edit';
  $link = get_permalink( $event->ID );

  ob_start();
?>
<p>
    Bonjour, nous vous informons que l'inscription de M/Mme <?php echo $full_name ?> au stage « Communication en situation d’urgence médiatique | Communication de crise » du <strong><?php echo $date ?></strong> a bien été validée.
</p>
<p>
    Toutes les informations sur cette session sont disponibles <a href="<?php echo $link ?>">ici</a>.
</p>

<?php
  $mail = ob_get_contents();
  ob_clean();
  return $mail;
}
