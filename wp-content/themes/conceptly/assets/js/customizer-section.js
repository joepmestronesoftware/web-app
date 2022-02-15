( function( api ) {

	// Extends our custom "example-1" section.
	api.sectionConstructor['plugin-section'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );


function conceptlyfrontpagesectionsscroll( section_id ){
    var scroll_section_id = "header-top";

    var $contents = jQuery('#customize-preview iframe').contents();

    switch ( section_id ) {
		
		case 'accordion-section-slider_setting':
        scroll_section_id = "slider";
        break;
		
        case 'accordion-section-info_setting':
        scroll_section_id = "contact-info";
        break;

        case 'accordion-section-service_setting':
        scroll_section_id = "our-service";
        break;

        case 'accordion-section-features_setting':
        scroll_section_id = "ourfeatures";
        break;
		
        case 'accordion-section-call_action_setting':
        scroll_section_id = "cta";
        break;
		
		case 'accordion-section-blog_setting':
        scroll_section_id = "latest-news";
        break;
		
		case 'accordion-section-sponsers_setting':
        scroll_section_id = "our-partners";
        break;
		
    }

    if( $contents.find('#'+scroll_section_id).length > 0 ){
        $contents.find("html, body").animate({
        scrollTop: $contents.find( "#" + scroll_section_id ).offset().top
        }, 1000);
    }
}

 jQuery('body').on('click', '#sub-accordion-panel-conceptly_frontpage_sections .control-subsection .accordion-section-title', function(event) {
        var section_id = jQuery(this).parent('.control-subsection').attr('id');
        conceptlyfrontpagesectionsscroll( section_id );
});