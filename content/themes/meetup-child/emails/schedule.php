<?php
function es_schedule_emails($user, $event) {
  $event_date_str = get_post_meta($event->ID, '_EventStartDate', true);
  $event_date = new DateTime($event_date_str, new DateTimeZone("UTC"));
  $month_earlier = clone $event_date;
  $month_earlier->sub(new DateInterval("P1M"));

  $week_earlier = clone $event_date;
  $week_earlier->sub(new DateInterval("P1W"));

  // TEST
  // $month_earlier = (new DateTime())->add(new DateInterval("PT1M"));
  // $week_earlier = (new DateTime())->add(new DateInterval("PT1M"));

  wp_schedule_single_event($week_earlier->getTimestamp(), 'reminder_week_earlier', array($user, $event, $event_date));
  wp_schedule_single_event($month_earlier->getTimestamp(), 'reminder_month_earlier', array($user, $event, $event_date));
}

function es_week_reminder($user, $event, $event_date) {
  notify($user, $event, get_userdata( $user->ID )->user_email, false );
}
function es_month_reminder($user, $event, $event_date) {
  notify($user, $event, get_userdata( $user->ID )->user_email, false );
}

add_action( 'reminder_week_earlier', 'es_week_reminder', 10, 3 );
add_action( 'reminder_month_earlier', 'es_month_reminder', 10, 3 );
?>
