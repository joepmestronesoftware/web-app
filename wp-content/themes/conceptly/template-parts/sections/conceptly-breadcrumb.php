<?php 
$conceptly_hs_breadcrumb			= get_theme_mod('hide_show_breadcrumb','1');
$conceptly_breadcrumb_bg_setting	= get_theme_mod('breadcrumb_background_setting',esc_url(get_template_directory_uri() .'/assets/images/bg/breadcrumb.jpg')); 
$conceptly_breadcrumb_bg_position	= get_theme_mod('breadcrumb_background_position','scroll');
if($conceptly_hs_breadcrumb == '1') :
?>
<!-- Start: Breadcrumb Area
============================= -->
<section id="breadcrumb-area" style="background-image:url('<?php echo esc_url($conceptly_breadcrumb_bg_setting); ?>');background-attachment:<?php echo esc_attr($conceptly_breadcrumb_bg_position); ?>;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>
					<?php 
							if ( is_day() ) : 
							
								printf( __( 'Daily Archives: %s', 'conceptly' ), get_the_date() );
							
							elseif ( is_month() ) :
							
								printf( __( 'Monthly Archives: %s', 'conceptly' ), (get_the_date( 'F Y' ) ));
								
							elseif ( is_year() ) :
							
								printf( __( 'Yearly Archives: %s', 'conceptly' ), (get_the_date( 'Y' ) ) );
								
							elseif ( is_category() ) :
							
								printf( __( 'Category Archives: %s', 'conceptly' ), (single_cat_title( '', false ) ));

							elseif ( is_tag() ) :
							
								printf( __( 'Tag Archives: %s', 'conceptly' ), (single_tag_title( '', false ) ));
								
							elseif ( is_404() ) :

								printf( __( 'Error 404', 'conceptly' ));
								
							elseif ( is_author() ) :
							
								printf( __( 'Author: %s', 'conceptly' ), (get_the_author( '', false ) ));		
							
							else :
									the_title();
									
							endif;
							
						?>
						</h1>
					<ul class="breadcrumb-nav list-inline">
						<?php if (function_exists('conceptly_breadcrumbs')) conceptly_breadcrumbs();?>
					</ul>
            </div>
        </div>
    </div>
    <div class="shape2"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shape/shape2.png" alt="image"></div>
    <div class="shape3"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shape/shape3.png" alt="image"></div>
    <div class="shape5"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shape/shape5.png" alt="image"></div>
    <div class="shape6"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shape/shape6.png" alt="image"></div>
    <div class="shape7"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shape/shape7.png" alt="image"></div>
    <div class="shape8"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shape/shape8.png" alt="image"></div>
    <div class="lines">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
</section>
<?php 
endif;
?>
<!-- End: Breadcrumb Area
============================= -->
