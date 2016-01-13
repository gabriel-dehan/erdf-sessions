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
}

?>