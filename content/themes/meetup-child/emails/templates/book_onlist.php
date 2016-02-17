<?php

// BOOK SESSION PARTICIPANT
function book_onlist_participant_subject($user, $event, $email) {
    return "Inscription sur liste d'attente au stage « Communication en situation d’urgence médiatique »";
}
function book_onlist_participant_template($user, $event, $email) {
  $event_start_date = new DateTime(get_post_meta($event->ID, '_EventStartDate', true));
  $date = date_i18n("l d F Y", $event_start_date->getTimestamp());

  $user_meta =  get_user_meta( $user->ID );
  $full_name = $user_meta["first_name"][0] . " " . $user_meta["last_name"][0];

  $link = get_permalink( $event->ID );

  ob_start();
?>

<p>
  Bonjour <?php echo $full_name ?>,
  Vous avez été placé sur la liste d'attente pour la formation de  «Communication en situation d’urgence médiatique | communication de crise» du <strong><?php echo $date ?></strong>.
</p>

<p>
    En cas de désistement la place vous sera automatiquement attribuée.
</p>

<p>
    Toutes les informations sur cette session du <strong><?php echo $date; ?></strong> sont disponibles <a href="<?php echo $link; ?>">ici</a>.
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
function book_onlist_responsable_subject($user, $event, $email) {
    return "Inscription sur liste d'attente au stage « Communication en situation d’urgence médiatique »";
}
function book_onlist_responsable_template($user, $event, $email) {
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
    En raison du nombre de places limités, sa candidature à été mise sur liste d'attente.<br>
    En cas de désistement son inscription ne sera définitive que lorsque vous l’aurez validée en répondant à ce mail.
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
function book_onlist_admin_subject($user, $event, $email) {
    return "Inscription sur liste d'attente au stage « Communication en situation d’urgence médiatique »";
}
function book_onlist_admin_template($user, $event, $email) {
  $event_start_date = new DateTime(get_post_meta($event->ID, '_EventStartDate', true));
  $date = date_i18n("l d F Y", $event_start_date->getTimestamp());

  $admin_url = admin_url( 'post.php?post=' . $event->ID ) . '&action=edit';
  $link = get_permalink( $event->ID );

  ob_start();
?>
<p>
    Bonjour, nous vous informons de la mise sur liste d'attente de M/Mme <?php echo $full_name ?> au stage « Communication en situation d’urgence médiatique | Communication de crise » du <strong><?php echo $date ?></strong>.
</p>

<p>
    En cas de désistement, la nouvelle place lui sera automatiquement attribuée.
</p>
<p>
    Toutes les informations sur cette session sont disponibles <a href="<?php echo $link ?>">ici</a>.
</p>

<?php
  $mail = ob_get_contents();
  ob_clean();
  return $mail;
}
