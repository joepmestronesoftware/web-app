<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package conceptly
 */

get_header(); ?>
<section id="blog-content" class="section-padding">
        <div class="container">
            <div class="row padding-top-60 padding-bottom-60">
				<div class="<?php esc_attr(conceptly_post_layout()); ?> mb-5 mb-lg-0" >
					<?php
					if ( have_posts() ) :
					
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content/content', 'search' );

						endwhile;

						the_posts_navigation();

					else :

						get_template_part( 'template-parts/content/content', 'none' );

					endif; ?>
				</div>
				<?php get_sidebar(); ?>
		</div>
	</div>
</section>
<?php
get_footer();
