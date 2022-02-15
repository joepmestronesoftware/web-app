<div class="wrap">
    <h1><?php printf( __( '%s - Settings', 'strato-assistant' ), Strato_Assistant_Config::get( 'name', 'branding', null, 'Assistant' ) ); ?></h1>

    <form method="post" action="options.php" novalidate="novalidate">

		<?php
		settings_fields( 'strato_assistant_settings_plugin_options' );
		do_settings_sections('strato_assistant_settings_plugin');
		submit_button();
		?>
    </form>

</div>