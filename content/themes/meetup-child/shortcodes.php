<?php

function es_calendar( $atts ){
    return '<div class="events-archive events-gridview"><div id="tribe-events-content"><div id="home-calendar"></div></div></div>';
    // tribe_get_template_part( 'month/content' );

    //return '<iframe src="/events#tribe-events-content"></iframe>';
}

add_shortcode( 'events_calendar', 'es_calendar' );
