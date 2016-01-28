<?php

// BOOK SESSION PARTICIPANT
function book_session_participant_subject($user, $event, $email) {
    return "Votre participation a bien été enregistrée !";
}

function book_session_participant_template($user, $event, $email) {
  ob_start();
?>

<h1>
  BIENVENU LOL
</h1>
LOLOLlolLOL
<ul
    <li>lol</li>
</ul>
<?php

  $mail = ob_get_contents();
  ob_clean();
  return $mail;
}

// BOOK SESSION RESPONSABLE
function book_session_responsable_subject($user, $event, $email) {
    return "Veuillez valider l'inscription de " . $user->first_name . " " . $user->last_name;
};
function book_session_responsable_template($user, $event, $email) {
  ob_start();
?>

HELLO

<?php
  $mail = ob_get_contents();
  ob_clean();
  return $mail;
}
