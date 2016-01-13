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
  if (isset($_POST['subscribe-action'])) {
    global $wpdb;
    $users_events = new ES_DB_UsersEvents;

    $action  = $_POST['subscribe-action'];
    $user_id = $_POST['subscribe-user-id'];

    $users_events->update_user_status($user_id, $action);
  }

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
    <h3><?php echo es_status_to_sentence($status); ?></h3>
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
                <tr>
                    <td>
                        <?php echo $user->first_name . ' ' . $user->last_name; ?>
                    </td>
                    <td>
                        <?php echo $user->user_email; ?>
                    </td>
                    <td>
                        <div>
                            <?php
                            if ($status == "pending") {
                              es_render_action_forms($user, ["onboard", "onlist", "rejected"]);
                            } else if ($status == "onboard") {
                              es_render_action_forms($user, ["onlist", "rejected"]);
                            } else if ($status == "onlist") {
                              es_render_action_forms($user, ["onboard", "rejected"]);
                            } else if ($status == "rejected") {
                              es_render_action_forms($user, ["onboard", "onlist"]);
                            }
                            ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
}

function es_render_action_forms($user, $actions) { ?>
    <form method="POST" action=""></form> <!-- first form seems to be parsed out ? -->
    <?php if ( in_array("onboard", $actions) ) { ?>
        <form method="POST" action="">
            <input type="hidden" name="subscribe-action" value="onboard">
            <input type="hidden" name="subscribe-user-id" value="<?php echo $user->ID; ?>">
            <button>Accepter</button>
        </form>
    <?php } ?>
    <?php if ( in_array("onlist", $actions) ) { ?>
        <form method="POST" action="">
            <input type="hidden" name="subscribe-action" value="onlist">
            <input type="hidden" name="subscribe-user-id" value="<?php echo $user->ID; ?>">
            <button>Mettre sur liste d'attente</button>
        </form>
    <?php } ?>
    <?php if ( in_array("rejected", $actions) ) { ?>
        <form method="POST" action="">
            <input type="hidden" name="subscribe-action" value="rejected">
            <input type="hidden" name="subscribe-user-id" value="<?php echo $user->ID; ?>">
            <button>Refuser</button>
        </form>
    <?php } ?>
<?php } ?>
