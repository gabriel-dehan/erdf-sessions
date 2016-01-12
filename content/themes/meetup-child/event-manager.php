<?php
class EventManager {
    protected $event;

    public function __construct($event) {
        $this->event = $event;
    }

    public function find_users() {
        hd($this->event);
    }
}

?>