<?php
class EventManager {
    protected $event;

    public function __construct($event) {
        $this->event = $event;
        $this->relations = new ES_DB_UsersEvents;
    }

    public function find_users() {
        return $this->relations->get_users($this->event);
    }

    public function find_onboard_users() {
        return $this->relations->get_users($this->event, "onboard");
    }

    public function get_spots() {
        return get_post_meta($this->event->ID, 'event_spots_limit', true);
    }
}

?>