<?php
/**
 * Provides methods to remove wp-user-manager default fields and replace them with new ones:
 *
 *  Fields added:
 *    Prénom*
 *    Nom*
 *    Email*
 *    Password*
 *    Email responsable*
 *    Direction appartenance
 *    Téléphone
 *
 */
class ES_DB_Fields extends WPUM_DB_Fields {

  public function __construct() {
    parent::__construct();
  }

  public function delete_all() {
    global $wpdb;
    $wpdb->query($wpdb->prepare("DELETE FROM $this->table_name"));
  }

  public function customize_fields() {
    $this->remove_default();
    return $this->create_custom_fields();
  }

  // Privates
  private function remove_default() {
    global $wpdb;

    $default = ['username', 'user_email', 'nick_name', 'email', 'password', 'first_name', 'last_name', 'display_name', 'user_url', 'description', 'user_avatar'];
    $placeholders = array_fill(0, count($default), '%s');
    $format = implode(', ', $placeholders);

    $query = "DELETE FROM $this->table_name WHERE meta IN($format)";

    return $wpdb->query($wpdb->prepare($query, $default));
  }

  private function create_custom_fields() {
		// Get primary group id
		$primary_group = WPUM()->field_groups->get_group_by( 'primary' );

		$fields = array(
			array(
				'group_id'             => $primary_group->id,
				'type'                 => 'username',
				'name'                 => 'Username',
				'is_required'          => true,
				'show_on_registration' => true,
				'can_delete'           => false,
				'meta'                 => 'username',
			),
			array(
				'group_id'             => $primary_group->id,
				'type'                 => 'text',
				'name'                 => 'Prénom',
				'is_required'          => true,
				'show_on_registration' => true,
				'can_delete'           => true,
				'meta'                 => 'first_name',
			),
			array(
				'group_id'             => $primary_group->id,
				'type'                 => 'text',
				'name'                 => 'Nom',
				'is_required'          => true,
				'show_on_registration' => true,
				'can_delete'           => true,
				'meta'                 => 'last_name',
			),
			array(
				'group_id'             => $primary_group->id,
				'type'                 => 'email',
				'name'                 => 'Email',
				'is_required'          => true,
				'show_on_registration' => true,
				'can_delete'           => false,
				'meta'                 => 'user_email',
			),
			array(
				'group_id'             => $primary_group->id,
				'type'                 => 'password',
				'name'                 => 'Password',
				'is_required'          => true,
				'show_on_registration' => true,
				'can_delete'           => false,
				'meta'                 => 'password',
			),
			array(
				'group_id'             => $primary_group->id,
				'type'                 => 'email',
				'name'                 => 'Email responsable',
				'is_required'          => true,
				'show_on_registration' => true,
				'can_delete'           => true,
				'meta'                 => 'responsable_email',
			),
			array(
				'group_id'             => $primary_group->id,
				'type'                 => 'email',
				'name'                 => 'Email professionnel',
				'is_required'          => true,
				'show_on_registration' => true,
				'can_delete'           => true,
				'meta'                 => 'email_pro',
			),
			array(
				'group_id'             => $primary_group->id,
				'type'                 => 'text',
				'name'                 => 'Direction appartenance',
				'is_required'          => true,
				'show_on_registration' => true,
				'can_delete'           => true,
				'meta'                 => 'direction_appartenance',
			),
			array(
				'group_id'             => $primary_group->id,
				'type'                 => 'text',
				'name'                 => 'Téléphone',
				'is_required'          => false,
				'show_on_registration' => true,
				'can_delete'           => true,
				'meta'                 => 'user_phone',
			)
		);

		foreach ( $fields as $field ) {
			WPUM()->fields->add( $field );
		}
  }
}

?>