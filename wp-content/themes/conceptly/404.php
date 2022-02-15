<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package conceptly
 */

get_header();
?>
<!-- Start: 404
    ============================= -->

    <section id="page-404" class="section-padding-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
					<img src=<?php echo esc_url(get_template_directory_uri()."/assets/images/404-image.png"); ?> alt="">
					 <h1><?php esc_html_e('Oops..','conceptly'); ?></h1>
					 <h3><?php esc_html_e('Something Went Wrong Here','conceptly'); ?></h3>
					 <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="boxed-btn"><?php esc_html_e('Back To Home','conceptly'); ?></a>
                    
                </div>
            </div>
        </div>
    </section>

    <!-- End: 404
    ============================= -->

<?php
get_footer();
