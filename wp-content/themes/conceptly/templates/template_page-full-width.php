<?php
/**
Template Name: Page Fullwidth
**/

get_header();
?>

    <section id="blog-content" class="full-width section-padding">
        <div class="container">
            <div class="row full-width">
				<div class="col-md-12 col-sm-12" >
					<div class="site-content">
						<?php the_post(); the_content(); ?>
					</div>
					
					<?php 
						if( $post->comment_status == 'open' ) { 
							comments_template( '', true ); // show comments 
						}
					?>	
					
				</div><!-- /.col -->
						
			</div><!-- /.row -->
		
		</div><!-- /.container -->
	</section>

<?php get_footer(); ?>

