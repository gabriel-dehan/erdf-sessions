<?php

function es_status_to_sentence($status) {
  $map = array(
    "pending" => "En attente",
    "onboard" => "Participant",
    "onlist"  => "Sur liste d'attente",
    "rejected" => "Refusé"
  );

  return $map[$status];
}


add_action( 'tribe_after_location_details', 'es_admin_participants' );

function es_admin_participants($id) {
  $is_new = $id == 0;

  if (!$is_new) {
    $users_events = new ES_DB_UsersEvents;
    $event     = new stdClass;
    $event->ID = $id;

    $users = $users_events->get_users_grouped_by_status($event);
  }

  ?>
<table id="event_organizer" class="eventtable">
		<thead>
			  <tr>
				    <td colspan="2" class="tribe_sectionheader">
					      <h4>Participants</h4>
            </td>
			  </tr>
		</thead>
    <tbody>
        <tr>
            <td>
                <?php es_render_subscription_admin_for("pending", $users); ?>
                <?php es_render_subscription_admin_for("onboard", $users); ?>
                <?php es_render_subscription_admin_for("onlist", $users); ?>
                <?php es_render_subscription_admin_for("rejected", $users); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php
}

function es_render_subscription_admin_for($status, $users) {
?>
    <h3><?php es_status_to_sentence($status); ?></h3>
    <table>
        <thead>
            <tr>
                <td>Nom de l'utilisateur</td>
                <td>Email</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users[$status] as $user) { ?>
                <?php hd($user);die(); ?>
                <tr>
                    <td>
                        <?php echo $user->firstName . ' ' . $user->lastName; ?>
                    </td>
                    <td>
                        <?php echo $user->email; ?>
                    </td>
                    <td>
                        Something something
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
}
