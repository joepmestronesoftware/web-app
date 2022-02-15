<?php
/**
 * The template for displaying search form.
 *
 * @package     Conceptly
 * @since       1.0.0
 */
?>

<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" placeholder="<?php esc_attr_e( 'Search', 'conceptly' ); ?>" name="s" id="s">
	<button><i class="fa fa-search"></i></button>
</form>							
							
							
							