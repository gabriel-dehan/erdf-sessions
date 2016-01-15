<?php
require('kint/Kint.class.php');
require('utils.php');
require('styles.php');
require('scripts.php');

require_once('db/es_db_users_events.php');

require_once('setup.php');
require_once('customize-tribe-events.php');
require_once('event-manager.php');
require_once('register-handler.php');

function es_event_find_users($event) {
  $event_manager = new EventManager($event);
  return $event_manager->find_onboard_users();
}

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
