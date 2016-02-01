<?php

function es_calendar( $atts ){
    ob_start();
?>
    <div class="tribe-header-nav">
		    <?php tribe_get_template_part( 'month/nav' ); ?>
    </div>
    <div class="events-archive events-gridview">
        <div id="tribe-events-content">
            <div id="home-calendar">
            </div>
        </div>
    </div>
<?php
    $content = ob_get_contents();
    ob_clean();

    return $content;
}

add_shortcode( 'events_calendar', 'es_calendar' );
