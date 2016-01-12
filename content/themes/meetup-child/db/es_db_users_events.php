<?php
/**
 * UsersEvents DB class
 * This class is for interacting with the user's events database table
 */

class ES_DB_UsersEvents {

	/**
	 * Get things started
	 *
	 * @access  public
	 * @since   1.0.0
	 */
	public function __construct() {
    global $wpdb;

    $this->table_name = $wpdb->prefix . 'users_events';
		$this->primary_key = 'id';
	}

	/**
	 * Get columns and formats
	 *
	 * @access  public
	 * @since   1.0.0
	 */
	public function get_columns() {
		return array(
			'time'                    => '%s',
			'user_id'                 => '%d',
			'event_id'                => '%d'
		);
	}

  public function user_subscribed($user, $event) {
    return count($this->fetch_subscription($user, $event));
  }

  public function fetch_subscription($user, $event) {
    global $wpdb;

    if ( empty($user->ID) || !is_numeric($user->ID) ) {
      return false;
    }
    if ( empty($event->ID) || !is_numeric($event->ID) ) {
      return false;
    }

    return $wpdb->get_results("SELECT * FROM " . $this->table_name . " WHERE user_id = " . $user->ID . " AND event_id = " . $event->ID . ";");
  }

	public function add($user, $event) {
    global $wpdb;

    if ( empty($user->ID) || !is_numeric($user->ID) ) {
      return false;
    }
    if ( empty($event->ID) || !is_numeric($event->ID) ) {
      return false;
    }

    $column_formats = $this->get_columns();
    $data = array(
      "time" => date('Y-m-d H:i:s'),
      "event_id" => $event->ID,
      "user_id" => $user->ID
    );

    $wpdb->insert( $this->table_name, $data, $column_formats);
	}

	public function delete( $id = false ) {
    global $wpdb;

		if ( empty( $id ) ) {
			return false;
		}
    $wpdb->delete( $this->table_name, array( 'id' => $id ), array( '%d' ) );
	}

	/**
	 * Create the table
	 */
	public function create_table() {
		global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $sql = "CREATE TABLE " . $this->table_name . " (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          user_id mediumint(9) NOT NULL,
          event_id mediumint(9) NOT NULL,
          UNIQUE KEY id (id),
          UNIQUE KEY id_user_event (user_id,event_id)
          ) $charset_collate;";

    dbDelta( $sql );
  }
}
