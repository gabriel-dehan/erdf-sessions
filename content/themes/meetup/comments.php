<?php 
	$custom_comment_form = array( 
		'fields' => apply_filters( 'comment_form_default_fields', array(
		    'author' => '<input class="input-standard" type="text" id="author" name="author" placeholder="' . __('Name *','meetup') . '" value="' . esc_attr( $commenter['comment_author'] ) . '" />',
		    'email'  => '<input class="input-standard" name="email" type="text" id="email" placeholder="' . __('Email *','meetup') . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" />',
		    'url'    => '<input class="input-standard" name="url" type="text" id="url" placeholder="' . __('Website','meetup') . '" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" />') 
		),
		'comment_field' => '<textarea class="input-standard" name="comment" placeholder="' . __('Enter your comment here...','meetup') . '" id="comment" aria-required="true" rows="4"></textarea>',
		'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a> <a href="%3$s">Log out?</a>','meetup' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
		'cancel_reply_link' => __( 'Cancel' , 'meetup' ),
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'label_submit' => __( 'Leave a reply' , 'meetup' )
	);
?>

<section class="blog-comments dark-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="comments-list">
				
					<h5><?php comments_number( __('0 Comments','meetup'), __('1 Comment','meetup'), __('% Comments','meetup') ); ?></h5>
					
					<?php 
						if( have_comments() ){
							echo '<ol id="singlecomments" class="commentlist">';
								wp_list_comments('type=comment&callback=ebor_custom_comment');
							echo '</ol>';
							paginate_comments_links();
						}
						
						comment_form($custom_comment_form); 
					?>
					
				</div>
			</div>
		</div><!--end of row-->
	</div><!--end of container-->
</section>