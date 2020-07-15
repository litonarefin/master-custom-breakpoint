(function ($) {
  "use strict";

	  $(function () {
		

	  	// Reset Form
        jQuery("#elementor_settings_reset_form").submit(function(evt){
            evt.preventDefault();
            var formData = new FormData(jQuery(this)[0]),
            	reset_form = $('#reset_form').val();
            jQuery.ajax({
                url: masteraddons.ajaxurl,
                type: 'POST',
				data: {
					'security': reset_form,
					action: 'jltma_mcb_reset_settings'
				},                
                dataType: 'json',
                async: true,
                cache: false,
                success: function (response) {
                    if(response == 'ok')  {
                        jQuery('#reset_success').slideDown();
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    }
                }
            });
            return false;
        });

	  	//Save Breakpoints
		jQuery("#jlmta-cbp-form").submit(function(e){
			e.preventDefault();

			var form = $( this ),
				form_data = form.serializeArray(),
				breakpoints_form = $('#breakpoints_form').val();
                form.addClass('loading');

			$.ajax({
				url: masteraddons.ajaxurl,
				method: 'POST',
				data: { 
					form_fields: form_data,
					'security': breakpoints_form,
					action: 'jltma_mcb_save_settings'
				},
				// dataType: 'json',
			    success : function( data ){ 
					form.prepend( '<div class="updated"><p>Saved Breakpoints</p></div>' );

                    setTimeout(function() {
                        form.removeClass('loading');
                        form.find('.updated').remove();
                    }, 700 );
			    },
			    error : function(error){ 
			    	console.log('failed', error); 
			    }
			});

		});	


	  });

})(jQuery);
