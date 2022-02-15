<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Conceptly
 */

get_header(); ?>
<section id="blog-content" class="section-padding-top">
	<div class="container">
		<div class="row">
			<!-- Blog Content -->
			<div class="<?php esc_attr(conceptly_post_layout()); ?> mb-5 mb-lg-0">
				<?php 
						$conceptly_paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
						$args = array( 'post_type' => 'post','paged'=>$conceptly_paged );	
					?>
					<?php if( have_posts() ): ?>
						<?php while( have_posts() ): the_post(); ?>
								<?php get_template_part('template-parts/content/content','page'); ?> 
						<?php endwhile; ?>
						<!-- Pagination -->
							<?php								
							// Previous/next page navigation.
							the_posts_pagination( array(
							'prev_text'          => '<i class="fa fa-angle-double-left"></i>',
							'next_text'          => '<i class="fa fa-angle-double-right"></i>',
							) ); ?>
						<!-- Pagination -->	
					<?php else: ?>
						<?php get_template_part('template-parts/content/content','none'); ?>
					<?php endif; ?>	
			</div>
			
			<!-- Sidebar -->
			<?php get_sidebar(); ?>
		</div>

	</div>
</section>
<?php get_footer(); ?>
