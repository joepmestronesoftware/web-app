<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package conceptly
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
	<figure class="post-thumb">
		<?php 
			if ( has_post_thumbnail() ) {
			 the_post_thumbnail(); 
			} 
		?>
		<?php 
			if ( has_post_thumbnail() ) {
		?>
		<figcaption>
			<div class="inner-text">
			<?php	
				$user = wp_get_current_user();
				if ( $user ) :
			?>	
			<img src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>" />
			</div>
		</figcaption>
		<ul class="meta-info list-inline">
			<li class="post-date"><a href="<?php echo esc_url(get_month_link(get_post_time('Y'),get_post_time('m'))); ?>"><i class="fa fa-calendar"></i><?php esc_html_e('on','conceptly'); ?> <?php echo esc_html(get_the_date('j')); ?>  <?php echo esc_html(get_the_date('M')); ?>  <?php echo esc_html(get_the_date('Y')); ?></a></li>
			<li class="posted-by"><a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>"><i class="fa fa-user"></i><?php esc_html_e('By','conceptly'); ?> <?php esc_html(the_author()); ?></a></li>
			 <li class="tags"><a href="<?php esc_url(the_permalink()); ?>"><i class="fa fa-folder-open"></i><?php echo the_category(', '); ?></a></li>
		</ul>
		<?php endif; } ?>
	</figure>
	<div class="post-content">
		<?php 
			if ( ! has_post_thumbnail() ) :
		?>
		<ul class="meta-info list-inline">
			<li class="post-date"><a href="<?php echo esc_url(get_month_link(get_post_time('Y'),get_post_time('m'))); ?>"><i class="fa fa-calendar"></i><?php esc_html_e('on','conceptly'); ?> <?php echo esc_html(get_the_date('j')); ?>  <?php echo esc_html(get_the_date('M')); ?>  <?php echo esc_html(get_the_date('Y')); ?></a></li>
			<li class="posted-by"><a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>"><i class="fa fa-user"></i><?php esc_html_e('By','conceptly'); ?> <?php esc_html(the_author()); ?></a></li>
			
			<?php if(!empty(get_the_category_list())) { ?>
				<li class="tags"><a href="<?php esc_url(the_permalink()); ?>"><i class="fa fa-folder-open"></i><?php echo the_category(', '); ?></a></li>
			<?php } ?>
		</ul>
		<?php endif; ?>
		 <?php     
				if ( is_single() ) :
				
				the_title('<h4 class="post-title">', '</h4>' );
				
				else:
				
				the_title( sprintf( '<h4 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				
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
</article>               