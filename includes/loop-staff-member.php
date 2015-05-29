<?php 
if (have_posts()) :

	echo '<div class="entry-content clearfix"><div class="row">';
	$people_counter = 0;
	
	while(have_posts()) : the_post();

		$people_counter++;
		if ($people_counter == 1): echo '<div class="clearfix">'; endif;
		get_template_part('includes/singlerow','ctc_person');
		if ($people_counter == 3): echo '</div>'; $people_counter = 0; endif;
		
	endwhile;
	
	echo '</div></div>';
	
endif; 