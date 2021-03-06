<?php
function handle_notes() {
  $users_events = new ES_DB_UsersEvents;

  $event     = new stdClass;
  $event->ID = $_POST['event_id'];

  $user      = new stdClass;
  $user->ID  = $_POST['user_id'];

  $content   = $_POST['content'];

  echo $users_events->update_user_reminder($user, $event, $content);

  exit; //always call exit at the end of a WordPress ajax function
}
add_action('wp_ajax_handle_notes', 'handle_notes');
add_action('wp_ajax_nopriv_handle_notes', 'handle_notes');

function es_status_to_sentence($status) {
  $map = array(
    "pending" => "En attente",
    "onboard" => "Participant",
    "onlist"  => "Sur liste d'attente",
    "rejected" => "Refusé"
  );

  return $map[$status];
}

function es_admin_status_to_sentence($status) {
  $map = array(
    "pending" => "En attente de validation responsable",
    "onboard" => "Participants confirmés",
    "onlist"  => "Sur liste d'attente",
    "rejected" => "Participations refusées"
  );

  return $map[$status];
}



add_action('save_post', 'save_spots_limit');

function save_spots_limit($post_id){
  global $post;

  if ( $post->post_type != 'tribe_events' ) {
    return;
  }

  if ( isset($_POST['EventSpotsLimit']) ) {
    $max = $_POST['EventSpotsLimit'];
    $max = $max <= 0 ? 1 : $max;
    update_post_meta($post_id, 'event_spots_limit', $max);
  }
}

function es_participants_limit($id) {
  global $wpdb;
  $meta = get_post_meta($id);
?>
    <table id="event_limit" class="eventtable limit">
		    <thead>
			      <tr>
				        <td colspan="2" class="tribe_sectionheader">
					          <h4 id="spots">Nombre de places</h4>
                </td>
			      </tr>
		    </thead>
        <tbody>
            <tr>
                <td>
							      <input min="3" autocomplete="off" type="number" name="EventSpotsLimit" id="EventSpotsLimit" value="<?php echo $meta["event_spots_limit"][0]; ?>" />
                    <br><br>
                    <p>
                        En plus de ces <span class="event-spot-limit-value">3</span> places, <strong>1</strong> place supplémentaire est réservée à la <strong>liste d'attente</strong>.
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
<?php
}

add_action( 'tribe_events_detail_top', 'es_participants_limit' );

add_action( 'tribe_after_location_details', 'es_admin_participants' );

function es_admin_participants($event_id) {
  $is_new = $event_id == 0;

  if (!$is_new) {
    $users_events = new ES_DB_UsersEvents;
    $event     = new stdClass;
    $event->ID = $event_id;

    if (isset($_POST['subscribe-action'])) {
      global $wpdb;
      $users_events = new ES_DB_UsersEvents;

      $action  = $_POST['subscribe-action'];
      $user      = new stdClass;
      $user->ID  = $_POST['subscribe-user-id'];

      $users_events->update_user_status($user, $event, $action);
    }

    $users = $users_events->get_users_grouped_by_status($event);
  }

  ?>
<table id="event_participants" class="eventtable participants">
		<thead>
			  <tr>
				    <td colspan="2" class="tribe_sectionheader">
					      <h4 id="participants">Participants</h4>
            </td>
			  </tr>
		</thead>
    <tbody>
        <tr>
            <td>
                <?php es_render_subscription_admin_for("onboard", $users, $event_id); ?>
                <?php es_render_subscription_admin_for("pending", $users, $event_id); ?>
                <?php es_render_subscription_admin_for("onlist", $users, $event_id); ?>
                <?php es_render_subscription_admin_for("rejected", $users, $event_id); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php
}

function es_render_subscription_admin_for($status, $users, $event_id) {
?>
    <h3 class="title"><?php echo es_admin_status_to_sentence($status); ?></h3>
    <?php if (count($users[$status]) > 0) { ?>
        <table class="participants-table">
            <thead>
                <tr>
                    <th class="participant-name">Nom</th>
                    <th class="participant-email">Email</th>
                    <th class="participant-note">Note</th>
                    <th class="participant-actions">Actions</th>
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
                        <td class="user-note-container">
                            <textarea name="user-note" placeholder="Pense-bête pour ce participant" class="user-note" data-event="<?php echo $event_id ?>" data-user="<?php echo $user->ID ?>"><?php echo $user->reminder ?></textarea>
                        </td>
                        <td class="actions">
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
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="no-participant">
            Il n'y a pas d'utilisateur <?php echo strtolower(es_status_to_sentence($status)); ?>
        </div>
    <?php } ?>
<?php
}

function es_render_action_forms($user, $actions) { ?>
    <form method="POST" action=""></form> <!-- first form seems to be parsed out ? -->
    <?php if ( in_array("onboard", $actions) ) { ?>
        <form method="POST" action="#participants">
            <input type="hidden" name="subscribe-action" value="onboard">
            <input type="hidden" name="subscribe-user-id" value="<?php echo $user->ID; ?>">
            <button class="action-onboard">
                <span class="dashicons dashicons-yes"
                      data-toggle="tooltip"
                      data-placement="top"
                      title="Accepter"></span>
            </button>
        </form>
    <?php } ?>
    <?php if ( in_array("onlist", $actions) ) { ?>
        <form method="POST" action="#participants">
            <input type="hidden" name="subscribe-action" value="onlist">
            <input type="hidden" name="subscribe-user-id" value="<?php echo $user->ID; ?>">
            <button class="action-onlist">
                <span class="dashicons dashicons-clock"
                      data-toggle="tooltip"
                      data-placement="top"
                      title="Mettre sur liste d'attente"></span>
            </button>
        </form>
    <?php } ?>
    <?php if ( in_array("rejected", $actions) ) { ?>
        <form method="POST" action="#participants">
            <input type="hidden" name="subscribe-action" value="rejected">
            <input type="hidden" name="subscribe-user-id" value="<?php echo $user->ID; ?>">
            <button class="action-rejected">
                <span class="dashicons dashicons-no-alt"
                      data-toggle="tooltip"
                      data-placement="top"
                      title="Refuser"></span>

            </button>
        </form>
    <?php } ?>
<?php } ?>
