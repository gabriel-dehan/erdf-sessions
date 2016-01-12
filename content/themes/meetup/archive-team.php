<?php 
	get_header(); 
	
	get_template_part('loop/loop', get_option('meetup_team_layout', 'team-row'));
	
	get_footer();