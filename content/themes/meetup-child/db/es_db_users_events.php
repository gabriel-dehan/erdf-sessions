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
    return count($this->fetch_subscription($user, $event)) > 0;
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

  public function fetch_subscriptions($event, $status) {
    global $wpdb;

    if ( empty($event->ID) || !is_numeric($event->ID) ) {
      return false;
    }

    return $wpdb->get_results("SELECT * FROM " . $this->table_name . " WHERE event_id = " . $event->ID . " AND status = '" . $status . "';");
  }

  public function destroy_subscriptions($user_id) {
    global $wpdb;

    if ( empty($event->ID) || !is_numeric($event->ID) ) {
      return false;
    }

    return $wpdb->get_results("DELETE FROM " . $this->table_name . " WHERE user_id = " . $user_id . ";");

  }

  /* ADD */
	public function add($user, $event) {
    global $wpdb;

    // Minus 2 because 2 are the waiting list
    $wait_list_spots = 1;
    $spots_limit = get_post_meta($event->ID, 'event_spots_limit', true);
    $onboard_users = count($this->fetch_subscriptions($event, 'onboard'));
    $onlist_users = count($this->fetch_subscriptions($event, 'onlist'));
    $upcoming_events_for_user = $wpdb->get_results(
      "SELECT * FROM wp_users_events ue WHERE ue.event_id IN " .
      "(SELECT p.id FROM  wp_posts p JOIN wp_postmeta m ON m.post_id = p.id " .
      " WHERE p.post_type =  'tribe_events' AND m.meta_key = '_EventStartDate' " .
      "AND DATE(m.meta_value) > DATE('" . date('Y-m-d H:i:s') . "') ) " .
      "AND ue.user_id = " . $user->ID . ";"
    );

    if ( empty($user->ID) || !is_numeric($user->ID) ) {
      return false;
    }
    if ( empty($event->ID) || !is_numeric($event->ID) ) {
      return false;
    }

    $column_formats = $this->get_columns();

    if (count($upcoming_events_for_user) > 0) {
      return array(
        "error" => 'Vous êtes déjà inscrit à une autre session.',
        "data"  => $upcoming_events_for_user[0]
      );
    }

    if (($spots_limit + $wait_list_spots) <= ($onboard_users + $onlist_users)) {
      return array(
        "error" => 'Cette session est complète.'
      );
    }

    // If the event is already full, put on waiting list
    if ($spots_limit <= $onboard_users) {
      $data = array(
        "time" => date('Y-m-d H:i:s'),
        "event_id" => $event->ID,
        "user_id" => $user->ID,
        "status"  => 'onlist'
      );
      $wpdb->insert( $this->table_name, $data, $column_formats);
      return array(
          "notice" => "Vous avez été placé sur liste d'attente."
      );
    } else {
      $data = array(
        "time" => date('Y-m-d H:i:s'),
        "event_id" => $event->ID,
        "user_id" => $user->ID
      );

      $wpdb->insert( $this->table_name, $data, $column_formats);
      return true;
    }

	}


	public function remove($user, $event) {
    global $wpdb;

    if ( empty($user->ID) || !is_numeric($user->ID) ) {
      return false;
    }
    if ( empty($event->ID) || !is_numeric($event->ID) ) {
      return false;
    }


    $wpdb->delete( $this->table_name, array( 'user_id' => $user->ID, 'event_id' => $event->ID ) );
	}


	public function delete( $id = false ) {
    global $wpdb;

		if ( empty( $id ) ) {
			return false;
		}
    $wpdb->delete( $this->table_name, array( 'id' => $id ), array( '%d' ) );
	}


  public function update_user_reminder($user, $event, $reminder) {
    global $wpdb;

    if ( empty($user->ID) || !is_numeric($user->ID) ) {
      return false;
    }
    if ( empty($event->ID) || !is_numeric($event->ID) ) {
      return false;
    }

    return $wpdb->update( $this->table_name, array('reminder' => $reminder),
                   array( 'user_id' => $user->ID, 'event_id' => $event->ID ),
                   array('%s' ),
                   array( '%d', '%d' ));
  }

  public function update_user_status($user, $event, $new_status) {
    global $wpdb;

    $current_status = $this->user_status($user, $event);

    // If someone is rejected for any reason, a new onlist user takes his place
    if ($current_status == "onboard" && $new_status == "rejected") {
      $users = $this->get_users($event, 'onlist');
      if (count($users) > 0) {
        $this->update_user_status($users[0], $event, 'onboard');
      }
      // get user
    }

    $update_ok = $wpdb->update( $this->table_name, array('status' => $new_status),
                         array( 'user_id' => $user->ID, 'event_id' => $event->ID ),
                         array('%s' ),
                         array( '%d', '%d' ));

    // if update_ok
    //hd( get_option( 'admin_email' ) );die;
    if ( $update_ok !== false ) {
      if ( $new_status == "onboard" ) {
        do_action( 'book_confirmed_participant', $user, $event, get_userdata( $user->ID )->user_email );
        do_action( 'book_confirmed_responsable', $user, $event, get_user_meta($user->ID, 'responsable_email', true ) );
        do_action( 'book_confirmed_admin', $user, $event, get_option( 'admin_email' ) );

        es_schedule_emails($user, $event);


      } else if ( $new_status == "rejected" ) {
        do_action( 'book_refused_participant', $user, $event, get_userdata( $user->ID )->user_email );
      } else if ( $new_status == "onlist" ) {
        do_action( 'book_onlist_participant', $user, $event, get_userdata( $user->ID )->user_email );
        do_action( 'book_onlist_responsable', $user, $event, get_user_meta($user->ID, 'responsable_email', true ) );
        do_action( 'book_onlist_admin', $user, $event, get_option( 'admin_email' ) );
      }

    }

    return $update_ok;
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
          reminder varchar(255),
          status varchar(50) DEFAULT 'pending' NOT NULL,
          UNIQUE KEY id (id),
          UNIQUE KEY id_user_event (user_id,event_id)
          ) $charset_collate;";

    dbDelta( $sql );
  }
}
