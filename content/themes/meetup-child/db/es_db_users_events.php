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

  public function get_users($event, $filter_status = false) {
    global $wpdb;

    $close_query = ";";

    $query = "SELECT * FROM " . $this->table_name . " ue " .
             "JOIN wp_users u ON u.id = ue.user_id " .
             "WHERE ue.event_id = " . $event->ID;

    if ($filter_status) {
      $query .= " AND ue.status = '" . $filter_status . "'";
    }

    $users_events = $wpdb->get_results($query . $close_query);

    $users = array_map(function($user) {
        global $wpdb;
        // We want to return users not users_events so we change the ID to the user_id
        $user->ID = $user->id = $user->user_id;

        $meta = $wpdb->get_results('SELECT * FROM wp_usermeta WHERE user_id = ' . $user->id . ';');

        // Populate with meta data
        foreach($meta as $info) {
            $user->{$info->meta_key} = $info->meta_value;
        }

        return $user;
    }, $users_events);

    return $users;
  }

  public function get_users_grouped_by_status($event) {
    $users_with_status = $this->get_users($event);

    $users = array(
      "pending"  => [],
      "onlist"   => [],
      "onboard"  => [],
      "rejected" => []
    );

    foreach($users_with_status as $user) {
      array_push( $users[$user->status], $user );
    }
    return $users;

  }

  public function user_status($user, $event) {
    return $this->fetch_subscription($user, $event)[0]->status;
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


    public function update_user_status($user_id, $status) {
        global $wpdb;

        return $wpdb->update('wp_users_events', array('status' => $status),
                    array( 'user_id' => $user_id ),
                    array('%s'),
                    array( '%d' ));

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
          status varchar(50) DEFAULT 'pending' NOT NULL,
          UNIQUE KEY id (id),
          UNIQUE KEY id_user_event (user_id,event_id)
          ) $charset_collate;";

    dbDelta( $sql );
  }
}
