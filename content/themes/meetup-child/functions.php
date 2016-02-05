<?php
require('kint/Kint.class.php');
require('utils.php');
require('styles.php');
require('scripts.php');

require_once('db/es_db_users_events.php');

require_once('setup.php');
require_once('shortcodes.php');
require_once('customize-tribe-events.php');
require_once('event-manager.php');
require_once('register-handler.php');
require_once('emails/emails.php');


function es_event_find_users($event) {
  $event_manager = new EventManager($event);
  return $event_manager->find_onboard_users();
}

function es_event_get_spots($event) {
  $event_manager = new EventManager($event);
  $spots = intval($event_manager->get_spots());
  return ($spots > 0) ? $spots : 5;
}

function es_delete_user_subscriptions($user_id) {
  $users_events = new ES_DB_UsersEvents;
  $users_events->destroy_subscriptions($user_id);
}

add_action( 'delete_user', 'es_delete_user_subscriptions' );

function display_modal($text) {

    ?>
    <div class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <h3>
                        <?php echo $text; ?>
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <?php
}
//hd( _get_cron_array() );die;

//wp_clear_scheduled_hook('reminder_week_earlier');
//wp_clear_scheduled_hook('reminder_month_earlier');
//wp_clear_scheduled_hook('es_week_schedule');
//wp_clear_scheduled_hook('es_month_reminder');
//wp_clear_scheduled_hook('es_week_reminder');

/*
 * Possible solution for Single Event page 404 errors where the WP_Query has an attachment set
 * IMPORTANT: Flush permalinks after pasting this code: http://tri.be/support/documentation/troubleshooting-404-errors/
 */
function tribe_attachment_404_fix () {
  if (class_exists('TribeEvents')) {
    remove_action( 'init', array( TribeEvents::instance(), 'init' ), 10 );
    add_action( 'init', array( TribeEvents::instance(), 'init' ), 1 );
  }
}
add_action( 'after_setup_theme', 'tribe_attachment_404_fix' );

// TODO: FInish implement it adds user meta in user profile
add_action( 'show_user_profile', 'display_user_custom_hash' );
add_action( 'edit_user_profile', 'display_user_custom_hash' );

function display_user_custom_hash( $user ) { ?>
    <h3>USERMETA Fields</h3>
    <table class="form-table">
        <tr>
            <th><label>Custom Hash Key</label></th>
            <td><input type="text" value="<?php echo get_user_meta( $user->ID, 'user_custom_hash', true ); ?>" class="regular-text" readonly=readonly /></td>
        </tr>
    </table>
<?php
}
