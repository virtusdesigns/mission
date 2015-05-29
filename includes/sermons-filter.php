<?php 
$topic_terms   = forgiven_get_terms_slugs( get_terms( 'ctc_sermon_topic' ));
$book_terms    = forgiven_get_terms_slugs( get_terms( 'ctc_sermon_book' ));
$series_terms  = forgiven_get_terms_slugs( get_terms( 'ctc_sermon_series' ));
$speaker_terms = forgiven_get_terms_slugs( get_terms( 'ctc_sermon_speaker' ));

?>
<div class="filter-row clearfix">
	
	<form action="" method="get">
	
		<div class="select-box">
			<i class="fa fa-user"></i>
			<?php forgiven_render_dropdown( $speaker_terms, 'speaker', __('Speakers','forgiven').':' ); ?>		
		</div><!-- /.select-box -->
		
		<div class="select-box">
			<i class="fa fa-file-text-o"></i>
			<?php forgiven_render_dropdown( $topic_terms, 'topic', __('Topics','forgiven').':' ); ?>		
		</div><!-- /.select-box -->

		<div class="select-box">
			<i class="fa fa-book"></i>
			<?php forgiven_render_dropdown( $book_terms, 'book', __('Books','forgiven').':' ); ?>		
		</div><!-- /.select-box -->

		<div class="select-box">
			<i class="fa fa-files-o"></i>
			<?php forgiven_render_dropdown( $series_terms, 'series', __('Series','forgiven').':' ); ?>		
		</div><!-- /.select-box -->

		<input type="submit" value="Filter" class="es-button" />
	</form><!-- /form -->

</div><!-- /.filter-row -->