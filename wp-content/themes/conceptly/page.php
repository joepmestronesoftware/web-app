<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package conceptly
 */

get_header();
?>

<section class="section-padding">
	<div class="container">
					
		<div class="row padding-top-60 padding-bottom-60">		
			<?php 
				echo '<div class="col-lg-'.( !is_active_sidebar( "conceptly-sidebar-primary" ) ?"12" :"8" ).'">';
			?>
			<div class="site-content">
			
				<?php 
					
					if( have_posts()) :  the_post();
					
					the_content(); 
					endif;
					if( $post->comment_status == 'open' ) { 
						comments_template( '', true ); // show comments 
					}
				?>
				

			</div><!-- /.posts -->
							
			</div><!-- /.col -->
		 <?php get_sidebar(); ?>		
		</div><!-- /.row -->
	</div><!-- /.container -->
</section>

<?php get_footer(); ?>

