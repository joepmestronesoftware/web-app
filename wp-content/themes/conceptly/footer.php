<?php 
	$hide_show_copyright 	= get_theme_mod('hide_show_copyright','1');	
	$copyright_content 		= get_theme_mod('copyright_content','Copyright &copy; [current_year] [site_title] | Powered by [theme_author]');
	$hide_show_scroller 	= get_theme_mod('hide_show_scroller','1');
	$footer_background_setting= get_theme_mod('footer_background_setting');
?>
<?php if ( is_active_sidebar( 'conceptly-footer-widget-area' ) ) { ?>
	<footer id="footer-widgets" style="background: url('<?php echo esc_url($footer_background_setting); ?>') no-repeat center / cover ">
			<div class="container">
				<div class="row">			
					<?php  dynamic_sidebar( 'conceptly-footer-widget-area' ); ?>
				</div>
			</div>
	</footer>
<?php } ?>
<section id="footer-copyright">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12 text-lg-left text-center mb-lg-0 mb-3 copyright-text">
				<?php if($hide_show_copyright == '1') { ?>
					<?php 	
						$conceptly_copyright_allowed_tags = array(
							'[current_year]' => date_i18n('Y'),
							'[site_title]'   => get_bloginfo('name'),
							'[theme_author]' => sprintf(__('<a href="https://www.nayrathemes.com/conceptly-free/" target="_blank">Conceptly WordPress Theme</a>', 'conceptly')),
						);
					?>
					<p>
						<?php
							echo apply_filters('conceptly_footer_copyright', wp_kses_post(conceptly_str_replace_assoc($conceptly_copyright_allowed_tags, $copyright_content)));
						?>
					</p>	
				<?php }  ?>
			</div>			
            <div class="col-lg-6 col-12">
                <ul class="text-lg-right text-center payment-method">
                    <?php 
						$hide_show_payment = get_theme_mod('hide_show_payment','1');
						$footer_Payment_icon= get_theme_mod('footer_Payment_icon'); 		
						?>
					<?php if($hide_show_payment == '1') { ?>
						<?php
			
							$footer_Payment_icon = json_decode($footer_Payment_icon);
							if( $footer_Payment_icon!='' )
							{
							foreach($footer_Payment_icon as $footer_Payment_item){
							$icon = ! empty( $footer_Payment_item->icon_value ) ? apply_filters( 'conceptly_translate_single_string', $footer_Payment_item->icon_value, 'footer section' ) : '';
							$conceptly_payment_icon_link = ! empty( $footer_Payment_item->link ) ? apply_filters( 'conceptly_translate_single_string', $footer_Payment_item->link, 'footer section' ) : '';
						?>
							<li><a href="<?php echo esc_url($conceptly_payment_icon_link); ?>"><i class="fa <?php echo esc_attr( $icon ); ?>"></i></a></li>
					<?php  } } } ?>
                </ul>                
            </div>
        </div>
    </div>
</section>
<?php if($hide_show_scroller == '1') { ?>
	<a href="#" class="scrollup boxed-btn"><i class="fa fa-arrow-up"></i></a>
<?php } ?>
<!-- End: Footer Copyright
============================= -->
</div>
</div>
<?php wp_footer(); ?>
</body>
</html>
