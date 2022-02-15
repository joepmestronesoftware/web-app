<?php 
if ( ! function_exists( 'conceptly_home_blogs' ) ) :
	function conceptly_home_blogs() {
	$hide_show_blog 		= get_theme_mod('hide_show_blog','1');
	$blog_title 			= get_theme_mod('blog_title');
	$blog_description 		= get_theme_mod('blog_description');
	$blog_display_num 		= get_theme_mod('blog_display_num','3');	
	if($hide_show_blog == '1') { 
?>
<section id="latest-news" class="section-padding position-relative">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 col-12">
                <div class="section-title">
					<?php if($blog_title) { ?>
						<h2><?php echo esc_html($blog_title); ?> <span></span></h2>
					<?php } ?>
					<?php if($blog_description) { ?>
						<p><?php echo esc_html($blog_description); ?></p>
					<?php } ?>
                </div>                    
            </div>                
        </div>
        <div class="row">
			<?php 	
				$conceptly_blog_args = array( 'post_type' => 'post','posts_per_page' => $blog_display_num,'post__not_in'=>get_option("sticky_posts")) ; 	
					$conceptly_wp_query = new WP_Query($conceptly_blog_args);
					if($conceptly_wp_query)
					{	
					while($conceptly_wp_query->have_posts()):$conceptly_wp_query->the_post(); ?>
						<div class="col-lg-4 col-md-6 col-sm-12 mb-4 mb-lg-0 news">
							<article  id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
								<div class="post-thumbnail">
									<?php 
										if ( has_post_thumbnail() ) {
										 the_post_thumbnail(); 
										} 
									?>
									<?php 
										if ( has_post_thumbnail() ) {
									?>
									<div class="post-overlay">
										<?php
											$user = wp_get_current_user();
											if ( $user ) :
										?>	
										<img src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>" />
									</div>									
									<ul class="meta-info list-inline">
										<li class="posted-by"><a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>"><i class="fa fa-user"></i><?php esc_html(the_author()); ?></a></li>
										<li class="tags"><a href="<?php esc_url(the_permalink()); ?>"><i class="fa fa-folder-open"></i><?php echo the_category(', '); ?></a></li>
									</ul>
									<?php endif; } ?>
								</div>
								<div class="post-content">
									<div class="post-content-inner">
										<?php 
											if ( ! has_post_thumbnail() ) :
										?>
										<ul class="meta-info list-inline">
											<li class="posted-by"><a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>"><i class="fa fa-user"></i><?php esc_html(the_author()); ?></a></li>
											<li class="tags"><a href="<?php esc_url(the_permalink()); ?>"><i class="fa fa-folder-open"></i><?php echo the_category(', '); ?></a></li>
										</ul>
										<?php endif; ?>
										<?php     
												if ( is_single() ) :
												
												the_title('<h3 class="post-title">', '</h3>' );
												
												else:
												
												the_title( sprintf( '<h3 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
												
												endif; 
											?> 	
										<?php 
											the_content( 
												sprintf( 
													__( 'Read More', 'conceptly' ), 
													'<span class="screen-reader-text">  '.esc_html(get_the_title()).'</span>' 
												) 
											);
										?>
									</div>
								</div>
							</article>
						</div>
				<?php 
					endwhile; 
					}
					wp_reset_postdata();
				?>
        </div>
    </div>
    <div class="shape18"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shape/shape18.png" alt="image"></div>
</section>
<?php } 
	}
endif;
if ( function_exists( 'conceptly_home_blogs' ) ) {
$conceptly_section_priority = apply_filters( 'conceptly_section_priority', 30, 'conceptly_home_blogs' );
add_action( 'conceptly_sections', 'conceptly_home_blogs', absint( $conceptly_section_priority ) );
}