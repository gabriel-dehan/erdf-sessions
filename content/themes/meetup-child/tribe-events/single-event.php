<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$event = get_post();
$current_user  = wp_get_current_user();

$users_events = new ES_DB_UsersEvents;
$users        = $users_events->get_users($event, "onboard");
$users_count  = count($users);
$spots        = es_event_get_spots($event);
$spots_left   = $spots - $users_count;

if (isset($_POST['subscribe'])) {
  $event = get_post($_POST['event_id']);

  $is_subscribed = $users_events->user_subscribed($current_user, $event);
  if (!$is_subscribed) {
    $users_events->add($current_user, $event);
  } else {
    echo 'You already subscribed';
  }
} else if (isset($_POST['unsubscribe'])) {
  $event = get_post($_POST['event_id']);

  $is_subscribed = $users_events->user_subscribed($current_user, $event);
  if ($is_subscribed) {
    $users_events->remove($current_user, $event);
  } else {
    echo 'You are not subscribed yet';
  }
}

  $events_label_singular = tribe_get_event_label_singular();
  $events_label_plural = tribe_get_event_label_plural();

  $event_id = get_the_ID();

?>

<div id="tribe-events-content" class="tribe-events-single">
<?php /* the_title( '<h1 class="tribe-events-single-event-title">', '</h1>' ); */ ?>

	<!--div class="tribe-events-schedule tribe-clearfix">
		<?php echo tribe_events_event_schedule_details( $event_id, '<h2>', '</h2>' ); ?>
		<?php if ( tribe_get_cost() ) : ?>
			<span class="tribe-events-divider">|</span>
			<span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
		<?php endif; ?>
	</div -->

	<!-- Event header -->
	<div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
		<!-- Navigation -->
		<h3 class="tribe-events-visuallyhidden"><?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?></h3>
		<ul class="tribe-events-sub-nav">
			<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
			<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
		</ul>
		<!-- .tribe-events-sub-nav -->
	</div>
	<!-- #tribe-events-header -->

	<?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!-- Event featured image, but exclude link -->
			<?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>

			<!-- Event meta -->
			<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
			<?php tribe_get_template_part( 'modules/meta' ); ?>
			<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
	      <!-- Notices -->
	      <?php tribe_the_notices() ?>

        <?php if ( !$users_events->user_subscribed($current_user, $event) && $spots_left > 0 ) { ?>
        <form method="POST" action="<?php the_permalink(); ?>" class="btn-book-event-big">
            <input type="hidden" name="subscribe">
            <input type="hidden" name="event_id" value="<?php echo the_ID(); ?>">
            <button>Réservez votre place !</button>
        </form>
        <?php } else if ( $spots_left == 0 ) { ?>
        <form method="POST" action="<?php the_permalink(); ?>" class="btn-book-event-big">
            <input type="hidden" name="subscribe">
            <input type="hidden" name="event_id" value="<?php echo the_ID(); ?>">
            <button class="disabled" disabled>Complet</button>
        </form>
        <?php } ?>
			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
			<!-- .tribe-events-single-event-description -->
        <div class="tribe-event-program">
            <h2>Programme</h2>
			      <div class="tribe-events-single-event-description tribe-events-content">
				        <?php the_content(); ?>
			      </div>
        </div>

        <div class="tribe-event-participants">
            <h2>Participants</h2>
            <div class="show-spots-left">
                <?php if ( $spots_left > 0 ) { ?>
                    <?php echo $spots_left ?> <?php echo $spots_left > 1 ? 'places restantes' : 'place restante' ?>.
                <?php }  ?>
            </div>
            <div class="show-participants">
                <?php if (count($users) > 0) { ?>
                    <ul>
                        <?php foreach ($users as $user) { ?>
                            <li><?php echo $user->first_name . " " . $user->last_name ?></li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <span class="none">Aucun participant.</span>
                <?php } ?>
            </div>
        </div>

        <div class="user-status">
            <?php if ( $users_events->user_subscribed($current_user, $event) ) { ?>
                Votre statut pour cette session: <span class='status'><?php echo es_status_to_sentence($users_events->user_status($current_user, $event)); ?></span>
            <?php } ?>
        </div>

        <div class="user-subscribe">
            <?php if ( $users_events->user_subscribed($current_user, $event) ) { ?>
                <form method="POST" action="<?php the_permalink(); ?>">
                    <input type="hidden" name="unsubscribe">
                    <input type="hidden" name="event_id" value="<?php echo the_ID(); ?>">
                    <button class="unsub">Se désinscrire</button>
                </form>
            <?php } else { ?>
                <form method="POST" action="<?php the_permalink(); ?>">
                    <input type="hidden" name="subscribe">
                    <input type="hidden" name="event_id" value="<?php echo the_ID(); ?>">
                    <button>S'inscrire</button>
                </form>
            <?php } ?>

        </div>
			  <?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

		</div> <!-- #post-x -->

		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>

	<!-- Event footer -->
	<div id="tribe-events-footer">
		<!-- Navigation -->
	    <p class="tribe-events-back">
		      <a href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php printf( '&laquo; ' . esc_html__( 'All %s', 'the-events-calendar' ), $events_label_plural ); ?></a>
	    </p>

		<h3 class="tribe-events-visuallyhidden"><?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?></h3>
		<ul class="tribe-events-sub-nav">
			<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> Date précédente' ) ?></li>
			<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( 'Date suivante <span>&raquo;</span>' ) ?></li>
		</ul>
		<!-- .tribe-events-sub-nav -->
	</div>
	<!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->

<?php

?>
