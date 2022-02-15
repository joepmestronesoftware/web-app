<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package conceptly
 */

get_header();
?>
  <section id="blog-content" class="section-padding-top blog-details-page">
        <div class="container">
            <div class="row">
                <!-- Blog Content -->
                <div class="<?php esc_attr(conceptly_post_layout()); ?>">
					<?php if( have_posts() ): ?>
						<?php while( have_posts() ): the_post(); ?>
							<?php get_template_part('template-parts/content/content','page'); ?> 
						<?php endwhile; ?>
					<?php endif; ?>
					<?php comments_template( '', true ); // show comments  ?>
                </div>

                <!-- Sidebar -->
                <?php get_sidebar(); ?>
            </div>
        </div>
    </section>
    <!-- End: Content Section
    ============================= -->

<?php get_footer(); ?>
